<?php

/*
 * TF OPTIONS: open dining
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

// Create Page
// -----------------------------------------

function themeforce_opendining_page() {
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
            'name' => __( 'App ID', 'themeforce'),
            'desc' => __( 'This is the ID that Open Dining provides, usually a few a string of text that looks like this \'4d278f47758d88fd32010000\'', 'themeforce'),
            'id' => 'tf_opendining_app_id',
            'std' => '',
            'type' => 'text'
        ),

        array(
            'name' => __( 'Restaurant ID', 'themeforce'),
            'desc' => __( 'This is the ID of your restaurant at Open Dining, usually a few a string of text that looks like this \'4d278f47758d88fd32010000\'', 'themeforce'),
            'id' => 'tf_opendining_rest_id',
            'std' => '',
            'type' => 'text'
        ),

        array( 
            'name' => __( 'Enable "Order Online" Button', 'themeforce'),
            'desc' => __( 'This will show the Open Dining buton at the top of your website on every page', 'themeforce'),
            'id' => 'tf_opendining_enabled',
            'std' => 'false',
            'type' => 'checkbox'
        ),
              
	    array( 'type' => 'close'),
 
	);
	
	$options = apply_filters( 'tf_options_opendining', $options );

    tf_display_settings( $options );
    ?> 
	 <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes', 'themeforce' )  ?>" />
         <div style="clear:both;"></div>
    </form>
        <!--
        <div id="tf-tip">
            <h3><?php _e('Did you know?', 'themeforce'); ?></h3>
            <p><a href="https://www.opendining.net/link/b1793c2f1bba061d188a11fff40aa30406455fae">Open Dining</a> <?php _e('gets your restaurant more orders, larger tickets, and more loyal customers with web, mobile, and Facebook ordering.', 'themeforce'); ?></p>
            <ul>
                <li>Receive orders in whichever way is most convenient: E-mail, Fax, directly to your PoS and more.</li>
                <li>The service is available globally.</li>
            </ul>

        </div>
        -->
    </div>
    </div>
    <?php
        
}	
?>