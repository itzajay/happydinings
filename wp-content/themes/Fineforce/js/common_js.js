jQuery(document).ready(function($) {
 	
	// Mobile site navigation toggle script
	//jQuery( '.mobile-nav-container .nav-button-nav' ).click( function(e) {
	//    e.preventDefault();
	//    jQuery( this ).parent().parent().find('.nav-mobile').stop(true,true).slideToggle();
	//} );
	//
	//jQuery( '.nav-mobile li' ).click( function(e) {
	//    e.preventDefault();
	//    e.stopPropagation();
	//    jQuery( this ).find( 'ul:first' ).stop(true,true).slideToggle();
	//} );
	//
	//jQuery( '.nav-mobile li a' ).click( function(e) {
	//    e.stopPropagation();
	//});
	
	//jQuery('#slider').bxSlider({
	//	mode: 'fade',
	//	controls: false,
	//	pager:false,
	//	auto: true,
	//	speed: 1000,
	//	pause: 4500 
	//});
	
	//var image_src = $(".current-image img").attr('src');
	//if(image_src != null){
	//	$('.current-image').css('display','block');
	//}
	//
	//$(".image-options").on("click", "a", function(e) {
	//	e.preventDefault();
	//	$('.current-image').css('display','none');
	//	$.ajax({
	//		url: 'wp-admin/admin-ajax.php',
	//		type: 'post',
	//		data: {action: 'delete_current_logo'},
	//		success: function(data){
	//			$(".loading-block").addClass("hidden");
	//			//console.log(data);
	//		},
	//		error: function(){
	//			$(".loading-block").addClass("hidden");
	//			console.log("error");
	//		}
	//	})
	//});
	//$('.fancybox').fancybox();
	
	jQuery("a.thumb").fancybox({
		'overlayShow'	: false,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic',
		'padding' : 5
    });
	jQuery("a.thumb-iframe").fancybox({
		'width'		    : '90%',
		'height'		: '90%',
		'autoScale'     : false,
		'transitionIn'	: 'none',
		'transitionOut'	: 'none',
		'type'		    : 'iframe'
    });	
});