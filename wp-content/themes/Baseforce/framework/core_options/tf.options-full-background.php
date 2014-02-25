<?php

/*
 * TF OPTIONS: FULL BACKGROUND
 * 
 */

function themeforce_theme_options() {
    add_submenu_page('themes.php', __('Full Background', 'themeforce'), __('Full Background', 'themeforce'), 'manage_options', 'themeforce_theme_options', 'themeforce_themeoptions_page');
}
add_action('admin_menu','themeforce_theme_options');



function themeforce_themeoptions_page() {
    ?>
    <div class="wrap tf-options-page">
    <div class="tf-options-panel">
    <form class="form-table" action="options.php" method="post">

    <?php 
   
    
    // Options
    
    $options = array (
 
        array( 'name' => __('Full Background', 'themeforce'), 'type' => 'title'),

        array( 'type' => 'open'),   
	
        array( 'name' => __('Use Full-Screen Background?', 'themeforce'),
                'desc' => __('Check this box if you\'d like to use a full background image that resizes with the browser.', 'themeforce'),
                'id' => 'tf_full_background',
                'std' => 'false',
                'type' => 'checkbox'),
	
        array( 'name' => __('Background Image', 'themeforce'),
                'desc' => __('Your background image (we recommend using a JPG that is smaller than 300kb in size, yet around 1400px in width)', 'themeforce'),
                'id' => 'tf_background',
                'std' => '',
                'type' => 'image'),
	
	array( 'type' => 'close'), 
 
    );

    tf_display_settings($options);
    ?>         
	 <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes', 'themeforce' )  ?>" />
         <div style="clear:both;"></div>
    </form>
        <div id="tf-tip">
            <h3><?php _e('Create Depth', 'themeforce'); ?></h3>
            <p><?php _e('We recommend using an image that has perspective (i.e. foreground & background) to create depth visually within your website.', 'themeforce'); ?></p>
        </div>    
    </div>
    <?php   
}	
?>