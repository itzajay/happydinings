<?php require_once( '../../../../../../wp-load.php' );

header('Content-Type: text/html; charset=' . get_bloginfo( 'charset') );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php echo get_option( 'blog_charset' ); ?>" />
<title><?php _e('Insert Events') ?></title>
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
	
	#tf_menu_shortcode_form select { width: 150px; }
	
	.split-column { float: left; width: 43%; margin-right: 5%; }
	
</style>
</head>
<body>
	<div class="wrap">
		<h2>Insert Events</h2>
		
		<script type="text/javascript">
			function sendShortcodeToEditor() {
				var shortcode = "[tf-events-";
				
				//shortcode type				
				shortcode += jQuery( '#tf_events_shortcode_form select[name="tf_events_type"]' ).val();
				
				if( jQuery( '#tf_events_shortcode_form select[name="tf_eventscat"]' ).val() > '') {
					shortcode += " group='" + jQuery( '#tf_events_shortcode_form select[name="tf_eventscat"]' ).val() + "'"
				}
				
				if( jQuery( '#tf_events_shortcode_form select[name="tf_events_limit"]' ).val() > '') {
					shortcode += " limit='" + jQuery( '#tf_events_shortcode_form select[name="tf_events_limit"]' ).val() + "'"
				}
				
				shortcode += jQuery( '#tf_events_shortcode_form input[name="tf_events_show_titles"]' ).is( ":checked" ) ? " header='yes'" : " header='no'";
				
				shortcode += "]";

				tinyMCE.execInstanceCommand( "content", "mceInsertContent", false, shortcode );
			}
			
			function getWin() {
				return window.dialogArguments || opener || parent || top;
			}
			
			jQuery( document ).ready( function() {
				jQuery( "#tf_events_shortcode_form" ).submit( function() {
					sendShortcodeToEditor();
					
					tinyMCEPopup.close();
				} );
			} );
		</script>
		<form id="tf_events_shortcode_form">
			<p class="split-column">
				<label>Display Style</label><br />
				<select name="tf_events_type">
					<option <?php selected( isset( $_GET['type'] ) && $_GET['type'] == 'full' ) ?> value="full">All Events</option>
					<option <?php selected( isset( $_GET['type'] ) && $_GET['type'] == 'feat' ) ?> value="feat">Featured Events Only</option>
				</select>
			</p>
			<p class="split-column">
				<label>Events Category</label><br />
				<select name="tf_eventscat">
					<option value="">All</option>
					<?php foreach( get_terms( 'tf_eventcategory' ) as $term ) : ?>
						<option <?php selected( isset( $_GET['group'] ) && ( $_GET['group'] == $term->slug || $_GET['group'] == $term->name ) ) ?>  value="<?php echo $term->slug ?>"><?php echo $term->name ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			
			<p class="split-column">
				<label>Event Limit</label><br />
				<select name="tf_events_limit">
					<option value="">No Limit</option>
					<?php while( $i < 20 ) : $i++; ?>
						<option <?php selected( isset( $_GET['limit'] ) && ( $_GET['limit'] == $i ) ) ?>  value="<?php echo $i ?>"><?php echo $i ?></option>
					<?php  endwhile; ?>
				</select>
			</p>
			
			<p class="clear">
				<label><input type="checkbox" name="tf_events_show_titles" <?php checked( 'yes', isset( $_GET['showHeader'] ) ? $_GET['showHeader'] : 'yes' ) ?> /> Show Category Headers</label>
			</p>
			
			<p class="submitbox" style="margin-top:15px;">
				<a href="#" onclick="tinyMCEPopup.close();" class="submitdelete deletion" style="float:left">Cancel</a>
				<input type="submit" class="right button-primary" style="float:right" value="Insert Events" />
			</p>
		</form>
	</div>
</body>
</html>
