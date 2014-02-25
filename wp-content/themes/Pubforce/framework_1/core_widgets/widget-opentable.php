<?php
/* ------------------- THEME FORCE ----------------------*/

// WIDGET: opentable TYPES
//***********************************************

class tf_opentable_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function tf_opentable_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tf-opentable', 'description' => __('This is used to show the OpenTable reservations widget', 'themeforce') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'tf-opentable-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'tf-opentable-widget', __('OpenTable', 'themeforce'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

                // - our variables from the widget settings -

		$title = apply_filters('widget_title', $instance['opentable-title'] );

                // widget display

                echo $before_widget;

                if ( $title ) {echo $before_title . $title . $after_title;}
                
					if ( TF_THEME != 'fineforce' ) { $iconstyle = 'dark'; } else { $iconstyle = 'dark'; }
				
                    $opentable = trim( get_option( 'tf_opentable_id' ) );
                    echo '<div class="tf-opentable" style="margin:0 auto !important;width:165px;">';
                    echo '<script type="text/javascript" src="http://www.opentable.com/frontdoor/default.aspx?rid='. $opentable. '&restref='. $opentable. '&bgcolor=F6F6F3&titlecolor=0F0F0F&subtitlecolor=0F0F0F&btnbgimage=http://www.opentable.com/frontdoor/img/ot_btn_red.png&otlink=FFFFFF&icon='. $iconstyle .'&mode=short"></script>';
                    echo '<style type="text/css">';
					// echo '.OT_wrapper{background:none;border:none;} .OT_day, .OT_time, .OT_party, .OT_submit {border:none;}';
					if ( TF_THEME == 'fineforce' ) {echo 'ul.OT_list, ul.OT_list li {list-style-type: none}';}
					echo '</style>';
                    echo '</div>';

                echo $after_widget;
                }

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

			  $instance['opentable-title'] = strip_tags( $new_instance['opentable-title'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'opentable-title' => __('Reservations', 'themeforce'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->

                <p><label for="<?php echo $this->get_field_id( 'opentable-title' ); ?>"><?php _e('Title:', 'themeforce'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'opentable-title' ); ?>" name="<?php echo $this->get_field_name( 'opentable-title' ); ?>" value="<?php echo $instance['opentable-title']; ?>" /></p>
                <p>The widget displays based on your OpenTable Restaurant ID, which can be set in the OpenTable options.</p>
	<?php
	}
}
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'tf_opentable_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function tf_opentable_load_widgets() {
	register_widget( 'tf_opentable_widget' );
}

?>