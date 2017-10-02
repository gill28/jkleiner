<?php
/**
 * Include and setup custom post types.
 *
 */


// Add Attorney Post Type
add_action( 'init', 'wsm_register_attorney_post_type' );
function wsm_register_attorney_post_type() {
	$labels = array(
		'name' => __( 'Attorneys', 'richard-attorneys' ),
		'singular_name' => __( 'Attorney', 'richard-attorneys' ),
		'add_new' => __( 'Add New Attorney', 'richard-attorneys' ),
		'add_new_item' => __( 'Add New Attorney', 'richard-attorneys' ),
		'edit_item' => __( 'Edit Attorney', 'richard-attorneys' ),
		'new_item' => __( 'New Attorney', 'richard-attorneys' ),
		'view_item' => __( 'View Attorney', 'richard-attorneys' ),
		'search_items' => __( 'Search Attorney', 'richard-attorneys' ),
		'not_found' =>  __( 'No Attorney found', 'richard-attorneys' ),
		'not_found_in_trash' => __( 'No Attorneys found in trash', 'richard-attorneys' ),
		'parent_item_colon' => '',
		'menu_name' => __( 'Attorneys', 'richard-attorneys' ),
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
		'menu_icon' => 'dashicons-businessman',
		'query_var' => true,
		'rewrite' => array( 'slug' => __( 'attorney', 'richard-attorneys' ) ),
		'capability_type' => 'post',
		'hierarchical' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes', )
	);

	register_post_type( 'wsm_attorney', $args );
}

add_filter('gettext','richard_attorney_name');

function richard_attorney_name( $input ) {

    global $post_type;

    if( is_admin() && 'Enter title here' == $input && 'attorney' == $post_type )
        return __( 'NAME GOES HERE', 'richard-attorneys' );
    return $input;
}