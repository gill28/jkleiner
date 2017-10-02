jQuery(document).ready(function($){
	// show the covers
	$('.fvc-preview').show();

	// pass click from cover to video	
	$('.fvc-icon').click(function(event){

		event.preventDefault();
		$video = $(this).parents('.fvc-player');

		$video.children('.fvc-preview, .fvc-controls')
			.hide();

		$frame = $video.children('iframe')[0];
		qs = $frame.src.indexOf('?') > 0 ? '&' : '?';
		$frame.src += qs + 'autoplay=1';

	});
});
