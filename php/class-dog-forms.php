<?php
/**
 * Front end form handling
 * @author Laura Heino
 * @since 1.0.0
 */
	class DogForms {
		public function __construct() {
			add_filter( 'get_delete_post_link', array( $this, 'dogium_change_delete_post_link' ), 10, 3 );
			add_action( 'deleted_post', array( $this, 'redirect_after_delete') );
		}

		protected $field_groups = array(
			'name' => 2763,
			'breed' => 2769,
			'basic' => 2764,
			'owners' => 2765,
			'breeders' => 2742,
			'desc' => 2766,
			'gallery' => 2768,
			'comments' => 2776
			// Todo: Replace with objects
		);

		public function print_delete_confirm() {
		global $post;
			if (! current_user_can('edit_post', $post->ID) ) {
				// bail if current user can not edit this post
				return;
			} else {
				$delete_dog_link = $this->change_delete_post_link($post->ID, '', true);

				$output = '';
				$output .= '<div class="reveal" id="delete-dog-modal" data-reveal>';
				$output .= '<div class="callout alert">';
				$output .= esc_html("You're about to delete this dog permanently. Are you sure you want to proceed?", 'dogium-dog');
				$output .= '</div>';
				$output .= '<div class="button-group">';
				$output .= '<button class="button secondary" data-close type="button">';
				$output .= esc_html('Cancel', 'dogium-dog');
				$output .= '</button>';
				$output .= "<a class='button alert' type='button' href='{$delete_dog_link}''>";
				$output .= esc_html('Delete', 'dogium-dog');
				$output .= '</a>';
				$output .= '</div>';
				$output .= '</div>';

				echo $output;
			}	
		}
		public function redirect_after_delete($post_id) {
			$deleted_post = get_post( $post_id );
			$author = $deleted_post->post_author;
		    $user_domain = bp_core_get_user_domain( $author ) . 'dogs';
		    // if we are in the front end, redirect to 'dogs' tab of the author
		    if ( filter_input( INPUT_GET, 'frontend', FILTER_VALIDATE_BOOLEAN ) ) {
	        	wp_redirect( $user_domain );
	        	exit;
	    	}
		}

		public function change_delete_post_link(  $id = 0, $deprecated = '', $force_delete = false ) {
		    global $post;
		    $action = ( $force_delete || !EMPTY_TRASH_DAYS ) ? 'delete' : 'trash';
		    $qargs = array(
		        'action' => $action,
		        'post' => $post->ID,
		        'user' => get_current_user_id(),
		        // Add parameter to find out if we're in the front end
		        'frontend' => true
		    );
		    $delete_link = add_query_arg( $qargs, admin_url() . 'post.php' );
		    // Use nonce for added security
		    return  wp_nonce_url( $delete_link, "$action-post_{$post->ID}" );
		}

			// Edit form for dogs
		public function print_edit_form() {
			global $post;
			if (!current_user_can('edit_post', $post->ID) ) {
				// bail if current user can not edit this post
				return;
			} else {

			$field_groups = $this->field_groups;	

			$html_before = '<div class="reveal" id="edit-dog-modal" data-reveal>';
			$html_after = '<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button></div>';
			// only show this form for dog post type
				if (is_singular('dogium_dog')) {

					$options = array(
					'post_id' => $post->ID,
					'field_groups' => $field_groups,
					'form' => true,
						'form_attributes' => array(
						'id' => 'post',
						'class' => '',
						'action' => '',
						'method' => 'post',
						),
					'return' => add_query_arg( 'updated', 'true', get_permalink() ),
					'html_before_fields' => '',
					'html_after_fields' => '',
					'submit_value' => __('Save changes', 'dogium'),
					'updated_message' => __('Dog updated', 'dogium'),
					'uploader' => 'basic'
					);

					echo $html_before;
					acf_form( $options );
					echo $html_after;

				}
			}
		}

		public function print_new_dog_form() {
			global $post;
			if (!current_user_can('publish_posts') ) {
				// bail if current user can not publish posts
				return;
			} else {

			// Todo: Replace with objects	
			$field_groups = $this->field_groups;

			$options = array(
				'post_id' => 'new_post',
				'post_title' => false,
				'post_content' => false,
				'new_post' => array(
					'post_type' => 'dogium_dog',
					'post_status' => 'publish'
				),
				'field_groups' => $field_groups,
				'form' => true,
					'form_attributes' => array(
					'id' => 'post',
					'class' => '',
					'action' => '',
					'method' => 'post',
					),
				'return' => '%post_url%',
				'html_before_fields' => '',
				'html_after_fields' => '',
				'submit_value' => __('Create new dog', 'dogium-dog'),
				'updated_message' => '',
				'uploader' => 'basic'
				);
				acf_form( $options );

			}
			
		}
	} // class DogForms	