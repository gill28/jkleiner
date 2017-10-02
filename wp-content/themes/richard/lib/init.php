<?php
/**
 * Richard Child Init File
 *
 * This file calls the Child and Genesis init.php files.
 *
 * @category     Richard
 * @package      Admin
 * @author       Web Savvy Marketing
 * @copyright    Copyright (c) 2012, Web Savvy Marketing
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0.0
 */

/**
 * This function defines the Genesis Child theme constants
 * and calls necessary theme files
 *
 */
function richard_init() {
	// Child theme (do not remove)
	define( 'CHILD_THEME_NAME', 'Richard' );
	define( 'CHILD_THEME_URL', 'http://www.web-savvy-marketing.com/store/' );
	define( 'CHILD_THEME_VERSION', wp_get_theme()->get( 'Version' ) );
	define( 'RICHARD_SETTINGS_FIELD', 'richard-settings' );
	define( 'SOLILOQUY_LICENSE_KEY', 'YinP3ZMcnSl0kc+QbvQnzyXBfKRYyPm8p1DJfsC5nLY=' );

	// Developer Information (do not remove)
	define( 'CHILD_DEVELOPER', 'Web Savvy Marketing' );
	define( 'CHILD_DEVELOPER_URL', 'http://www.web-savvy-marketing.com/'  );

	/** Define Directory Location Constants */
	if ( ! defined( 'CHILD_DIR' ) )
		define( 'CHILD_DIR', get_stylesheet_directory() );

	/** Define URL Location Constants */
	if ( ! defined( 'CHILD_URL' ) )
	define( 'CHILD_URL', get_stylesheet_directory_uri() );
	define( 'RICHARD_URL', get_stylesheet_directory_uri() );
	define( 'RICHARD_DIR', get_stylesheet_directory() );
	define( 'RICHARD_LIB', CHILD_URL . '/lib' );
	define( 'RICHARD_IMAGES', CHILD_URL . '/images' );
	define( 'RICHARD_ADMIN', CHILD_LIB . '/admin' );
	define( 'RICHARD_ADMIN_IMAGES', CHILD_LIB . '/images' );
	define( 'RICHARD_JS' , CHILD_URL .'/lib/js' );

	// Load admin files when necessary
	if ( is_admin() ) {
		// Plugins
		include_once( CHILD_DIR . '/lib/plugins/plugins.php' );

		// Theme Settings
		require_once( CHILD_DIR . '/lib/admin/theme-settings.php' );

	}

	// Add HTML5 markup structure
	add_theme_support( 'html5', array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
		) );

	// Add Mobile Responsive Viewport meta tag
	add_theme_support( 'genesis-responsive-viewport' );

	// Add Genesis Accessibility Features
	add_theme_support( 'genesis-accessibility', array(
			'404-page',
			'drop-down-menu',
			'headings',
			'rems',
			'search-form',
			'skip-links',
		) );

	// Add structural wraps
	add_theme_support( 'genesis-structural-wraps', array(
		'header',
		'menu-primary',
		'menu-secondary',
		'footer-widgets',
		'footer',
		'site-inner',
	) );

	//Structure
	include_once( CHILD_DIR . '/lib/structure/post.php');
	include_once( CHILD_DIR . '/lib/structure/sidebar.php');
	include_once( CHILD_DIR . '/lib/structure/comment-form.php');
	include_once( CHILD_DIR . '/lib/structure/footer.php');
	include_once( CHILD_DIR . '/lib/structure/top-image.php');

	// Shortcodes
	include_once( CHILD_DIR . '/lib/functions/shortcodes.php');

	// Setup Widgets
	include_once( CHILD_DIR . '/lib/widgets/call-to-action-bar.php');
	include_once( CHILD_DIR . '/lib/widgets/call-to-action.php');
	include_once( CHILD_DIR . '/lib/widgets/title.php');
	include_once( CHILD_DIR . '/lib/widgets/widget-social.php');
	include_once( CHILD_DIR . '/lib/widgets/wsm-featured-page.php');
	include_once( CHILD_DIR . '/lib/widgets/wsm-featured-post.php');
	include_once( CHILD_DIR . '/lib/widgets/wsm-featured-video.php');
	include_once( CHILD_DIR . '/lib/widgets/wsm-featured-widget.php');

	//include extras
	include_once( CHILD_DIR . '/lib/functions/metaboxes.php');
	include_once( CHILD_DIR . '/lib/functions/hide-search.php');
	include_once( CHILD_DIR . '/lib/functions/full-video-cover.php');

	// Enable Gravity Forms setting to hide form labels
	add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

	// Remove Edit link
	add_filter( 'edit_post_link', '__return_false' );

	// Enqueue Genericons font
	add_action( 'wp_enqueue_scripts', 'richard_load_fonts' );

	// Mobile menu
	include_once( CHILD_DIR . '/lib/functions/mobilemenu.php');

	// Enable Customizer Support for site title, description, and widgets
	add_action( 'customize_register', 'wsm_customize_register' );
	add_theme_support( 'customize-selective-refresh-widgets' );

}

function wsm_customize_register( WP_Customize_Manager $wp_customize ) {
	global $wp_version;
	if ( $wp_version < 4.5 ) {
		return;
	}
    $wp_customize->selective_refresh->add_partial( 'blogname', array(
        'selector' => '.site-title a',
        'render_callback' => function() {
            bloginfo( 'name' );
        },
    ) );
}

// Setting up Google Fonts URL
function richard_google_fonts_url() {
    $fonts_url = '';

    /* Translators: If there are characters in your language that are not
    * supported by Open Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    $yantramanav = _x( 'on', 'Yantramanav font: on or off', 'richard' );

    /* Translators: If there are characters in your language that are not
    * supported by Prata, translate this to 'off'. Do not translate
    * into your own language.
    */
    $libre_baskerville = _x( 'on', 'Libre Baskerville font: on or off', 'richard' );

    if ( 'off' !== $yantramanav || 'off' !== $libre_baskerville ) {
        $font_families = array();

        if ( 'off' !== $yantramanav ) {
            $font_families[] = 'Yantramanav:400,300,500,700';
        }

        if ( 'off' !== $libre_baskerville ) {
            $font_families[] = 'Libre Baskerville:400,400italic,700';
        }

        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );

        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }

    return esc_url_raw( $fonts_url );
}

function richard_load_fonts() {
	wp_register_style( 'genericons', CHILD_URL . '/lib/genericons/genericons.css', array(), CHILD_THEME_VERSION, 'all' );
	wp_enqueue_style( 'genericons' );
	wp_enqueue_style( 'richard-fonts', richard_google_fonts_url(), array(), null );
	wp_enqueue_style( 'material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), null );
}

add_filter( 'http_request_args', 'richard_dont_update_theme', 5, 2 );
/**
 * Don't Update Theme
 * If there is a theme in the repo with the same name,
 * this prevents WP from prompting an update.
 *
 * @author Mark Jaquith
 * @link http://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
 *
 * @param array $r Request arguments
 * @param string $url Request url
 * @return array $r Request arguments
 */
function richard_dont_update_theme( $r, $url ) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
		return $r; // Not a theme update request. Bail immediately.
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );
	$r['body']['themes'] = serialize( $themes );
	return $r;
}