<?php get_header(); ?>
	<!-- main -->
	<div id="main" >
		<div id="papercurl">
			<div class="page-curl"></div>
		</div>
		<div id="paper">
			<!-- page content -->
			<?php get_template_part('loop-page','page'); ?>
			<!-- /page content -->
		</div>
		<div class="clearfix"></div>
		<div class="paper-bottom"></div>
	</div>
	<!-- SIDEBAR -->
	<?php get_sidebar(); ?>
	<!-- /SIDEBAR -->
	<div class="clearfix"></div>
</div>
<!-- /main -->
<?php get_footer(); ?>