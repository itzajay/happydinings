<?php

/*
 * TF OPTIONS: opentable
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

// Create Page
// -----------------------------------------

function themeforce_opentable_page() {
    ?>
    <div class="tf-options-page">
    <div class="tf-options-panel">

    <form class="form-table" action="options.php" method="post">
   
    <?php 
    
    // List of Options used within Dropdowns, etc.
    
    $shortname = "tf";
    $options_yesno = array ( 'yes', 'no' );
    
    // Options
    
    $options = array (
 
        array( 'type' => 'open'),

        array( 
		'name' => 'Restaurant ID',
		'desc' => 'This is the numeric ID of your restaurant, usually a few numbers, i.e. \'12345\'',
		'id' => 'tf_opentable_id',
		'std' => '',
		'type' => 'text'
        ),

        array( 
		'name' => 'Enable OpenTable Reservation Bar?',
		'desc' => 'This will show the OpenTable bar at the top of your website on every page',
		'id' => 'tf_opentable_bar_enabled',
		'std' => 'false',
		'type' => 'checkbox'
        ),
              
	array( 'type' => 'close'), 
 
	);
	
	$options = apply_filters( 'tf_options_opentable', $options );

    tf_display_settings( $options );
    ?> 
	 <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes' )  ?>" />
         <div style="clear:both;"></div>
    </form>

        <!--


        <div id="tf-tip">
            <h3>Did you know?</h3>
            <p>OpenTable is a leading provider of free, real-time online restaurant reservations for diners and reservation and guest management solutions for restaurants.</p>
            <ul>
                <li>OpenTable has more than 20,000 restaurant customers, and, since its inception in 1998, has seated more than 200 million diners around the world.</li>
                <li>The OpenTable service is available throughout the United States, as well as in Canada, Germany, Japan, Mexico, and the United Kingdom.</li>
            </ul>

        </div>


         -->

    </div>
    </div>
    <?php
        
}	
?>