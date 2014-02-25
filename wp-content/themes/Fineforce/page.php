<?php get_header(); ?>
<!-- start Main Wrap -->
<div id="main-wrap" class="template-regular">
    <div class="fine">
        <div class="grid_8">
            <div class="content">		
                <?php get_template_part('loop-page','page'); ?>
            </div>
        </div>
        <div class="grid_4">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<!-- end Main Wrap -->
<?php get_footer(); ?>