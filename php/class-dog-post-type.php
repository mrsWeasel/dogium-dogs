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
			'add_new_item' => __('Add new dog', 'dogium-dog'),
			'edit_item' => __('Edit dog', 'dogium-dog'),
			'new_item' => __('New dog', 'dogium-dog'),
			'all_items' => __('All dogs', 'dogium-dog'),
			'view_item' => __('View dog', 'dogium-dog'),
			'search_items' => __('Search dogs', 'dogium-dog'),
			'not_found' => __('No dogs found', 'dogium-dog'),
			'not_found_in_trash' => __('No dogs found in the trash', 'dogium-dog'),
			'parent_item_colon' => '&rarr;',
			'menu_name' => __('Dogs', 'dogium-dog')
		);

		$args = array(
			'labels' => $labels,
			'description' => __('Dogs owned by community members', 'dogium-dog'),
			'public' => true,
			'has_archive' => true,
			'hierarchical' => true,
			'rewrite' => array('slug' => 'dog'),
			'supports' => array('title', 'editor', 'author', 'thumbnail', 'comments', 'page-attributes'),
	 	);

	 	register_post_type('dogium_dog', $args);

	}

	// "Breed" custom taxonomy for Dogs
	public function register_breed_taxonomy() {
		register_taxonomy(
			'dogium_breed',
			'dogium_dog',
			array(
				'label' => __('Breed', 'dogium-dog'),
				'hierarchical' => true,
				'rewrite' => array(
					'slug' => 'rotu',
				)
			)
		);
	}

	public function add_term_other() {
		if (!term_exists('Muu', 'dogium_breed')) {
			wp_insert_term('Muu', 'dogium_breed');
		}
	}
} // DogPostType
new DogPostType;