<?php
/*
Add back Schema.org/blogPosting microdata to post entries.

*/


add_filter( 'genesis_attr_body', 'wsm_attributes_body' );
/**
 * If viewing blog post or archive, make this a Blog page type.
 */
function wsm_attributes_body( $attributes ) {

	if ( is_singular( 'post' ) || is_archive() || is_home() || is_page_template( 'page_blog.php' ) ) {
		$attributes['itemtype']  = 'http://schema.org/Blog';
	}

	return $attributes;

}

add_filter( 'genesis_attr_entry', 'wsm_attributes_entry' );
/**
 * Add Schema.org microdata to the entry.
 *
 * No need to change any of this.
 */
function wsm_attributes_entry( $attributes ) {

	//* Only target main query entries
	if ( ! is_main_query() && ! genesis_is_blog_template() ) {
		return $attributes;
	}

	if ( 'post' === get_post_type() ) {

		$attributes['itemscope'] = true;
		$attributes['itemtype']  = 'http://schema.org/BlogPosting';

		//* If not search results page
		if ( ! is_search() ) {
			$attributes['itemprop']  = 'blogPost';
		}

	}

	return $attributes;

}

add_action( 'genesis_entry_content', 'wsm_extra_entry_meta', 5 );
/**
 * Extra recommended meta data about the entry
 */
function wsm_extra_entry_meta() {

	printf( '<meta itemprop="dateModified" content="%s" />', esc_attr( get_the_modified_time( 'c' ) ) );
	printf( '<meta itemprop="mainEntityOfPage" content="%s" />', esc_url( get_permalink() ) );

}

//add_action( 'genesis_entry_content', 'wsm_entry_image', 8 );
/**
 * Output the entry image object.
 */
function wsm_entry_image() {

	$img = genesis_get_image( array(
		'format'  => 'html',
		'size'    => genesis_get_option( 'image_size' ),
		'context' => is_singular() ? 'singular' : 'archive',
		'attr'    => genesis_parse_attr( 'entry-image', array ( 'alt' => get_the_title() ) ),
	) );

	list( $url, $width, $height ) = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

	if ( ! empty( $img ) ) {
		$img = sprintf( '<a href="%s" aria-hidden="true">%s</a>', get_permalink(), $img );
	}

	echo '<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">';
	echo $img;
	printf( '<meta itemprop="url" content="%s">', esc_url( $url ) );
	printf( '<meta itemprop="width" content="%s">', esc_attr( $width ) );
	printf( '<meta itemprop="height" content="%s">', esc_attr( $height ) );
	echo '</div>';

}

add_action( 'genesis_entry_content', 'wsm_entry_publisher' );
/**
 * Output publisher information.
 *
 * Requires user input. Replace values below with ones that you choose.
 */
function wsm_entry_publisher() {

	// Is the publisher a person or organization?
	// Uncomment your choice below.

	$publisher = 'https://schema.org/Organization';
	//$publisher = 'https://schema.org/Person';

	$publisher_name = 'Web Savvy Marketing';
	$logo = get_stylesheet_directory_uri(). '/images/logo.png';
	$logo_width = 148; // Replace this with your logo width
	$logo_height = 64; // Replace this with your logo height

	//* Do nothing if user hasn't uncommented a publisher type above
	if ( ! isset( $publisher ) ) {
		return;
	}

	printf( "<div itemprop=\"publisher\" itemscope itemtype=\"%s\">\n", esc_url( $publisher ) );
    	echo "\t<div itemprop=\"logo\" itemscope itemtype=\"https://schema.org/ImageObject\">\n";
      		printf( "\t\t<meta itemprop=\"url\" content=\"%s\">\n", esc_url( $logo ) );
      		printf( "\t\t<meta itemprop=\"width\" content=\"%d\">\n", esc_attr( $logo_width ) );
      		printf( "\t\t<meta itemprop=\"height\" content=\"%d\">\n", esc_attr( $logo_height ) );
		echo "\t</div>\n";
		printf( "\t<meta itemprop=\"name\" content=\"%s\">\n", esc_attr( $publisher_name ) );
	echo "</div>\n";

}