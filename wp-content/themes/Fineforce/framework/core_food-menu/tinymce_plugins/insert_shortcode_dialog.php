<?php require_once( '../../../../../../wp-load.php' );

header('Content-Type: text/html; charset=' . get_bloginfo( 'charset') );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php echo get_option( 'blog_charset' ); ?>" />
<title><?php _e('Insert Food Menu') ?></title>
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
		<h2>Insert Food Menu</h2>
		
		<script type="text/javascript">
			
			function sendCategoryShortcodeToEditor() {
				var shortcode = "[tf-menu-";
				
				//shortcode type				
				shortcode += jQuery( '#tf_category_only_shortcode_form select[name="tf_food_menu_type"]' ).val();
				
				if( jQuery( '#tf_category_only_shortcode_form select[name="tf_foodmenucat"]' ).val() > '') {
					shortcode += " id='" + jQuery( '#tf_category_only_shortcode_form select[name="tf_foodmenucat"]' ).val() + "'"
				}
				
				if( jQuery( '#tf_category_only_shortcode_form select[name="tf_food_menu_align"]' ).val() > '' ) {
					shortcode += " align='" + jQuery('#tf_category_only_shortcode_form select[name="tf_food_menu_align"]' ).val() + "'";
				}
				
				shortcode += jQuery( '#tf_category_only_shortcode_form input[name="tf_food_menu_show_titles"]' ).is( ":checked" ) ? " header='yes'" : " header='no'";
				
				shortcode += "]";
				
				tinyMCE.execInstanceCommand( "content", "mceInsertContent", false, shortcode );
			}
			
			
			function sendMenuShortcodeToEditor() {
			
				var shortcode = "[tf-menu-all";
				
				//shortcode type				
				shortcode += " menuid='" + jQuery( '#tf_full_menu_shortcode_form select[name="tf_food_menu_select"]' ).val() + "'";
				
				shortcode += " name='" + jQuery( '#tf_full_menu_shortcode_form select[name="tf_food_menu_select"]' ).text() +"'";
				
				shortcode += jQuery( '#tf_category_only_shortcode_form input[name="tf_food_menu_show_titles"]' ).is( ":checked" ) ? " header='yes'" : " header='no'";
				
				shortcode += " fullmenu='true'";	
				
				shortcode += " ]";
				
				console.log( shortcode );
				
				tinyMCE.execInstanceCommand( "content", "mceInsertContent", false, shortcode );
			
			}
			
			function getWin() {
				return window.dialogArguments || opener || parent || top;
			}
			
			jQuery( document ).ready( function() {
				
				jQuery( "#tf_category_only_shortcode_form" ).submit( function() {
					sendCategoryShortcodeToEditor();
					
					tinyMCEPopup.close();
					
				} );
				
								
				 jQuery( "#tf_full_menu_shortcode_form" ).submit( function() {
					sendMenuShortcodeToEditor();
					
					tinyMCEPopup.close();
					
				} );
				
				jQuery( 'input[name="add_type"]' ).live( 'click', function ( e ) {
							
						if ( jQuery( this ).is( ':checked' ) && jQuery( this ).val() == "category" ){
						
							jQuery( '#tf_full_menu_shortcode_form' ).hide();
							jQuery( '#tf_category_only_shortcode_form').show();						
						}else{
						
							jQuery( '#tf_full_menu_shortcode_form' ).show();
							jQuery( '#tf_category_only_shortcode_form').hide();	
						}
				
				} );
				

				if( window.parent.jQuery( '#page_template' ).val() != 'page-full.php' && window.parent.jQuery( '#page_template' ).val() != 'onecolumn-page.php' )
					jQuery( 'p._align' ).val('').hide();
				else
					jQuery( 'p._type option[value="short"]' ).remove();
				
			} );
		</script>
		
		<input type="radio" name="add_type" value="menu"  <?php checked( ! isset( $_GET['type'] ) || $_GET['type'] == 'All' ); ?>  /> Insert a full Menu <br />
		<input type="radio" name="add_type" value="category" <?php checked( isset( $_GET['type'] ) && $_GET['type'] != 'All' ); ?>  /> Insert a Menu Category only
		
			<?php tf_foodmenu_output_full_menu_form(); ?>
			
			<?php tf_foodmenu_output_category_only_form(); ?>
			
		</div>
</body>
</html>

<?php 

function tf_foodmenu_output_full_menu_form() {

	?>
	<form id="tf_full_menu_shortcode_form" style="<?php if ( isset( $_GET['type'] ) && $_GET['type'] != 'All' ) echo "display: none;"; ?>">
	    <p class="split-column _type">
	    	
	    	<label>Menu</label><br />
	    	<select name="tf_food_menu_select">
	    		
	    		<?php foreach( get_option( '_tf_food_menu_array' ) as $key => $menu ): ?>
	    		
	    			<option value="<?php echo $key; ?>"><?php echo $menu['menu-name']; ?></option>
	    		
	    		<?php endforeach; ?>
	
	    	</select>
	    </p>
	    
	    <p class="split-column">
	    
	    </p>
	    
	    <?php if ( get_current_theme() != 'Pubforce' ) : ?>
	    	<p class="split-column _align">
	    		<label>Align Side (Only for Full Width)</label><br />
	    		<select name="tf_food_menu_align">
	    			<option value="">None</option>
	    			<option <?php selected( isset( $_GET['align'] ) && $_GET['align'] == 'left' ) ?> value="left">Left</option>
	    			<option <?php selected( isset( $_GET['align'] ) && $_GET['align'] == 'right' ) ?> value="right">Right</option>
	    		</select>
	    	</p>
	    <?php endif; ?>
	    
	    <p class="clear">
	    	<label><input type="checkbox" name="tf_food_menu_show_titles" <?php checked( 'yes', isset( $_GET['showHeader'] ) ? $_GET['showHeader'] : 'yes' ) ?> /> Show Category Headers</label>
	    </p>
	    
	    <p class="submitbox" style="margin-top:15px;">
	    	<a href="#" onclick="tinyMCEPopup.close();" class="submitdelete deletion" style="float:left">Cancel</a>
	    	<input type="submit" class="right button-primary" style="float:right" value="Insert Menu" />
	    </p>
	</form>
	<?php
}

function tf_foodmenu_output_category_only_form() {

?>
		<form id="tf_category_only_shortcode_form" style="<?php if ( ! isset( $_GET['type'] ) || $_GET['type'] == 'All' ) echo "display: none;"; ?>">
			<p class="split-column _type">
				<label>Display Style</label><br />
				<select name="tf_food_menu_type">
					<option <?php selected( isset( $_GET['type'] ) && $_GET['type'] == 'full' ) ?> value="full">Full (w/images)</option>
					<option <?php selected( isset( $_GET['type'] ) && $_GET['type'] == 'list' ) ?> value="list">List</option>
					<option <?php selected( isset( $_GET['type'] ) && $_GET['type'] == 'short' ) ?> value="short">Short</option>
				</select>
			</p>
			<p class="split-column">
				<label>Food Menu Category</label><br />
				<select name="tf_foodmenucat">
					<option value="">All</option>
					<?php foreach ( get_terms( 'tf_foodmenucat' ) as $term ) : ?>
						<option <?php selected( isset( $_GET['id'] ) && ( $_GET['id'] == $term->slug || $_GET['id'] == $term->name ) ) ?>  value="<?php echo $term->slug ?>"><?php echo $term->name ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			
			<?php if ( get_current_theme() != 'Pubforce' ) : ?>
				<p class="split-column _align">
					<label>Align Side (Only for Full Width)</label><br />
					<select name="tf_food_menu_align">
						<option value="">None</option>
						<option <?php selected( isset( $_GET['align'] ) && $_GET['align'] == 'left' ) ?> value="left">Left</option>
						<option <?php selected( isset( $_GET['align'] ) && $_GET['align'] == 'right' ) ?> value="right">Right</option>
					</select>
				</p>
			<?php endif; ?>
			
			<p class="clear">
				<label><input type="checkbox" name="tf_food_menu_show_titles" <?php checked( 'yes', isset( $_GET['showHeader'] ) ? $_GET['showHeader'] : 'yes' ) ?> /> Show Category Headers</label>
			</p>
			
			<p class="submitbox" style="margin-top:15px;">
				<a href="#" onclick="tinyMCEPopup.close();" class="submitdelete deletion" style="float:left">Cancel</a>
				<input type="submit" class="right button-primary" style="float:right" value="Insert Menu" />
			</p>
		</form>
<?php
}
