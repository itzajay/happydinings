<?php

/**
 * Text widget on single page class
 * displays text widget on selected page
 * @since 2.8.0
 */
class TF_Text_Widget_On_Page extends WP_Widget {

	
	function __construct() {

		$widget_ops = array('classname' => 'widget_text', 'description' => 'Add a text widget which can be displayed on a single page only');
		$control_ops = null;
		parent::__construct('opinionpanel-text-with-image-widget', __('Single Page Text Widget'), $widget_ops, $control_ops);

	}


	//Widget output on front end
	function widget( $args, $instance ) {
	
		extract( $args );
	
		//if the current page isnt the same as the one selected for the widget, and the widget isnt set to display on all pages
		if ( get_queried_object()->ID != $instance['selected_page'] && $instance['selected_page'] != "all"  )
			return;	

		echo $before_widget;
		
		echo $before_title; ?>

		<?php echo $instance['title']; ?>

		<?php echo $after_title; ?>

			<div><?php echo $instance ['text']; ?></div>
	
		<?php echo $after_widget;
	  }


	//The widget form seen in 'Widgets' screen
	function form( $instance ) {
	
		//actualize variables
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'selected_page' => 'all') );
		
		$title = strip_tags( $instance['title'] );
		$text = esc_textarea( $instance['text'] );
		$selected_page = esc_textarea( $instance['selected_page'] );

		
			//draw input fields for widget options?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

			<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:'); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_attr($text); ?></textarea></p>

			<p>
			
				<label for="<?php echo $this->get_field_id('page_display'); ?>"><?php _e('Display on Page:'); ?></label>

				<!-- find all published pages on the site -->	
				<?php $pages = new WP_Query( 'post_type=page&post_status=publish&posts_per_page=99' ); ?>
						
				<select class="widefat" id="<?php echo $this->get_field_id('selected_page'); ?>" name="<?php echo $this->get_field_name('selected_page'); ?>" type="text">
	
					<option value="all" <?php if ( $selected == 'all' ): ?> selected <?php endif; ?>>-All Pages-</option>

					<!--Add an option to the select for each published page on the site-->
					<?php while ( $pages->have_posts() ): $pages->the_post(); ?>
			
						<option value="<?php echo get_the_ID(); ?>" <?php if( get_the_ID() == $selected_page ):?> selected <?php endif; ?>><?php the_title(); ?></option>
				
					<?php endwhile; ?>
					
				</select>
			
			</p>		
	
			<?php
	}
}



/* register widget. */
function tf_register_text_widget_on_page() {
	register_widget( 'TF_Text_Widget_On_Page' );
}

/* Add  function to the widgets_init hook. */
add_action( 'widgets_init', 'tf_register_text_widget_on_page' );
