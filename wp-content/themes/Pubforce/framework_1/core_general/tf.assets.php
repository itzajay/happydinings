<?php

/*
* -------------------------------------
* Common Library of TF Assets
* -------------------------------------
*/

function tf_common_css() {
    wp_enqueue_style('tfcommoncss', TF_URL . '/assets/css/common.css', array(), TF_VERSION );
}

/* 
* -------------------------------------
* Common Library of 3rd Party Assets
* -------------------------------------
*/

/* 
 Nivo Slider
 --------------------------------------
 v 2.7.1

 http://nivo.dev7studios.com

 */

function tf_nivoslider_js() {
	wp_enqueue_script('nivoslider', TF_URL . '/assets/js/jquery.nivo.slider.2.7.1.js', array( 'jquery'), TF_VERSION  );
}
	
function tf_nivoslider_css() {
	wp_enqueue_style('nivoslidercss', TF_URL . '/assets/css/nivo-slider.css', array(), TF_VERSION );
}
	
/* 
 FancyBox
 --------------------------------------
 v 1.3.4

 http://fancybox.net/
 
 License

 http://jquery.org/license/
 */

function tf_fancybox_js() {
    wp_enqueue_script('fancybox', TF_URL . '/assets/js/jquery.fancybox-1.3.4.pack.js', array( 'jquery'), TF_VERSION );
    
    // adds pop-up to .thumb classes
    wp_enqueue_script('fancybox-settings', TF_URL . '/assets/js/jquery.fancybox-settings.js', array( 'jquery'), TF_VERSION );
}
	
function tf_fancybox_css() {
	wp_enqueue_style('fancybox', TF_URL . '/assets/css/jquery.fancybox-1.3.4.css', array(), TF_VERSION );
}	

/* 
 bxSlider
 --------------------------------------
 v 3.0

 http://bxslider.com/
 
 License

 http://www.opensource.org/licenses/mit-license.php
 */	
 
function tf_bxslider_js() {
	wp_enqueue_script('bxslider', TF_URL . '/assets/js/jquery.bxSlider.min.js', array( 'jquery'), TF_VERSION );
}

/* 
FullCalendar
 --------------------------------------
 v 3.0

 */

function tf_fullcalendar_js() {
	wp_enqueue_script('fullcalendar', TF_URL . '/assets/js/fullcalendar.js', array( 'jquery'), TF_VERSION );
}

/*
FlexSlider
 --------------------------------------
 v 1.8

 */

function tf_flexslider_js() {
    wp_enqueue_script('flexslider', TF_URL . '/assets/js/jquery.flexslider-min.js', array( 'jquery'), TF_VERSION );
}

function tf_flexslider_css() {
    wp_enqueue_style('flexslider', TF_URL . '/assets/css/flexslider.css', array(), TF_VERSION );
}

?>