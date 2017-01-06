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

require_once('php/class-dog-post-type.php');
//require_once('php/register-dog-custom-fields.php');
require_once('php/class-dog-crud.php');
require_once('php/class-dog-fields.php');
require_once('php/class-dogs-tab.php');
require_once('php/helpers.php');

// Activation hook
register_activation_hook( __FILE__, array( $dog_crud, 'add_dog_page' ) );
add_action('template_include', array( $dog_crud, 'use_dog_template' ));