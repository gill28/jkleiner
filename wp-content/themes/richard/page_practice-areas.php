<?php

/*
 * Template Name: Practice Areas
 *
 */

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );


// Execute attorneys loop
add_action( 'genesis_after_loop', 'richard_practice_area_loop' );
function richard_practice_area_loop() {


echo '<div class="pa-container">';

	global $wp_query;
	global $post;
	global $paged, $page;

	$query_args = array(
				'post_type' => 'wsm_practice-area',
				'showposts' => 25,
				'order' => 'ASC',
				'paged' => get_query_var( 'paged' ),
	);

	$wp_query = new WP_Query( $query_args );

			if ( $wp_query -> have_posts() ) :

			while ( $wp_query -> have_posts() ) :

						$wp_query -> the_post();

						$post_id = get_the_ID( $post->ID );

						$pa_icon = get_post_meta( $post_id , '_richard_pa_featured_icon', true );
						$pa_icon_default = get_post_meta( $post_id , '_richard_pa_featured_icon_default', true );

						$do_pa_icon= '';

						if ( $pa_icon ) { $do_pa_icon = '<img src="'. $pa_icon .'" alt="'. get_the_title() .'" class="practice-area-icon alignnone" />'; }
						elseif ( $pa_icon_default ) { $do_pa_icon = '<span class="'. $pa_icon_default .' practice-area-icon">Icon</span>'; }

						$do_pa = '';

						$do_pa .= sprintf('<div class="pa-icon-title alignleft"><a href="%s" title="%s">', get_permalink(), the_title_attribute( 'echo=0' ));
						$do_pa .= sprintf( $do_pa_icon );
						$do_pa .= sprintf( '<h2 class="pa-name">'. get_the_title() .'</h2>' );
						$do_pa .= sprintf('</a></div>');
						if ( has_excerpt( $post_id ) ) {
						$do_pa .= sprintf('<div class="pa-excerpt">');
						$do_pa .= sprintf( get_the_excerpt() );
						$do_pa .= sprintf('<div class="more-link"><a href="' .get_permalink($post_id) .'">Learn More</a></div>');
						$do_pa .= sprintf('</div>');
						}

						$toggle = $toggle == 'odd' ? 'even' : 'odd';

						printf( '<div class="%s practice-area entry one-half" id="attorney-%s">%s</div>', $toggle, $post_id,  $do_pa );

			endwhile;


			//* Restore original query
			wp_reset_query();

			$cta_title = get_post_meta( $post->ID , '_richard_pas_cta_title', true );
			$cta_content = get_post_meta( $post->ID , '_richard_pas_cta_content', true );
			$cta_link = get_post_meta( $post->ID , '_richard_pas_cta_link', true );


			if ( $cta_title ) {
			echo '<div class="cta-bar one-half">';
			if ( $cta_link ) { echo '<h2 class="cta-bar-title"><a href="'. $cta_link .'">'. $cta_title .'</a></h2>'; }
			else { echo '<h2 class="cta-bar-title">'. $cta_title .'</h2>'; }
			if ( $cta_content ) { echo '<div class="cta-bar-content">'. $cta_content .'</div>'; }
			echo '</div>';

			}

				echo '</div>';

				genesis_posts_nav();

			endif;


echo '</div>';

}


genesis();