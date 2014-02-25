<?php get_header(); ?>
<!-- start Main Wrap -->
<div id="main-wrap" class="template-regular">
    <div class="fine">
        <div class="grid_8">
            <div class="content">		
                <?php
					while ( have_posts() ) : the_post();
				?>
				   <article id="post-<?php echo the_ID(); ?>" class="page">
					   <header class="entry-header">
						   <div class="page-title-wrap"><h1 class="entry-title"><?php the_title(); ?></h1></div>
					   </header>
					   <div class="entry-content">            
						   <?php
                                $post_image_id = get_post_thumbnail_id(get_the_ID());
                                if($post_image_id){
                                    if($thumbnail = wp_get_attachment_image_src( $post_image_id, 'width=200&height=200&crop=1', false) )
                                        ( string ) $thumbnail = $thumbnail[0];
                                }
                            ?>
                            <div class="event-thumb-single">
                                <?php if ($thumbnail != '') {?><img itemprop="photo" src="<?php echo $thumbnail; ?>" alt="<?php the_title(); ?>" /><?php } ?>
                            </div>
                            <div class="event-info">
                                <?php
                                    // - declare fresh day -
                                    $date_format = get_option( 'date_format' );
                                    $custom = get_post_custom( get_the_ID() );
                                    $sd = $custom["tf_events_startdate"][0];
                                    $ed = $custom["tf_events_enddate"][0];
                                    
                                    $sqldate = date('Y-m-d H:i:s', $sd);
                                    $sdate = mysql2date($date_format, $sqldate);
                                    $time_format = get_option( 'time_format' );
                                    $stime = date($time_format, $sd); // <- Start Time
                                    
                                    $sqlenddate = date('Y-m-d H:i:s', $ed);
                                    $edate = mysql2date($date_format, $sqlenddate);
                                    $etime = date($time_format, $ed); // <- Start Time
                                ?>
                                <div class="openitem">
                                    <div class="openday_event">Start Date/Time - </div>
                                    <div class="opentime_event"><?php echo ' '.$sdate.' '.$stime; ?></div>
                                </div>
                                <div class="openitem bottom_margin">
                                    <div class="openday_event">End Date/Time - </div>
                                    <div class="opentime_event"><?php echo ' '.$edate.' '.$etime; ?></div>
                                </div>
                            </div>
                            <div class="event-description">
                                <?php the_content(); ?>
                            </div>
					   </div>
				   </article>
			   <?php endwhile; ?>
            </div>
        </div>
        <div class="grid_4">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<!-- end Main Wrap -->
<?php get_footer(); ?>