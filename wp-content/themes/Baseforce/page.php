<?php get_header(); ?>
<!-- start Main Wrap -->
	<div class="main_wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-6">
					<?php get_template_part('loop-page','page'); ?>
				</div>
				<div class="col-md-4 col-sm-6">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div>
<!-- end Main Wrap -->
<?php get_footer(); ?>