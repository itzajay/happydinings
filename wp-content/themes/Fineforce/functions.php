<?php
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
	
    register_nav_menus( array(
		'primary' => __('Primary Navigation', 'fineforce' ),
	));
	
	//register_nav_menus( array(
	//	'secondary' => __('Secondary Navigation', 'fineforce' ),
	//));
    
    //hide the admin bar
    add_filter('show_admin_bar', '__return_false');
    
    register_sidebar(array(
		'name' => __('Footer(Left)'),
		'id' => 'footer-left-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',				
		'after_widget' => '</aside>'						
	));
	
	register_sidebar(array(
		'name' => __('Footer(Middle)'),
		'id' => 'footer-middle-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',				
		'after_widget' => '</aside>'					
	));
	
	register_sidebar(array(
		'name' => __('Footer(Right)'),
		'id' => 'footer-right-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',				
		'after_widget' => '</aside>'
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
		wp_enqueue_script('jquery-backstretch-script',get_template_directory_uri() . '/js/jquery.backstretch.min.js');
		wp_enqueue_script('jquery-fancybox-script',get_template_directory_uri() . '/js/jquery.fancybox.js');
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
                    "name" => "Active",
                    "default_value" => (get_option('active-text-color')) ? get_option('active-text-color') :"#f14a00",
                    "css" => array(
                        "color" => ".entry-meta, .fine a, .fine a,.nav-primary a:hover, .nav-primary li:hover ul li a:hover, .menu-title, h2.full-menu, .fs-tips-item strong,.fineforce-title, .required, h2.full-menu",
                        "border-color" => ".full-events .thumb img,.full-menu .thumb img"
                    ),
                    "option_name" => "fineforce_color_h_reg",
                    "value" => (get_option('active-text-color')) ? get_option('active-text-color') :"#f14a00"
                ),
                1 => array(
                    "name" => "Neutral Light",
                    "default_value" => (get_option('content-text-color')) ? get_option('content-text-color') : "#858585",
                    "css" => array(
                        "color" => "html #wrap,.comment-meta a time"
                    ),
                    "option_name" => "fineforce_color_f_first",
                    "value" => (get_option('content-text-color')) ? get_option('content-text-color') : "#858585"
                ),
                2 => array(
                    "name" => "Neutral Mid",
                    "default_value" => (get_option('textbox-background-color')) ? get_option('textbox-background-color') : "#3d3d3d",
                    "css" => array(
                        "color" => "input#searchsubmit,input#submit",
                        "background-color" => "#comments li li.comment,#comments li,textarea, input[type=text]"
                    ),
                    "option_name" => "fineforce_color_f_second",
                    "value" => (get_option('textbox-background-color')) ? get_option('textbox-background-color') : "#3d3d3d"
                ),
                3 => array(
                    "name" => "Neutral Dark",
                    "default_value" => (get_option('background-color')) ? get_option('background-color') : "#000000",
                    "css" => array(
                        "color" => ".nav-primary li:hover > ul li a",
                        "background-color" => "#footer-wrap,#navigation-wrap,#comments .reply,.header-wrap",
                        "border-color" => ".header-wrap, #main-wrap"
                    ),
                    "option_name" => "fineforce_color_f_third",
                    "value" => (get_option('background-color')) ? get_option('background-color') : "#000000"
                ),
                4 => array(
                    "name" => "Content",
                    "default_value" => (get_option('heading-text-color')) ? get_option('heading-text-color') : "#ffffff",
                    "css" => array(
                        "color" => ".nav-primary a,.sec-footer-outer #wrap a, #wrap h1, #wrap h2, #wrap h3, #wrap h4, #wrap h5, #wrap h6,.entry-content blockquote,textarea, input[type=text],.full-events .title .eventtext,.events-widget .eventitem,.feat-events .eventtitle,.extrasizes strong,.rightbox,.events-single-meta span,.events-single-meta time,.full-menu .title,.mid-menu .title,.mid-menu .rightbox,.small-menu .title,.fs-tips-quote, .openingtimes",
                        "background-color" => ".nav-primary li:hover > ul",
                        "border-color" => ".feat-events .thumb",
                        "outline-color" => ".full-menu .thumb img"
                    ),
                    "option_name" => "fineforce_color_content",
                    "value" => (get_option('heading-text-color')) ? get_option('heading-text-color') : "#ffffff"
                )
            );
			wp_enqueue_script('jquery-designpanel-script',get_template_directory_uri() . '/js/jquery.designpanel.js');
            ?>
            
			<script type="text/javascript">
				var TFThemeConfigurationUpdateURL = '<?php echo network_site_url( '/' ); ?>'+'wp-admin/admin-ajax.php';
			</script>
<?php	}
	}
    
	//function my_enqueue() {
		//wp_enqueue_script('farbtastic_ui','https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js');
		//wp_enqueue_script('farbtastic_script', get_bloginfo('template_directory').'/js/farbtastic.js');
		//wp_enqueue_script('farbtastic_admin_script', get_bloginfo('template_directory').'/js/admin_script.js');
	//}
	//add_action('admin_enqueue_scripts','my_enqueue');
	
	function load_custom_wp_admin_style(){
//		wp_register_style('custom_wp_admin_css', get_bloginfo('template_directory') . '/css/farbtastic.css', false, '1.0.0' );
//        wp_enqueue_style('custom_wp_admin_css');
		wp_register_style('admin-area-style', get_bloginfo('template_directory') . '/css/admin-area.css', false, '1.0.0' );
        wp_enqueue_style('admin-area-style');
	}
	add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');
	
    add_action('wp_enqueue_scripts', 'my_scripts_method');
    
    function tf_save_theme_configuration(){
        update_option('active-text-color',$_POST['colors'][0]);
        update_option('content-text-color',$_POST['colors'][1]);
		update_option('textbox-background-color',$_POST['colors'][2]);
        update_option('background-color',$_POST['colors'][3]);
        update_option('heading-text-color',$_POST['colors'][4]);
    }
    add_action('wp_ajax_tf_save_theme_configuration', 'tf_save_theme_configuration');
?>