<?php

/*
 * TF OPTIONS: MAILCHIMP
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */


function themeforce_mailchimp_page() {
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
		'name' => __( 'API Key', 'themeforce'),
		'desc' => __( 'If you\'re unsure where to find your API key, please <a href=\'http://kb.mailchimp.com/article/where-can-i-find-my-api-key/\' target=\'_blank\'>click here</a>.', 'themeforce'),
		'id' => 'tf_mailchimp_api_key',
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

        <!--

        <div id="tf-tip">
            <h3>Why is a MailChimp Newsletter important?</h3>
            <p>A newsletter allows you to <strong>automatically</strong> keep in touch with your customer base, updating them on the latest news & events. You can set your newsletter to automatically send off your events on a weekly or monthly basis.</p>
        </div>

         -->

    </div>
    </div>
    <?php
        
}	
?>