<?php
// Do not allow direct access
defined( 'ABSPATH' ) or die( 'No direct access allowed.' );

// Dog post type
class DogPostType {
	public function __construct() {
		add_action('init', array($this, 'register_dog_post_type'));
		add_action('init', array($this, 'register_breed_taxonomy'));
		add_action('init', array($this, 'add_term_other'));
	}
	public function register_dog_post_type() {
		$labels = array(
			'name' => _x('Dogs', 'post type general name'),
			'singular_name' => _x('Dog', 'post type singular name'),
			'add_new' => _x('Add new', 'dog'),
			'add_new_item' => __('Add new dog', 'dogium-dogs'),
			'edit_item' => __('Edit dog', 'dogium-dogs'),
			'new_item' => __('New dog', 'dogium-dogs'),
			'all_items' => __('All dogs', 'dogium-dogs'),
			'view_item' => __('View dog', 'dogium-dogs'),
			'search_items' => __('Search dogs', 'dogium-dogs'),
			'not_found' => __('No dogs found', 'dogium-dogs'),
			'not_found_in_trash' => __('No dogs found in the trash', 'dogium-dogs'),
			'parent_item_colon' => '&rarr;',
			'menu_name' => __('Dogs', 'dogium-dogs')
		);

		$args = array(
			'labels' => $labels,
			'description' => __('Dogs owned by community members', 'dogium-dogs'),
			'public' => true,
			'has_archive' => true,
			'hierarchical' => false,
			'rewrite' => array('slug' => 'dog'),
			'supports' => array('title', 'author', 'thumbnail', 'comments'),
			'capability_type' => 'dog',
			'capabilities' => array(
		        'edit_post' => 'edit_dog',
		        'edit_posts' => 'edit_dogs',
		        'edit_others_posts' => 'edit_others_dogs',
		        'publish_posts' => 'publish_dogs',
		        'read_post' => 'read_dog',
		        'read_private_posts' => 'read_private_dogs',
		        'delete_post' => 'delete_dog'
		    ),
		    'map_meta_cap' => true
	 	);

	 	register_post_type('dogium_dog', $args);

	}

	// "Breed" custom taxonomy for Dogs
	public function register_breed_taxonomy() {
		register_taxonomy(
			'dogium_breed',
			'dogium_dog',
			array(
				'label' => __('Breed', 'dogium-dogs'),
				'hierarchical' => true,
				'rewrite' => array(
					'slug' => 'rotu',
				)
			)
		);
	}

	public function add_term_other() {
		if ( !term_exists('Muu', 'dogium_breed') ) {
			wp_insert_term('Muu', 'dogium_breed');
		}
	}
} // DogPostType
new DogPostType;