<?php

/*
 * TF OPTIONS: Google Apps & Webmaster Validation
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */


function themeforce_google_page() {
    ?>
    <div class="tf-options-page">
    <div class="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
    <?php 
    
    // List of Options used within Dropdowns, etc.
    
    $shortname = "tf";

    // Options
    
    $options = array (

        array( 'type' => 'open'),

        array( 'name' => __('Google Apps Domain Verification', 'themeforce'),
            'desc' => __('Please enter the key here if you need to verfiy a domain, i.e. <em>&lt;meta name="google-site-verification" content="<strong>THIS_IS_THE_KEY</strong>" /&gt;</em>', 'themeforce'),
            'id' => 'tf_googleapps',
            'std' => '',
            'type' => 'text'),

        array( 'type' => 'close'),
 
);

    tf_display_settings( $options );
    ?> 
	 <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes', 'themeforce' )  ?>" />
         <div style="clear:both;"></div>
    </form>

    </div>
    </div>
    <?php
        
}	
?>