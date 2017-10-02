<?php


//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove the standard loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Execute Attorney Single Content

add_action( 'genesis_loop', 'richard_attorney_page' );
function richard_attorney_page() {

global $post;

$post_id = get_the_ID( $post->ID );


// Contact Details

$attorney_img = genesis_get_image( array( 'format' => 'html', 'size' => 'attorney', 'attr' => array( 'class' => 'featured-image alignone' ) ) );
$attorney_contact_heading = get_post_meta( $post_id , '_richard_attorney_contact_heading', true );
$attorney_address = get_post_meta( $post_id , '_richard_attorney_contact_address', true );
$attorney_phone = get_post_meta( $post_id , '_richard_attorney_contact_phone', true );
$attorney_fax = get_post_meta( $post_id , '_richard_attorney_contact_fax', true );
$attorney_email = get_post_meta( $post_id , '_richard_attorney_contact_email', true );
$attorney_linkedin = get_post_meta( $post_id , '_richard_attorney_contact_linkedin', true );
$attorney_facebook = get_post_meta( $post_id , '_richard_attorney_contact_facebook', true );
$attorney_twitter = get_post_meta( $post_id , '_richard_attorney_contact_twitter', true );
$attorney_gplus = get_post_meta( $post_id , '_richard_attorney_contact_gplus', true );

echo '<div class="attorney-left-info">';

echo $attorney_img;

echo '<div class="left-info">';

if ( ! empty( $attorney_contact_heading ) ) { echo '<h4 class="info-heading">'. $attorney_contact_heading .'</h4>'; }

	if ( $attorney_address ) {  echo '<p class="attorney-address">'. $attorney_address .'</p>'; }
	if ( $attorney_phone ) {  echo '<p class="attorney-phone">'. strip_tags( $attorney_phone ) .'</p>'; }
	if ( $attorney_fax ) {  echo '<p class="attorney-fax">'. strip_tags( $attorney_fax ) .'</p>'; }
	if ( $attorney_email ) {  echo '<p class="attorney-email"><a href="mailto:'. $attorney_email  .'">'. strip_tags( $attorney_email ) .'</a></p>'; }

echo '<div class="social-share widget-social">';
	if ( $attorney_linkedin ) { echo '<a href="'. $attorney_linkedin .'" class="genericon genericon-linkedin" target="_blank" title="Linkedin">Linkedin</a>'; }
	if ( $attorney_facebook ) { echo '<a href="'. $attorney_facebook .'" class="genericon genericon-facebook-alt" target="_blank" title="Facebook">Facebook</a>'; }
	if ( $attorney_twitter ) { echo '<a href="'. $attorney_twitter .'" class="genericon genericon-twitter" target="_blank" title="Twitter">Twitter</a>'; }
	if ( $attorney_gplus ) { echo '<a href="'. $attorney_gplus .'" class="genericon genericon-googleplus-alt" target="_blank" title="Google +">Google +</a>'; }
echo '</div>';

// Education

$schools_heading = get_post_meta( $post_id , '_richard_attorney_education_heading', true );
$schools = get_post_meta( $post_id , '_richard_attorney_education_group', true );

if ( $schools ) {

if ( $schools_heading ) { echo '<h4 class="info-heading">'. $schools_heading .'</h4>'; }

echo '<ul class="education-list">';

foreach ( (array) $schools as $key => $school ) {

	$school_name = $school_desc = '';

	if ( isset( $school['_richard_attorney_school_name'] ) )
	$school_name = strip_tags($school['_richard_attorney_school_name']);
	if ( isset( $school['_richard_attorney_school_desc'] ) )
	$school_desc = $school['_richard_attorney_school_desc'];

	$do_school = '';
	if ( $school_name ) { $do_school .= '<span class="school-name">'. $school_name .'</span>'; }
	if ( $school_desc ) { $do_school .= '<span class="school_desc">'. $school_desc .'</span>'; }

	printf( '<li>%s</li>', $do_school );

}

echo '</ul>';

//* Restore original query
wp_reset_query();

}

// Associations

$associations_heading = get_post_meta( $post_id , '_richard_attorney_associations_heading', true );
$associations = get_post_meta( $post_id , '_richard_attorney_associations_group', true );

if ( $associations ) {

if ( $associations_heading ) { echo '<h4 class="info-heading">'. $associations_heading .'</h4>'; }

echo '<ul class="association-list">';

foreach ( (array) $associations as $key => $association ) {

	$association_name = '';

	if ( isset( $association['_richard_attorney_association_name'] ) )
	$association_name = strip_tags($association['_richard_attorney_association_name']);


	$do_association = '';
	if ( $association_name ) { $do_association .= '<span class="association_name">'. $association_name .'</span>'; }

	printf( '<li>%s</li>', $do_association );

}

echo '</ul>';

//* Restore original query
wp_reset_query();

}

echo '</div>';

echo '</div>';


// Main Content

echo '<div class="attorney-content entry-content">';

	$short_desc = get_post_meta( $post_id , '_richard_attorney_short_desc', true );

	if ( $short_desc ) { echo '<div class="intro-text">' . $short_desc .'</div>'; }

	$industries = get_post_meta( $post_id , '_richard_attorney_industry_group', true );
	$get_practice_areas = get_post_meta( $post_id , '_richard_attorney_select_pa', true );

	// Practice Area

	$pa_heading = get_post_meta( $post_id , '_richard_attorney_pa_heading', true );

	if ( !empty( $get_practice_areas ) || !empty( $industries ) ) { echo '<div class="practice-area-indutry">'; }

	if ( !empty( $get_practice_areas ) ) {

	 $args = wp_parse_args( $query_args, array(
         'post_type'   => 'wsm_practice-area',
         'post__in' => $get_practice_areas,
     ) );

     $posts = get_posts( $args );

		 if ( $posts ) {
		 if ( $pa_heading ) { echo '<h4 class="info-heading">'. $pa_heading .'</h4>'; }
		 echo '<ul class="practice-areas">';
			foreach ( $posts as $post ) {
			   echo '<li><a href="'. get_permalink() .'">'. get_the_title() .'</a></li>';
			}

		echo '</ul>';

		}

	}

	// Industries
	$industries_heading = get_post_meta( $post_id , '_richard_attorney_industries_heading', true );

	if ( $industries ) {

	if ( $industries_heading ) { echo '<h4 class="info-heading">'. $industries_heading .'</h4>'; }

	echo '<ul class="industries">';

	foreach ( (array) $industries as $key => $industry ) {

		$industry_name = '';

		if ( isset( $industry['_richard_attorney_industry_name'] ) )
		$industry_name = strip_tags($industry['_richard_attorney_industry_name']);


		$do_industry = '';
		if ( $industry_name ) { $do_industry .= '<li>'. $industry_name .'</li>'; }
		echo $do_industry;

	}

	echo '</ul>';

	}

	if ( !empty( $get_practice_areas ) || !empty( $industries ) ) { echo '</div>'; }

		//* Restore original query
	wp_reset_query();


	 the_content($post_id);


// Awards

	$awards_heading = get_post_meta( $post_id , '_richard_attorney_awards_heading', true );
	$awards = get_post_meta( $post_id , '_richard_attorney_awards_group', true );

	if ( $awards ) {

	echo '<div class="awards-list">';

	if ( $awards_heading ) { echo '<h4 class="info-heading">'. $awards_heading .'</h4>'; }

	foreach ( (array) $awards as $key => $award ) {

		$association_name = '';

		if ( isset( $award['_richard_attorney_award_logo'] ) )
		$award_logo = strip_tags($award['_richard_attorney_award_logo']);


		$do_award = '';
		if ( $award_logo ) { $do_award .= '<img class="alignleft awards-logo" src="'. $award_logo .'" alt=""/>'; }
		echo $do_award;

	}

	echo '</div>';

	//* Restore original query
	wp_reset_query();

	}

	echo '</div>';


}

genesis();