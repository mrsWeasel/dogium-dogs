<?php
// Do not allow direct access
defined( 'ABSPATH' ) or die( 'No direct access allowed.' );
class DogsTab {
	public function __construct() {
		add_action('bp_actions', array($this, 'add_bp_tabs'));
	}
	public function add_bp_tabs() {
		$user = bp_displayed_user_id();
		$owned_dogs = $this->get_owned_dogs($user);
		$shared_dogs = $this->get_shared_dogs($user);
		$dogs = array_merge($owned_dogs, $shared_dogs);
		$count = count( $dogs );
		$class = $count > 0 ? 'count' : 'no-count';
		// Add "dogs" tab to profile
		bp_core_new_nav_item(array(
			'name' => sprintf(__('Dogs <span class="%s">%s</span>', 'dogium-dog'), $class, number_format_i18n($count)),
			'slug' => 'dogs',
			'position' => 20,
			'screen_function' => array( $this, 'add_profile_template'),
			'default_subnav_slug' => 'dogs'
		) );
	}
	public function get_owned_dogs( $user, $display = false ) {
		$status = array('publish');
		if ($display === true) {
			array_push($status, 'draft');
		}
		// Users own (authored) dogs
		$own_dogs = get_posts(array(
			'author' => $user,
			'post_type' => 'dogium_dog',
			'post_status' => $status
		));
		return $own_dogs;
	}
	// value not matching
	public function get_shared_dogs( $user ) {
		// Dogs assigned by other users
		$shared_dogs = get_posts(array(
			'post_type' => 'dogium_dog',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => 'dgm_owners',
					'value' => '"' . strval($user) . '"',
					'compare' => 'LIKE'
				)
				
			)
		));
		return $shared_dogs;
	}
	public function add_profile_template() {
		add_action('bp_template_content', array($this, 'display_profile_dogs'));
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}
	public function display_profile_dogs() {
		if ( bp_displayed_user_id() === get_current_user_id() ) {
			$button_markup = '';
			$button_markup .= sprintf( '<a href="%s" class="button large primary hollow">', get_site_url() . '/lisaa-uusi-koira' );
			$button_markup .= '<i class="fa fa-plus" aria-hidden="true"></i> ';
			$button_markup .= __('Add new dog', 'dogium-dog');
			$button_markup .= '</a>';
			echo $button_markup;
		}
		$user = bp_displayed_user_id();
		// list draft dogs too, if current user should be able to edit them
		if ( $user === get_current_user_id() || current_user_can('edit_others_dogs') ) {
			$owned_dogs = $this->get_owned_dogs($user, true);
		} else {
			$owned_dogs = $this->get_owned_dogs($user);
		}
		$shared_dogs = $this->get_shared_dogs($user);
		$dogs = array_merge($owned_dogs, $shared_dogs);
		if ( $dogs ) : ?>
			<?php
			foreach ($dogs as $dog) {
				$object = get_post( $dog );
				$id = $object->ID;
				$subheading = get_post_meta($id, 'dgm_official_name', true);
				$content = $object->post_content;
				$link = get_permalink($id);
				$image = get_the_post_thumbnail($id, 'fp-xsmall');
				$image_src = get_template_directory_uri() . '/assets/images/paw.jpg';
				?>
				
				<div class="media-object">
				<div class="media-object-section align-self-top">
				<div class="thumbnail">
					<a href="<?php echo esc_url($link); ?>">
						<?php 
						if ($image) {
							echo $image;
						
						} else {
							?>
							<img src="<?php echo $image_src; ?>" width="320" height="213">
							<?php
						}
						?>
					</a>	
				</div>	
				</div>
				<div class="media-object-section main-section">
					<h3><a href="<?php echo esc_url($link); ?>"><?php echo apply_filters('the_title', $object->post_title); ?></a></h3>
					<?php if ('' != $subheading ) :?>
					<h4 class="subheader"><?php echo esc_html($subheading);?></h4>
					<?php endif;?>
					
					<?php if ($object->post_status == 'draft') :?>
						<span class="label secondary"><?php esc_html_e('Draft', 'dogium-dog'); ?></span>
					<?php endif; ?>
					<?php echo apply_filters('the_content', $object->post_content); ?>
				</div>	
					
				</div>

				<?php
				
			}
		endif;
		
	}
} // DogsTab
// create instance of DogTab class
new DogsTab;