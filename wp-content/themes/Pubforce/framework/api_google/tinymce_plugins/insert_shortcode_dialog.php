<?php require_once( '../../../../../../wp-load.php' );

header('Content-Type: text/html; charset=' . get_bloginfo( 'charset') );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php echo get_option( 'blog_charset' ); ?>" />
<title><?php _e('Insert Google Map') ?></title>
<script type="text/javascript" src="<?php bloginfo( 'url' )?>/wp-includes/js/tinymce/tiny_mce_popup.js?ver=342"></script>
<script type="text/javascript" src="<?php bloginfo( 'url' )?>/wp-includes/js/jquery/jquery.js"></script>
<?php
wp_admin_css( 'wp-admin', true );
wp_admin_css( 'colors-fresh', true );

?>
<style type="text/css">
	body { min-width: 200px; } 

	#wphead {
		font-size: 80%;
		border-top: 0;
		color: #555;
		background-color: #f1f1f1;
	}
	#wphead h1 {
		font-size: 24px;
		color: #555;
		margin: 0;
		padding: 10px;
	}
	#tabs {
		padding: 15px 15px 3px;
		background-color: #f1f1f1;
		border-bottom: 1px solid #dfdfdf;
	}
	#tabs li {
		display: inline;
	}
	#tabs a.current {
		background-color: #fff;
		border-color: #dfdfdf;
		border-bottom-color: #fff;
		color: #d54e21;
	}
	#tabs a {
		color: #2583AD;
		padding: 6px;
		border-width: 1px 1px 0;
		border-style: solid solid none;
		border-color: #f1f1f1;
		text-decoration: none;
	}
	#tabs a:hover {
		color: #d54e21;
	}
	.wrap {
		padding: 15px;
		margin: 0;
	}
	.wrap h2 {
		border-bottom-color: #dfdfdf;
		color: #555;
		margin: 5px 0;
		padding: 0;
		font-size: 18px;
	}
	#user_info {
		right: 5%;
		top: 5px;
	}
	h3 {
		font-size: 1.1em;
		margin-top: 10px;
		margin-bottom: 0px;
	}
	#flipper {
		margin: 0;
		padding: 5px 20px 10px;
		background-color: #fff;
		border-left: 1px solid #dfdfdf;
		border-bottom: 1px solid #dfdfdf;
	}
	* html {
        overflow-x: hidden;
        overflow-y: scroll;
    }
	#flipper div p {
		margin-top: 0.4em;
		margin-bottom: 0.8em;
		text-align: justify;
	}
	th {
		text-align: center;
	}
	.top th {
		text-decoration: underline;
	}
	.top .key {
		text-align: center;
		width: 5em;
	}
	.top .action {
		text-align: left;
	}
	.align {
		border-left: 3px double #333;
		border-right: 3px double #333;
	}
	.keys {
		margin-bottom: 15px;
	}
	.keys p {
		display: inline-block;
		margin: 0px;
		padding: 0px;
	}
	.keys .left { text-align: left; }
	.keys .center { text-align: center; }
	.keys .right { text-align: right; }
	td b {
		font-family: "Times New Roman" Times serif;
	}
	#buttoncontainer {
		text-align: center;
		margin-bottom: 20px;
	}
	#buttoncontainer a, #buttoncontainer a:hover {
		border-bottom: 0px;
	}

	.mac,
	.macos .win {
		display: none;
	}

	.macos span.mac {
		display: inline;
	}

	.macwebkit tr.mac {
		display: table-row;
	}
	
	.regular-num {
		width: 60px;
	}
	
	#tf_menu_shortcode_form select { width: 150px; }
	
	.split-column { float: left; width: 13%; margin-right: 3%; }
	
</style>
</head>
<body>
	<div class="wrap">
		<h2>Insert Map</h2>
		
		<script type="text/javascript">
			function sendShortcodeToEditor() {
				var shortcode = "[tf-googlemaps";
				
				if( jQuery( '#tf_google_maps_shortcode_form select[name="tf_google_maps_align"]' ).val() > '' ) {
					shortcode += " align='" + jQuery('#tf_google_maps_shortcode_form select[name="tf_google_maps_align"]' ).val() + "'";
				}
				
				if( jQuery( '#tf_google_maps_shortcode_form input[name="tf_google_maps_width"]' ).val() > '' ) {
					shortcode += " width='" + jQuery('#tf_google_maps_shortcode_form input[name="tf_google_maps_width"]' ).val() + "'";
				}
				
				if( jQuery( '#tf_google_maps_shortcode_form input[name="tf_google_maps_height"]' ).val() > '' ) {
					shortcode += " height='" + jQuery('#tf_google_maps_shortcode_form input[name="tf_google_maps_height"]' ).val() + "'";
				}
				
				if( jQuery( '#tf_google_maps_shortcode_form select[name="tf_google_maps_color"]' ).val() > '' ) {
					shortcode += " color='" + jQuery('#tf_google_maps_shortcode_form select[name="tf_google_maps_color"]' ).val() + "'";
				}
				
				if( jQuery( '#tf_google_maps_shortcode_form input[name="tf_google_maps_zoom"]' ).val() > '' ) {
					shortcode += " zoom='" + jQuery('#tf_google_maps_shortcode_form input[name="tf_google_maps_zoom"]' ).val() + "'";
				}
				
				shortcode += "]";
				
				tinyMCE.execInstanceCommand( "content", "mceInsertContent", false, shortcode );
			}
			
			function getWin() {
				return window.dialogArguments || opener || parent || top;
			}
			
			jQuery( document ).ready( function() {
				jQuery( "#tf_google_maps_shortcode_form" ).submit( function() {
					sendShortcodeToEditor();
					
					tinyMCEPopup.close();
					
				} );
			} );
		</script>
		<form id="tf_google_maps_shortcode_form">
			<p class="split-column _type">
				<label>Width</label><br />
				<input name="tf_google_maps_width" type="text" class="regular-num" value="<?php echo (int) $_GET['width'] ? $_GET['width'] : 578 ?>" />
			</p>
			<p class="split-column">
				<label>Height</label><br />
				<input name="tf_google_maps_height" type="text" class="regular-num" value="<?php echo (int) $_GET['height'] ? $_GET['height'] : 200 ?>" />
			</p>
			
			<p class="split-column _align">
			    <label>Align</label><br />
			    <select name="tf_google_maps_align">
			    	<option value="">None</option>
			    	<option <?php selected( isset( $_GET['align'] ) && $_GET['align'] == 'center' ) ?> value="center">Center</option>
			    	<option <?php selected( isset( $_GET['align'] ) && $_GET['align'] == 'left' ) ?> value="left">Left</option>
			    	<option <?php selected( isset( $_GET['align'] ) && $_GET['align'] == 'right' ) ?> value="right">Right</option>
				</select>
			</p>
			
			<p class="split-column _align">
			    <label>Color</label><br />
			    <select name="tf_google_maps_color">
			    	<option <?php selected( isset( $_GET['align'] ) && $_GET['align'] == 'center' ) ?> 	value="green">Green</option>
			    	<option <?php selected( isset( $_GET['align'] ) && $_GET['align'] == 'left' ) ?> 	value="red">Red</option>
			    	<option <?php selected( isset( $_GET['align'] ) && $_GET['align'] == 'right' ) ?> 	value="blue">Blue</option>
				</select>
			</p>
			
			<p class="split-column">
				<label>Zoom</label><br />
				<input name="tf_google_maps_zoom" type="text" class="regular-num" value="<?php echo (int) $_GET['zoom'] ? $_GET['zoom'] : 13 ?>" />
			</p>
			
			<div class="map-preview clear" style="padding: 10px; background: #f3f3f3; border: 1px solid #eee; border-radius: 3px;">
				<strong class="clear" style="display: block">Map Preview</strong>
				
				<script type="text/javascript">
					var address = '<?php echo preg_replace( '![^a-z0-9]+!i', '+', get_option( 'tf_address_street' ) . ', ' . get_option( 'tf_address_locality' ) . ', ' . get_option( 'tf_address_postalcode' ) . ' ' . get_option( 'tf_address_region' ) . ' ' . get_option( 'tf_address_country' ) ) ?>';


					jQuery( document ).ready( function() {
					
						refreshPreview();
					
					});
					
					jQuery( '#tf_google_maps_shortcode_form input, #tf_google_maps_shortcode_form select' ).change( function() {
						refreshPreview();
					} );
					
					function refreshPreview() {
					
						var width = jQuery( 'input[name="tf_google_maps_width"]' ).val();
						var height = jQuery( 'input[name="tf_google_maps_height"]' ).val();
						var align = jQuery( 'select[name="tf_google_maps_align"]' ).val();
						var color = jQuery( 'select[name="tf_google_maps_color"]' ).val();
						var zoom = jQuery( 'input[name="tf_google_maps_zoom"]' ).val();

						var src = 'http://maps.google.com/maps/api/staticmap?center=' + address + '&zoom=' + zoom + '&size=' + width + 'x' + height + '&markers=color:' + color + '|' + address + '&sensor=false';
						
						jQuery( 'img.tf-googlemaps' ).attr( 'src', src );
						jQuery( 'img.tf-googlemaps' ).attr( 'class', 'tf-googlemaps align-' + align );
					}
				</script>

			    <span itemprop="maps">
			    	<a href="<?php echo 'http://maps.google.com/maps?q=' . $address_url; ?>" target="_blank">
			    		<img style="max-width:100%; max-height: 240px" class="align<?php echo $align; ?> tf-googlemaps" src="">
			    	</a>
			    </span>
			    
			    <p class="description"><br />You can change your address details in <a target="_blank" href="<?php echo admin_url( 'admin.php?page=themeforce_location' ) ?>">Business Options Settings</a></p>
			</div>
			
			<p class="submitbox clear" style="margin-top:15px;">
				<a href="#" onclick="tinyMCEPopup.close();" class="submitdelete deletion" style="float:left">Cancel</a>
				<input type="submit" class="right button-primary" style="float:right" value="Insert Map" />
			</p>
		</form>
	</div>
</body>
</html>
