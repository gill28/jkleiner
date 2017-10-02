<?php

/*
 * Plugin Name: Richard Practice Areas
 * Plugin URI: http://www.web-savvy-marketing.com/
 * Description: Practice Area custom post type.
 * Author: Web Savvy Marketing
 * Version: 1.0
 * Author URI: http://www.web-savvy-marketing.com/
 * 
 * Text Domain: richard-practice-areas
 *
 */


// Get all the things
require_once( dirname( __FILE__ ) . '/post-types.php' );
require_once( dirname( __FILE__ ) . '/metaboxes.php' );

// Load Translations
add_action( 'plugins_loaded', 'richard_practice_areas_init' );
function richard_practice_areas_init() {
	load_plugin_textdomain( 'richard-practice-areas', false, '/languages' );
}
