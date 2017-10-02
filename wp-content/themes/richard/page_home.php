<?php

//* Template Name:  Home

do_action( 'genesis_home' );

// Add home body class to the head
add_filter( 'body_class', 'wsm_home_body_class' );
function wsm_home_body_class( $classes ) {

	$classes[] = 'home';
	return $classes;

}

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_action( 'genesis_after_header', 'richard_home_top' );
function richard_home_top() {
	genesis_widget_area( 'rotator', array( 'before' => '<div class="home-slider">', 'after' => '</div>') );
}

// Remove the standard loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Execute custom child loop
add_action( 'genesis_loop', 'richard_home_loop_helper' );
function richard_home_loop_helper() {
	genesis_widget_area( 'home-cta-bar', array( 'before' => '<div class="home-cta-bar">', 'after' => '</div>') );
	genesis_widget_area( 'home-ctas', array( 'before' => '<div class="home-ctas">', 'after' => '</div>') );
	genesis_widget_area( 'home-main', array( 'before' => '<div class="home-main widget-area">', 'after' => '</div>') );
}

genesis();