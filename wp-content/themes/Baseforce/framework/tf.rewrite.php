<?php

/*
 * Custom rewrite for Event Post Type
 */

function tf_setup_rewrite_rules() {

	// hm_add_rewrite_rule( 'events/([^/]+)/([^/]+)(/page/([0-9]+))?/?$', 'post_type=tf_events&name=$matches[2]&page=$matches[4]' );
}

add_action( 'init', 'tf_setup_rewrite_rules' );