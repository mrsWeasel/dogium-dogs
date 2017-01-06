<?php
// Do not allow direct access
defined( 'ABSPATH' ) or die( 'No direct access allowed.' );


class DogFields {
	public function __construct() {
		add_action('post_updated', array($this, 'changed_dog_owner'), 10, 3);
		add_filter('acf/load_value/name=dgm_name', array($this, 'dog_name'), 10, 3);
		add_filter('acf/load_value/name=dgm_description', array($this, 'dog_description'), 10, 3);
		add_filter('acf/load_field/name=dgm_owners', array($this, 'add_dog_select_friends'));
		add_filter('acf/load_field/name=dgm_friends_as_breeders', array($this, 'add_dog_select_friends'));
		add_filter('acf/load_field/name=dgm_groups_as_breeders', array($this, 'add_groups_as_breeder'));
	}

	protected function get_friends() {
		global $post;
		// reset
		$field['choices'] = array();
		$data = array();

		// This will fall back to current user if author is not yet defined (for new posts).
		// Todo: disable this for options panel (causes php notice)
		$author = get_post_field('post_author', $post->ID);
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
				$field['choices'][$choice] = $val['name'] . ' | ' . $val['email'];
			}
		}

		return $field;
	}

	public function add_groups_as_breeder($field) {
		$groups = $this->get_groups();

		if (is_array($groups)) {
			foreach($groups as $group) {
				$choice = $group->id;
				$field['choices'][$choice] = $group->name;
			}
		}

		return $field;
	}

	// For front end posting (title)
	public function dog_name( $value, $post_id, $field ) {
    $value = get_the_title(); 
    return $value;
	}
	// For front end posting (content)
	public function dog_description( $value, $post_id, $field ) {
    $value = get_the_content(); 
    return $value;
	}

	public function changed_dog_owner($post_ID, $post_after, $post_before) {
		if ( $post_after->post_author !== $post_before->post_author ) {
				delete_field('dgm_owners', $post_ID);
		} 

	}

}

new DogFields;