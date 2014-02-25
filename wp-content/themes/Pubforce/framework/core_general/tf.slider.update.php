<?php

// Update Slides
// TODO Could use a yellow notice prompt similar to Upgrade Settings used for older
// TF themes (though for hosted it would make more sense to 'convert' automatically,
// otherwise their sliders would be down)

// PUBFORCE

if ( get_option( 'pubforce_slider_1' ) != '' ) {

    $c = 1;
    
    // - loop -
    while($c <= 5):
    
    $raw_image = get_option('pubforce_slider_' . $c);
    $url = get_option('pubforce_slider_' . $c . 'url');
    $cap = get_option('pubforce_slider_' . $c . 'cap');
    
    // check if image exists
    if ( $raw_image != '' )
        {
        // show goodies
        $post_title = 'Legacy Slide ' . $c;
        $slidertype = 'image';
        $imageurl = $raw_image;
        $new_post = array(
              'ID' => '',
              'post_type' => 'tf_slider',
              'post_author' => '1', 
              'post_content' => '',
              'post_title' => $post_title,
              'post_status' => 'publish',
            );
    
        // Create New Slide
        $post_id = wp_insert_post( $new_post );
    
        // Update Meta Data
        $order_id = intval( $post_id )*100;
        update_post_meta( $post_id, '_tfslider_type', $slidertype);
        update_post_meta( $post_id, '_tfslider_order', $order_id);
        update_post_meta( $post_id, 'tfslider_image', $imageurl);
        }
    $c++;
    endwhile;
    update_option( 'tf_sliderconversion', 'true' );
}
            
// CHOWFORCE
$chowforce = get_option( 'chowforce_s1_img' );        
if ( $chowforce ) {

    $c = 1;
    
    // - loop -
    while($c <= 5):
    
    	$raw_image = get_option('chowforce_s' . $c .'_img');
    	$stype = get_option('chowforce_s' . $c .'_type');
    	if ($stype == 'textimage') {$slidertype = 'content';} else {$slidertype = 'image';}
    	$sheader = '';
    	$sdesc = '';
    	$button = '';
    	$header = 'Legacy Slide' . $c;
    	
    	// check type and load approriate options
    	if ( $slidertype == 'content') {
    	    $sheader = stripslashes(get_option('chowforce_s' . $c .'_h'));
    	    if ($sheader > '') { $header = $sheader; }
    	    $sdesc = stripslashes(get_option('chowforce_s' . $c .'_p'));
    	    $button = stripslashes(get_option('chowforce_s' . $c .'_at'));
    	}
    	    
    	$link = get_option('chowforce_s' . $c .'_a');    
    	    
    	// check if image exists
    	if ( $raw_image != '' )
    	    {
    	    // show goodies
    	    $post_title = $header;
    	    $imageurl = $raw_image;
    	    $new_post = array(
    	          'ID' => '',
    	          'post_type' => 'tf_slider',
    	          'post_author' => '1', 
    	          'post_content' => $sdesc,
    	          'post_title' => $post_title,
    	          'post_status' => 'publish',
    	        );
    	
    	    // Create New Slide
    	    $post_id = wp_insert_post( $new_post );
    		
    	    // Update Meta Data
    	    $order_id = intval( $post_id )*100;
    	    update_post_meta( $post_id, '_tfslider_type', $slidertype);
    	    update_post_meta( $post_id, '_tfslider_order', $order_id);
    	    update_post_meta( $post_id, 'tfslider_image', $imageurl);
    	    if ( $link ) {update_post_meta( $post_id, 'tfslider_link', $link);}
    	    }
    	$c++;
    endwhile;
    update_option( 'tf_sliderconversion', 'true' );
}                

// FINEFORCE

if ( get_option( 'fineforce_slider_1' ) != '') {

    $c = 1;
    
    // - loop -
    while($c <= 5):
    	
    	$raw_image = get_option('fineforce_slider_' . $c);
    	$url = get_option('fineforce_slider_' . $c . 'url');
    	$cap = get_option('fineforce_slider_' . $c . 'cap');
    	
    	// check if image exists
    	if ( $raw_image != '' )
    	    {
    	    // show goodies
    	    $post_title = 'Legacy Slide ' . $c;
    	    $slidertype = 'image';
    	    $imageurl = $raw_image;
    	    $new_post = array(
    	          'ID' => '',
    	          'post_type' => 'tf_slider',
    	          'post_author' => '1', 
    	          'post_content' => '',
    	          'post_title' => $post_title,
    	          'post_status' => 'publish',
    	        );
    	
    	    // Create New Slide
    	    $post_id = wp_insert_post( $new_post );
    	
    	    // Update Meta Data
    	    $order_id = intval( $post_id )*100;
    	    update_post_meta( $post_id, '_tfslider_type', $slidertype);
    	    update_post_meta( $post_id, '_tfslider_order', $order_id);
    	    update_post_meta( $post_id, 'tfslider_image', $imageurl);
    	    }
    	$c++;
    endwhile;
	update_option( 'tf_sliderconversion', 'true' );
}