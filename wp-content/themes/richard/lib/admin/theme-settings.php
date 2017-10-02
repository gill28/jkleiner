<?php
/**
 * Richard Settings
 *
 * This file registers all of Richard's specific Theme Settings, accessible from
 * Genesis --> Richard Settings.
 *
 * NOTE: Change out "RICHARD" in this file with name of theme and delete this note
 */

/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Child Theme Settings page.
 *
 * @since 1.0.0
 *
 * @package richard
 * @subpackage RICHARD_Settings
 */
class RICHARD_Settings extends Genesis_Admin_Boxes {

	/**
	 * Create an admin menu item and settings page.
	 * @since 1.0.0
	 */
	function __construct() {

		// Specify a unique page ID.
		$page_id = 'richard';

		// Set it as a child to genesis, and define the menu and page titles
		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title'  => __( 'Richard Settings', 'richard' ),
				'menu_title'  => __( 'Richard Settings', 'richard' ),
				'capability' => 'manage_options',
			)
		);

		// Set up page options. These are optional, so only uncomment if you want to change the defaults
		$page_ops = array(
		//	'screen_icon'       => 'options-general',
		//	'save_button_text'  => 'Save Settings',
		//	'reset_button_text' => 'Reset Settings',
		//	'save_notice_text'  => 'Settings saved.',
		//	'reset_notice_text' => 'Settings reset.',
		);

		// Give it a unique settings field.
		// You'll access them from genesis_get_option( 'option_name', 'richard-settings' );
		$settings_field = 'richard-settings';

		// Set the default values
		$default_settings = array(
			'wsm_attorneys_count' => '12',
			'wsm_page_top_image' => '[child]/images/top-image.jpg',
			'wsm_practice_area_top_image' => '[child]/images/top-image.jpg',
			'wsm_attorney_top_image' => '[child]/images/top-image.jpg',
			'wsm_search' => 1,
			'wsm_phone' => '248-555-1212',
			'wsm_info' => '30100 Telegraph Road  |  Birmingham, MI 48382 <br />248-555-1212 p  | 248-555-4422 f',
			'wsm_copyright' => '[footer_copyright] Richard Lawyer Theme  |  Richard is a Genesis Theme Designed by Web Savvy Marketing',
			'wsm_extras' => '<img class="alignright" src="[url]/wp-content/uploads/2016/05/tl.png" alt="The Best Lawyers of America" />
<img class="alignright" src="[url]/wp-content/uploads/2016/05/sls.png" alt="Best Law Firms" />
<img class="alignright" src="[url]/wp-content/uploads/2016/05/cuafew.png" alt="Award Winner Logo" />
<img class="alignright" src="[url]/wp-content/uploads/2016/05/blfldl.png" alt="Top Law Firms" />
<img class="alignright" src="[url]/wp-content/uploads/2016/05/tblis.png" alt="" />',
			);

		// Create the Admin Page
		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

		// Initialize the Sanitization Filter
		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );

	}

	/**
	 * Set up Sanitization Filters
	 * @since 1.0.0
	 *
	 * See /lib/classes/sanitization.php for all available filters.
	 */
	function sanitization_filters() {

		genesis_add_option_filter( 'no_html', $this->settings_field,
			array(
				'wsm_attorneys_count',
			) );

		genesis_add_option_filter( 'one_zero', $this->settings_field,
			array(
				'wsm_search',
			) );

		genesis_add_option_filter( 'safe_html', $this->settings_field,
			array(
				'wsm_page_top_image',
				'wsm_practice_area_top_image',
				'wsm_attorney_top_image',
				'wsm_phone',
				'wsm_copyright',
				'wsm_info',
				'wsm_extras',
			) );
	}

	/**
	 * Set up Help Tab
	 * @since 1.0.0
	 *
	 * Genesis automatically looks for a help() function, and if provided uses it for the help tabs
	 * @link http://wpdevel.wordpress.com/2011/12/06/help-and-screen-api-changes-in-3-3/
	 */
	 function help() {
	 	$screen = get_current_screen();

		$screen->add_help_tab( array(
			'id'      => 'sample-help',
			'title'   => 'Sample Help',
			'content' => '<p>Help content goes here.</p>',
		) );
	 }

	/**
	 * Register metaboxes on Child Theme Settings page
	 * @since 1.0.0
	 */
	function metaboxes() {
		add_meta_box('richard_attorneys_metabox', __( 'Attorneys Main', 'richard' ), array( $this, 'richard_attorneys_metabox' ), $this->pagehook, 'main', 'high');
		add_meta_box('richard_top_image_metabox', __( 'Default Top Image', 'richard' ), array( $this, 'richard_top_image_metabox' ), $this->pagehook, 'main', 'high');
		add_meta_box('richard_navigation_metabox', __( 'Menu Extras', 'richard' ), array( $this, 'richard_navigation_metabox' ), $this->pagehook, 'main', 'high');
		add_meta_box('richard_footer_info_metabox', __( 'Footer Info', 'richard' ), array( $this, 'richard_footer_info_metabox' ), $this->pagehook, 'main', 'high');
		add_meta_box('wsm_upate_notifications_metabox', __( 'Update Notifications', 'richard' ), array( $this, 'wsm_upate_notifications_metabox' ), $this->pagehook, 'main', 'high');
	}

	/**
	 * Interior Top Image Metabox
	 * @since 1.0.0
	 */
	function richard_attorneys_metabox() {
		echo '<p><strong>' . __( 'Attorneys Per Page:', 'richard' ) . '</strong> ';
		echo '<input class="small-text" type="text" name="' . $this->get_field_name( 'wsm_attorneys_count' ) . '" id="' . $this->get_field_id( 'wsm_attorneys_count' ) . '" value="' . esc_attr( $this->get_field_value( 'wsm_attorneys_count' ) ) . '" /></p>';
	}

	/**
	 * Interior Top Image Metabox
	 * @since 1.0.0
	 */
	function richard_top_image_metabox() {

	echo '<p><strong>' . __( 'Page Top Image URL', 'richard' ) . '</strong><br>';
	echo '<input class="large-text" type="text" name="' . $this->get_field_name( 'wsm_page_top_image' ) . '" id="' . $this->get_field_id( 'wsm_page_top_image' ) . '" value="' . esc_attr( $this->get_field_value( 'wsm_page_top_image' ) ) . '" /><br><em><small>' . __( ' Recommended image size', 'richard' ) . ' 1200px x 250px</small></em></p>';

	echo '<p><strong>' . __( 'Practice Area Top Image URL', 'richard' ) . '</strong><br>';
	echo '<input class="large-text" type="text" name="' . $this->get_field_name( 'wsm_practice_area_top_image' ) . '" id="' . $this->get_field_id( 'wsm_practice_area_top_image' ) . '" value="' . esc_attr( $this->get_field_value( 'wsm_practice_area_top_image' ) ) . '" /><br><em><small>' . __( ' Recommended image size', 'richard' ) . ' 1200px x 250px</small></em></p>';

	echo '<p><strong>' . __( 'Attorneys Top Image URL', 'richard' ) . '</strong><br>';
	echo '<input class="large-text" type="text" name="' . $this->get_field_name( 'wsm_attorney_top_image' ) . '" id="' . $this->get_field_id( 'wsm_attorney_top_image' ) . '" value="' . esc_attr( $this->get_field_value( 'wsm_attorney_top_image' ) ) . '" /><br><em><small>' . __( ' Recommended image size', 'richard' ) . ' 1200px x 250px</small></em></p>';

	}

	/**
	 * Navigation Extras Metabox
	 * @since 1.0.0
	 */
	function richard_navigation_metabox() {

		echo '<p><input type="checkbox" name="' . $this->get_field_name( 'wsm_search' ) . '" id="' . $this->get_field_id( 'wsm_search' ) . '" value="1"';
        checked( 1, $this->get_field_value( 'wsm_search' ) ); echo '/><strong>' . __( 'Enable Search in Primary Menu', 'richard' ) . '</strong></p>';

		echo '<p><strong>' . __( 'Add Phone Number to Secondary Menu', 'richard' ) . '</strong><br>';
		echo '<input class="medium-text" type="text" name="' . $this->get_field_name( 'wsm_phone' ) . '" id="' . $this->get_field_id( 'wsm_phone' ) . '" value="' . esc_attr( $this->get_field_value( 'wsm_phone' ) ) . '" /></p>';
	}


	/**
	 * Footer Info Metabox
	 * @since 1.0.0
	 */
	function richard_footer_info_metabox() {

		echo '<p><strong>' . __( 'Contact Info', 'richard' ) . '</strong><br>';
		echo '<input class="large-text" type="text" name="' . $this->get_field_name( 'wsm_info' ) . '" id="' . $this->get_field_id( 'wsm_info' ) . '" value="' . esc_attr( $this->get_field_value( 'wsm_info' ) ) . '" /></p>';

		echo '<p><strong>' . __( 'Copyright Info', 'richard' ) . '</strong><br>';
		echo '<input class="large-text" type="text" name="' . $this->get_field_name( 'wsm_copyright' ) . '" id="' . $this->get_field_id( 'wsm_copyright' ) . '" value="' . esc_attr( $this->get_field_value( 'wsm_copyright' ) ) . '" /></p>';

		echo '<p><strong>' . __( 'Footer Right Content', 'richard' ) . '</strong><br>';
		echo __( '(Some HTML is allowed.)', 'richard' ) . '<br>';
		echo '<textarea class="large-text" name="' . $this->get_field_name( 'wsm_extras' ) . '" cols="78" rows="8">' . esc_textarea( $this->get_field_value( 'wsm_extras' ) ) . '</textarea><br><small><em>(Recommended image size for awards icons is 64px wide by 60px high)</em></small></p>';

	}

	/**
	 * Update Notifications Metabox
	 * @since 1.0.0
	 */
	function wsm_upate_notifications_metabox() {

		echo '<p>' . __( 'Please check the box below if you wish to ignore/hide the theme update notification.<br/>Uncheck the box if you wish to be notified of theme updates.', 'richard' ) . '</p>';

		echo '<input type="checkbox" name="' . $this->get_field_name( 'wsm_ignore_updates' ) . '" id="' .  $this->get_field_id( 'wsm_ignore_updates' ) . '" value="1" ';
		checked( 1, $this->get_field_value( 'wsm_ignore_updates' ) );
		echo '/> <label for="' . $this->get_field_id( 'wsm_ignore_updates' ) . '">' . __( 'Ignore Theme Updates?', 'richard' ) . '</label>';

	}


}

/**
 * Add the Theme Settings Page
 * @since 1.0.0
 */
function richard_add_settings() {
	global $_child_theme_settings;
	$_child_theme_settings = new RICHARD_Settings;
}
add_action( 'genesis_admin_menu', 'richard_add_settings' );
