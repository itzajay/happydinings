<?php
     while ( have_posts() ) : the_post();
?>
		<article id="post-<?php echo the_ID(); ?>">
	        <header>
	            <h1><?php the_title(); ?></h1>
	        </header>
	        <div class="entry-content">            
	            <?php the_content(); ?>
	        </div>
	    </article>
<?php endwhile; ?>