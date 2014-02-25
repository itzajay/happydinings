<?php
	add_image_size('logo_img', 250, 200, false);
	global $current_user;
	get_currentuserinfo();
	$user_id = $current_user->ID;
	if($user_id){
		if(!get_option('tf_business_name')){
			update_option('tf_business_name',get_user_meta($user_id,'tf_business_name',true));
		}
		//if(!get_option('tf_address_country')){
		//	update_option('tf_address_country',get_user_meta($user_id,'tf_address_country',true));
		//}
	}
	
	
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
	function tf_foodmenu_get_menus($cat_id = null) {

		$menus = get_terms('tf_menutype', array('hide_empty' => 0));

		$args = array(
			'post_type' => 'tf_categorybox',
		);

		$food_menu = array();

		foreach ( $menus as $menu ) {
			$categoryBoxesArgs = array(
		        'post_type' => 'tf_categorybox',
		        'meta_key' => 'display_order',
		        'orderby' => 'meta_value',
		        'order' => 'ASC',
		        'tax_query' => array(
		            array(
		                'taxonomy' => 'tf_menutype',
		                'terms' => $menu->term_id,
		            )
		        )
		    );

		    $categoryBoxes = get_posts( $categoryBoxesArgs );
		    $food_menu[$menu->term_id] = array(
		    	'menu-name' => $menu->name,
		    );

		    foreach ( $categoryBoxes as $categoryBox ) {
		    	$category_id = get_post_custom_values('food_category_id', $categoryBox->ID);
		    	if ( (!empty($cat_id) && $cat_id == $category_id[0]) || empty($cat_id) )
		    		$food_menu[$menu->term_id]['categories'][$categoryBox->ID] = $category_id[0];
		    }
		}

		return $food_menu;
	}
	
	define('FontsImagePath',get_bloginfo('template_directory').'/images/fonts/');
	define('ImagePath',get_bloginfo('template_directory').'/images/thumbs/');
	define('PresetsImagePath',get_bloginfo('template_directory').'/images/presets/');
	
	function register_menu_custom() {
		register_nav_menus( array(
			'primary' => __('Primary Navigation', 'baseforce' ),
		));
		if (!get_option('set_default_manus')) {
			$menu_id = wp_create_nav_menu('primary_menu_1');
			$menu_items = array(
				1 => 'Welcome',
				2 => 'Menu',
				3 => 'Location',
				4 => 'About Us'
			);
			foreach($menu_items as $key => $menu_item){
				$myPage = get_page_by_title($menu_item);
				$itemData =  array(
					'menu-item-object-id' => $myPage->ID,
					'menu-item-parent-id' => 0,
					'menu-item-position'  => $key,
					'menu-item-object' => 'page',
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish'
				);
				wp_update_nav_menu_item( $menu_id, 0, $itemData );
			}
			$locations = get_theme_mod('nav_menu_locations');
			$locations['primary'] = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
		update_option('set_default_manus',1);
	}
	add_action( 'init', 'register_menu_custom' );
	
	add_theme_support('post-thumbnails');
	
	add_action('admin_menu', 'register_custom_menu_page');
	function register_custom_menu_page(){
		//add_theme_page( 'Custom Background', 'Background', 'administrator', 'theme_background_color', 'custom_theme_background_color');
		add_theme_page( 'Custom CSS', 'Custom CSS', 'plately_author', 'theme_custom_css', 'custom_theme_css');
		//add_theme_page( 'Slides', 'Slides', 'administrator', 'slider_slides', 'show_slides');
	}
	
	function custom_theme_css(){
		if($_POST['baseforce-custom-css']){ save_custom_css(); }
		include('custom_css.php');
	}
	
	function save_custom_css(){
		update_option('baseforce_custom_css',$_POST['custom_css']);
	}
	
	register_sidebar(array(
		'name' => __('Footer(Left)'),
		'id' => 'footer-left-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'before_title' => '<div class="title widget-title-wrap"><h3 class="widget-title">',
		'after_title' => '</h3></div>',				
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
	
	register_sidebar(array(
		'name' => __('Footer(Middle)'),
		'id' => 'footer-middle-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'before_title' => '<div class="title widget-title-wrap"><h3 class="widget-title">',
		'after_title' => '</h3></div>',				
		'after_widget' => '</aside>'					
	));
	
	register_sidebar(array(
		'name' => __('Footer(Right)'),
		'id' => 'footer-right-sidebar',
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
		//wp_enqueue_script('jquery-flexslider-script',get_template_directory_uri() . '/js/jquery.flexslider-min.js');
		wp_enqueue_script('jquery-fancybox-script',get_template_directory_uri() . '/js/jquery.fancybox.js');
		wp_enqueue_script('browser-plus','http://bp.yahooapis.com/2.4.21/browserplus-min.js');
		if(is_user_logged_in()){
			//wp_enqueue_script('plupload',get_template_directory_uri() . '/js/plupload.js');
			//wp_enqueue_script('plupload-flash',get_template_directory_uri() . '/js/plupload.flash.js');
			//wp_enqueue_script('plupload-html5',get_template_directory_uri() . '/js/plupload.html5.js');
			//wp_enqueue_script('plupload-html4',get_template_directory_uri() . '/js/plupload.html4.js');
			//wp_enqueue_script('plupload-queue',get_template_directory_uri() . '/js/jquery.plupload.queue.js');
			global $fonts_settings;
			$fonts_settings = array(
				array(
					"name" => "Primary",
					"id" => "primary",
					"default_value" => "",
					"option_name" => "baseforce_font_primary",
					"font_options" => array(
						"default" => array(
							"sample" => FontsImagePath."default.jpg",
							"class_name" => ""
						),
						"oldstandard" => array(
							"sample" => FontsImagePath."oldstandard.jpg",
							"class_name" => "base-font-oldstandard"
						),
						"comfortaa" =>  array(
							"sample" => FontsImagePath."comfortaa.jpg",
							"class_name" => "base-font-comfortaa"
						),
						"yanone" => array(
							"sample" => FontsImagePath."yanone.jpg",
							"class_name" => "base-font-yanone"
						),
						"oswald" => array(
							"sample" => FontsImagePath."oswald.jpg",
							"class_name" => "base-font-oswald"
						),
						"opensans" => array(
							"sample" => FontsImagePath."opensans.jpg",
							"class_name" => "base-font-opensans"
						),
						"rokkitt" => array(
							"sample" => FontsImagePath."rokkit.jpg",
							"class_name" => "base-font-rokkitt"
						),
						"pacifico" => array(
							"sample" => FontsImagePath."signika.jpg",
							"class_name" => "base-font-signika"
						)
					)
				)
			);
			
			global $backgroundImageOptions;
			$backgroundImageOptions = array(
				0 => array(
					"thumbnail" => ImagePath."none.jpg",
					"image" => ImagePath."themeforce-hostednone.png"
				),
				1 => array(
					"thumbnail" => ImagePath."tcheckerbw1.jpg",
					"image" => ImagePath."checkerbw1.png"
				),
				2 => array(
					"thumbnail" => ImagePath."tstripe2.jpg",
					"image" => ImagePath."stripe2.png"
				),
				3 => array(
					"thumbnail" => ImagePath."tstripe3.jpg",
					"image" => ImagePath."stripe3.png"
				),
				4 => array(
					"thumbnail" => ImagePath."tpaper1.jpg",
					"image" => ImagePath."paper1.png"
				),
				5 => array(
					"thumbnail" => ImagePath."tpubforce1.jpg",
					"image" => ImagePath."pubforce1.png"
				),
				6 => array(
					"thumbnail" => ImagePath."tbrick1.jpg",
					"image" => ImagePath."tbrick1-full.jpg"
				),
				7 => array(
					"thumbnail" => ImagePath."tbrickbw1.jpg",
					"image" => ImagePath."tbrick1-full.png"
				),
				8 => array(
					"thumbnail" => ImagePath."tdarkwood1.jpg",
					"image" => ImagePath+"tdarkwood1-full.jpg"
				),
				9 => array(
					"thumbnail" => ImagePath."tdarkwoodbw1.jpg",
					"image" => ImagePath."tdarkwood1-full.png"
				),
				10 => array(
					"thumbnail" => ImagePath."tmarble1.jpg",
					"image" => ImagePath."tmarble1-full.jpg"
				),
				11 => array(
					"thumbnail" => ImagePath."tmarble1.jpg",
					"image" => ImagePath+"tmarble1-full.png"
				)
			);
			global $themePresets;
			$themePresets = array(
				array(
					"name" => "Empty",
					"image" => PresetsImagePath."c-default.jpg",
					"color" => "#000",
					"colors" => array(
						"Background" => "#4d4d4d",
						"Content Background" => "#ffffff",
						"Regular Text" => "#5c5c5c",
						"Active" => "#0C87D7"
					),
					"fonts" => array(
						"primary" => "default"
					),
					"background" => ""
				),
				array(
					"name" => "Elegant",
					"image" => PresetsImagePath."c-minimal.jpg",
					"color" => "#fff",
					"colors" => array(
						"Background" => "#2e2522",
						"Content Background" => "#fff",
						"Regular Text" => "#1f1c1b",
						"Active" => "#1f1c1b"
					),
					"fonts" => array(
						"primary" => "oldstandard"
					),
					"background" => ImagePath."finedining.png",
					"base-radius-off" => true
				),
				array(
					"name" => "Last Call",
					"image" => PresetsImagePath."c-dark.jpg",
					"color" => "#fff",
					"colors" => array(
						"Background" => "#242424",
						"Content Background" => "#242424",
						"Regular Text" => "#9c9c9c",
						"Active" => "#00a6ff"
					),
					"fonts" => array(
						"primary" => "yanone"
					),
					"background" => ImagePath."stripe3.png",
					"base-radius-off" => false
				),
				array(
					"name" => "Barbeque",
					"image" => PresetsImagePath."c-bbq.jpg",
					"color" => "#e0dbc0",
					"colors" => array(
						"Background" => "#2b261a",
						"Content Background" => "#2b271d",
						"Regular Text" => "#e0dbc0",
						"Active" => "#f08400"
					),
					"fonts" => array(
						"primary" => "opensans"
					),
					"background" => ImagePath."tdarkwood1-full.png"
				),
				array(
					"name" => "Pizza",
					"image" => PresetsImagePath."c-pizza.jpg",
					"color" => "#ffffff",
					"colors" => array(
						"Background" => "#213d1c",
						"Content Background" => "#ffffff",
						"Regular Text" => "#382e22",
						"Active" => "#ed1d1d"
					),
					"fonts" => array(
						"primary" => "opensans"
					),
					"background" => ImagePath."stripe2.png"
				),
				array(
					"name" => "Italian",
					"image" => PresetsImagePath."c-italian.jpg",
					"color" => "#faf9e1",
					"colors" => array(
						"Background" => "#7a783f",
						"Content Background" => "#faf9e1",
						"Regular Text" => "#525033",
						"Active" => "#de4928"
					),
					"fonts" => array(
						"primary" => "oldstandard"
					),
					"background" => ImagePath."paper.jpg"
				),
				6 => array(
					"name" => "Asian",
					"image" => PresetsImagePath."c-asian.jpg",
					"color" => "#e0b98d",
					"colors" => array(
						"Background" => "#ab370d",
						"Content Background" => "#5e2614",
						"Regular Text" => "#e0b98d",
						"Active" => "#de4928"
					),
					"fonts" => array(
						"primary" => "comfortaa"
					),
					"background" => ""
				),
				7 => array(
					"name" => "Organic",
					"image" => PresetsImagePath."c-organic.jpg",
					"color" => "#45591c",
					"colors" => array(
						"Background" => "#abd062",
						"Content Background" => "#ffffff",
						"Regular Text" => "#52412e",
						"Active" => "#517a00"
					),
					"fonts" => array(
						"primary" => "comfortaa"
					),
					"background" => ImagePath."tdarkwood1-full.png"
				),
				8 => array(
					"name" => "Seafood",
					"image" => PresetsImagePath."c-seafood.jpg",
					"color" => "#99d6ff",
					"colors" => array(
						"Background" => "#122029",
						"Content Background" => "#1c2f3b",
						"Regular Text" => "#99d6ff",
						"Active" => "#ff5619"
					),
					"fonts" => array(
						"primary" => "yanone"
					),
					"background" => ImagePath.""
				),
				9 => array(
					"name" => "Deli",
					"image" => PresetsImagePath."c-deli.jpg",
					"color" => "#404040",
					"colors" => array(
						"Background" => "#ff9999",
						"Content Background" => "#ffffff",
						"Regular Text" => "#404040",
						"Active" => "#fc3737"
					),
					"fonts" => array(
						"primary" => "comfortaa"
					),
					"background" => ImagePath."checker.png"
				)
			);
			global $colors;
			$colors = array(
				0 => array(
					"name" => "Background",
					"default_value" => "#ff9999",
					"css" => array(
						"color" => "ul#slider .content-text, #information",
						"background-color" => "body, li.content-slide"
					),
					"option_name" => "baseforce_color_pri_dark",
					"value" => get_option('background-color')? get_option('background-color') : "#ff9999"
				),
				1 => array(
					"name" => "Content Background",
					"default_value" => "#ffffff",
					"css" => array(
						"color" => ".mobile-nav-container, #wrap .nav-mobile .nav-link-mobile a, .fc th, .fc-state-active .fc-button-inner, li.slide-type-content a.slide-button, #wrap .mobile-nav-container .show-nav, #wrap .mobile-nav-container .show-nav a span",
						"background-color" => "#wrap,h1.post-title,h1.entry-title,h3.widget-title,.slider-button,.full-menu .title .left,.full-menu .title .right,.mid-menu .left,.mid-menu .rightbox .size,.mid-menu .rightbox .price,.small-menu .lefttext,.small-menu .rightbox .size,.small-menu .rightbox .price,.nav-primary li:hover > ul, .current-image"
					),
					"option_name" => "baseforce_color_pri_contentbg",
					"value" => get_option('content-background-color')? get_option('content-background-color') : "#ffffff"
				),
				2 => array(
					"name" => "Regular Text",
					"default_value" => "#404040",
					"css" => array(
						"color" => "#information,.phone,#wrap,.nav-mobile a",
						"background-color" => "ul#slider .content-text",
						"border-color" => ".full-events .thumb img"
					),
					"option_name" => "baseforce_color_pri_content",
					"value" => get_option('regular-text-color')? get_option('regular-text-color') : "#404040"
				),
				3 => array(
					"name" => "Active",
					"default_value" => "#fc3737",
					"css" => array(
						"color" => "#wrap a, h2.menu-title,#navigation a, #navigation .dropdown, h3.widget-title, h1.post-title, h1.entry-title a, h1.entry-title, .meta-info",
						"background-color" => ".fc th, .fc-state-default .fc-button-inner, .fc-button-prev, .fc-button-next, .show-nav, li.slide-type-content a.slide-button",
						'btn-background-color' => '.cta-default'
					),
					"option_name" => "baseforce_color_pri_link",
					"value" => get_option('active-text-color') ? get_option('active-text-color') : "#fc3737"
				)
			);
			wp_enqueue_script('jquery-designpanel-script',get_template_directory_uri() . '/js/jquery.designpanel.js'); ?>
			<script type="text/javascript">
				var TFThemeConfigurationUpdateURL = '<?php echo get_bloginfo( 'home' ); ?>'+'/wp-admin/admin-ajax.php';
			</script>
<?php	}
	}    
	 
	//add_action('wp_enqueue_scripts', 'my_scripts_method');
	
	
	function load_custom_wp_admin_style(){
		wp_register_style('admin-area-style', get_bloginfo('template_directory') . '/css/admin-area.css', false, '1.0.0' );
        wp_enqueue_style('admin-area-style');
	}
	add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');
	
	function tf_save_theme_configuration(){
		update_option('background-color',$_POST['colors'][0]);
		update_option('content-background-color',$_POST['colors'][1]);
		update_option('regular-text-color',$_POST['colors'][2]);
		update_option('active-text-color',$_POST['colors'][3]);
		update_option('content-font',$_POST['fonts']['primary']);
		if(isset($_POST['background-image'])){
			delete_option('theme_background_url');
			$image_url = array($_POST['background-image']);
			update_option('theme_background_url',$image_url);
		}
	}
	add_action('wp_ajax_tf_save_theme_configuration', 'tf_save_theme_configuration');
	add_filter('show_admin_bar', '__return_false');
?>