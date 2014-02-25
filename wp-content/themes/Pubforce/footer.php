</div>
<!-- footer -->
<div id="footer">
    <div class="footer-widget-wrap">
        <?php dynamic_sidebar('footer-left-sidebar'); ?>
    </div>
    <div class="footer-widget-wrap">
        <?php dynamic_sidebar('footer-middle-sidebar'); ?>
    </div>  
    <!-- widget right -->
    <div class="footer-widget-wrap footer-right" id="sidebar-footer">
        <?php dynamic_sidebar('footer-right-sidebar'); ?>
    </div>
    <div class="clearfix"></div>
</div>
<!-- /footer -->
</div>
<!-- /main -->
<!-- terminal footer -->
<div class="sec-footer-outer">
    <div class="sec-footer">
        <?php
			if(has_nav_menu('secondary')){
				wp_nav_menu(array('container_class'=>'footer-nav-ul','theme_location'=>'secondary'));
			}
		?>
        <div class="copyright"><?php echo get_option('tf_terminalnotice'); ?></div>
        <div class="poweredby">
            <a class="poweredby" href="<?php echo NOBLOGREDIRECT; ?>" target="_blank">
                <img src="<?php echo get_bloginfo('template_directory'); ?>/images/logo-light.png" alt="Restaurant website by happy dinings" />
            </a>
        </div>
    </div>
</div>
<!-- / terminal footer -->
</div>
    <?php if(is_user_logged_in()){ ?>
        <?php global $colors; ?>
        <script type="text/javascript">
            var colors = jQuery.parseJSON('<?php echo json_encode($colors); ?>');
			//console.log(colors1);
			//var colors = [{"name":"Background","default_value":"#394831","css":{"color":".sec-footer-outer .sec-footer","border-color":"body,.openitem,input.tf-newsletter-link,.sf-menu li li,.sf-menu ul"},"option_name":"pubforce_color_pri_reg","value":"#394831"},{"name":"Regular","default_value":"#131410","css":{"color":"#main H1,#main H2,#main H3,#main .posttitle a,.full-events .title .time,a.feat-events .time,.events-single-meta span","background-color":"#container,#papercurl,#footer,.sec-footer-outer, .mobile-phone","border-color":"input.tf-newsletter-link"},"option_name":"pubforce_color_pri_dark","value":"#131410"},{"name":"Widgets","default_value":"#ffd172","css":{"color":".light-secondary,.openitem,#footer a,#sidebar-wrap a,#footer a,#sidebar-wrap a,#header-address,#sidebar-wrap h3,.events-widget .longdate,input.tf-newsletter-link,.footer-widget H3,.sec-footer-outer .sec-footer a,#sidebar-wrap .events-widget .eventitem a:hover","background-color":".fs-tips-thumb,#box-thumbnails a","border-color":"#main-sidebar .widget H3,.footer-widget H3,div#fancy_outer div#fancy_inner,input.tf-newsletter-link:hover"},"option_name":"pubforce_color_sec_reg","value":"#ffd172"},{"name":"Links","default_value":"#456711","css":{"color":"#main a, .mobile-phone a","background-color":".thumb, input.tf-newsletter-link,.fc th, .fc-state-default .fc-button-inner, .fc-button-prev, .fc-button-next","border-color":".sf-menu ul li"},"option_name":"pubforce_color_pri_light","value":"#456711"},{"name":"Navigation","default_value":"#ffd172","css":{"color":".sf-menu a"},"option_name":"pubforce_color_nav","value":"#ffd172"}];			
            var backgroundImageOptions = '[]';
            var themePresets = '[]';
            var fonts = '[]';
            var DesignPanelMarginOffset = '320'
        </script>
        <div id="tf-panel-wrap" style="left: -320px;">
            <div id="tf-designpanel-toggle" style="float: right;" class="toggle-off"></div>
                <div id="tf-panel-secondary-wrap">
                    <h2 class="tf-panel-header">Customize</h2>
                    <div id="tf-panel-accordion">
                        <h3>Colors</h3>
                        <div class="accordion-box">
                            <p>You can tailor your colors to match your brand here. Remember to be subtle but still use contrast.</p>
                            <div class="color-select">Background
                                <div id="colorSelector0" class="colorSelectorbutton">
                                    <?php
                                        if(get_option('background-color')){
                                            $color1 = get_option('background-color');
                                        }else{
                                            $color1 = "#394831";
                                        }
                                    ?>
                                    <div style="background-color: <?php echo $color1; ?>"></div>
                                </div>
                            </div>
                            <div class="color-select">Regular
                                <div id="colorSelector1" class="colorSelectorbutton">
                                    <div style="background-color: <?php echo (get_option('content-background-color')) ? get_option('content-background-color') : '#131410'; ?>"></div>
                                </div>
                            </div>
                            <div class="color-select">Widgets
                                <div id="colorSelector2" class="colorSelectorbutton">
                                    <div style="background-color: <?php echo (get_option('widget-heading-color')) ? get_option('widget-heading-color') : '#ffd172'; ?>"></div>
                                </div>
                            </div>
                            <div class="color-select">Links
                                <div id="colorSelector3" class="colorSelectorbutton">
                                    <div style="background-color: <?php echo (get_option('active-text-color')) ? get_option('active-text-color') : '#456711'; ?>"></div>
                                </div>
                            </div>
                            <div class="color-select">Navigation
                                <div id="colorSelector4" class="colorSelectorbutton">
                                    <div style="background-color: <?php echo (get_option('navigation-text-color')) ? get_option('navigation-text-color') : '#ffd172'; ?>"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="padding:10px;">
                        <a class="dashboard-button" href="<?php echo get_bloginfo('home'); ?>/wp-admin/index.php" target="_blank">Go to Dashboard</a>
                    </div>
                </div>
                <!-- / Presets -->
            <?php } ?>
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>