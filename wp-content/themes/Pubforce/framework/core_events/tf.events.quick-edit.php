<?php

/**
 * Enqueue the necissary scripts for the much improved Food Menu quick edit
 * 
 */
function tf_events_enqueue_scripts() {

	if ( empty( $_GET['post_type'] ) || $_GET['post_type'] !== 'tf_events' )
		return;
		
	add_thickbox();
	
	wp_enqueue_script( 'media-uploader-extensions', TF_URL . '/assets/js/media-uploader.extensions.js', array(), TF_VERSION  );
	wp_enqueue_script( 'jquery-ui-sortable' );
	
	_tf_tj_register_custom_media_button( '_tf_events_image', 'Add Image' );
}
add_action( 'load-edit.php', 'tf_events_enqueue_scripts' );

/**
 * Adds the extra fields to the quick edit row on Manage Events.
 * 
 * @param string $column_name
 * @param string $post_type
 * @return void
 */
function tf_events_add_fields_to_quick_edit( $column_name, $post_type ) {

	if ( $post_type !== 'tf_events' )
		return $column_name;
	
	add_action( 'admin_footer', 'tf_events_add_inline_js_to_footer' );
	?>

	<?php if ( $column_name == 'tf_col_ev_cat' ): ?>
		
		<div class="tf-quickedit-header tf-primary-gradient">
			<div class="width-item"><h3><?php _e('Item', 'themeforce'); ?></h3></div>
			<div class="width-cat"><h3><?php _e('Event Categories', 'themeforce'); ?></h3></div>
			<div class="width-image"><h3><?php _e('Image', 'themeforce'); ?></h3></div>
			<div class="width-desc"><h3><?php _e('Description', 'themeforce'); ?></h3></div>
		</div>
		
		<div id="tf-inline-edit-dates" style="margin-top: 10px">

			<span class="tf_ev_title"><?php _e('Start Date', 'themeforce'); ?></span>
			<div class="start-date" style="display:block; margin-left: 5em; "></div>
			<div style="clear:both;height:10px;"></div>
			<span class="tf_ev_title"><?php _e('End Date', 'themeforce'); ?></span>
			<div class="end-date" style="display:block; margin-left: 5em;"></div>

		</div>
		
		<div id="tf-inline-edit-image" style="width:28%; float:left; padding:2% 0">
			<?php _tf_tj_add_image_html_custom( '_tf_events_image', 'Add Image', 0, array(), '', 'width=80&height=80&crop=1', '' ) ?>
		</div>
		
		<div id="tf-inline-edit-description" style="width:66%; padding:2%; float:left;">
			<textarea style="width:100%; height:100px;"></textarea>
			<input type="hidden" name="tf_description" value="" />
		</div>
	<?php endif; ?>
	<?php
	return $column_name;
}
add_action( 'quick_edit_custom_box', 'tf_events_add_fields_to_quick_edit', 10, 2 );

//make sure the javascript required for inline edit is loaded, even when there are no events because the quick_edit_custom_box hook is not fired in that case
add_action( 'admin_footer', function() {

    if ( $_GET['post_type'] != 'tf_events' )
        return;

    tf_events_add_inline_js_to_footer();
} );

/**
 * Extra JavaScript needed for the food menu quick edit.
 * 
 */
function tf_events_add_inline_js_to_footer() {

    ?>
	<script type="text/javascript">
	    jQuery( document ).ready( function() {

	    	var TFInlineAddedElements = [];
	    	
	    	jQuery( '.row-actions .edit' ).css( 'display', 'none' );
	    	jQuery( '.row-actions .editinline' ).text( '<?php _e( 'Edit' ); ?>' );
	    	jQuery( '.row-title' ).addClass( 'editinline' );
	    	
	    	//hide unwanted stuff
	    	jQuery( '#inlineedit input[name=post_name]' ).closest( 'label' ).hide();
	    	jQuery( '#inlineedit .inline-edit-date' ).hide().prev().filter( function(i, obj) { return jQuery( obj).text() == 'Date'; } ).hide();
	    	jQuery( "#inlineedit input[name=post_password]").closest( 'div.inline-edit-group' ).hide().prev('br').hide();
	    	jQuery( '#inlineedit .inline-edit-tags' ).hide();
			jQuery( "#inlineedit .inline-edit-status").hide();
			jQuery( "#inlineedit .inline-edit-col h4" ).hide();
			jQuery( "#inlineedit .inline-edit-categories-label .catshow" ).click().parent().hide();
			
			jQuery( '#inlineedit' ).addClass( 'tf-menu' );
			jQuery( "#inlineedit .inline-edit-col-left" ).addClass( "width-item" );
			jQuery( "#inlineedit .inline-edit-col-center" ).addClass( "width-cat" );
			jQuery( "#inlineedit .tf-inline-edit-image" ).addClass( "width-image" );
			jQuery( "#inlineedit .tf-inline-edit-description" ).addClass( "width-desc" );
			
			jQuery( "#inlineedit .colspanchange" ).wrapInner( '<div class="tf-quickedit-content"></div>' );
			
			//move stuff around
	    	jQuery( '#inlineedit .inline-edit-date' ).closest( '.inline-edit-col').append( jQuery( '#tf-inline-edit-dates' ) );

	    	jQuery( '.tf-quickedit-header' ).prependTo( jQuery( '.tf-quickedit-header' ).closest( 'td' ) );

	    	jQuery( "#tf-inline-edit-add-new-size").live( 'click', function(e) {
	    		e.preventDefault();
				
				if ( jQuery( this ).closest( '#tf-inline-edit-sizes' ).find( 'ul li' ).length >= 3 )
	    			jQuery( this ).hide();
				
	    		jQuery( this ).closest( '#tf-inline-edit-sizes' ).find( 'ul li.hidden' ).first().clone().insertBefore(jQuery(this ).closest( '#tf-inline-edit-sizes' ).find( 'ul li.hidden' )).removeClass( 'hidden' );
	    		
	    	} );
	    	
	    	jQuery( '.tf-inline-edit-remove-variant' ).live('click', function(e) {
	    		e.preventDefault();
	    		jQuery( this ).closest( 'li' ).remove();
	    		jQuery( "#tf-inline-edit-add-new-size" ).show();
	    	} );
	    	
	    	jQuery( 'a.editinline' ).live( 'click', function() {
	    		
	    		//cancel any open ones
	    		if ( jQuery( "tr.inline-edit-row" ).length )
	    			jQuery( "tr.inline-edit-row a.cancel" ).click();
	    		
	    		//clean up anyting from before
	    		for( var i = 0; i < TFInlineAddedElements.length; i++ ) {
		    		jQuery( TFInlineAddedElements[i] ).remove();
		    	}
		    	TFInlineAddedElements = [];
	    		
	    		jQuery( "#tf-inline-edit-image #_tf_events_image_container" ).html( '' );
	    		jQuery( "#tf-inline-edit-description textarea" ).html( '' );
	    		jQuery( "#tf-inline-edit-description input[type='hidden']" ).val( '' );
	    		jQuery( "#tf-inline-edit-image input#_tf_events_image" ).val( '' );
	    		
	    		var data = window[jQuery( this).closest('tr').find('.tf-inline-data-variable').text()];
	    		
	    		// Dates
                        
                        // *** Commented out for Datepicker ***
	    		jQuery( '#inlineedit .inline-edit-date' ).closest( '.inline-edit-col').find('#tf-inline-edit-dates .start-date').html( data.start_date );
	    		jQuery( '#inlineedit .inline-edit-date' ).closest( '.inline-edit-col').find('#tf-inline-edit-dates .end-date').html( data.end_date );

                // Update end date if it occurs earlier then start date

                jQuery('input#event_start_date-day').change( function() {
                    var start = jQuery(this).val();
                    jQuery('input#event_end_date-day').val(start);
                });


                //image
	    		if ( data.image_id )
		    		jQuery( "#tf-inline-edit-image #_tf_events_image_container" ).html( '<span class="image-wrapper" id="' + data.image_id + '"><img src="' + data.image + '" /><a class="delete_custom_image" rel="_tf_events_image:' + data.image_id + '">Remove</a></span>' );
		    	else
		    		jQuery( "#tf-inline-edit-image #_tf_events_image_container" ).html( '<span class="image-wrapper no-attached-image"></span>' );
	    		//description
	    		jQuery( "#tf-inline-edit-description textarea" ).html( data.description );
	    		//jQuery( "#tf-inline-edit-description input[type='hidden']" ).val( data.description );
	    		jQuery( "#tf-inline-edit-image input#_tf_events_image" ).val( data.image_id );
				
				setTimeout( function() {
					jQuery( '#event_end_date-day' ).datepicker({
                                            dateFormat: 'D - d M - y',
                                            showOn: 'both',
                                            buttonImage: '<?php echo TF_URL . '/assets/images/ui/icon-datepicker.png'; ?>',
                                            buttonImageOnly: true,
                                            changeMonth:true,
                                            changeYear: true,
                                            numberOfMonths: 3});
					jQuery( '#event_start_date-day' ).datepicker({
                                            dateFormat: 'D - d M - y',
                                            showOn: 'both',
                                            buttonImage: '<?php echo TF_URL . '/assets/images/ui/icon-datepicker.png'; ?>',
                                            buttonImageOnly: true,
                                            changeMonth:true,
                                            changeYear: true,
                                            numberOfMonths: 3});
				}, 1);
                                
   

	    		
	    	} );
	    	
	    	//re-modify the Edit links when quick edit finished
	    	jQuery( document ).ajaxComplete( function(e, xhr, settings) { 
	    		
	    		jQuery( '.row-actions .edit' ).css( 'display', 'none' );
		    	jQuery( '.row-actions .editinline' ).text( '<?php _e( 'Edit' ); ?>' );
		    	jQuery( '.row-title' ).addClass( 'editinline' );
	    		
	    	} );

	    	//sync description teaxtarea and input
	    	jQuery( "#tf-inline-edit-description textarea" ).change( function() {

	    		jQuery( "#tf-inline-edit-description input[type='hidden']" ).val( jQuery( "#tf-inline-edit-description textarea" ).val() );
	    	} );
	    	
	    	jQuery( '#tf-inline-edit-image' ).appendTo( jQuery("#inlineedit .inline-edit-status").parent() );
	    	jQuery( '#tf-inline-edit-description' ).appendTo( jQuery("#inlineedit .inline-edit-status").parent() );
	    } );
	</script>
	<?php
}

/**
 * Adds a JSON object to each table row in the manage food menu.
 * 
 * @param int $post_id
 */
function tf_events_inline_data( $post_id ) {
	
	$post = get_post( $post_id );
	
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'width=80&height=80&crop=1' );
	if ( is_array( $image ) )
		$image = reset( $image );
		
	$start_date_selector = new TFDateSelector( 'event_start_date' );
	$start_date_selector->setDate( get_post_meta( $post_id, 'tf_events_startdate', true ) );
	
	$end_date_selector = new TFDateSelector( 'event_end_date' );
	$end_date_selector->setDate( get_post_meta( $post_id, 'tf_events_enddate', true ) );
	
	$data = array(
		'image'			=> get_post_thumbnail_id( $post_id ) ? $image : '',
		'image_id'		=> get_post_thumbnail_id( $post_id ),
		'description' 	=> strip_tags( $post->post_content, '<br><p>' ),
		'start_date' 	=> $start_date_selector->getDatePickerHTML(),
		'end_date'		=> $end_date_selector->getDatePickerHTML()
	);
	?>
	
	<script type="text/javascript">
		var TFInlineData<?php echo $post_id ?> = <?php echo json_encode( $data ) ?>;
	</script>
	<span class="tf-inline-data-variable hidden">TFInlineData<?php echo $post_id ?></span>

	<?php
}

/**
 * Catches the inline edit save post form.
 * 
 * @param int $post_id
 * @param object $post
 */
function tf_events_inline_edit_save_post( $post_id, $post ) {
		
	if ( !isset( $_POST['_inline_edit'] ) || $post->post_type !== 'tf_events' )
		return;

	$start_date = new TFDateSelector( 'event_start_date' );
	update_post_meta( $post_id, 'tf_events_startdate', $start_date->getDateFromPostDataDatePicker() );
	
	$end_date = new TFDateSelector( 'event_end_date' );
	update_post_meta( $post_id, 'tf_events_enddate', $end_date->getDateFromPostDataDatePicker() );
	
	// description
	global $wpdb;
	$data['post_content'] = strip_tags( stripslashes( $_POST['tf_description'] ), '<br><p>' );
	
	$wpdb->update( $wpdb->posts, $data, array( 'ID' => $post_id ) );
	
	//post image
	set_post_thumbnail( $post_id, ( int ) $_POST['_tf_events_image'] );
}
add_action( 'save_post', 'tf_events_inline_edit_save_post', 10, 2 );


function quick_edit_events_styles() {
    global $post_type;
    if ( 'tf_events' != $post_type )
        return;
    wp_enqueue_style('ui-datepicker', TF_URL . '/assets/css/jquery-ui-1.8.9.custom.css', array(), TF_VERSION );
}

function quick_edit_events_scripts() {
    global $post_type;
    wp_enqueue_script('jquery-ui', TF_URL . '/assets/js/jquery-ui-1.8.9.custom.min.js', array( 'jquery'), TF_VERSION );
    wp_enqueue_script('ui-datepicker', TF_URL . '/assets/js/jquery.ui.datepicker.js', array(), TF_VERSION );
    wp_enqueue_script('ui-datepicker-settings', TF_URL . '/assets/js/themeforce-admin.js', array( 'jquery'), TF_VERSION  );
    // - pass local img path to js -
    $datepicker_img = TF_URL . '/assets/images/ui/icon-datepicker.png';

}

if ( is_admin() ) {

add_action( 'init', 'quick_edit_events_scripts', 1000 );

add_action( 'init', 'quick_edit_events_styles', 1000 );

}

/**
 * register_custom_media_button function.
 *
 * Wrapper function for easily added new add media buttons
 *
 * @param int $id
 * @param string $button_text ( optional )
 * @param bool $hide_other_options ( optional ) hide the default send to editor button and the other
 * @param bool $mutliple ( optional ) if the uploader and js lets you add more than one image
 */
function _tf_tj_register_custom_media_button( $id, $button_text = null, $hide_other_options = true, $multiple = false, $width = 50, $height = 50, $crop = true, $type = 'thumbnail', $insert_into_post = false ) {

    if ( empty( $id ) || !is_string( $id ) )
        return false;

    $id = sanitize_title( $id );

    if ( is_null( $button_text ) )
        $button_text = 'Use as ' . ucwords( preg_replace( '#( -|_ )#', ' ', $id ) );

    $buttons = get_option( '_tf_tj_custom_media_buttons' );

    $button = array( 'id' => $id, 'button_text' => $button_text, 'hide_other_options' => ( bool ) $hide_other_options, 'multiple' => ( $multiple ? 'yes' : '' ), 'width' => $width, 'height' => $height, 'crop' => $crop, 'insert_into_post' => ( bool ) $insert_into_post, 'type' => $type );

    $buttons[$id] = $button;

    update_option( '_tf_tj_custom_media_buttons', $buttons );

}

function _tf_tj_remove_from_url_from_media_upload( $tabs ) {

    unset( $tabs['type_url'] );

    return $tabs;

}


/**
 * add_extra_media_buttons function.
 *
 * Adds the "Use as Post Thumbnail" button to the add media thickbox.
 *
 * @param array $form_fields
 * @param object $media
 * @return array $form_fields
 */
function _tf_tj_add_extra_media_buttons( $form_fields, $media ) {

    $buttons = get_option( '_tf_tj_custom_media_buttons' );

    if ( !empty( $_GET['button'] ) ) :
        $button_id = $_GET['button'];

    else :
        preg_match( '/button=([^&]*)/', $_SERVER['HTTP_REFERER'], $matches );
        if ( isset( $matches[1] ) )
            $button_id = $matches[1];

    endif;

    if ( !isset( $button_id ) || !$button_id )
        return $form_fields;

    if ( isset( $button_id ) && ($button = $buttons[$button_id]) ) {

        $crop = $button['crop'] == true ? 1 : 0;

        $attach_thumb_url = wp_get_attachment_image_src( $media->ID, "width={$button['width']}&height={$button['height']}&crop=$crop" );

        $onclick = "var win = window.dialogArguments || opener || parent || top;";

        if ( $button['type'] == 'file' ) :
            $onclick .= "win.insert_custom_file( '" . $button_id . "', " . $media->ID . ", '" . wp_get_attachment_url() . "', '" . $button['multiple'] . "', '" . $media->post_title . "' );";
            $onclick .= "jQuery( this ).replaceWith('<span style=\'color: #07AA00; font-weight:bold;\'>File Added</span>');";

        elseif ( $button['insert_into_post'] ) :
            $onclick .= "win.insert_custom_image( '" . $button_id . "', " . $media->ID . ", '" . $attach_thumb_url[0] . "' );";
            $onclick .= "jQuery( this ).replaceWith('<span style=\'color: #07AA00; font-weight:bold;\'>Image Inserted</span>');";

        else :
            $onclick .= "win.save_custom_image( '" . $button_id . "', " . $media->ID . ", '" . $attach_thumb_url[0] . "', '" . $button['multiple'] . "' );";
            $onclick .= "jQuery( this ).replaceWith('<span style=\'color: #07AA00; font-weight:bold;\'>Image Added</span>');";

        endif;

        $onclick .= "return false;";

        $buttons_html = '<a class="button-primary" onclick="' . $onclick . '" href="">' .  esc_attr( $button['button_text'] ) . '</a>';
    }


    if ( !$button['hide_other_options'] ) :
        $send = '<input type="submit" class="button" name="send[' . $media->ID . ']" value="' . __( 'Insert into Post' ) . '" />';

    else : ?>

    <style type="text/css">
        .slidetoggle tr.post_title, .slidetoggle tr.image_alt, .slidetoggle tr.post_excerpt, .slidetoggle tr.post_content, .slidetoggle tr.url, .slidetoggle tr.align, .slidetoggle tr.image-size, .media-upload-form p.savebutton.ml-submit { display: none !important; }
    </style>

    <?php endif;

    if ( !empty( $send ) )
        $send = '<input type="submit" class="button" name="send[' . $media->ID . ']" value="' . __( 'Insert into Post' ) . '" />';

    else
        $send = false;

    if ( current_user_can( 'delete_post', $media->ID ) ) {
        if ( !EMPTY_TRASH_DAYS ) {
            $delete = '<a href=""' . wp_nonce_url( 'post.php?action=delete&amp;post=' . $media->ID , 'delete-post_' . $media->ID ) . '" id="del[' . $media->ID . ']" class="delete">' . __('Delete Permanently') . '</a>';
        } elseif ( !MEDIA_TRASH ) {
            $delete = '<a href="#" class="del-link" onclick="document.getElementById( \'del_attachment_' . $media->ID . '\' ).style.display=\'block\'; return false;">' . __( 'Delete' ) . '</a> <div id="del_attachment_' . $media->ID . '" class="del-attachment" style="display:none;">' . sprintf( __( 'You are about to delete <strong>%s</strong>.' ), $media->post_title ) . ' <a href="' . wp_nonce_url( 'post.php?action=delete&amp;post=' . $media->ID, 'delete-post_' . $media->ID ) . '" id="del[' . $media->ID . ']" class="button">' . __( 'Continue' ) . '</a> <a href="#" class="button" onclick="this.parentNode.style.display=\'none\';return false;">' . __( 'Cancel' ) . '</a></div>';
        } else {
            $delete = '<a href="' . wp_nonce_url( 'post.php?action=trash&amp;post=' . $media->ID, 'trash-post_' . $media->ID ) . '" id="del[' . $media->ID . ']" class="delete">' . __( 'Move to Trash' ) . '</a> <a href="' . wp_nonce_url( 'post.php?action=untrash&amp;post=' . $media->ID, 'untrash-post_' . $media->ID ) . '" id="undo[' . $media->ID . ']" class="undo hidden">' . __( 'Undo' ) . '</a>';
        }
    } else {
        $delete = '';
    }

    $thumbnail = '';

    if ( isset( $type ) && 'image' == $type && current_theme_supports( 'post-thumbnails' ) && get_post_image_id( $_GET['post_id'] ) != $media->ID )
        $thumbnail = "<a class='wp-post-thumbnail' href='#' onclick='WPSetAsThumbnail( \"$media->ID\" );return false;'>" . esc_html__( "Use as thumbnail" ) . "</a>";

    // Create the buttons array
    $form_fields['buttons'] = array( 'tr' => "\t\t<tr class='submit'><td></td><td class='savesend'>$send $thumbnail $buttons_html $delete</td></tr>\n" );

    return $form_fields;

}
add_filter( 'attachment_fields_to_edit', '_tf_tj_add_extra_media_buttons', 99, 2 );

/** add_button_to_upload_form function
 *
 * Adds the button variable to the GET params of the media buttons thickbox link
 *
 */
function _tf_tj_add_button_to_upload_form() {

    if ( !isset( $_GET['button'] ) )
        return; ?>

<script type="text/javascript">

    jQuery( document ).ready( function() {
        jQuery( '#image-form' ).attr( 'action', jQuery( '#image-form' ).attr( 'action' ) + '&amp;button=<?php echo $_GET['button']; ?>');
        jQuery( '#filter' ).append( '<input type="hidden" name="button" value="<?php echo $_GET['button'] ?>" />' );
        jQuery( '#library-form' ).attr( 'action', jQuery( '#library-form' ).attr( 'action' ) + '&amp;button=<?php echo $_GET['button']; ?>');
    } );

</script>

<?php }
add_action( 'admin_head', '_tf_tj_add_button_to_upload_form' );

function _tf_tj_add_image_html( $button_id, $post = null, $classes = null, $size = 'thumbnail' ) {

    if ( is_null( $post ) )
        global $post;

    if ( $post->term_id )
        $post->ID = $post->term_id;

    $type = ( $post->term_id ) ? 'term' : 'post'; ?>

<div id="<?php echo $button_id; ?>_container" class="<?php echo $classes; ?>">

    <?php if ( $image_id = get_metadata( $type, $post->ID, $button_id, true  ) ) : ?>

    <span class="image-wrapper" id="<?php echo $post->ID; ?>">

			<?php echo wp_get_attachment_image( $image_id, $size ); ?>

        <a class="delete_custom_image" rel="<?php echo $button_id; ?>:<?php echo $post->ID; ?>">Remove</a> |

		</span>

    <?php endif; ?>

</div>

<a class="add-image button thickbox" onclick="return false;" title="Add an Image" href="media-upload.php?post=<?php echo $post->ID; ?>&amp;button=<?php echo $button_id; ?>&amp;type=image&amp;TB_iframe=true&amp;width=640&amp;height=197">
    <img alt="Add an Image" src="<?php bloginfo( 'url' ); ?>/wp-admin/images/media-button-image.gif" /> Upload / Insert
</a>

<input type="hidden" name="<?php echo $button_id; ?>" id="<?php echo $button_id; ?>" value="<?php echo $image_id; ?>" />

<?php }

/**
 * Adds the necessary html for showing images (container, images, delete links etc).
 *
 * @param string 	$button_id
 * @param string 	$title (title of the "Add Images" button
 * @param int	 	$post_id
 * @param array 	$image_ids (array of image id's to be shown)
 * @param string 	$classes
 * @param string	$size (eg. 'width=15=&height=100&crop=1'
 * @param string 	$non_attached_text - Text to be shown when there are no images
 */
function _tf_tj_add_image_html_custom( $button_id, $title, $post_id, $image_ids, $classes, $size, $non_attached_text, $args = array() ) {

    $image_ids = array_filter( (array) $image_ids );

    $buttons = get_option( '_tf_tj_custom_media_buttons' );
    $button = $buttons[$button_id];
    $attachments = get_posts( "post_type=attachment&post_parent=$post_id" );

    $default_args = array( 'default_tab' => 'gallery' );

    $args = wp_parse_args( $args, $default_args );

    ?>

<style>
    .image-wrapper { min-width:80px; min-height:80px; text-align: center; display: block; padding: 5px; border: 1px solid #DFDFDF; float: left; margin-right: 7px; margin-bottom: 7px; background-color: #F1F1F1; -webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;}
    .sortable .image-wrapper { cursor: move; }
    .sortable .image-wrapper:hover { border-style: dashed; }
    .ui-sortable-placeholder { visibility: visible !important; background-color: transparent; border-style: dashed; }
    .image-wrapper img { display: block; }
    .image-wrapper a { display: block; cursor: pointer; margin: 3px 10px; }
    #<?php echo $button_id; ?>_container { display: block; overflow: hidden; }
    #normal-sortables .postbox .<?php echo $button_id; ?>_submit { padding: 0; margin: 6px 6px 8px; display: block; }
</style>

<p class="submit <?php echo $button_id; ?>_submit">
    <a class="add-image button thickbox" style="font-size:11px !important;" onclick="return false;" title="Add Image" href="media-upload.php?button=<?php echo $button_id ?>&amp;post_id=<?php echo $post_id ?><?php echo $post_id > 0 && $attachments && $args['default_tab'] == 'gallery' ? "&amp;tab=gallery" : '' ?>&amp;multiple=<?php echo $button['multiple'] == true ? 'yes' : 'no' ?>&amp;type=image&amp;TB_iframe=true&amp;width=640&amp;height=600">
        <?php echo $title ?>
    </a>

    <input type="hidden" name="<?php echo $button_id ?>" id="<?php echo $button_id ?>" value="<?php echo implode( ', ', $image_ids ) ?>" />
</p>

<span id="<?php echo $button_id; ?>_container" rel="<?php echo $button_id ?>" class="<?php echo $classes; ?>">

	    <?php foreach( $image_ids as $image_id ) : ?>
    <span class="image-wrapper" id="<?php echo $image_id ?>"><?php echo wp_get_attachment_image( $image_id, $size ); ?>
        <a class="delete_custom_image" rel="<?php echo $button_id ?>:<?php echo $image_id ?>">Remove</a></span>
    <?php endforeach; ?>

    <?php if ( !$image_ids ) : ?>
    <?php if ( $non_attached_text === null ) : ?>
        <p class="empty-message">No <?php echo $button['text'] ?> Added</p>
        <?php else : ?>
        <p class="empty-message"><?php echo $non_attached_text ?></p>
        <?php endif; ?>
    <?php endif; ?>

	</span>

<div style="clear: both;"></div>

<?php
}
