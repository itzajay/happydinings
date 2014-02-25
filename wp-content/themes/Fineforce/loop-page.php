<?php
     while ( have_posts() ) : the_post();
?>
    <article id="post-<?php echo the_ID(); ?>" class="page">
        <header class="entry-header">
            <div class="page-title-wrap"><h1 class="entry-title"><?php the_title(); ?></h1></div>
        </header>
        <div class="entry-content">            
            <?php the_content(); ?>
        </div>
    </article>
<?php endwhile; ?>