<?php
/* ------------------- THEME FORCE ----------------------*/

// WIDGET: FACEBOOK FACEPILE
//***********************************************

class tf_fb_facepile_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function tf_fb_facepile_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tf-fb_facepile', 'description' => __('This widget is used to show a Facebook Facepile (based on your Facebook address)', 'themeforce') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'tf-fb_facepile-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'tf-fb_facepile-widget', __('Facebook - Facepile', 'example'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

        // - our variables from the widget settings -
		$title = apply_filters('widget_title', $instance['fb-fp-title'] );
        $fb_rows = $instance['fb-fp-rows'];
        $fb_url = get_option('tf_facebook');
        $fb_width = '300';              
        
        // widget display
		
        echo $before_widget;
		
        if ( $title ) {echo $before_title . $title . $after_title;}
                        			
        echo '<div class="fb-facepile" data-href="'. $fb_url .'" data-width="'. $fb_width .'" data-max-rows="'. $fb_rows .'"></div>';
        
        echo '<style type="text/css">';
        echo '.fb-facepile .fb_ltr {background-color:transparent !important}';
        echo '</style>';
        
        echo $after_widget;
        
		add_action( 'wp_footer', 'tf_enqueue_fb_code_in_footer' );
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['fb-fp-title'] = strip_tags( $new_instance['fb-fp-title'] );
		$instance['fb-fp-rows'] = strip_tags( $new_instance['fb-fp-rows'] );
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'fb-fp-title' => __('Facebook Friends', 'themeforce'));
		$instance = wp_parse_args( (array) $instance, $defaults );
                $rows = $instance['fb-fp-rows'];
                ?>

		<!-- Widget Title: Text Input -->

        <p><label for="<?php echo $this->get_field_id( 'fb-fp-title' ); ?>"><?php _e('Title:', 'themeforce'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'fb-fp-title' ); ?>" name="<?php echo $this->get_field_name( 'fb-fp-title' ); ?>" value="<?php echo $instance['fb-fp-title']; ?>" /></p>
        <label><?php _e('Number of Rows:', 'themeforce'); ?></label>
        <select id="<?php echo $this->get_field_id( 'fb-fp-rows' ); ?>" name="<?php echo $this->get_field_name( 'fb-fp-rows' ); ?>">
            <option value='1' <?php selected( $rows, 1); ?>>1</option>
            <option value='2' <?php selected( $rows, 2); ?>>2</option>
            <option value='3' <?php selected( $rows, 3); ?>>3</option>
            <option value='4' <?php selected( $rows, 4); ?>>4</option>
            <option value='5' <?php selected( $rows, 5); ?>>5</option>
        </select>
	<?php
	}
}
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'tf_fb_facepile_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function tf_fb_facepile_load_widgets() {
	register_widget( 'tf_fb_facepile_widget' );
}

?>