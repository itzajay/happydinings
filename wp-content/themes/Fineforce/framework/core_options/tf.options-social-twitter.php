<?php

/*
 * TF OPTIONS: TWITTER
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

function themeforce_social_twitter_page() {
    ?>
    <div class="wrap tf-options-page">
    <div class="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
    <?php 

    // Options
    
    $options = array (
 
    array( 'name' => __( 'Twitter Settings', 'themeforce'), 'type' => 'title'),

    array( 'type' => 'open'),

	array( 'name' => __( 'Twitter Link', 'themeforce'),
                'desc' => __( 'The link to your Twitter profile/username.', 'themeforce'),
                'id' => 'tf_twitter',
                'std' => TwitterUrl,
                'type' => 'text'),     
      
	array( 'type' => 'close'), 
 
);

    tf_display_settings( $options );
    ?> 
	 <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes', 'themeforce' )  ?>" />
         <div style="clear:both;"></div>
    </form>

    </div>
    <?php
        
}

/*
 * Hooks into update_option to sanitize the twiiter url
 * 
 * @param string value of option
 * @return string - modified value
 */
function tf_escape_site_to_twitter ( $newvalue ){
	
	if (!$newvalue)
		return;

	if( strpos ( $newvalue, 'twitter.'  ) !== false ) {
		$newvalue = esc_url( $newvalue );

	} else {
		$newvalue = ltrim( $newvalue, '@');
		$newvalue = 'http://twitter.com/' . $newvalue;
	}
		
	return $newvalue;		
}
add_filter ( 'pre_update_option_tf_twitter', 'tf_escape_site_to_twitter', 1 );
