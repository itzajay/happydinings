<?php
/* ------------------- THEME FORCE ----------------------*/

// WIDGET: FACEBOOK LIKEBOX
//***********************************************

class tf_fb_likebox_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function tf_fb_likebox_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_likebox_fb', 'description' => __('This widget is used to show a Facebook Like Box (based on your Facebook address)', 'themeforce') );

		/* Widget control settings. */
		//$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'tf-fb_likebox-widget' );
		$control_ops = array( 'width' => 200, 'height' => 350);

		/* Create the widget. */
		parent::WP_Widget( 'likebox_fb', __('Facebook - Like Box', 'example'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

                // - our variables from the widget settings -

		$title = apply_filters('widget_title', $instance['fb-lb-title'] );
		
		
		if(get_option('tf_facebook')){
			$fb_url = get_option('tf_facebook');	
		}else{
			$fb_url = 'https://www.facebook.com/pages/happytables/269775543058919';
		}	
		//$fb_url = get_option('tf_facebook');
		$fb_width = '300';
		$fb_faces = 'true';
		
		// widget display
		
		echo $before_widget;
		
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		
		echo '<div class="fb-like-box" data-href="'. $fb_url .'" data-width="'. $fb_width .'" data-show-faces="'. $fb_faces .'" data-stream="false" data-header="false"></div>';
		
		echo '<style type="text/css">';
		echo '.fb-like-box .fb_ltr {background:white !important}';
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
		$instance['fb-lb-title'] = strip_tags( $new_instance['fb-lb-title'] );
                /*
                $instance['gmaps-headdesc'] = strip_tags( $new_instance['gmaps-headdesc'] );
                $instance['gmaps-height'] = strip_tags( $new_instance['gmaps-height'] );
                $instance['gmaps-zoom'] = strip_tags( $new_instance['gmaps-zoom'] );
                $instance['gmaps-footdesc'] = strip_tags( $new_instance['gmaps-footdesc'] );
                */
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'fb-lb-title' => __('Like us on Facebook', 'themeforce'));
		$instance = wp_parse_args( (array) $instance, $defaults );
                /* $zoom = $instance['gmaps-zoom']; */
                ?>

		<!-- Widget Title: Text Input -->

        <p><label for="<?php echo $this->get_field_id( 'fb-lb-title' ); ?>"><?php _e('Title:', 'themeforce'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'fb-lb-title' ); ?>" name="<?php echo $this->get_field_name( 'fb-lb-title' ); ?>" value="<?php echo $instance['fb-lb-title']; ?>" /></p>
        <!--
        <p><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'gmaps-headdesc' ); ?>" name="<?php echo $this->get_field_name( 'gmaps-headdesc' ); ?>"><?php echo $instance['gmaps-headdesc']; ?></textarea></p>
        <p><label for="<?php echo $this->get_field_id( 'gmaps-height' ); ?>"><?php _e('Height (in pixels):', 'themeforce'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'gmaps-height' ); ?>" name="<?php echo $this->get_field_name( 'gmaps-height' ); ?>" value="<?php echo $instance['gmaps-height']; ?>" /></p>
        <label><?php _e('Zoom Factor:', 'themeforce'); ?></label>
        <select id="<?php echo $this->get_field_id( 'gmaps-zoom' ); ?>" name="<?php echo $this->get_field_name( 'gmaps-zoom' ); ?>">
            <option value='1' <?php selected( $zoom, 1); ?>>1</option>
            <option value='2' <?php selected( $zoom, 2); ?>>2</option>
            <option value='3' <?php selected( $zoom, 3); ?>>3</option>
            <option value='4' <?php selected( $zoom, 4); ?>>4</option>
            <option value='5' <?php selected( $zoom, 5); ?>>5</option>
            <option value='6' <?php selected( $zoom, 6); ?>>6</option>
            <option value='7' <?php selected( $zoom, 7); ?>>7</option>
            <option value='8' <?php selected( $zoom, 8); ?>>8</option>
            <option value='9' <?php selected( $zoom, 9); ?>>9</option>
            <option value='10' <?php selected( $zoom, 10); ?>>10</option>
            <option value='11' <?php selected( $zoom, 11); ?>>11</option>
            <option value='12' <?php selected( $zoom, 12); ?>>12</option>
            <option value='13' <?php selected( $zoom, 13); ?>>13</option>
            <option value='14' <?php selected( $zoom, 14); ?>>14</option>
            <option value='15' <?php selected( $zoom, 15); ?>>15</option>
            <option value='16' <?php selected( $zoom, 16); ?>>16</option>
            <option value='17' <?php selected( $zoom, 17); ?>>17</option>
            <option value='18' <?php selected( $zoom, 18); ?>>18</option>
            <option value='19' <?php selected( $zoom, 19); ?>>19</option>
            <option value='20' <?php selected( $zoom, 20); ?>>20</option>
            <option value='21' <?php selected( $zoom, 20); ?>>21</option>
        </select>
        <p><textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'gmaps-footdesc' ); ?>" name="<?php echo $this->get_field_name( 'gmaps-footdesc' ); ?>"><?php echo $instance['gmaps-footdesc']; ?></textarea></p>
        -->
	<?php
	}
}
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'tf_fb_likebox_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function tf_fb_likebox_load_widgets() {
	register_widget( 'tf_fb_likebox_widget' );
	//register_widget( 'Tf_Demo1_Widget_Demo' );
}


class Tf_Demo1_Widget_Demo extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_demo', 'description' => __( 'This widget is used to show a Facebook Like Box (based on your Facebook address)') );
		parent::__construct('demo', __('demo'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		
		if($instance){
			$title = apply_filters('widget_title', $instance['title'] );
		}else{
			$title = apply_filters('widget_title','demo' );
		}
	
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
?>
		<div><?php echo $title; ?></div>
<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'demo like') );
		$title = strip_tags($instance['title']);
		//$count = $instance['count'] ? 'checked="checked"' : '';
		//$dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
<?php
	}
}
?>