<?php
// Do not allow direct access
defined( 'ABSPATH' ) or die( 'No direct access allowed.' );

class DogsTab {

	public function __construct() {
		add_action('bp_actions', array($this, 'add_bp_tabs'));
	}

	public function add_bp_tabs() {
		$dogs = $this->get_all_dogs();
		$count = count( $dogs );
		$class = $count > 0 ? 'count' : 'no-count';
		// Add "dogs" tab to profile
		bp_core_new_nav_item(array(
			'name' => sprintf(__('Dogs <span class="%s">%s</span>', 'dogium-dog'), $class, number_format_i18n($count)),
			'slug' => 'dogs',
			'position' => 60,
			'screen_function' => array( $this, 'add_profile_template'),
			'default_subnav_slug' => 'dogs'

		) );
	}

	public function get_owned_dogs( $user ) {
		// Users own (authored) dogs
		$own_dogs = get_posts(array(
			'author' => $user,
			'post_type' => 'dogium_dog',
			'post_status' => 'publish'
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

	public function get_all_dogs() {
		$user = bp_displayed_user_id();

		$own_dogs = $this->get_owned_dogs($user);
		$shared_dogs = $this->get_shared_dogs($user);

		$dogs = array_merge($own_dogs, $shared_dogs);
		return $dogs;

	}

	public function add_profile_template() {
		add_action('bp_template_content', array($this, 'display_profile_dogs'));
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	public function display_profile_dogs() {
		$dogs = $this->get_all_dogs();

		if ( $dogs ) : ?>
			<?php
			foreach ($dogs as $dog) {
				$object = get_post( $dog );
				$id = $object->ID;
				$subheading = get_field('dgm_official_name', $id);
				$content = $object->post_content;
				$link = get_permalink($id);
				$image = get_the_post_thumbnail($id, 'fp-xsmall');
				?>
				
				<div class="media-object">
				<div class="media-object-section align-self-top">
				<div class="thumbnail">
					<a href="<?php echo esc_url($link); ?>">
						<?php echo $image; ?>
					</a>	
				</div>	
				</div>
				<div class="media-object-section main-section">
					<h3><a href="<?php echo esc_url($link); ?>"><?php echo apply_filters('the_title', $object->post_title); ?></a></h3>
					<?php if ('' != $subheading ) :?>
					<h4 class="subheader"><?php echo esc_html($subheading);?></h4>
					<?php endif;?>
					<?php echo apply_filters('the_content', $object->post_content); ?>
				</div>	
					
				</div>

				<?
				
			}
		endif;

		if ( bp_displayed_user_id() === get_current_user_id() ) {
			// tähän painike koiran lisäämiseksi frontendista käsin
		}
	}
} // DogsTab

// create instance of DogTab class
new DogsTab;