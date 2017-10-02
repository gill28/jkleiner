<?php

/*
 * Plugin Name: Richard Attorneys
 * Plugin URI: http://www.web-savvy-marketing.com/
 * Description: Attorney custom post type.
 * Author: Web Savvy Marketing
 * Version: 1.0
 * Author URI: http://www.web-savvy-marketing.com/
 * 
 * Text Domain: richard-attorneys
 *
 */


// Get all the things
require_once( dirname( __FILE__ ) . '/post-types.php' );
require_once( dirname( __FILE__ ) . '/metaboxes.php' );

// Load Translations
add_action( 'plugins_loaded', 'richard_attorneys_init' );
function richard_attorneys_init() {
	load_plugin_textdomain( 'richard-attorneys', false, 'richard-attorneys/languages' );
}