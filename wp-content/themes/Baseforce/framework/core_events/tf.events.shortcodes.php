<?php
/* ------------------- THEME FORCE ---------------------- */

/*
 * EVENTS SHORTCODES (CUSTOM POST TYPE)
 *
 * [tf-events-full limit='10']
 * [tf-events-feat limit='1' group='Featured' header='yes' text='Featured Events']
 *
 */
 
// CATEGORIES FUNCTION
//***********************************************************************************

function tf_list_cats() {
	$terms = get_the_terms($post->id, 'tf_eventcategory');
	if ( !$terms ) {return;}
	$counter = 0;
	foreach ($terms as $term) {
	// Doesn't show featured items by default
		if ($term->name != __( 'Featured', 'themeforce') ) {
		  if ( $counter > 0 ) { $output .= ', ';}
		  $output .= $term->name;
		  $counter++;
		}
	};
	return $output;
};
 
// 1) FULL EVENTS
//***********************************************************************************

function tf_events_full ( $atts ) {

    if ( ! tf_is_premium_active() )
        return null;

	// - define arguments -
	extract(shortcode_atts(array(
	    'limit' => '20', // # of events to show
	 ), $atts));

	// ===== OUTPUT FUNCTION =====
	
	ob_start();
	
	// ===== LOOP: FULL EVENTS SECTION =====
	
	// - make sure it's a number for our query -
	
	$limit = intval( $limit );
	
	// - hide events that are older than 6am today (because some parties go past your bedtime) -
	
	$yesterday6pm = strtotime('yesterday 18:00') + ( get_option( 'gmt_offset' ) * 3600 );
	$name = stripslashes( get_option('tf_business_name') );
    $address = stripslashes( get_option('tf_business_address') );
    $location = $name . ', ' . $address;

    $tax_query = array();

    if ( ! empty ( $atts['group'] )  ) {

        $tax_query = array(
                array(
                    'taxonomy' => 'tf_eventcategory',
                    'field' => 'slug',
                    'terms' => $atts['group']
                )
        );
    }

    $args = array(
        'post_type' => 'tf_events',
        'post_status' => 'publish',
        'orderby' => 'meta_value_num',
        'meta_key' => 'tf_events_startdate',
        'order' => 'ASC',
        'posts_per_page' => $limit,
        'meta_query' => array(
            array(
                'key' => 'tf_events_enddate',
                'value' => $yesterday6pm,
                'compare' => '>'
            ),
            array(
                'key' => 'tf_events_startdate',
                'value' => '1',
                'compare' => '>'
            )
        ),
        'tax_query'  => $tax_query

    );

    $events = new WP_Query( $args );

	// - declare fresh day -
	$date_format = get_option( 'date_format' );
	
	echo '<!-- www.schema.org -->';
	
	// - loop -
	if ( $events ):
	global $post;
	while ( $events->have_posts() ) : $events->the_post();

	// - custom variables -
	$custom = get_post_custom( get_the_ID() );
	$sd = $custom["tf_events_startdate"][0];
	$ed = $custom["tf_events_enddate"][0];

    $post_image_id = get_post_thumbnail_id( get_the_ID() );
        if ( $post_image_id ) {
                 if ( $thumbnail = wp_get_attachment_image_src( $post_image_id, 'width=80&height=80&crop=1', false) )
                    ( string ) $thumbnail = $thumbnail[0];
        }
			
	// - determine if it's a new day -
	$sqldate = date('Y-m-d H:i:s', $sd);
	$longdate = mysql2date($date_format, $sqldate);

	// - determine date -
	$sqldate = date('Y-m-d H:i:s', $sd);
	$schema_startdate = date('Y-m-d\TH:i', $sd); // <- Date for Google Rich Snippets
	$schema_enddate = date('Y-m-d\TH:i', $ed); // <- Date for Google Rich Snippets
	$date_format = get_option( 'date_format' );
	$local_startdate = mysql2date($date_format, $sqldate); // <- Date for Display
	
	// - determine duration -
	$schema_duration = ( $ed-$sd )/60; // Duration for Google Rich Snippets

	// - local time format -
	$time_format = get_option( 'time_format' );
	$stime = date($time_format, $sd); // <- Start Time
	$etime = date($time_format, $ed); // <- End Time
	
	// TODO add fallback for nothumb
	
	// - output - ?>
    <div class="full-events" itemprop="events" itemscope itemtype="http://schema.org/Event">

        <div class="event-thumb">

            <?php if ($thumbnail != '') {?><img itemprop="photo" src="<?php echo $thumbnail; ?>" alt="<?php the_title(); ?>" /><?php } ?>

        </div>

        <div class="event-text">

            <!-- url & name -->
            <div class="title"><a itemprop="url" href="<?php echo get_bloginfo('home').'/?tf_events='.basename(get_permalink()); ?>"><span itemprop="name"><?php the_title(); ?></span></a></div>
            <!-- date -->
            <div class="datetime">
                <span class="date"><?php echo $longdate; ?></span><span class="date-sep"> &bull; </span></span><span class="time" itemprop="startDate" content="<?php echo $schema_startdate; ?>"><?php echo $stime . ' - ' . $etime; ?></span>
            </div>
            <!-- meta -->
            <meta itemprop="duration" content="PT<?php echo $schema_duration; ?>M" />
            <meta itemprop="location" content="<?php echo $location;?>" />
            <meta itemprop="eventType" content="<?php tf_list_cats(); ?>" />
            <!-- description -->
            <div class="desc" itemprop="description">
                <?php the_content() ?>
            </div>

        </div>

    </div>


	<!-- www.schema.org -->  
	
	<?php

    $thumbnail = null;

    endwhile;
	else :
	endif;
	
	echo '<!-- / www.schema.org -->';

    wp_reset_postdata();
	
	// ===== RETURN: FULL EVENTS SECTION =====
	
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
	
}
	
add_shortcode('tf-events-full', 'tf_events_full');
add_shortcode('tf-events-feat', 'tf_events_full'); // Previously tf_events_feat - Merged into one


/**
 * Registers the Insert Shortcode tinymce plugin for Food menu.
 * 
 */
function tf_events_register_tinymce_buttons() {
	
	if ( !current_user_can( 'edit_posts' ) || 
		( isset( $_GET['post'] ) && !in_array( get_post_type( $_GET['post'] ), array( 'post', 'page' ) ) ) || 
		( isset( $_GET['post_type'] ) && !in_array( $_GET['post_type'], array( 'post', 'page' ) ) ) )
		return;
	
	add_filter( 'mce_external_plugins', 'tf_events_add_tinymce_plugins' );
}
add_action( 'load-post.php', 'tf_events_register_tinymce_buttons' );
add_action( 'load-post-new.php', 'tf_events_register_tinymce_buttons' );


/**
 * Adds the Insert Shortcode tinyMCE plugin for the food menu.
 * 
 * @param array $plugin_array
 * @return array
 */
function tf_events_add_tinymce_plugins( $plugin_array ) {
	$plugin_array['tf_events_shortcode_plugin'] = TF_URL . '/core_events/tinymce_plugins/insert_shortcode.js';
	
	return $plugin_array;
}

function tf_events_add_insert_events_above_editor() {

    if ( ! tf_is_premium_active() )
        return null;

	?>
	<a class="tf-button tf-inlinemce" href="javascript:tinyMCE.activeEditor.execCommand( 'mceExecTFEventsInsertShortcode' );"><img src="<?php echo TF_URL . '/core_events/tinymce_plugins/event_16.png' ?>"/><span>Events</span></a>
	<?php
}
add_action( 'tf_above_editor_insert_items', 'tf_events_add_insert_events_above_editor' );