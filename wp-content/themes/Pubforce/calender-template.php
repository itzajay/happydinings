<?php
/*
Template Name: Calendar
*/
?>
<?php get_header(); ?>
<link rel='stylesheet' id='full-calendar' href="<?php echo get_bloginfo('template_directory');?>/css/fullcalendar.css" type='text/css' media='all' />
<!--<link rel='stylesheet' id='full-calendar-print' href="<?php echo get_bloginfo('template_directory');?>/css/fullcalendar.print.css" type='text/css' media='all' />-->
<script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/js/fullcalendar.min.js"></script>
<!-- start Main Wrap -->
<div class="main-full-width" id="main">
    <div id="papercurl">
        <div class="page-curl"></div>
    </div>
    <div id="paper">
		<?php get_template_part('loop-page','page' ); ?>
		<div id='calendar'></div>
		<?php
			query_posts( array('post_type'=>'event') );
			$all_data = array();
			while ( have_posts() ) : the_post();
				$start_date = get_post_meta( get_the_ID(), 'tf_events_startdate', true );
				$start_dd = date('d',$start_date);
				$start_mm = date('m',$start_date);
				$start_yy = date('y',$start_date);
				$start_hh = date('h',$start_date);
				$start_min = date('i',$start_date);
				$end_date = get_post_meta( get_the_ID(), 'tf_events_enddate', true );
				$end_dd = date('d',$end_date);
				$end_mm = date('m',$end_date);
				$end_yy = date('y',$end_date);
				$end_hh = date('h',$end_date);
				$end_min = date('i',$end_date);
				$all_data[] = array(
					'id' => get_the_ID(),
					'title' => get_the_title(get_the_ID()),
					'start' => date('Y-m-d H:i:s', mktime($start_hh, $start_min, 0, $start_mm, $start_dd, $start_yy)),
					'end' => date('Y-m-d H:i:s', mktime($end_hh, $end_min, 0, $end_mm, $end_dd, $end_yy)),
					'url' => get_bloginfo('home').'/?tf_events='.basename(get_permalink())
				);
		?>
		<?php
			endwhile;
		?>
		<script type='text/javascript'>
			jQuery(document).ready(function($){
				$('#calendar').fullCalendar({
					editable: false,
					events: <?php echo json_encode($all_data); ?>
				});
			});
		</script>
	</div>
    <div class="clearfix"></div>
	<div class="paper-bottom"></div>
</div>
<!-- end Main Wrap -->
<?php get_footer(); ?>