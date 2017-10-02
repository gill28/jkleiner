<?php


//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove the standard loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Execute Practice Single Content

add_action( 'genesis_loop', 'richard_practice_area_post' );
function richard_practice_area_post() {

global $post;

$post_id = get_the_ID( $post->ID );

echo '<div class="pa-container">';

// Left Icon

	$pa_icon = get_post_meta( $post_id , '_richard_pa_featured_icon', true );
	$pa_icon_default = get_post_meta( $post_id , '_richard_pa_featured_icon_default', true );


	if ( $pa_icon ) {
	echo '<div class="pa-left-icon">';
		echo '<img src="'. $pa_icon .'" alt="'. get_the_title() .'" class="practice-area alignone"/>';
	echo '</div>';
	}

	elseif ( $pa_icon_default ) {
	echo '<div class="pa-left-icon">';
		echo '<span class="'. $pa_icon_default .' practice-area-icon">Icon</span>';
	echo '</div>';
	}

	//* Restore original query
	wp_reset_query();

// Main Content
echo '<div class="pa-main-content entry-content">';
	the_content( $post_id );
echo '</div>';

echo '</div>';

}

// Bottom Featured Content
add_action( 'genesis_before_footer', 'richard_bottom_featured', 5 );
function richard_bottom_featured() {

global $post;

$post_id = get_the_ID( $post->ID );

// Featured Video

$video_oembed = get_post_meta( $post_id , '_richard_pa_video_oembed', true );
$video_poster = get_post_meta( $post_id , '_richard_pa_video_poster', true );
$video_desc = get_post_meta( $post_id , '_richard_pa_video_desc', true );
$video_title = get_post_meta( $post_id , '_richard_pa_video_title', true );

	if( !empty( $video_oembed ) ) {

	echo '<div class="wsm-featured-video">';

			if ( function_exists( 'fvc_video' ) ) {

				fvc_video( $video_oembed, $video_poster );

			} else {

				echo '<div class="video-file video-url">';

				echo wp_oembed_get( $video_oembed, array( 'width' => 160, 'height' => 90 ) );

				echo '</div>';

			}


			echo '<div class="video-caption"><div class="video-text">';
			echo '<h3 class="info-heading">'. $video_title .'</h3>';
			if( !empty( $video_desc ) ) {	echo $video_desc; }
			echo '</div></div>';

	echo '</div>';

	}

// Featured Testimonial

$quote_text = get_post_meta( $post_id , '_richard_pa_quote_text', true );
$quote_name = get_post_meta( $post_id , '_richard_pa_quote_name', true );
$quote_company = get_post_meta( $post_id , '_richard_pa_quote_company', true );
$quote_bg = get_post_meta( $post_id , '_richard_pa_quote_bg', true );

$do_bg = '';
if ( $quote_bg ) { $do_bg = ' style="background-image: url(' . $quote_bg .');"'; }

	if(!empty( $quote_text )) {

	echo '<div class="wsm-featured-testimonial"'. $do_bg .'><div class="wrap">';
			echo '<blockquote>';
			echo strip_tags( $quote_text );
			echo '</blockquote>';

			if(!empty( $quote_name )) { echo '<p class="author-name">'. $quote_name .'</p>'; }
			if(!empty( $quote_company )) { echo '<p class="author-company">'. $quote_company .'</p>'; }

	echo '</div></div>';

	}


}

genesis();