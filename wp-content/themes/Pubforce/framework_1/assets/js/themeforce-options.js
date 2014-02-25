jQuery(document).ready(function($) {
 
    // Yes / No Slider
 
    $('.tf-options-page .form-table .iphone:checkbox').iphoneStyle({
      checkedLabel: 'YES',
      uncheckedLabel: 'NO'
    });
    
    // Farbtastic Settings
    
    if( jQuery( '#picker-bg' ).length ) {
    	var f = $.farbtastic( '#picker-bg');
    	var p = $('#picker-bg').css('opacity', 0.25);
    	var selected;
    	$('.colorwell')
    	  .each(function () { f.linkTo(this); $(this).css('opacity', 0.75); })
    	  .focus(function() {
    	    if (selected) {
    	      $(selected).css('opacity', 0.75).removeClass('colorwell-selected');
    	    }
    	    f.linkTo(this);
    	    p.css('opacity', 1);
    	    $(selected = this).css('opacity', 1).addClass('colorwell-selected');
    	  });
    }
    
    // Chosen
    
    $(".chzn-select").chosen();
    
    
	// Mobile site navigation toggle script
	jQuery( '.mobile-nav-container .show-nav' ).click( function(e) {
	    e.preventDefault();
	    
	    jQuery( this ).parent().find('.nav-mobile').stop(true,true).slideToggle();
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