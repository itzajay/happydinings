<?php

/*
 * TF OPTIONS: Localina
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

function themeforce_localina_page() {
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
        'name' => __( 'Restaurant API Key', 'themeforce'),
        'desc' => __( 'This is your personal API key', 'themeforce'),
        'id' => 'tf_localina_api',
        'std' => '',
        'type' => 'text'
        ),

        array( 
		'name' => __( 'Restaurant Phone Number', 'themeforce'),
		'desc' => __( 'This is the numeric phone number of your restaurant, with full prefix, i.e. \'0041431234567\'', 'themeforce'),
		'id' => 'tf_localina_phone',
		'std' => '',
		'type' => 'text'
        ),

        array( 
		'name' => __( 'Enable Localina Button?', 'themeforce'),
		'desc' => __( 'This will show the Localina button at the top of your website on every page', 'themeforce'),
		'id' => 'tf_localina_enabled',
		'std' => 'false',
		'type' => 'checkbox'
        ),

	array( 'type' => 'close'), 
 
	);
	
	$options = apply_filters( 'tf_options_localina', $options );

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