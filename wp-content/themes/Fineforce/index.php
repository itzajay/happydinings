<?php get_header(); ?>
    <!-- Main Wrap -->
	<div id="main-wrap" class="template-regular">
        <div class="fine">
            <div class="grid_8">
                <div class="content">
					<?php while ( have_posts() ) : the_post(); ?>
                    <article id="<?php echo the_ID(); ?>" class="status-publish hentry">
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </article>
					<?php endwhile; ?>
                </div>
            </div>
            <div class="grid_4">
				<?php get_sidebar(); ?>
            </div>
		</div>
	</div> <!-- / Main -->
	<div class="clearfix"></div>
<?php get_footer(); ?>