<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 */

/**
 * Get the bootstrap!
 */

if ( file_exists( dirname( __FILE__ ) . '/metabox/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/metabox/init.php';
}

// Get practice-area Post type
function wsm_get_pa_post_options( $query_args ) {

     $args = wp_parse_args( $query_args, array(
         'post_type'   => 'practice-area',
         'numberposts' => -1,
     ) );

     $posts = get_posts( $args );

     $post_options = array();
     if ( $posts ) {
         foreach ( $posts as $post ) {
           $post_options[ $post->ID ] = $post->post_title;
         }
     }

     return $post_options;
}

add_action( 'cmb2_init', 'wsm_register_attorneys_metabox' );
function wsm_register_attorneys_metabox() {


	// Start with an underscore to hide fields from custom fields list
	$prefix = '_richard_attorney_';
	
		
	/**
	 * Intro
	 */
	$cmb_attorney_intro = new_cmb2_box( array(
		'id'           => $prefix . 'intro_metabox',
		'title'        => __( 'Details', 'richard-attorneys' ),
		'object_types' => array( 'wsm_attorney', ), // Post type
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true,
	) );
	
	$cmb_attorney_intro->add_field( array(
		'name' => __( 'Job Title', 'richard-attorneys' ),
		'id'   => $prefix . 'job_title',
		'type' => 'text',
	) );

	$cmb_attorney_intro->add_field( array(
		'name' => __( 'Short Description', 'richard-attorneys' ),
		'id'   => $prefix . 'short_desc',
		'type' => 'textarea',
	) );
	
	/**
	 * Practice Area
	 */
	$cmb_attorney_pa = new_cmb2_box( array(
		'id'           => $prefix . 'attorney_pa_metabox',
		'title'        => __( 'Practice Areas', 'richard-attorneys' ),
		'object_types' => array( 'wsm_attorney', ), // Post type
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true,
	) );
	
	$cmb_attorney_pa->add_field( array(
		'name' => __( 'Section Heading', 'richard-attorneys' ),
		'id'   => $prefix . 'pa_heading',
		'type' => 'text',
		'default' => ' Practice Area',
	) );
	
	$cmb_attorney_pa ->add_field( array(
	'name'     => __( 'Practice Areas', 'richard-attorneys' ),
	'id'       => $prefix . 'select_pa',
	'type'	=> 'multicheck',
	'options' => 'wsm_get_pa_post_options',
	) );
	
	/**
	 * Industries
	 */
	$cmb_attorney_industries = new_cmb2_box( array(
		'id'           => $prefix . 'attorney_industries_metabox',
		'title'        => __( 'Industries', 'richard-attorneys' ),
		'object_types' => array( 'wsm_attorney', ), // Post type
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true,
	) );
	
	$cmb_attorney_industries->add_field( array(
		'name' => __( 'Section Heading', 'richard-attorneys' ),
		'id'   => $prefix . 'industries_heading',
		'type' => 'text',
		'default' => 'Industries',
	) );
	
	$industries_field_id = $cmb_attorney_industries->add_field( array(
		'id'          => $prefix . 'industry_group',
		'type'        => 'group',
		'options'     => array(
			'group_title'   => __( 'Industry {#}', 'richard-attorneys' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Industry', 'richard-attorneys' ),
			'remove_button' => __( 'Remove Industry', 'richard-attorneys' ),
			'sortable'      => true,
		),
	) );

	$cmb_attorney_industries->add_group_field( $industries_field_id, array(
		'name'       => __( 'Industry Name', 'richard-attorneys' ),
		'id'         => $prefix .'industry_name',
		'type'       => 'text',
	) );

	/**
	 * Contact Info
	 */
	$cmb_attorney_contact = new_cmb2_box( array(
		'id'           => $prefix . 'contact_metabox',
		'title'        => __( 'Contact Details', 'richard-attorneys' ),
		'object_types' => array( 'wsm_attorney', ), // Post type
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true,
	) );
	$cmb_attorney_contact->add_field( array(
		'name' => __( 'Section Heading', 'richard-attorneys' ),
		'id'   => $prefix . 'contact_heading',
		'type' => 'text',
		'default' => 'Contact',
	) );
	$cmb_attorney_contact->add_field( array(
		'name' => __( 'Address', 'richard-attorneys' ),
		'id'   => $prefix . 'contact_address',
		'type' => 'textarea_small',
	) );
	$cmb_attorney_contact->add_field( array(
		'name' => __( 'Phone', 'richard-attorneys' ),
		'id'   => $prefix . 'contact_phone',
		'type' => 'text_medium',
	) );
	$cmb_attorney_contact->add_field( array(
		'name' => __( 'Fax', 'richard-attorneys' ),
		'id'   => $prefix . 'contact_fax',
		'type' => 'text_medium',
	) );
	$cmb_attorney_contact->add_field( array(
		'name' => __( 'Email', 'richard-attorneys' ),
		'id'   => $prefix . 'contact_email',
		'type' => 'text_medium',
	) );
	$cmb_attorney_contact->add_field( array(
		'name' => __( 'Linkedin', 'richard-attorneys' ),
		'id'   => $prefix . 'contact_linkedin',
		'type' => 'text',
	) );
	$cmb_attorney_contact->add_field( array(
		'name' => __( 'Facebook', 'richard-attorneys' ),
		'id'   => $prefix . 'contact_facebook',
		'type' => 'text',
	) );
	$cmb_attorney_contact->add_field( array(
		'name' => __( 'Twitter', 'richard-attorneys' ),
		'id'   => $prefix . 'contact_twitter',
		'type' => 'text',
	) );
	$cmb_attorney_contact->add_field( array(
		'name' => __( 'Google +', 'richard-attorneys' ),
		'id'   => $prefix . 'contact_gplus',
		'type' => 'text',
	) );

	/**
	 * Education Info
	 */

	$cmb_attorney_education = new_cmb2_box( array(
		'id'           => $prefix . 'education_metabox',
		'title'        => __( 'Education', 'richard-attorneys' ),
		'object_types' => array( 'wsm_attorney', ),
	) );
	
	$cmb_attorney_education->add_field( array(
		'name' => __( 'Section Heading', 'richard-attorneys' ),
		'id'   => $prefix . 'education_heading',
		'type' => 'text',
		'default' => 'Education',
	) );

	$education_field_id = $cmb_attorney_education->add_field( array(
		'id'          => $prefix . 'education_group',
		'type'        => 'group',
		'options'     => array(
			'group_title'   => __( 'School {#}', 'richard-attorneys' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another School', 'richard-attorneys' ),
			'remove_button' => __( 'Remove School', 'richard-attorneys' ),
			'sortable'      => true,
		),
	) );

	$cmb_attorney_education->add_group_field( $education_field_id, array(
		'name'       => __( 'School Name', 'richard-attorneys' ),
		'id'         => $prefix .'school_name',
		'type'       => 'text',
	) );

	$cmb_attorney_education->add_group_field( $education_field_id, array(
		'name'        => __( 'Description', 'richard-attorneys' ),
		'id'          => $prefix .'school_desc',
		'type'        => 'text',
	) );
	
	/**
	 * Associations
	 */

	$cmb_attorney_associations = new_cmb2_box( array(
		'id'           => $prefix . 'associations_metabox',
		'title'        => __( 'Associations', 'richard-attorneys' ),
		'object_types' => array( 'wsm_attorney', ),
	) );
	
	$cmb_attorney_associations->add_field( array(
		'name' => __( 'Section Heading', 'richard-attorneys' ),
		'id'   => $prefix . 'associations_heading',
		'type' => 'text',
		'default' => 'Associations',
	) );

	$associations_field_id = $cmb_attorney_associations->add_field( array(
		'id'          => $prefix . 'associations_group',
		'type'        => 'group',
		'options'     => array(
			'group_title'   => __( 'Association {#}', 'richard-attorneys' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Association', 'richard-attorneys' ),
			'remove_button' => __( 'Remove Association', 'richard-attorneys' ),
			'sortable'      => true,
		),
	) );

	$cmb_attorney_associations->add_group_field( $associations_field_id, array(
		'name'       => __( 'Association Name', 'richard-attorneys' ),
		'id'         => $prefix .'association_name',
		'type'       => 'text',
	) );
	
	/**
	 * Membership/Awards
	 */

	$cmb_attorney_awards = new_cmb2_box( array(
		'id'           => $prefix . 'awards_metabox',
		'title'        => __( 'Membership/Awards', 'richard-attorneys' ),
		'object_types' => array( 'wsm_attorney', ),
	) );
	
	$cmb_attorney_awards->add_field( array(
		'name' => __( 'Section Heading', 'richard-attorneys' ),
		'id'   => $prefix . 'awards_heading',
		'type' => 'text',
		'default' => 'Membership & Awards',
	) );

	$awards_field_id = $cmb_attorney_awards->add_field( array(
		'id'          => $prefix . 'awards_group',
		'type'        => 'group',
		'options'     => array(
			'group_title'   => __( 'Membership/Award {#}', 'richard-attorneys' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Membership/Award', 'richard-attorneys' ),
			'remove_button' => __( 'Remove Membership/Award', 'richard-attorneys' ),
			'sortable'      => true,
		),
	) );

	$cmb_attorney_awards->add_group_field( $awards_field_id, array(
		'name'       => __( 'Logo', 'richard-attorneys' ),
		'id'         => $prefix .'award_logo',
		'type'       => 'file',
	) );
	
}
