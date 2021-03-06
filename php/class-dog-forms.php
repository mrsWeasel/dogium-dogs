<?php
/**
 * Front end form handling
 * @author Laura Heino
 * @since 1.0.0
 */
	class DogForms {
		public function __construct() {
			add_filter( 'get_delete_post_link', array( $this, 'change_delete_post_link' ), 10, 3 );
			add_action( 'deleted_post', array( $this, 'redirect_after_delete') );
			add_action( 'admin_post_publish_dog', array( $this, 'publish_post' ) );
			add_filter('acf/update_value/name=dgm_featured_image', array($this, 'save_featured_image'), 10, 3);
			add_filter('acf/update_value/name=dgm_breeds', array($this, 'save_breed'), 10, 3);
			add_action('acf/save_post', array($this, 'set_commenting_status'), 1 );
		}
		protected $field_groups = array(
			'name' => 'group_586e4536b0de8',
			'breed' => 'group_586e46bd652ce',
			'breed_other' => 'group_5874c79f11bc1',
			'basic' => 'group_586e4553c0474',
			'owners' => 'group_586e45a60e790',
			'breeders' => 'group_586e18a2caf2e',
			'description' => 'group_586e45d2e8da0',
			'gallery' => 'group_586e462e3c0e4',
			'comments' => 'group_58736638f39eb'
		);
		public function save_breed($value,$post_id,$field) {
			    if($value != '') {
			    	// If term is not 'Muu' there shouldn't be content in 'other' text input
			    	$term_other_id = get_term_by('name', 'Muu', 'dogium_breed')->term_id;
			    	$term_other_id = intval( $term_other_id );
			    	
			    	if ( $value !== $term_other_id ) {
			    		delete_post_meta($post_id, 'dgm_other_what');
			    	}
	    			// We need to pass an array even though we just have one term to add
					// Assign new category and wipe any existing one			    
	    			wp_set_object_terms($post_id, intval( $value ), 'dogium_breed');
    			}
    			return $value;
		}
		public function save_featured_image($value,$post_id,$field) {
			    if($value != '') {
	    		//Add the value which is the image ID to the _thumbnail_id meta data for the current post
	    			update_post_meta($post_id, '_thumbnail_id', $value);
    			} else {
    				delete_post_meta($post_id, '_thumbnail_id', $value);
    			}
 
    			return $value;
		}
		public function set_commenting_status( $post_id ) {
			$post = get_post($post_id);
		    if ($post->post_type !== 'dogium_dog') {
		    	return;
		    }
			if (empty($_POST['acf'])) {
				return;
			}
			$field = $_POST['acf']['field_587366523c31c'];
			$choices = array('open', 'closed');
			if (! in_array($field, $choices)) {
				return;
			}
		    $updated_post = array(
		    	'ID' => $post_id,
		    	'comment_status' => $field
		    );
		    wp_update_post($updated_post);
		
		}
		public function print_delete_confirm() {
		global $post;
			if (! current_user_can('edit_dog', $post->ID) ) {
				// bail if current user can not edit this post
				return;
			} else {
				$delete_dog_link = $this->change_delete_post_link($post->ID, '', true);
				$output = '';
				$output .= '<div class="reveal" id="delete-dog-modal" data-reveal>';
				$output .= '<div class="callout alert">';
				$output .= esc_html__("You're about to delete this dog permanently. Are you sure you want to proceed?", 'dogium-dogs');
				$output .= '</div>';
				$output .= '<div class="button-group">';
				$output .= '<button class="button secondary" data-close type="button">';
				$output .= esc_html__('Cancel', 'dogium-dogs');
				$output .= '</button>';
				$output .= "<a class='button alert' type='button' href='{$delete_dog_link}''>";
				$output .= esc_html__('Delete', 'dogium-dogs');
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
		public function publish_post($post_id) {
			// This action is not allowed for non logged in users
			if ( ! is_user_logged_in() ) {
				return;
			}

			$post_id = $_POST['post_id'];

			$nonce = $_REQUEST['_publish-dog'];
			if ( !isset( $nonce ) || ! wp_verify_nonce( $nonce, 'publish-dog_' . $post_id ) ) {
				die( 'Security check failed.' );
			}

			$link = get_permalink($post_id);
			$args = array(
				'ID' => $post_id,
				'post_status' => 'publish'
			);
				
			wp_update_post($args);
			wp_redirect( $link );
			exit;
			//print_r($args);
		}
		public function print_publish_form() {
			global $post;
			if (!current_user_can('edit_dog', $post->ID)) {
				return;
			}
			$action = esc_url( admin_url('admin-post.php') );
			$post_id = $post->ID;
			//$action = plugin_dir_url(__FILE__) . 'publish-post.php';
			$html = '';
			$html .= '<div class="reveal" id="publish-dog-modal" data-reveal>';
			$html .= '<p>';
			$html .= esc_html__('You are about to publish this dog. After publishing, it will be visible to all users.', 'dogium-dogs');
			$html .= '</p>';
			$html .= "<form action='{$action}' method='post'>";
			$html .= '<div class="button-group">';
			$html .= '<button class="button secondary" data-close type="button">';
			$html .= esc_html__('Cancel', 'dogium-dogs');
			$html .= '</button>';
			$html .= '<button class="button success" type="submit">';
			$html .= esc_html__('Publish', 'dogium-dogs');
			$html .= '</button>';
			$html .= '</div>';
			$html .= '<input type="hidden" name="action" value="publish_dog">';
			$html .= "<input type='hidden' name='post_id' value='{$post_id}'>";
			$html .= wp_nonce_field('publish-dog_' . $post->ID, '_publish-dog');
			$html .= '</form>';
			$html .= '</div>';
			echo $html;
		}

			// Edit form for dogs
		public function print_edit_form() {
			global $post;
			if (!current_user_can('edit_dog', $post->ID) ) {
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
					'post_title' => true,
					'post_content' => false,
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
					'submit_value' => __('Save changes', 'dogium-dogs'),
					'updated_message' => __('Dog updated', 'dogium-dogs'),
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
			if (!current_user_can('publish_dogs') ) {
				// bail if current user can not publish posts
				return;
			} else {
			// Todo: Replace with objects	
			$field_groups = $this->field_groups;
			$options = array(
				'post_id' => 'new_post',
				'post_title' => true,
				'post_content' => false,
				'field_groups' => array( $field_groups['name'], $field_groups['breed'], $field_groups['breed_other'] ),
				'new_post' => array(
					'post_status' => 'draft',
					'post_type' => 'dogium_dog',
					'post_author' => get_current_user_id()
				),
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
				'submit_value' => __('Create new dog', 'dogium-dogs'),
				'updated_message' => '',
				'uploader' => 'basic'
				);
				acf_form( $options );
			}
			
		}
	} // class DogForms	
	new DogForms;