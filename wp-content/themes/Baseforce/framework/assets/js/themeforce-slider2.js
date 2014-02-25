jQuery(document).ready(function($) {

    // Functions

    var resetTypes = function() {
        $('.slide-edit-image, .slide-edit-content').hide();
    }

    var resetImageWells = function( ) {

        jQuery( '.slide-item').each( function() {
            jQuery( this ).find( '.slide-thumbnail' ).css( 'background-position', 'center center' );
            jQuery( this ).find( '.slide-thumbnail .slide-image-well' ).css( 'margin-top', '500px' );
            jQuery( this ).find( '.slide-thumbnail .slide-change-image' ).show();

            setImageWellHeight( jQuery( this ), '180px' );
        } );

    }

    var resetSlide = function() {
        $('.slide-edit').hide();
        $('.slide-thumbnail').css( 'height', '180px' );
        resetImageWells();
        resetTypes();
    }

    var getParent = function(selector) {
        return $(selector).closest('li.slide-item');
    }

    var getID = function(selector) {
        return $(selector).closest('li.slide-item').find('input[name*="id"]').val();
    }

    var shortenText = function( text, amount ) {
        var short = text.trim().substring(0, amount);
        if ( text.length > amount ) {
            return short + "...";
        } else {
            return short;
        }
    }

    var switchType = function(selector, slideType) {

        var parent = getParent(selector);

        resetTypes();

        switch (slideType)

        {
            case 'content':
                parent.find('.slide-edit-content').show('slow');
                parent.find('.slide-thumbnail').animate({'width':'400px'}, 'slow', function(){
                    parent.find('.slide-content-preview').show('fast');
                } );
                resizeImageWell( parent, '400px' );
                break;

            default:
                parent.find('.slide-edit-content').hide();
                parent.find('.slide-content-preview').hide();
                parent.find('.slide-edit-image').show('slow');
                parent.find('.slide-thumbnail').animate({'width':'678px'}, 'slow');
                resizeImageWell( parent, '678px' );
        }

    }

    var switchPreview = function(selector, slideType) {

        var parent = getParent(selector);

        switch (slideType)

        {
            case 'content':
                parent.find('.slide-thumbnail').animate({'width':'400px'}, 'slow', function() {
                    parent.find('.slide-content-preview').show('fast');
                });
                resizeImageWell( parent, '400px' );
                break;

            default:
                parent.find('.slide-content-preview').hide();
                parent.find('.slide-thumbnail').animate({'width':'678px'}, 'slow');
                resizeImageWell( parent, '678px' );

        }

    }

    var resizeImageWell = function( slide, width, height ) {

        slide.find('.slide-image-well').animate({'width': width }, 'slow' );
        slide.find('.slide-image-well>div').animate({'width': width }, 'slow' );

        slide.find('.slide-image-well>div>div').each( function() {

            if( jQuery( this ).css('z-index') != '-1' )
                jQuery( this ).animate({'width': width }, 'slow' );
        } );
    }

    var setImageWellHeight = function ( slide, height ) {

        slide.find('.slide-image-well').css( 'height', height );
        slide.find('.slide-image-well>div').css( 'height', height );

        slide.find('.slide-image-well>div>div').each( function() {

            if( jQuery( this ).css('z-index') != '-1' )
                jQuery( this ).css( 'height', height );
        } );
    }

    // Init

    $('ul#tf-slides-list li.slide-item').each(function(index) {
        var slideType = $(this).find('.slide-edit .slide-type-selection input:checked').val();
        switchPreview($(this),slideType);
    });

    // Sortable List and Update
  
    $("#tf-slides-list").sortable({
        placeholder: 'ui-state-highlight',
        handle : '.slide-icon-move',
        revert: true,
        update : function () {
            var order = 1;
            $("li.slide-item").each( function() {
                $(this).find('input[name*="order"]').val(order);
                var id = $(this).find('input[name*="id"]').val();
                jQuery.post( ajaxurl, { action: 'tf_slides_update_order', postid: id, neworder: order } );
                order++;
            });
        }
    });

    // Sort - Reset size of Slide when clicking on Handle

    $('.slide-icon-move').mousedown(function(){

        resetSlide( jQuery( this ).closest( '.slide-item' ) );
    });

    // Sort - Match UI Highlight Placeholder to height of selected Slide

    $('body').delegate('.slide-icon-move', 'sortstart', function(){

        var uiHeight = $(this).parent().parent().parent().css('height');
        $('li.ui-state-highlight').css('min-height', uiHeight );

    });
      
    // Edit - Click on main Edit Button
    
    $('.slide-icon-edit').click(function () {

        if ( jQuery( this).closest( '.slide-item').find( '.slide-edit').css( 'display' ) != 'none' ) {
            resetSlide( jQuery( this ).closest( '.slide-item' ) );
            return;
        }

        resetSlide( jQuery( this ).closest( '.slide-item' ) );

        getParent($(this)).find('.slide-edit').show();

        var slideType = getParent($(this)).find('.slide-edit .slide-type-selection input:checked').val();
        getParent($(this)).find( '.slide-edit-' + slideType ).show();
        getParent($(this)).find( '.slide-change-image' ).show();

        if ( $('#tf_current_theme').val() == 'Pubforce' ) {

            getParent($(this)).find( '.slide-thumbnail' ).css( 'height', '303' );
            setImageWellHeight( getParent( $(this) ), '303px' );
        }

    });

    // Edit - Change Slide Type

    $('.slide-edit .slide-type-selection input').change(function(){

        var parent = getParent($(this));
        var slideType = $(this).val();

        jQuery.post( ajaxurl, { action: 'tf_slides_update_type', postid: getID($(this)), type: slideType } );

        switchType($(this),slideType);
        switchPreview($(this),slideType);

    })

    // Update Preview Slide

    $('.slide-content-header, .slide-content-desc, .slide-content-button').on('keyup', function(){

        var meta = $(this).data('meta');
        var value = $(this).val();

        getParent($(this)).find('.preview-' + meta).text(shortenText(value,130));

    });

    // Update Slide Content

    $('.slide-content-header, .slide-content-desc, .slide-content-button, .slide-content-link').on('change', function(){

        var id = getID($(this));
        var meta = $(this).data('meta');
        var value = $(this).val();

        jQuery.post( ajaxurl, { action: 'tf_slides_update_content', postid: id, key: meta, value: value } );

    });

    //Update Slide Image

    $('#tf-slides-list').on( 'click', '.slide-change-image', function( e ) {

        e.preventDefault();

        tf_show_slide_image_well( jQuery( this ).closest( '.slide-item' ), 'show' );
    } );

    // Delete Slide
    
    $('.slide-icon-delete').click(function () {

        getParent($(this)).css({opacity:'0.8', "background-color":"#B81D21"}).animate({opacity: "0.1"}, 650, "swing").hide('slow');
        jQuery.post( ajaxurl, { action: 'tf_slides_delete', postid: getID($(this)) } );

    } );


    //Add slige image change upload callbacks

    jQuery( '#tf-slides-list .hm-uploader').each( function() {

        tf_add_image_well_upload_callback( jQuery( this).find( '.field-id' ).val() );

    } );

    //Function to add an upload callback via well ID

    function tf_add_image_well_upload_callback( well_id ) {

        var self = this;
        self.image_id = 0;

        jQuery( document ).ready( function () {

            ImageWellController.addFileUploadCallbackForImageWell( well_id, function() {

                var well_container_selector = '#' + well_id + '-container';

                var image_id = jQuery( 'input[name="'+well_id+'"]' ).val();
                var post_id  = jQuery( well_container_selector + ' input[name="post_id"]' ).val();

                jQuery.post( ajaxurl, { action: 'tf_slides_change_image', image_id: image_id, post_id: post_id }, function( background_url ) {
                    jQuery( well_container_selector ).closest( '.slide-thumbnail').css( 'background-image','url(' + background_url + ')' );
                    jQuery( well_container_selector ).closest( '.slide-thumbnail').find( '.slide-notice' ).remove();
                } );

            } );
        } );
    }

    $( '.slide-item').each( function() {

        setImageWellHeight( $( this ), '180px' );
    } );

    function tf_show_slide_image_well( slide ) {

        slide.find( '.slide-thumbnail').css( 'background-position', 'center -500px' );
        slide.find( '.slide-thumbnail .slide-image-well' ).css( 'margin-top', '0' );
        slide.find( '.slide-thumbnail .slide-change-image' ).hide();
    }
    
    // Upload Slide Image (still useful?)
    
    $('#upload_image_button').click(function() {
        formfield = jQuery('#tfslider_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true&amp;tab=gallery');
        $('tr.post_title, tr.image_alt, tr.post_except, tr.post_content, tr.url, tr.0, tr.align, tr.image-size').hide();
        return false;
    });

    window.send_to_editor = function(html) {
        imgurl = jQuery('img',html).attr('src');
        jQuery('#tfslider_image').val(imgurl);
        tb_remove();
    }

  });