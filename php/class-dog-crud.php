<?php

// Do not allow direct access
defined( 'ABSPATH' ) or die( 'No direct access allowed.' );

class DogCrud {
	// internal method for inserting new page if it does not exist yet
	private function insert_new_page($page_title, $args) {
		if ( get_page_by_title($page_title) == NULL ) {
			wp_insert_post( $args );
		}
	}

	public function use_dog_template($template) {
		if ( is_page('add-dog') ) {
			$file = 'page-add-dog.php';
			$template = plugin_dir_path(__FILE__) . '/templates/' . $file;
		}
		return $template;
		 
	}
	// will be run on plugin activation
	public function add_dog_page() {
		$page_title = 'Add Dog';
		$args = array(
			'post_title' => $page_title,
			'post_status' => 'publish',
			'post_type' => 'page',
			'comment_status' => false
		);

		$this->insert_new_page($page_title, $args);
	}
}

// create instance for activation hook
$dog_crud = new DogCrud;