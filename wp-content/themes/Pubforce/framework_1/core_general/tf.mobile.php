<?php

// Adapted from Mike Schinkel
// http://wordpress.stackexchange.com/questions/859/show-a-wp-3-0-custom-menu-in-an-html-select-with-auto-navigation

function wp_nav_mobile( $menu ) {
          
  $page_menu_items = wp_get_nav_menu_items($menu, array(
    'meta_key'=>'_menu_item_object',
  ));
  $selector = array();
  if ( is_array($page_menu_items ) && count( $page_menu_items)>0 ) {
    $selector[] =<<<HTML
<select id="page-selector" name="page-selector"
    onchange="location.href = document.getElementById( 'page-selector' ).value;">
HTML;
    $selector[] = '<option value="">Select a Page</option>';
    foreach($page_menu_items as $page_menu_item) {
      $link = get_page_link( $page_menu_item->object_id );
      $prefix = '';
      if ($page_menu_item->menu_item_parent > 0 ) { $prefix = '- ';}
      $selector[] =<<<HTML
<option value="{$link}">{$prefix}{$page_menu_item->title}</option>
HTML;
  }
    $selector[] = '</select>';
  }
  return implode( "\n", $selector );
}        


/* Add Mobile Nav Menu
*  @param array/string $args
*  Requires toggle js (themeforce-options.js)
*/
function tf_add_mobile_nav_menu ( $args = array() ){
?>
	<!-- mobile nav menu -->
	<div class="mobile-nav-container" style="display: none;">
		<a href="#" class="show-nav">Press here for Site Navigation</a>
		 
		 <?php $default_args = array(
	     	'theme_location'  => 'primary',
	     	'container'       => 'div',
	     	'container_class' => 'nav-mobile',
	     	'menu_class'      => '',
	     	'before'          => '<div class="nav-link-mobile">',
	     	'after'           => '</div>',
	     	'menu_id'         => '',
	     	'depth' 	  => 2,
	     	'fallback_cb'     => 'tf_nomenu');
	     
	     $menuargs = wp_parse_args ( $args, $default_args);
	     
	     wp_nav_menu($menuargs); ?>
	</div>
	
<?php
}



/**
 * Add a submenu class to parent menus
 *
 * @access public
 * @param array $classes
 * @param object $item
 * @return null
 */
function tf_submenu_class( $classes, $item ) {
	
	global $wpdb;
	
	if ( $wpdb->get_var( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_menu_item_menu_item_parent' AND meta_value = '$item->ID'" ) )
	        $classes[] = 'menu_parent';

    return $classes;
}

add_filter( 'nav_menu_css_class', 'tf_submenu_class', 10, 2);