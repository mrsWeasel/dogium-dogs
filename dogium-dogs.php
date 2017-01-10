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
require_once('php/class-dog-fields.php');
require_once('php/class-dogs-tab.php');
require_once('php/class-dog-forms.php');
require_once('php/helpers.php');
//require_once('php/class-dog-edit-form.php');