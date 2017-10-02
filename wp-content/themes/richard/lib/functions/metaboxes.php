<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */
$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);


if ( file_exists( CHILD_DIR . '/lib/metabox/init.php' ) ) {
	require_once CHILD_DIR . '/lib/metabox/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

add_action( 'cmb2_init', 'richard_register_about_page_metabox' );
/**
 * Single Post Meta
 */
function richard_register_about_page_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_richard_post_';

	$cmb_post_meta = new_cmb2_box( array(
		'id'           => $prefix . 'post_metabox',
		'title'        => __( 'Top Featured Image', 'richard' ),
		'object_types' => array( 'post', ), // Post type
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true,
	) );

	$cmb_post_meta->add_field( array(
		'name' => __( 'Featured Image URL', 'richard' ),
		'desc' => __( 'Recommended image size is 743px wide by 391px high.', 'richard' ),
		'id'   => $prefix . 'image_url',
		'type' => 'file',
	) );

}

add_action( 'cmb2_init', 'richard_register_practice_area_metabox' );
/**
 * Practice Areas Page
 */
function richard_register_practice_area_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_richard_pas_';

	$cmb_pas_cta = new_cmb2_box( array(
		'id'           => $prefix . 'pas_cta_metabox',
		'title'        => __( 'CTA Bar', 'richard' ),
		'object_types' => array( 'page', ), // Post type
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true,
		'show_on'      => array( 'key' => 'page-template', 'value' => 'page_practice-areas.php' ),
	) );

	$cmb_pas_cta->add_field( array(
		'name' => __( 'CTA Title', 'richard' ),
		'id'   => $prefix . 'cta_title',
		'type' => 'text',
	) );

	$cmb_pas_cta->add_field( array(
		'name' => __( 'CTA Content', 'richard' ),
		'id'   => $prefix . 'cta_content',
		'type' => 'textarea',
	) );

	$cmb_pas_cta->add_field( array(
		'name' => __( 'CTA Link', 'richard' ),
		'id'   => $prefix . 'cta_link',
		'type' => 'text',
	) );
}


// Register Top Image metabox

if ( $template_file != 'page_home.php' ) {
	add_action( 'cmb2_init', 'richard_top_image_metabox' );
}

function richard_top_image_metabox() {

	$prefix = '_richard_top_image_';

	$cmb_page_metabox = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Top Image Settings', 'richard' ),
		'object_types' => array( 'page', 'wsm_attorney' , 'wsm_practice-area' ), // Post type
		'context'      => 'normal',
		'priority'     => 'high',
	) );

	$cmb_page_metabox->add_field( array(
		'name' => __( 'Customize Top Image', 'richard' ),
		'desc'   => __( 'Upload a custom page top image below if desired. The default top image is configured in the Genesis --> Richard Settings', 'richard' ),
		'id'   => $prefix . 'instruction_info',
		'type' => 'title',
	) );

	$cmb_page_metabox->add_field( array(
		'name' => __( 'Image URL', 'richard' ),
		'desc'   => __( 'Recommended image size is 743px wide by 391px high.', 'richard' ),
		'id'   => $prefix . 'url',
		'type' => 'file',
	) );

	$cmb_page_metabox->add_field( array(
		'name' => __( 'Hide Top Image', 'richard' ),
		'desc'   => __( 'Prevent any top image from displaying on this page.', 'richard' ),
		'id'   => $prefix . 'hide',
		'type' => 'checkbox',
	) );

}