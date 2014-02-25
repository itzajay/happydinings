<?php

/*
 * TF OPTIONS: LOGO
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

// Create Page
// -----------------------------------------

function themeforce_logo_page() {
	
	// migrate tf_logo to tf_logo_id

	if ( ! get_option( 'tf_logo_id' ) && get_option( 'tf_logo' ) ) {
		
		$logo = hm_remote_get_file( get_option( 'tf_logo' ) );
		$info = getimagesize( $logo );
		$post_id = wp_insert_attachment( array( 'post_mime_type' => $info['mime'] ), $logo );
		
		$meta = wp_generate_attachment_metadata( $post_id, $logo );
		wp_update_attachment_metadata( $post_id, $meta );

		if ( $post_id ) {
			update_option( 'tf_logo_id', $post_id );
			delete_option( 'tf_logo' );
		}
			
	}
	
    ?>
    <div class="wrap" id="tf-options-page">
    <div id="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
    <?php 

    // Options
    
    $options = array (
 
	    array( 'name' => __('Logo', 'themeforce'), 'type' => 'title'),

	    array( 'type' => 'open'),

		array( 'name' => __('Logo', 'themeforce'),
	                'desc' => __('Your business logo (choose from an array of formats .JPG, .GIF, .PNG)', 'themeforce'),
	                'id' => 'tf_logo_id',
	                'std' => '',
	                'size' => 'width=300&height=300&crop=0',
	                'type' => 'image'),

	   	array( 'name' => __('Favicon', 'themeforce'),
	                'desc' => __('Your Favicon, make sure it is 16px by 16px (you can <a href=\'http://www.favicon.cc/\' target=\'_blank\'>generate one here</a>)', 'themeforce'),
	                'id' => 'tf_favicon',
	                'std' => '',
	                'type' => 'image',
	                'allowed_extensions' => array( 'ico' ),
	                'drop_text' => __('Drop favicon here', 'themeforce')),
	      
		array( 'type' => 'close'), 
	 
	);

    tf_display_settings( $options );
    ?> 
	 <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes','themeforce' )  ?>" />
         <div style="clear:both;"></div>
    </form>

    </div>
    <?php
        
}	

function tf_logo( $size ='width=250&height=200&crop=0' ) {
	
	$logo_src = tf_logo_url( $size );
	$logomobile = wpthumb( $logo_src, 'width=200&height=160&crop=0' );
	
	if ( is_user_logged_in() ) :
		
		$uploader = new TF_Upload_Image_Well( 'tf_logo_id', get_option( 'tf_logo_id', 0 ), array( 'size' => $size ) );
		$uploader->drop_text = __('Drop your logo here', 'themeforce');
	    ?>


	    <div style="float:left;">
	    	<?php $uploader->html() ?>
	    </div>
	
	<?php else : ?>
	
	    <div style=""><a href="<?php bloginfo('url'); ?>"><div id="logo" style="background-image:url(<?php echo $logo_src; ?>)"></div></a></div>
	
	<?php endif; ?>
	    
    <div id="logo-mobile" style="display:none;">
        <a href="<?php bloginfo('url'); ?>"><div style="background:url('<?php echo $logomobile; ?>') no-repeat center center"></div></a>
    </div>
	
	<?php

}

function tf_logo_url( $size ='width=250&height=200&crop=0' ) {
	
	if ( get_option( 'tf_logo_id' ) )
		$logo_id = (int) get_option( 'tf_logo_id' );
	
	else
		$logo_id = null;
	
	if ( $logo_id ){
		$logo_src = reset( wp_get_attachment_image_src( $logo_id, $size ) );
	}
	
	elseif ( get_option( 'tf_logo' ) )

		$logo_src = wpthumb( get_option( 'tf_logo' ), $size );
	
	else
		$logo_src = '';

    // This is defaulting to a logo when we probably want to keep it empty
	// $logo_src = wpthumb( get_bloginfo( 'template_directory' ) . '/images/logo.jpg', $size );
	
	return $logo_src;
}

function tf_get_favicon_url() {
	
	if ( is_numeric( get_option( 'tf_favicon' ) ) )
		$logo_src = wp_get_attachment_image_src( $logo_id, 'width=16&height=16' ) ? reset( wp_get_attachment_image_src( $logo_id, 'width=16&height=16' ) ) : '';
	
	elseif ( get_option( 'tf_favicon' ) )
		$logo_src = get_option( 'tf_favicon' );
	
	elseif ( get_option( 'tf_custom_favicon' ) )
		$logo_src = get_option( 'tf_custom_favicon' );
	
	return $logo_src;
}

//include the image picker JS etc
add_action( 'wp_head', function() {
	if ( is_user_logged_in() )
		TF_Upload_Image_Well::enqueue_scripts();
}, 1 );