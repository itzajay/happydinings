jQuery(document).ready(function($) {
 	
	// Mobile site navigation toggle script
	jQuery( '.mobile-nav-container .nav-button-nav' ).click( function(e) {

	    e.preventDefault();
	    jQuery( this ).parent().parent().find('.nav-mobile').stop(true,true).slideToggle();

	} );
	
	jQuery( '.nav-mobile li' ).click( function(e) {

	    e.preventDefault();
	    e.stopPropagation();
	    jQuery( this ).find( 'ul:first' ).stop(true,true).slideToggle();


	} );
	
	jQuery( '.nav-mobile li a' ).click( function(e) {

	    e.stopPropagation();

	} );
	
	$('ul.sub-menu').parent().find('.nav-link:first a').append('&nbsp;&#9679;');

    $('.nav-primary li').hover(function() {
        $(this).find("ul.sub-menu").stop().slideDown('fast');
    },
    function(){
        $(this).find("ul.sub-menu").fadeOut('fast');
    });
    
});