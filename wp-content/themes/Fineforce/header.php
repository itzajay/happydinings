<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
     
    <title><?php echo get_option('tf_business_name').' - '.get_option('tf_address_locality'); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="shortcut icon" href="<?php echo wp_get_attachment_url(get_option('tf_favicon')); ?>" />
    <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/css/960.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/css/common.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_bloginfo('template_directory'); ?>/style.css" />
    <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/mobile.css" title="default" media="screen" />   
    
    <!-- IE Fixes --> 
    <!--[if IE 7]>
		<style>
			body {padding-top:58px !important;}			
			#yelpcontent, #qypecontent {zoom: 1;*display: inline}
		</style>
	<![endif]--> 
    
    <!--[if lt IE 9]>
    <script src="<?php echo get_bloginfo('template_directory'); ?>/js/html5.js" type="text/javascript"></script>
    <![endif]-->

    <link rel='stylesheet' id='colorpicker_css-css'  href='<?php echo get_bloginfo("template_directory"); ?>/css/colorpicker.css' type='text/css' media='all' />
    <link rel='stylesheet' id='designpanel-css'  href='<?php echo get_bloginfo("template_directory"); ?>/css/designpanel.css' type='text/css' media='all' />
    <link rel='stylesheet' id='themecolors-css'  href='<?php echo get_bloginfo("template_directory"); ?>/css/Fineforce-theme-css.css' type='text/css' media='all' />
    <link rel='stylesheet' id='fancybox-css'  href='<?php echo get_bloginfo("template_directory"); ?>/css/jquery.fancybox.css' type='text/css' media='all' />
	
	<?php wp_head(); ?>
	
	<style type="text/css">
		.entry-meta, .fine a, .fine a, h3.widget-title, .nav-primary a:hover, .nav-primary li:hover ul li a:hover, .menu-title, h2.full-menu, .fs-tips-item strong, h3.widget-title, .fineforce-title, .required, h2.full-menu{color:<?php echo get_option('active-text-color'); ?>}
		.full-events .thumb img,.full-menu .thumb img { border-color: <?php echo get_option('active-text-color'); ?> }
		html #wrap,.comment-meta a time { color : <?php echo get_option('content-text-color'); ?> }
		.nav-primary li:hover > ul li a { color : <?php echo get_option('background-color'); ?>}
		#footer-wrap,#navigation-wrap,#comments .reply,.header-wrap { background-color : <?php echo get_option('background-color'); ?> }
		.header-wrap, #main-wrap { border-color : <?php echo get_option('background-color'); ?> }
		.nav-primary a,.menu a,.sec-footer-outer #wrap a, #wrap h1, #wrap h2, #wrap h3, #wrap h4, #wrap h5, #wrap h6,.entry-content blockquote,textarea, input[type=text],.full-events .title .eventtext,.events-widget .eventitem,.feat-events .eventtitle,.extrasizes strong,.rightbox,.events-single-meta span,.events-single-meta time,.full-menu .title,.mid-menu .title,.mid-menu .rightbox,.small-menu .title,.fs-tips-quote,.openingtimes,.openitem{ color:<?php echo get_option('heading-text-color'); ?>; }
		.nav-primary li:hover > ul { background-color : <?php echo get_option('heading-text-color'); ?>; }
		.feat-events .thumb { border-color : <?php echo get_option('heading-text-color'); ?>; }
		.full-menu .thumb img { outline-color : <?php echo get_option('heading-text-color'); ?>; }
		input#searchsubmit,input#submit { color : <?php echo get_option('textbox-background-color'); ?>; }
		#comments li li.comment,#comments li,textarea, input[type=text] { background-color : <?php echo get_option('textbox-background-color'); ?>; }
	</style>
	<!-- Full Background -->
	<?php
		if(get_option('theme_background_url')){
			$image = wp_get_attachment_image_src(get_option('theme_background_attachment_id'),'large');
	?>
		<style type="text/css">
			body.custom-background {
				background-repeat: <?php echo (get_option('background-repeat')) ? get_option('background-repeat') : "repeat"; ?>;
				background-position: <?php echo get_option('background-position-x'); ?> top;
				background-attachment: <?php echo get_option('background-attachment'); ?>;
			}
		</style>
		<script type="text/javascript">
			jQuery.backstretch("<?php echo $image[0]; ?>");
		</script>
	<?php }else{ ?>
		<script type="text/javascript">
			jQuery.backstretch("<?php echo get_bloginfo('template_directory'); ?>/images/default-background.jpg")
		</script>
	<?php } ?>
	<script type="text/javascript">
		var tracking_id = '<?php echo get_option("tf_ua_analytics"); ?>';
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', tracking_id]);
		_gaq.push(['_trackPageview']);
	  
		(function() {
		  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();  
	</script>
	<!-- / Full Background -->
</head>
<!-- BODY -->
<body class="home custom-background">
    <div id="wrap" class="wrap">
    <!-- Navigation -->
        <div id="navigation-wrap">
            <div id="navigation">
				<?php
					wp_nav_menu(array(
						'container_class' => 'nav-primary',
						'theme_location' => 'primary',
						'sort_column' => 'ID'
					));
				?>
                <!-- address -->
                <div class="mobile-phone" style="display:none;">
                    <?php echo do_shortcode('[tf-phone]'); ?><br />
                    <?php echo do_shortcode('[tf-address]'); ?>
                </div>
                <!-- /address -->
                <!-- Social Media Links -->
                <div id="nav-social">
                    <a href="<?php echo get_option('tf_facebook'); ?>" class="social_icon">
                        <img src="<?php echo get_bloginfo('template_directory'); ?>/images/nav-facebook.png" alt="Facebook Link" />
                    </a>
                    <a href="<?php echo get_option('tf_twitter'); ?>" class="social_icon">
                        <img src="<?php echo get_bloginfo('template_directory'); ?>/images/nav-twitter.png" alt="Twitter Link" />
                    </a>
                </div>
                <!-- / Social Media Links -->
            </div>
            <div class="clearfix"></div>
		</div>
    <!-- / Navigation -->
    <!-- Featured -->
	<div class="header-wrap">
       <div id="logo-wrap">			
            <div style="float:left;">
				<?php if(is_user_logged_in()){ ?>
					<div style='width: 300px; height: 250px;' class='hm-uploader ' id='tf_logo_id-container'>
						<?php $image = wp_get_attachment_image_src(get_option('tf_logo_id')); ?>
						<?php if($image){ ?>
							<div style="width: 300px; height: 250px;display: none; line-height: 250px;" class="current-image">
								<img src="<?php echo $image[0]; ?>" class="current_logo_pic" />
								<div class="image-options">
									<a href="#" class="delete-image">Delete</a>
								</div>
							</div>
						<?php } ?>
						<div style="width:300px; height: 250px;" class="loading-block hidden">
							<img src="<?php echo get_bloginfo('template_directory'); ?>/images/spinner.gif" />
						</div>
						<div style='width:300px; height: 250px;' id='tf_logo_id-dragdrop' data-extensions='jpg,jpeg,png,gif' data-size='width=300&height=250&crop=0' class='rwmb-drag-drop upload-form'>
							<div class='rwmb-drag-drop-inside'>
								<p>Drop your logo here</p>
								<p>or</p>
								<p><input id='tf_logo_id-browse-button' type='button' value='Select Files' class='button' /></p>
							</div>
						</div>
					</div>
				<?php }else{ ?>
						<div class="logo_wrapper">
							<?php $image = wp_get_attachment_image_src(get_option('tf_logo_id')); ?>
							<?php if($image){ ?>
								<img src="<?php echo $image[0]; ?>" class="current_logo_pic" />
							<?php }else{ ?>
								<img src="<?php echo get_bloginfo('template_directory').'/images/logo/logo.png'; ?>"/>
							<?php } ?>
						</div>
				<?php } ?>
			</div>
	    </div>
		<?php do_shortcode('[tf-slider]'); ?>
    </div>
	<!-- Add main naviation menu for mobiles -->
    <!-- / Featured -->