<?php

/*
 * TF OPTIONS: FACEBOOK
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

function themeforce_social_facebook_page() {
    ?>
    <div class="wrap tf-options-page">
    <div class="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
    <?php 

    // Options
    
    $options = array (
 
        array( 'name' => __( 'Facebook Settings', 'themeforce'), 'type' => 'title'),

        array( 'type' => 'open'),   

 		array( 'name' => __( 'Facebook Link', 'themeforce'),
 	               'desc' => __( 'The link to your Facebook fan page/profile.', 'themeforce'),
 	               'id' => 'tf_facebook',
 	               'std' => FacebookUrl,
 	               'type' => 'text'),     
 	     
 		array( 'type' => 'close'), 
 	
	);
	
	do_action( 'tf_settings_facebook_before' );
	
    tf_display_settings( apply_filters( 'tf_options_facebook', $options ) );
    ?> 
        
    <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes', 'themeforce' )  ?>" />
    <div style="clear:both;"></div>
    
    </form>
        <!--
        <div id="tf-tip">
            <h3>Did you know?</h3>
            <p>Having a Yelp profile can increase your exposure to various plenty of new customers. In May 2011, they recorded the following numbers:</p>
            <ul>
                <li>A whopping 27% of all Yelp searches come from that iPhone application.</li>
                <li>Over half a million calls were made to local businesses directly from the iPhone App, or one in every five seconds.</li>
                <li>Nearly a million people generated point-to-point directions to a local business from their Yelp iPhone App last month.</li>
            </ul>

        </div>
        -->
    </div>
    <?php
    do_action( 'tf_settings_facebook_after' );
}

/*
 * Hooks into update_option to sanitize the facebook url
 * 
 * @param string value of option
 * @return string - modified value
 */
function tf_escape_site_to_facebook ( $newvalue ){
	
	if (!$newvalue)
		return;

	if( strpos ( $newvalue, 'facebook.'  ) !== false ) {
		$newvalue = esc_url( $newvalue );
	}
		
	return $newvalue;		
}
add_filter ( 'pre_update_option_tf_facebook', 'tf_escape_site_to_facebook', 1 );
