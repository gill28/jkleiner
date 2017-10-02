<?php

/*
 * Template Name: Attorneys
 *
 */

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove the standard loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Execute attorneys loop
add_action( 'genesis_loop', 'richard_attorneys_loop' );
function richard_attorneys_loop() {


echo '<div class="attorneys-container">';

	global $wp_query;
	global $post;
	global $paged, $page;

	$attorneys_count = genesis_get_option( 'wsm_attorneys_count', 'richard-settings' );

	$query_args = array(
				'post_type' => 'wsm_attorney',
				'showposts' => $attorneys_count,
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'paged' => get_query_var( 'paged' ),
	);

	$wp_query = new WP_Query( $query_args );

			if ( $wp_query -> have_posts() ) :

			while ( $wp_query -> have_posts() ) :

						$wp_query -> the_post();

						$post_id = get_the_ID( $post->ID );

						$attorney_short_desc = get_post_meta( $post_id , '_richard_attorney_short_desc', true );
						$attorney_job_title = get_post_meta( $post_id , '_richard_attorney_job_title', true );

						$attorney_img = genesis_get_image( array( 'format' => 'html', 'size' => 'attorney', 'attr' => array( 'class' => 'featured-image alignone' ) ) );

						$attorney = '';

						if ( has_post_thumbnail()) { $attorney .= sprintf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $attorney_img ); }
						$attorney .= sprintf( '<div class="attorney-header">' );
						$attorney .= sprintf( '<h2 class="attorney-name"><a href="%s" title="%s">%s</a></h2>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_title() );
						if (!empty( $attorney_job_title ) ) { $attorney .= sprintf( '<p class="job_title">'. $attorney_job_title .'</p>' ); }
						$attorney .= sprintf('<div class="more-link"><a href="' .get_permalink($post_id) .'">Bio</a></div>');
						$attorney .= sprintf( '</div>' );
						if (!empty( $attorney_short_desc ) ) { $attorney .= sprintf( '<div class="short_desc">'. $attorney_short_desc .'</div>' ); }

						printf( '<div class="attorney entry one-third" id="attorney-'.$post_id.'">%s</div>',  $attorney );

			endwhile;

				genesis_posts_nav();

			endif;

	echo '</div>';

//* Restore original query
wp_reset_query();


}


genesis();