<?php

/*
 * TF OPTIONS: MASTER FUNCTIONS
 * 
 */

// Register Menu Pages

require_once( TF_PATH . '/core_options/tf.options-of-uploader.php' );


require_once( TF_PATH . '/core_options/tf.options-business-general.php' );
require_once( TF_PATH . '/core_options/tf.options-business-location.php' );
require_once( TF_PATH . '/core_options/tf.options-business-logo.php' );


require_once( TF_PATH . '/core_options/tf.options-social-media.php' );
require_once( TF_PATH . '/core_options/tf.options-social-facebook.php' );
require_once( TF_PATH . '/core_options/tf.options-social-twitter.php' );


require_once( TF_PATH . '/core_options/tf.options-social-overview.php' );
require_once( TF_PATH . '/core_options/tf.options-social-yelp.php' );
require_once( TF_PATH . '/core_options/tf.options-social-foursquare.php' );


require_once( TF_PATH . '/core_options/tf.options-3rdparty.php' );
require_once( TF_PATH . '/core_options/tf.options-integrations.php' );
require_once( TF_PATH . '/core_options/tf.options-mailchimp.php' );
require_once( TF_PATH . '/core_options/tf.options-opentable.php' );
require_once( TF_PATH . '/core_options/tf.options-grubhub.php' );
require_once( TF_PATH . '/core_options/tf.options-opendining.php' );
require_once( TF_PATH . '/core_options/tf.options-localina.php' );
require_once( TF_PATH . '/core_options/tf.options-analytics.php' );
require_once( TF_PATH . '/core_options/tf.options-google.php' );


if ( TF_MOBILE == true ) {
    require_once( TF_PATH . '/core_options/tf.options-mobile.php' );
}

// Register Pages
// -----------------------------------------

function themeforce_business_options() {
    add_menu_page( __('Business Overview', 'themeforce'), __('Your Business', 'themeforce'), 'edit_posts', 'themeforce_business_options', '', TF_URL . '/assets/images/general_16.png', 25); // $function, $icon_url, $position
    add_submenu_page('themeforce_business_options', __( 'Business Details', 'themeforce'), __( 'Business Details', 'themeforce'), 'edit_posts', 'themeforce_business', 'themeforce_business_page');
    add_submenu_page('themeforce_business_options', __( 'Logo', 'themeforce'), __( 'Logo', 'themeforce'), 'edit_posts', 'themeforce_logo', 'themeforce_logo_page');
    add_submenu_page('themeforce_business_options', __( 'Your Location', 'themeforce'), __( 'Location', 'themeforce'), 'edit_posts', 'themeforce_location', 'themeforce_location_page');

}

add_action( 'admin_menu', 'themeforce_business_options' );

function themeforce_socialmedia_options() {
    add_menu_page( __( 'Social Media Overview', 'themeforce'), __( 'Social Media', 'themeforce'), 'manage_options', 'themeforce_socialmedia_options', 'themeforce_social_media_overview_page', TF_URL . '/assets/images/socialmedia_16.png', 30); // $function, $icon_url, $position
    add_submenu_page('themeforce_socialmedia_options', __( 'Facebook', 'themeforce'), __( 'Facebook', 'themeforce'), 'manage_options', 'themeforce_facebook', 'themeforce_social_facebook_page');
    add_submenu_page('themeforce_socialmedia_options', __( 'Twitter', 'themeforce'), __('Twitter', 'themeforce'), 'manage_options', 'themeforce_twitter', 'themeforce_social_twitter_page');
}

add_action( 'admin_menu', 'themeforce_socialmedia_options' );

function themeforce_social_options() {
    add_menu_page( __('Social Proof Overview', 'themeforce'), __( 'Social Proof', 'themeforce'), 'manage_options', 'themeforce_social_options', 'themeforce_social_overview_page', TF_URL . '/assets/images/social_16.png', 35); // $function, $icon_url, $position
    add_submenu_page('themeforce_social_options', __( 'Yelp', 'themeforce'), __( 'Yelp', 'themeforce'), 'manage_options', 'themeforce_yelp', 'themeforce_social_yelp_page');
    add_submenu_page('themeforce_social_options', __( 'Foursquare', 'themeforce'), __( 'Foursquare', 'themeforce'), 'manage_options', 'themeforce_foursquare', 'themeforce_social_foursquare_page');
    
}

add_action( 'admin_menu', 'themeforce_social_options' );

function themeforce_3rdparty_options() {
    add_menu_page( __( '3rd Party Integrations', 'themeforce'), __( 'Integrations', 'themeforce'), 'manage_options', 'themeforce_integrations', 'themeforce_integrations_page', TF_URL . '/assets/images/integrate_16.png', 36); // $function, $icon_url, $position


}

add_action( 'admin_menu', 'themeforce_3rdparty_options');

// Load jQuery & relevant CSS
// -----------------------------------------

// js
function themeforce_business_options_scripts() {
    wp_enqueue_script( 'tfoptions', TF_URL . '/assets/js/themeforce-options.js', array( 'jquery'), TF_VERSION  );
    wp_enqueue_script( 'iphone-checkbox', TF_URL . '/assets/js/jquery.iphone-style-checkboxes.js', array( 'jquery'), TF_VERSION  );
    wp_enqueue_script( 'farbtastic', TF_URL . '/assets/js/jquery.farbtastic.js', array( 'jquery'), TF_VERSION  );
    wp_enqueue_script( 'chosen', TF_URL . '/assets/js/jquery.chosen.min.js', array( 'jquery'), TF_VERSION  );
}

add_action( 'admin_print_scripts', 'themeforce_business_options_scripts' );

// css
function themeforce_business_options_styles() {
    wp_enqueue_style( 'tfoptions', TF_URL . '/assets/css/themeforce-options.css', array(), TF_VERSION );
    wp_enqueue_style( 'farbtastic', TF_URL . '/assets/css/farbtastic.css', array(), TF_VERSION );
}

add_action( 'admin_print_styles', 'themeforce_business_options_styles' );

// Validation

function tf_settings_validate( $input ) {
    
	$newinput['text_string'] = trim( $input['text_string'] );
    
    if (!preg_match('/^[a-z0-9]{32}$/i', $newinput['text_string'])) {
        $newinput['text_string'] = '';
    }

	return $newinput;
}

// Display Settings

function tf_display_settings( $options ) {

    foreach ($options as $value) {
        switch ( $value['type'] ) {

        case "title":
        ?>
        <h3><?php echo $value['name']; ?></h3>

        <?php break;    

        case "open":
        ?>

        <table>

        <?php break;

        case "close":
        ?>

        </table>

        <?php break;

        case 'text':
        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
            <td>
                <input name="<?php echo $value['id'] ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>">
                <br /><span class="desc"><?php echo $value['desc'] ?></span>
            </td>
        </tr>

        <?php
        break;

        case 'textarea':
        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
            <td><textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?></textarea>
            <br /><span class="desc"><?php echo $value['desc'] ?></span></td>
        </tr>

        <?php
        break;

        case 'select':
        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
            <td>
                <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                <?php foreach ($value['options'] as $key => $option) { ?>
                    <option value="<?php echo ( $value['use_keys'] ) ? $key : $option; ?>" <?php selected( ( $value['use_keys'] ) ? $key : $option, get_option( $value['id'] ) ) ?>><?php echo $option; ?></option><?php } ?>
                </select>
                <br /><span class="desc"><?php echo $value['desc'] ?></span>
            </td>
        </tr>
         <?php
        break;
        
        case 'multiple-select':
        	
        	$current_values = (array) get_option( $value['id'], array() );
        	?>
			
        	<tr>
        	    <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
        	    <td>
        	        <select name="<?php echo $value['id']; ?>[]" class="chzn-select" multiple id="<?php echo $value['id']; ?>">
        	        <?php foreach ($value['options'] as $key => $option) { ?>
        	            <option value="<?php echo ( $value['use_keys'] ) ? $key : $option; ?>" <?php selected( in_array( ( $value['use_keys'] ) ? $key : $option, $current_values ) ) ?>><?php echo $option; ?></option><?php } ?>
        	        </select>
        	        <br /><span class="desc"><?php echo $value['desc'] ?></span>
        	    </td>
        	</tr>
			
        	<?php
        	
        	
        	break;

        case "checkbox":
        
        	$std = $value['std'];     
        	    
        	$saved_std = get_option( $value['id'] );
			
        	$checked = '';
			
        	if ( !empty( $saved_std ) ) {
        	        if ( $saved_std == 'true' ) {
        	       		$checked = 'checked="checked"';
        	        }
        	        else {
        	           $checked = '';
        	        }
        	}
        	elseif ( $std == 'true') {
        	   $checked = 'checked="checked"';
        	}
        	else {
				$checked = '';
        	}
        	    
        	?>
			
        	<tr>
        	    <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
        	    <td>
        	        <input type="checkbox" name="<?php echo $value['id']; ?>" class="iphone" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
        	        <br /><span class="desc"><?php echo $value['desc'] ?></span>
        	    </td>
        	</tr>
			
        	<?php break;

        case "radio":
        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
            <td>
            <?php foreach ($value['options'] as $option) { ?>
                <div><input type="radio" name="<?php echo $value['id']; ?>" <?php if (get_option( $value['id'] ) == $option) { echo 'checked'; } ?> /><?php echo $option; ?></div><?php } ?>
                <br /><span class="desc"><?php echo $value['desc'] ?></span>
            </td>
        </tr>
        
        <?php break;
        
        case "image":

        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>

            </th>
            <td>
            	<?php
            	if ( get_option( $value['id'] ) != "") { $val = stripslashes(get_option( $value['id'])  ); } else { $val =  $value['std']; }
            	?>
            	<?php
            	$value['allowed_extensions'] = $value['allowed_extensions'] ? $value['allowed_extensions'] : array( 'jpeg', 'jpg', 'png', 'gif' );
            	$drop_text = ! empty( $value['drop_text'] ) ? $value['drop_text'] : __( 'Drop image here', 'themeforce');
            	
            	$value['size'] = $value['size'] ? $value['size'] : 'width=440&height=220&crop=1';
            	
            	$uploader = new TF_Upload_Image_Well( $value['id'], $val, array( 'size' => $value['size'], 'drop_text' => $drop_text, 'allowed_extensions' => $value['allowed_extensions'] ) );
            	$uploader->admin_print_styles();
            	$uploader->html();
            	
            	?>
            	
            	<?php //echo tf_optionsframework_medialibrary_uploader( $value['id'], $val ); ?>
            	<br /><span class="desc"><?php echo $value['desc'] ?></span>
            	
            	
            </td>
        </tr>
        
        <?php break;
        
        case "images":
        ?>
        <tr class="image-radio">
            <th><label><?php echo $value['name']; ?></label>

         </th>
        <td>
        <?php
        
        $i = 0;
        $select_value = get_option( $value['id'] );

        foreach ($value['options'] as $key => $option) 
         { 
         $i++;

                 $checked = '';
                 $selected = '';
                   if ($select_value != '') {
                                if ( $select_value == $key) { $checked = ' checked'; $selected = 'tf-radio-img-selected'; } 
                    } else {
                                if ($value['std'] == $key) { $checked = ' checked'; $selected = 'tf-radio-img-selected'; }
                                elseif ($i == 1  && !isset( $select_value) ) { $checked = ' checked'; $selected = 'tf-radio-img-selected'; }
                                elseif ($i == 1  && $value['std'] == '') { $checked = ' checked'; $selected = 'tf-radio-img-selected'; }
                                else { $checked = ''; }
                        }	

                echo '<span>';
                echo '<input type="radio" id="' . $value['id'] . $i . '" class="tf-radio-img-radio" value="'.$key.'" name="'. $value['id'].'"'.$checked.' tabindex="'.$i .'" />';
                echo '<label for="'. $value['id'] . $i . '"><img src="'.$option.'" alt="" class="tf-radio-img-img '. $selected .'" /></label>';
                echo '</span>';

        } ?>
        </td>
        </tr> 
         
        <?php
        break;
        
        case "open-farbtastic":
        ?>
        
        </table>
        <div style="clear:both;"></div>
        <div class="tf-settings-wrap tf-farbtastic">
        <div id="farbtastic-picker"><div id="picker-bg"></div></div>
        <table> 
        
        
        <?php break;
        
        case "colorpicker":
        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
            <td>
            <input class="colorwell" name="<?php echo $value['id'] ?>" type="text" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>">
            </td>
        </tr>
        
         <?php break;
        
        case "close-farbtastic":
        ?>
            
        </table>
        </div>
        <div style="clear:both;"></div>
        <table>      
        
        <?php break;
        
        
        default :
        	do_action( 'tf_display_setting_type_' . $value['type'], $value );
        }
	}
	
	foreach( $options as $option ) 
		if ( !empty( $option['id'] ) )
			$option_ids[] = $option['id'];
	
	?>
	
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="<?php echo implode(', ', $option_ids) ?>" />
    <?php wp_nonce_field( 'update-options' ); ?>
	    
    <?php
}?>