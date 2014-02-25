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
    
});