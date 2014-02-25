<?php

/*
 * TF OPTIONS: grubhub
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

function themeforce_grubhub_page() {
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
        'name' => __( 'GrubHub Customer ID', 'themeforce'),
        'desc' => __( 'This is the ID of your restaurant', 'themeforce'),
        'id' => 'tf_grubhub_id',
        'std' => '',
        'type' => 'text'
        ),

        array( 
		'name' => __( 'Enable GrubHub Button?', 'themeforce'),
		'desc' => __( 'This will show the GrubHub order button at the top of your website on every page', 'themeforce'),
		'id' => 'tf_grubhub_enabled',
		'std' => 'false',
		'type' => 'checkbox'
        ),

	array( 'type' => 'close'), 
 
	);
	
	$options = apply_filters( 'tf_options_grubhub', $options );

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