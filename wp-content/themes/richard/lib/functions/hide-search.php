<?php

// Script for adding show/hide menu
add_action( 'wp_head', 'wsm_show_hide_script' );
function wsm_show_hide_script() { ?>

<script type="text/javascript">

jQuery(document).ready(function($) {

	$('#show_hide').click(function(){
    $(".slidingDiv").slideToggle("fast");
    });

    $('#show_more1').click(function(){
    $(".more-content1").slideToggle("fast");
    });

	$('#show_more2').click(function(){
    $(".more-content2").slideToggle("fast");
    });

	$('#show_more3').click(function(){
    $(".more-content3").slideToggle("fast");
    });

	$( "div.show-more" ).click(function() {
		  $( this ).toggleClass( "hide" );
	});

});

</script>

<?php

}