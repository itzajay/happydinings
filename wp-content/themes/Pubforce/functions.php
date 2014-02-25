<?php

	define('Street','Times Square');
	define('Locality','New York City');
	define('State','NY');
	define('Country','USA');
	define('FacebookUrl','https://www.facebook.com/plately');
	define('TwitterUrl','https://twitter.com/plately');

	function tf_is_premium_active() {
		return true;
	}

	add_theme_support( 'tf_food_menu' );
	add_theme_support( 'tf_events' );
	add_theme_support( 'tf_widget_opening_times' );
	add_theme_support( 'tf_widget_google_maps' );
	add_theme_support( 'tf_widget_payments' );
	add_theme_support( 'tf_widget_twitter' );
	add_theme_support( 'tf_foursquare' );
	add_theme_support( 'tf_yelp' );
	add_theme_support( 'tf_mailchimp' );
	add_theme_support( 'tf_fullbackground' );
	add_theme_support( 'tf_settings_api' );

	include_once('framework/themeforce.php');

	/**
	 * returns the food menu items
	 *
	 * @return array() $food_menu an array containing the food menus
	 */
	function tf_foodmenu_get_menus($cat_id) {
		$args = array(
			'orderby' => 'title',
			'post_type' => 'tf_foodmenu',
		);
		$food_menu_posts = get_posts( $args );

		$food_menu = array();
		
		$args = array(
			'post_type' => 'tf_foodmenu',
			'meta_key' => 'display_order',
			'orderby' => 'meta_value',
			'order' => 'ASC',
			'tax_query' => array(
				array(
					'taxonomy' => 'tf_foodmenucat',
					'terms' => $cat_id
				)
			)
		);
		query_posts($args);
		$food_menu = array();
		while(have_posts()): the_post();
			$food_menu[get_the_ID()] = array(
				'menu-name' => get_the_title(),
				'categories' => array(
					0 => $cat_id
				)
			); 
		endwhile;
		return $food_menu;
	}
	
    function set_basic_options(){
		delete_option('theme_background_url');
		delete_option('theme_background_attachment_id');
		delete_option('background-position-x');
		delete_option('background-repeat');
		delete_option('background-attachment');
		delete_option('background-color');
		delete_option('content-background-color');
		delete_option('widget-heading-color');
		delete_option('navigation-text-color');
		delete_option('active-text-color');
	}
	add_action('switch_theme','set_basic_options');
	
    register_nav_menus(array(
		'primary' => __('Primary Navigation', 'fineforce' ),
	));
	
	register_nav_menus(array(
		'secondary' => __('Secondary Navigation', 'fineforce' ),
	));
    
    //hide the admin bar
    add_filter('show_admin_bar', '__return_false');
    
    register_sidebar(array(
		'name' => __('Footer(Left)'),
		'id' => 'footer-left-sidebar',
		'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s">',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',				
		'after_widget' => '</div>'						
	));
	
	register_sidebar(array(
		'name' => __('Footer(Middle)'),
		'id' => 'footer-middle-sidebar',
		'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s">',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',				
		'after_widget' => '</div>'					
	));
	
	register_sidebar(array(
		'name' => __('Footer(Right)'),
		'id' => 'footer-right-sidebar',
		'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s">',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',				
		'after_widget' => '</div>'
	));
	
	register_sidebar(array(
		'name' => __('Right Sidebar'),
		'id' => 'right-left-sidebar',
		'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s">',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',				
		'after_widget' => '</div>'						
	));
	
	register_sidebar(array(
		'name' => __('Happy Dinings Sidebar'),
		'id' => 'plately-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'before_title' => '<div class="title widget-title-wrap"><h3 class="widget-title">',
		'after_title' => '</h3></div>',				
		'after_widget' => '</aside>'						
	));
	
	function my_scripts_method() {
		//wp_enqueue_script('jquery','https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
		wp_enqueue_script('colorpicker-script',get_template_directory_uri() . '/js/colorpicker.js');
		wp_enqueue_script('jQuery UI Core');
		wp_enqueue_script('jquery-ui-widget',get_template_directory_uri() . '/js/jquery.ui.widget.min.js',array('jQuery UI Core'));
		wp_enqueue_script('jquery-ui-accordion',get_template_directory_uri() . '/js/jquery.ui.accordion.min.js',array('jquery-ui-widget','jQuery UI Core'));
		wp_enqueue_script('jquery-common-scripts',get_template_directory_uri() . '/js/common_js.js');
		//wp_enqueue_script('jquery-bxSlider-script',get_template_directory_uri() . '/js/jquery.bxSlider.min.js');
		//wp_enqueue_script('jquery-backstretch-script',get_template_directory_uri() . '/js/jquery.backstretch.min.js');
		//wp_enqueue_script('browser-plus','http://bp.yahooapis.com/2.4.21/browserplus-min.js');
		if(is_user_logged_in()){
			//wp_enqueue_script('plupload',get_template_directory_uri() . '/js/plupload.js');
			//wp_enqueue_script('plupload-flash',get_template_directory_uri() . '/js/plupload.flash.js');
			//wp_enqueue_script('plupload-html5',get_template_directory_uri() . '/js/plupload.html5.js');
			//wp_enqueue_script('plupload-html4',get_template_directory_uri() . '/js/plupload.html4.js');
			//wp_enqueue_script('plupload-queue',get_template_directory_uri() . '/js/jquery.plupload.queue.js');
            global $colors;
            $colors = array(
                0 => array(
                    "name" => "Background",
                    "default_value" => (get_option('background-color')) ? get_option('background-color') : "#394831",
                    "css" => array(
                        "color" => ".sec-footer-outer .sec-footer",
                        "background-color" => "body,.openitem,input.tf-newsletter-link,.sf-menu li li,.sf-menu ul"
                    ),
                    "option_name" => "pubforce_color_pri_reg",
                    "value" => (get_option('background-color')) ? get_option('background-color') : "#394831"
                ),
				1 => array(
                    "name" => "Regular",
                    "default_value" => (get_option('content-background-color')) ? get_option('content-background-color') : "#131410",
                    "css" => array(
                        "color" => "#main H1,#main H2,#main H3,#main .posttitle a,.full-events .title .time,a.feat-events .time,.events-single-meta span",
						"background-color" => "#container,#papercurl,#footer,.sec-footer-outer, .mobile-phone",
						"border-color" => "input.tf-newsletter-link"
                    ),
                    "option_name" => "pubforce_color_pri_dark",
                    "value" => (get_option('content-background-color')) ? get_option('content-background-color') :"#131410"
                ),
				2 => array(
                    "name" => "Widgets",
                    "default_value" => (get_option('widget-heading-color')) ? get_option('widget-heading-color') : "#ffd172",
                    "css" => array(
                        "color" => ".light-secondary,.openitem,#footer a,#sidebar-wrap a,#footer a,#sidebar-wrap a,#header-address,#sidebar-wrap h3,.events-widget .longdate,input.tf-newsletter-link,.footer-widget H3,.sec-footer-outer .sec-footer a,#sidebar-wrap .events-widget .eventitem a:hover",
                        "background-color" => ".fs-tips-thumb,#box-thumbnails a",
						"border-color" => "#main-sidebar .widget H3,.footer-widget H3,div#fancy_outer div#fancy_inner,input.tf-newsletter-link:hover"
                    ),
                    "option_name" => "pubforce_color_sec_reg",
                    "value" => (get_option('widget-heading-color')) ? get_option('widget-heading-color') : "#ffd172"
                ),
				3 => array(
                    "name" => "Links",
                    "default_value" => (get_option('active-text-color')) ? get_option('active-text-color') : "#456711",
                    "css" => array(
                        "color" => "#main a, .mobile-phone a",
                        "background-color" => ".thumb, input.tf-newsletter-link,.fc th, .fc-state-default .fc-button-inner, .fc-button-prev, .fc-button-next",
                        "border-color" => ".sf-menu ul li,.menu ul li"
                    ),
                    "option_name" => "pubforce_color_pri_light",
                    "value" => (get_option('active-text-color')) ? get_option('active-text-color') : "#456711"
                ),
				4 => array(
                    "name" => "Navigation",
                    "default_value" => (get_option('navigation-text-color')) ? get_option('navigation-text-color') : "#ffd172",
                    "css" => array(
                        "color" => ".sf-menu a,.menu a"
                    ),
                    "option_name" => "pubforce_color_nav",
                    "value" => (get_option('navigation-text-color')) ? get_option('navigation-text-color') : "#ffd172"
                )
				
            );
			wp_enqueue_script('jquery-designpanel-script',get_template_directory_uri() . '/js/jquery.designpanel.js');
            ?>
			<script type="text/javascript">
				var TFThemeConfigurationUpdateURL = '<?php echo network_site_url( '/' ); ?>'+'wp-admin/admin-ajax.php';
			</script>
<?php	}
	}
	add_action('wp_enqueue_scripts', 'my_scripts_method');
	
	function tf_save_theme_configuration(){
		print_r($_POST);
        update_option('background-color',$_POST['colors'][0]);
        update_option('content-background-color',$_POST['colors'][1]);
		update_option('widget-heading-color',$_POST['colors'][2]);
        update_option('active-text-color',$_POST['colors'][3]);
        update_option('navigation-text-color',$_POST['colors'][4]);
    }
    add_action('wp_ajax_tf_save_theme_configuration', 'tf_save_theme_configuration');
?>