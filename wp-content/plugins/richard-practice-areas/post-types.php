<?php
/**
 * Include and setup custom post types.
 *
 */


// Add Practice Area Post Type
add_action( 'init', 'richard_register_practice_area' );
function richard_register_practice_area() {
	$labels = array(
		'name' => __( 'Practice Areas', 'richard-practice-areas' ),
		'singular_name' => __( 'Practice Area', 'richard-practice-areas' ),
		'add_new' => __( 'Add New Practice Area', 'richard-practice-areas' ),
		'add_new_item' => __( 'Add New Practice Area', 'richard-practice-areas' ),
		'edit_item' => __( 'Edit Practice Area', 'richard-practice-areas' ),
		'new_item' => __( 'New Practice Area', 'richard-practice-areas' ),
		'view_item' => __( 'View Practice Area', 'richard-practice-areas' ),
		'search_items' => __( 'Search Practice Area', 'richard-practice-areas' ),
		'not_found' =>  __( 'No Practice Area found', 'richard-practice-areas' ),
		'not_found_in_trash' => __( 'No Practice Areas found in trash', 'richard-practice-areas' ),
		'parent_item_colon' => '',
		'menu_name' => __( 'Practice Areas', 'richard-practice-areas' ),
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'menu_position' => null,
		'menu_icon' => 'dashicons-clipboard',
		'query_var' => true,
		'rewrite' => array( 'slug' => __( 'practice-area', 'richard-practice-areas' ) ),
		'capability_type' => 'post',
		'hierarchical' => true,
		'supports' => array( 'title', 'editor', 'page-attributes', 'excerpt',)
	);

	register_post_type( 'wsm_practice-area', $args );
}

add_filter('gettext','richard_practice_area_name');

function richard_practice_area_name( $input ) {

    global $post_type;

    if( is_admin() && 'Enter title here' == $input && 'practice-area' == $post_type )
        return __( 'Practice Area Title', 'richard-practice-areas' );
    return $input;
}