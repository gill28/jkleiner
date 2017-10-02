<?php

// Script for inserting the mobile menu icon toggle
add_action( 'wp_head', 'wsm_mobile_menu_script' );
function wsm_mobile_menu_script() {
?>
<script type="text/javascript">
jQuery(document).ready(function($) {


$('.menu-primary').before('<button class="menu-toggle genericon genericon-menu" role="button" aria-pressed="false"></button>'); // Add toggles to menus
$('.menu-primary .sub-menu').before('<button class="sub-menu-toggle" role="button" aria-pressed="false"></button>'); // Add toggles to sub menus
// Show/hide the navigation
$('.menu-toggle, .sub-menu-toggle').click(function() {
if ($(this).attr('aria-pressed') == 'false' ) {
$(this).attr('aria-pressed', 'true' );
}
else {
$(this).attr('aria-pressed', 'false' );
}
$(this).toggleClass('activated');
$(this).next('.menu-primary, .sub-menu').slideToggle('fast', function() {
return true;
// Animation complete.
});
});

$(window).resize(function(){
if(window.innerWidth > 700) {
$(".menu-primary").removeAttr("style");
}
});

});
</script>
<?php

}
