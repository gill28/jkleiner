<?php

/**
 * Full Video Cover
 *
 * This file contains the code needed to display the video cover image.
 *
 */

add_action( 'wp_enqueue_scripts', function() {

	// Register a new script file to be linked
	wp_enqueue_script( 'video-cover', RICHARD_JS . '/video-cover.js', array( 'mediaelement' ), CHILD_THEME_VERSION, true );

});

function fvc_video( $video_oembed, $poster_url = '' ) {

	echo fvc_get_video( $video_oembed, $poster_url );

}

function fvc_get_video( $video_oembed, $poster_url = '' ) {

	$content = '<div class="video-file video-url fvc-player">';

	$content .= wp_oembed_get( $video_oembed );

	if ( ! empty( $poster_url ) ) {

		$content .= '
		<div class="fvc-preview" style="background-size:cover; background-image:url(' . $poster_url . ')"></div>
		<div class="fvc-controls">
			<div class="fvc-icon-container">
				<div class="fvc-icon"></div>
			</div>
		</div>
';
	}

	$content .= '</div>';

	return $content;

}