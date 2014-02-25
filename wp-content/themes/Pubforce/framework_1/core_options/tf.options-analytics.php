<?php

/*
 * TF OPTIONS: Google Analytics
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */


function themeforce_analytics_page() {
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

        array( 
		'name' => __( 'Google Analytics UA ID', 'themeforce'),
		'desc' => __( 'This is you UA code from your Google Analytics Profile, enter it here to track this website. Example "UA-12345-67"', 'themeforce'),
		'id' => 'tf_ua_analytics',
		'std' => '',
		'type' => 'text'
	),
      
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