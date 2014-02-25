	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-6 col-xs-12">
					<?php dynamic_sidebar('footer-left-sidebar'); ?>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<?php dynamic_sidebar('footer-middle-sidebar'); ?>
				</div>
				<div class="col-md-4 col-sm-12 col-xs-12">
					<?php dynamic_sidebar('footer-right-sidebar'); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-xs-6">
					<?php echo get_option('tf_terminalnotice'); ?>
				</div>
				<div class="col-md-6 col-xs-6">
					<a class="poweredby pull-right" href="<?php echo NOBLOGREDIRECT; ?>" target="_blank">
						<img src="<?php echo get_bloginfo('template_directory'); ?>/images/logo-light.png" alt="Restaurant website by happy dinings" />
					</a>
				</div>
			</div>
		</div>
	</footer>
	
	<?php wp_footer(); ?>
</body>
</html>