<?php

/*
 * TF OPTIONS: LOCATION
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */


// Create Page
// -----------------------------------------


function themeforce_location_page() {
    ?>
    <div class="wrap tf-options-page">
    <div class="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
    <?php 
    // Options
    
    $options = array (
 
        array( 'name' => __('Location Details', 'themeforce'), 'type' => 'title'),

        array( 'type' => 'open'),

    	array( 'name' => __('Street Name', 'themeforce'),
                    'desc' => __('The street address. For exampl: 1600 Amphitheatre Pkwy', 'themeforce'),
                    'id' => 'tf_address_street',
                    'std' => Street,
                    'type' => 'text'),

    	array( 'name' => __('Town or Locality', 'themeforce'),
                    'desc' => __('The locality. For example, Mountain View, Miami, Sydney, etc.', 'themeforce'),
                    'id' => 'tf_address_locality',
                    'std' => Locality,
                    'type' => 'text'), 					

    	array( 'name' => 'State or Region',
                    'desc' => __('The region. For example, CA.', 'themeforce'),
                    'id' => 'tf_address_region',
                    'std' => State,
                    'type' => 'text'), 		

    	array( 'name' => __('Country', 'themeforce'),
                    'desc' => __('Select your country', 'themeforce'),
                    'id' => 'tf_address_country',
                    'std' => Country,
                    'type' => 'text'), 	
    						
    	array( 'name' => __('Phone Number', 'themeforce'),
                    'desc' => __('Your business phone number.', 'themeforce'),
                    'id' => 'tf_business_phone',
                    'std' => __('( 123 ) 456 789', 'themeforce'),
                    'type' => 'text'),
    							

    	array( 'name' => __('Short Contact Info', 'themeforce'),
                    'desc' => __('Visible contact information in the top-right corner (you can also leave blank)', 'themeforce'),
                    'id' => 'chowforce_biz_contactinfo',
                    'std' => __('Call us at +01 ( 02 ) 123 57 89', 'themeforce'),
                    'type' => 'text'), 				

    	array( 'type' => 'close'), 
     
    );

    tf_display_settings( $options );
    ?> 
	 <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes', 'themeforce' )  ?>" />
         <div style="clear:both;"></div>
    </form>
        
        <div id="tf-tip">
            <h3><?php _e('Why is Location important?', 'themeforce'); ?></h3>
            <p><?php _e('We use location data to enhance content across your website. An example of this are Events: Your location is attached to individual events which means that you can potentially <strong>increase your traffic from Google, Yahoo or Bing</strong> for local event searches.', 'themeforce'); ?></p>
        </div>    
        
    </div>
    <?php
        
}	
?>