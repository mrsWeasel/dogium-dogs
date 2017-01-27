<?php
/*
Plugin Name: Dogium Dogs
Plugin URI:  http://dogium.com
Description: Custom Plugin for creating custom "dog" posts and sharing them with other BP users. This plugin requires BuddyPress and ACF to function properly. 
Version:     1.0.0.
Author:      Laura Heino
Author URI:  http://dogium.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: dogium-dog
Domain Path: /languages
*/

// Do not allow direct access
defined( 'ABSPATH' ) or die( 'No direct access allowed.' );

function dogium_dog_enqueue_scripts() {
	wp_enqueue_script( 'dogium-dog-fields', plugin_dir_url(__FILE__) . 'js/fields.js' , array('jquery'), '2.6.1', true );
}

add_action('wp_enqueue_scripts', 'dogium_dog_enqueue_scripts');

require_once('php/register-custom-fields.php');
require_once('php/class-dog-post-type.php');
require_once('php/class-dog-fields.php');
require_once('php/class-dogs-tab.php');
require_once('php/class-dog-forms.php');
require_once('php/helpers.php');
