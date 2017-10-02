<?php
/**
 * Child after header
 *
 * @category     Child
 * @package      Structure
 * @author       Web Savvy Marketing
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        2.0.0
 */


// Add Top image

add_action( 'genesis_after_header' , 'richard_do_top_image' , 10 );
function richard_do_top_image() {
	global $post;

	//default Image
	$page_default_image = genesis_get_option( 'wsm_page_top_image', 'richard-settings' );
	$pa_default_image = genesis_get_option( 'wsm_practice_area_top_image', 'richard-settings' );
	$attorney_default_image = genesis_get_option( 'wsm_attorney_top_image', 'richard-settings' );

	//New Image Url
	$new_image = get_post_meta($post->ID, '_richard_top_image_url', true);
	// Hide Image
	$hide_image = get_post_meta( $post->ID, '_richard_top_image_hide', true);


	// skip all the other checks if the image should be hidden
	if ( ! empty( $hide_image ) )
		return;


		if ( !is_front_page() && !is_page_template( 'page_home.php' ) && is_page() ) {

		if ( ! empty( $new_image ) ) {

			//* Remove the entry title (requires HTML5 theme support)
			remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

			echo '<div class="top-image page-top-image">';
			echo '<img src="' . $new_image . '" alt="' . get_the_title( $post->ID ) . '" class="banner-image" />';
			echo '<div class="wrap">';
			the_title( '<h1 class="entry-title">', '</h1>' );
			echo '</div></div>';
		}

		elseif ( ! empty( $page_default_image ) ) {
			//* Remove the entry title (requires HTML5 theme support)
			remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

			echo '<div class="top-image page-top-image default-image" >';
			echo '<img src="' . do_shortcode( $page_default_image ) . '" alt="' . get_the_title( $post->ID ) . '" class="banner-image" />';
			echo '<div class="wrap">';
			the_title( '<h1 class="entry-title">', '</h1>' );
			echo '</div></div>';
		}

	}

	elseif ( is_singular('wsm_practice-area') ) {

		if ( ! empty( $new_image ) ) {
			echo '<div class="top-image pa-top-image">';
			echo '<img src="' . do_shortcode( $new_image ) . '" alt="' . get_the_title( $post->ID ) . '" class="banner-image" />';
			echo '<div class="wrap">';
			the_title( '<h1 class="entry-title">', '</h1>' );
			echo '</div></div>';
		}

		elseif ( ! empty( $pa_default_image ) ) {
			echo '<div class="top-image pa-top-imag default-image" >';
			echo '<img src="' . do_shortcode( $pa_default_image ) . '" alt="' . get_the_title( $post->ID ) . '" class="banner-image" />';
			echo '<div class="wrap">';
			the_title( '<h1 class="entry-title">', '</h1>' );
			echo '</div></div>';
		}

	}

	elseif ( is_singular('wsm_attorney') ) {

		if ( ! empty( $new_image ) ) {
			echo '<div class="top-image attorney-top-image">';
			echo '<img src="' . do_shortcode( $new_image ) . '" alt="'. get_the_title( $post->ID ) .'" class="banner-image" />';
			echo '<div class="wrap">';
			the_title( '<h1 class="entry-title">', '</h1>' );
			echo '</div></div>';
		}

		elseif ( ! empty( $attorney_default_image ) ) {
			echo '<div class="top-image attorney-top-imag default-image" >';
			echo '<img src="' . do_shortcode( $attorney_default_image ) . '" alt="' . get_the_title( $post->ID ) . '" class="banner-image" />';
			echo '<div class="wrap">';
			the_title( '<h1 class="entry-title">', '</h1>' );
			echo '</div></div>';
		}

	}

}