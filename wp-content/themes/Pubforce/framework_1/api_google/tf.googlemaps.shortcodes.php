<?php
// Output Linked Google Map (with Schema)

/**
 * @param Shortcode variables (width, height, color, zoom, align, address)
 * @return string DOM output
 */
function tf_googlemaps ( $atts ) {

    extract( shortcode_atts( array(
        'width' => '578',
        'height' => '200',
        'color' => 'green',
        'zoom' => '13',
        'align' => 'center',
        'address' => ''
        ), $atts) );

    ob_start();
    
    // Grab Addresss Data
    
    $options_address = get_option( 'tf_address_street' ) . ', ' . get_option( 'tf_address_locality' ) . ', ' . get_option( 'tf_address_postalcode' ) . ' ' . get_option( 'tf_address_region' ) . ' ' . get_option( 'tf_address_country' );
    
    // Choose
    
    if ( $address != '' ) {
        $valid_address = $address;
    } else {
        $valid_address = $options_address;
    }
    
    $address_url = preg_replace( '![^a-z0-9]+!i', '+', $valid_address );
    
    // Display ?>

    <span itemprop="maps"><a href="<?php echo 'http://maps.google.com/maps?q=' . $address_url; ?>" target="_blank"><img class="align<?php echo $align; ?> tf-googlemaps" src="http://maps.googleapis.com/maps/api/staticmap?size=<?php echo $width; ?>x<?php echo $height; ?>&zoom=<?php echo $zoom; ?>&markers=color:red%7C<?php echo $address_url; ?>&sensor=true" alt="<?php _e('Google Map of Location', 'themeforce'); ?>"></a></span>

    
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;

    }

add_shortcode('tf-googlemaps', 'tf_googlemaps');

/**
 * Registers the Insert Shortcode tinymce plugin for google maps.
 * 
 */
function tf_google_maps_register_tinymce_buttons() {
	
	if ( !current_user_can( 'edit_posts' ) || 
		( isset( $_GET['post'] ) && !in_array( get_post_type( $_GET['post'] ), array( 'post', 'page' ) ) ) || 
		( isset( $_GET['post_type'] ) && !in_array( $_GET['post_type'], array( 'post', 'page' ) ) ) )
		return;
	
	add_filter( 'mce_external_plugins', 'tf_google_maps_add_tinymce_plugins' );
}

add_action( 'load-post.php', 'tf_google_maps_register_tinymce_buttons' );
add_action( 'load-post-new.php', 'tf_google_maps_register_tinymce_buttons' );


/**
 * Adds the Insert Shortcode tinyMCE plugin for google maps.
 * 
 * @param array $plugin_array
 * @return array
 */
function tf_google_maps_add_tinymce_plugins( $plugin_array ) {
	$plugin_array['tf_google_maps_shortcode_plugin'] = TF_URL . '/api_google/tinymce_plugins/insert_shortcode.js';
	
	return $plugin_array;
}

function tf_google_maps_add_insert_events_above_editor() {
	?>
	<a class="tf-button tf-inlinemce" href="javascript:tinyMCE.activeEditor.execCommand( 'mceExecTFGoogleMapsInsertShortcode' );"><img src="<?php echo TF_URL . '/api_google/tinymce_plugins/map_20.png' ?>"/><span>Maps</span></a>
	<script>
		var TFAddress = '<?php echo preg_replace( '![^a-z0-9]+!i', '+', get_option( 'tf_address_street' ) . ', ' . get_option( 'tf_address_locality' ) . ', ' . get_option( 'tf_address_postalcode' ) . ' ' . get_option( 'tf_address_region' ) . ' ' . get_option( 'tf_address_country' ) ) ?>';
	</script>
	<?php
}

add_action( 'tf_above_editor_insert_items', 'tf_google_maps_add_insert_events_above_editor' );