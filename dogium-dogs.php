<?php
/*
Plugin Name: Dogium Dogs
Plugin URI:  http://dogium.com
Description: Custom Plugin for creating custom "dog" posts and sharing them with other BP users. This plugin requires BuddyPress and ACF to function properly. 
Version:     1.0.0.
Author:      Laura Heino
Author URI:  http://lauraheino.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: dogium-dogs
Domain Path: /languages
*/

// Do not allow direct access
defined( 'ABSPATH' ) or die( 'No direct access allowed.' );

function dogium_dog_enqueue_scripts() {
	wp_enqueue_script( 'dogium-dog-fields', plugin_dir_url(__FILE__) . 'js/fields.js' , array('jquery'), '2.6.1', true );
}

add_action('plugins_loaded', 'dogium_dog_load_textdomain');

function dogium_dog_acf_init() {
	
	acf_update_setting('l10n_textdomain', 'dogium-dogs');
	
}

add_action('acf/init', 'dogium_dog_acf_init');

function dogium_dog_load_textdomain() {
	load_plugin_textdomain( 'dogium-dogs', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}

add_action('wp_enqueue_scripts', 'dogium_dog_enqueue_scripts');

require_once('php/register-custom-fields.php');
require_once('php/class-dog-post-type.php');
require_once('php/class-dog-fields.php');
require_once('php/class-dogs-tab.php');
require_once('php/class-dog-forms.php');
require_once('php/helpers.php');
