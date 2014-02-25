<?php
     while ( have_posts() ) : the_post();
?>
    <div class="page type-page status-publish hentry" id="page-<?php echo the_ID(); ?>">
        <h1 id="posttitle"><?php the_title(); ?></h1>
        <div class="content">
            <?php the_content(); ?>
        </div>
    </div>
<?php endwhile; ?>