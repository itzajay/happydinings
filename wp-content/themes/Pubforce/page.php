<?php get_header(); ?>
<!-- start Main Wrap -->
<div id="main">
    <div id="papercurl">
        <div class="page-curl"></div>
    </div>
    <div id="paper">
        <?php get_template_part('loop-page','page'); ?>      
    </div>
    <div class="clearfix"></div>
   <div class="paper-bottom"></div>
</div>
<?php get_sidebar(); ?>
<!-- end Main Wrap -->
<?php get_footer(); ?>