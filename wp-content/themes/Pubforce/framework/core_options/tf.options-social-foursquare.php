<?php

/*
 * TF OPTIONS: YELP
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

function themeforce_social_foursquare_page() {
    ?>
    <div class="wrap tf-options-page">
    <div class="tf-options-panel">
    <form class='form-table' action='options.php' method='post'>
   
    <?php

    // Options
    
    $options = array (
 
        array( 'name' => __( 'Foursquare Settings', 'themeforce'), 'type' => 'title'),

        array( 'type' => 'open'),   

        array( 
                'name' => __( 'Venue ID', 'themeforce'),
                'desc' => __( 'If your profile URL is http://foursquare.com/venue/12345, then your Venue ID is 12345', 'themeforce'),
                'id' => 'tf_fsquare_venue_id',
                'std' => '',
                'type' => 'text'),   
        
        array( 
               	'name' => __( 'Client ID', 'themeforce'),
                'desc' => __('Request API access here, register <a href=\'https://foursquare.com/oauth/\' target=\'_blank\'>here</a>. Callback URL does not matter for the Venues APIv2 we\'ll be using.', 'themeforce'),
                'id' => 'tf_fsquare_client_id',
                'std' => '',
                'type' => 'text'),        
        
        array( 
                'name' => __('Client Secret', 'themeforce'),
                'desc' => __('Provided together with the Client ID above.', 'themeforce'),
                'id' => 'tf_fsquare_client_secret',
                'std' => '',
                'type' => 'text'),        
      
	array( 'type' => 'close'), 
 
);

    tf_display_settings( $options );
    ?> 
	 <input type='submit' class="tf-button tf-major right" name='options_submit' value=' <?php _e( 'Save Changes', 'themeforce' )  ?>' />
         <div style='clear:both;'></div>
    </form>
        <div id='tf-tip'>
            <h3><?php _e('How can I get more out of Foursquare?', 'themeforce'); ?></h3>
            <p><?php _e('If you\'re looking to increase check-ins, try creating special gifts for Mayors (the people who check in the most) as well as other special offers through Foursquare.', 'themeforce'); ?></p>
        </div>    
    </div>
    <?php
        
}	
?>