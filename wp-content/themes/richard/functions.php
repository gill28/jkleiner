<?php

add_action( 'after_setup_theme', 'richard_i18n' );
/**
 * Load the child theme textdomain for internationalization.
 *
 * Must be loaded before Genesis Framework /lib/init.php is included.
 * Translations can be filed in the /languages/ directory.
 *
 * @since 1.2.0
 */
function richard_i18n() {
    load_child_theme_textdomain( 'richard', get_stylesheet_directory() . '/languages' );
}

add_action( 'wp_enqueue_scripts', 'richard_enqueue_assets' );
/**
 * Enqueue theme assets.
 */
function richard_enqueue_assets() {
	wp_enqueue_style( 'richard', get_stylesheet_uri() );
	wp_style_add_data( 'richard', 'rtl', 'replace' );
}

// Start the engine
require_once(TEMPLATEPATH.'/lib/init.php');
require_once( 'lib/init.php' );

// Calls the theme's constants & files
richard_init();

// Editor Styles
add_editor_style( 'editor-style.css' );

/** Create additional color style options */
add_theme_support( 'genesis-style-selector',
	array(
		'richard-option1' => 'Red',
		'richard-option2' => 'Green',
		'richard-option3' => 'Orange',
		'richard-option4' => 'Dark Blue',
		'richard-option5' => 'Rose',
	)
);

// Force Stupid IE to NOT use compatibility mode
add_filter( 'wp_headers', 'richard_keep_ie_modern' );
function richard_keep_ie_modern( $headers ) {
	if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false ) ) {
		$headers['X-UA-Compatible'] = 'IE=edge,chrome=1';
	}
	return $headers;
}

// Add new image sizes
add_image_size( 'grid', 335, 220, TRUE );
add_image_size( 'feature', 743, 391, TRUE );
add_image_size( 'attorney', 346, 374, TRUE );

// Move the post image to the entry header
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 6);

// Add Image & Date wrapper
add_action( 'genesis_entry_header', 'genesis_do_open_div', 5);
function genesis_do_open_div() {
	if( is_category() || is_tag() || is_archive() || is_home() || is_search() ) {
		echo '<div class="image-date">';
	}
}

// Closed Image & Date wrapper
// Add Date
add_action( 'genesis_entry_header', 'genesis_do_closed_div', 8);
function genesis_do_closed_div() {

	if( is_category() || is_tag() || is_archive() || is_home() || is_search() ) {

		$attachments = get_children( array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image') );

		if ( ! empty($attachments ) || has_post_thumbnail() ) {
			echo '<span class="entry-date">' . get_the_date( 'M <b>d</b>' ) .'</span>';
		}
		else {
			echo '<span class="entry-date">' . get_the_date( 'M d, Y' ) .'</span>';
		}
		echo '</div>';
	}
}

// Add Single Post Featured Image
add_action( 'genesis_entry_header', 'richard_do_post_image', 5 );
function richard_do_post_image() {
	global $post;
	if( ! is_singular( 'post' ) ) {
		return;
	}
	$feature_image = get_post_meta($post->ID, '_richard_post_image_url', true);
	if ( $feature_image ) {
		echo '<img class="post-image" src="' . $feature_image . '" alt="' . get_the_title( $post->ID ) . '" />';
	}
}

// Add custom body class if has featured image
add_filter( 'body_class', 'sp_body_class' );
function sp_body_class( $classes ) {
	global $post;

	$feature_image = get_post_meta($post->ID, '_richard_post_image_url', true);

	if ( $feature_image )
		$classes[] = 'has-featured-image';
		return $classes;
}

// Customize the Search Box
add_filter( 'genesis_search_button_text', 'custom_search_button_text' );
function custom_search_button_text( $text ) {
    return esc_attr( 'Go', 'richard' );
}


// Modify the author box display
add_filter( 'genesis_author_box', 'richard_author_box' );
function richard_author_box() {
	$authinfo = '';
	$authdesc = get_the_author_meta( 'description' );

	if( !empty( $authdesc ) ) {
		$authinfo .= sprintf( '<section %s>', genesis_attr( 'author-box' ) );
		$authinfo .= get_avatar( get_the_author_id() , 168, '', get_the_author_meta( 'display_name' ) . '\'s avatar' ) ;
		$authinfo .= '<h3 class="author-box-title">' . __( 'About ', 'richard' ) . get_the_author_meta( 'display_name' ) . '</h3>';
		$authinfo .= '<div class="author-box-content" itemprop="description">';
		$authinfo .= '<p>' . get_the_author_meta( 'description' ) . '</p>';
		$authinfo .= '</div>';
		$authinfo .= '</section>';
	}
	if ( is_author() || is_single() ) {
		echo $authinfo;
	}
}

// Customize the entry meta in the entry header
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter( $post_info ) {

	if ( ! is_singular( 'post' ) )  {
		return;
	}

	global $post;
	$feature_image = get_post_meta($post->ID, '_richard_post_image_url', true);

	if ( $feature_image ) {
		$post_info = '[post_date before="" format="M <b>d</b>"] [post_comments before=" " ]';
	}
	else {
		$post_info = '[post_date before="" format="M d, Y"] [post_comments before=" " ]';
	}

	return $post_info;
}

// Relocate the entry meta in the entry header
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 8 );

// Customize the post meta function
add_filter( 'genesis_post_meta', 'post_meta_filter' );
function post_meta_filter( $post_meta ) {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
    $post_meta = '[post_categories sep=", " before="<b>' . __( 'Categories:', 'richard' ) . '</b> "] [post_tags sep=", " before="<b>' . __( 'Tags:', 'richard' ) . '</b> "]';
    return $post_meta;
}

// Add Read More button to blog page and archives
add_filter( 'excerpt_more', 'richard_add_excerpt_more' );
add_filter( 'get_the_content_more_link', 'richard_add_excerpt_more' );
add_filter( 'the_content_more_link', 'richard_add_excerpt_more' );
function richard_add_excerpt_more( $more ) {
    return '<span class="more-link"><a href="' . get_permalink() . '" rel="nofollow">' . __( 'Read More', 'richard' ) . '</a></span>';
}

/*
 * Add support for targeting individual browsers via CSS
 * See readme file located at /lib/js/css_browser_selector_readm.html
 * for a full explanation of available browser css selectors.
 */
add_action( 'get_header', 'richard_load_scripts' );
function richard_load_scripts() {
    wp_enqueue_script( 'browserselect', CHILD_URL . '/lib/js/css_browser_selector.js', array('jquery'), '0.4.0', TRUE );
}


// Set default theme locations for menus
add_theme_support ( 'genesis-menus' ,
	array (
		'primary'   => __( 'Primary Navigation Menu', 'richard' ),
		'secondary' => __( 'Secondary Navigation Menu', 'richard' ),
	)
);


// Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header_right', 'genesis_do_nav' );

// Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_header', 'genesis_do_subnav' );


// Add Search Icon to Primary Menu
add_filter( 'genesis_nav_items', 'be_search_icons', 10, 2 );
add_filter( 'wp_nav_menu_items', 'be_search_icons', 10, 2 );
function be_search_icons( $menu, $args ) {

	$search = genesis_get_option( 'wsm_search', 'richard-settings' );

	$args = (array)$args;
	if ( 'primary' !== $args['theme_location'] || empty( $search ) ) {
		return $menu;
	}

	ob_start();
	get_search_form();
	$search = ob_get_clean();
	$menu_right  .= '<li class="search menu-item last"><span id="show_hide">' . __( 'Search', 'richard' ) . '</span><div class="slidingDiv" style="display:none;">' . $search . '</div></li>';
	return $menu . $menu_right;
}


// Add Phone Info to Secondary Menu
add_filter( 'genesis_nav_items', 'be_phone_info', 10, 2 );
add_filter( 'wp_nav_menu_items', 'be_phone_info', 10, 2 );
function be_phone_info( $menu, $args ) {

	$args = (array)$args;
	$phone = genesis_get_option( 'wsm_phone', 'richard-settings' );
	if ( 'secondary' !== $args['theme_location'] || empty( $phone ) ) {
		return $menu;
	}

	$menu_right  .= '<li class="phone menu-item last"><a href="tel:' . strip_tags( $phone ) . '">' . strip_tags( $phone ) . '</a></li>';
	return $menu . $menu_right;

}

// Move Genesis Comments
add_action( 'genesis_before_comments' , 'richard_move_comments' );
function richard_move_comments () {
  if ( is_single() && have_comments() ) {
    remove_action( 'genesis_comment_form', 'genesis_do_comment_form' );
    add_action( 'genesis_comments', 'genesis_do_comment_form', 5 );
  }
}


// Change size of comment avatars.
add_filter( 'genesis_comment_list_args', 'childtheme_comment_list_args' );
function childtheme_comment_list_args( $args ) {
    $args['avatar_size'] = 64;
	return $args;
}

// Unregister Layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Add support for 2-column footer widgets
add_theme_support( 'genesis-footer-widgets', 2);

// Setup Sidebars
unregister_sidebar( 'sidebar-alt' );
unregister_sidebar( 'header-right' );

genesis_register_sidebar( array(
	'id'			=> 'rotator',
	'name'			=> __( 'Rotator', 'richard' ),
	'description'	=> __( 'This is the image rotator section.', 'richard' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-main',
	'name'			=> __( 'Home Main Section', 'richard' ),
	'description'	=> __( 'This is the home page widget section.', 'richard' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'blog-sidebar',
	'name'			=> __( 'Blog Sidebar', 'richard' ),
	'description'	=> __( 'This is the Blog Page Sidebar.', 'richard' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'page-sidebar',
	'name'			=> __( 'Page Sidebar', 'richard' ),
	'description'	=> __( 'This is the Page Sidebar.', 'richard' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'footer-social',
	'name'			=> __( 'Footer Social Media', 'richard' ),
	'description'	=> __( 'This is the Footer Social Media Icons Section.', 'richard' ),
) );


// Remove Genesis Blog Template
add_filter( 'theme_page_templates', 'richard_remove_genesis_page_templates' );
function richard_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}

// Add Posts Social Share
add_action( 'genesis_entry_footer', 'richard_post_ssbp' );
function richard_post_ssbp() {

if ( ! is_singular( 'post' ) ) return;

	if ( function_exists ( 'show_share_buttons' ) ) { echo do_shortcode(' [ssba] '); }
}

// Gravity Forms anchor
add_filter( 'gform_confirmation_anchor', '__return_true' );
