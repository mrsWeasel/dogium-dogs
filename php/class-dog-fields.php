<?php
// Do not allow direct access
defined( 'ABSPATH' ) or die( 'No direct access allowed.' );
class DogFields {
	public function __construct() {
		add_action('post_updated', array($this, 'changed_dog_owner'), 10, 3);
		add_action('friends_friendship_post_delete', array($this, 'removed_friend'), 10, 2);
		add_filter('acf/prepare_field/name=_post_title', array($this, 'dog_name'));
		add_filter('acf/load_field/name=dgm_owners', array($this, 'add_dog_select_friends'));
		add_filter('acf/load_field/name=dgm_friends_as_breeders', array($this, 'add_dog_select_friends'));
		add_filter('acf/load_field/name=dgm_groups_as_breeders', array($this, 'add_groups_as_breeder'));
		//add_filter('acf/fields/taxonomy/query/name=dgm_breeds', array($this, 'dog_terms'), 10, 3);
	}
	protected function get_friends() {
		global $post;
		// reset
		$field['choices'] = array();
		$data = array();
		
		if ($post->post_type !== 'dogium_dog') {
			// This applies if we're on the "add new"-PAGE and not in a single dog post
			$author = get_current_user_id();
		} else {
			// This will fall back to current user if author is not yet defined (for new posts that are created from the backend).
			$author = get_post_field('post_author', $post->ID);
		}
		$friend_ids = friends_get_friend_user_ids($author);
			
		foreach($friend_ids as $friend_id) {
			$user = get_userdata($friend_id);
			$data[] = array('name' => $user->display_name, 'id' => strval( $friend_id ), 'email' => $user->user_email);
		}
		return $data;
	}
	protected function get_groups() {
		$groups = BP_Groups_Group::get(array(
				'type'=>'alphabetical',
				'per_page'=>-1
				));
		// We just need this
		$groups = $groups['groups'];
		return $groups;
	}
	public function add_dog_select_friends($field) {
		// Do not populate menu on settings page
		if (function_exists('get_current_screen')) {
			$current_screen = get_current_screen();
			if ($current_screen->post_type == 'acf-field-group') {
				return $field;
			}
		}
		
		$data = $this->get_friends();
		// Populate ACF select menu
		if (is_array($data)) {
			foreach($data as $key=>$val) {
				$choice = $val['id'];
				$field['choices'][$choice] = $val['name'];
			}
		}
		return $field;
	}
	public function add_groups_as_breeder($field) {
		if (function_exists('get_current_screen')) {
			$current_screen = get_current_screen();
			if ($current_screen->post_type == 'acf-field-group') {
				return $field;
			}
		}
		$groups = $this->get_groups();
		if (is_array($groups)) {
			foreach($groups as $group) {
				$choice = $group->id;
				$field['choices'][$choice] = $group->name;
			}
		}
		return $field;
	}
	public function dog_name( $field ) {
	        // Change the label
	        $field['label'] = __('Name', 'dogium-dog');  
	        $field['instructions'] = __('What is the nickname of your dog?', 'dogium-dog');  
	    
	    	return $field;    
	}
	public function dog_terms( $args, $field, $post_id ) {
		$term = get_term_by('name', 'Muu', 'dogium_breed');
		if ($term) {
			$id = intval( $term->term_id );
			$args['exclude'] = $id;
		}
		return $args;
	}
	public function changed_dog_owner($post_ID, $post_after, $post_before) {
		if ( $post_after->post_author !== $post_before->post_author ) {
				delete_field('dgm_owners', $post_ID);
				delete_field('dgm_friends_as_breeders', $post_ID);
		} 
	}
	// Remove shared dogs if friendship ends
	public function removed_friend($initiator_userid, $friends_userid) {
		// Posts authored by initiator first
		$friend_posts = get_posts(array(
			'author' => $initiator_userid,
			'post_type' => 'dogium_dog',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => 'dgm_owners',
					'value' => '"' . strval( $friends_userid ) . '"',
					'compare' => 'LIKE'
				)		
			)
		));
		$breeder_posts = get_posts(array(
			'author' => $initiator_userid,
			'post_type' => 'dogium_dog',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => 'dgm_friends_as_breeders',
					'value' => '"' . strval( $friends_userid ) . '"',
					'compare' => 'LIKE'
				)		
			)
		));
		
		// Then vice versa (posts shared with initiator)
			$dumped_friend_posts = get_posts(array(
			'author' => $friends_userid,
			'post_type' => 'dogium_dog',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => 'dgm_owners',
					'value' => '"' . strval( $initiator_userid ) . '"',
					'compare' => 'LIKE'
				)		
			)
		));
		$dumped_breeder_posts = get_posts(array(
			'author' => $friends_userid,
			'post_type' => 'dogium_dog',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => 'dgm_friends_as_breeders',
					'value' => '"' . strval( $initiator_userid ) . '"',
					'compare' => 'LIKE'
				)		
			)
		));

		if ($friend_posts) {
			foreach ($friend_posts as $apost) {
				$metadata = get_post_meta($apost->ID, 'dgm_owners', true);
				foreach ($metadata as $key=>$value) {
					if ( $value === strval( $friends_userid ) ) {
						unset( $metadata[$key] );
					}
				}
				update_post_meta($apost->ID, 'dgm_owners', $metadata);
			}
		}
		if ($breeder_posts) {
			foreach ($breeder_posts as $bpost) {
				$metadata = get_post_meta($bpost->ID, 'dgm_friends_as_breeders', true);
				foreach ($metadata as $key=>$value) {
					if ( $value === strval( $friends_userid ) ) {
						unset( $metadata[$key] );
					}
				}
				update_post_meta($bpost->ID, 'dgm_friends_as_breeders', $metadata);
			}
		}
		if ($dumped_friend_posts) {
			foreach ($dumped_friend_posts as $cpost) {
				$metadata = get_post_meta($cpost->ID, 'dgm_owners', true);
				foreach ($metadata as $key=>$value) {
					if ( $value === strval( $initiator_userid ) ) {
						unset( $metadata[$key] );
					}
				}
				update_post_meta($cpost->ID, 'dgm_owners', $metadata);
			}
		}
		if ($dumped_breeder_posts) {
			foreach ($dumped_breeder_posts as $dpost) {
				$metadata = get_post_meta($dpost->ID, 'dgm_friends_as_breeders', true);
				foreach ($metadata as $key=>$value) {
					if ( $value === strval( $initiator_userid ) ) {
						unset( $metadata[$key] );
					}
				}
				update_post_meta($dpost->ID, 'dgm_friends_as_breeders', $metadata);
			}
		}

	}
}
new DogFields;