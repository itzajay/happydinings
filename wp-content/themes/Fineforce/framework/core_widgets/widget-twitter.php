<?php
/*
Plugin Name: Twitter Widget
Description: Adds a sidebar widget to display Twitter updates. Adapted and upgraded from Sean Spalding's Twitter Widget, for use with Theme Force
Version: 1.0
Author: ThemeForce
Author URI: http://theme-force.com
License: GPL
*/

class tf_twitter_widget extends WP_Widget {

	function __construct() {

		$widget_ops = array('classname' => 'widget_twitter', 'description' => 'This widget is used to show your recent Twitter activity using your Twitter account');
		$control_ops = null;
		parent::__construct('twitter', __('Twitter - Display Feed'), $widget_ops, $control_ops);

	}

	//Widget output on front end
	function widget( $args, $instance ) {
		
		// "$args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys." - These are set up by the theme
		extract($args);

		// These are our own options
		
		if($instance['tf_twitter_title']){
			$title = apply_filters('widget_title', $instance['tf_twitter_title'] );
		}else{
			$title = apply_filters('widget_title', $instance['title'] );
		}
		
		$account = ($instance['tf_twitter_account']) ? $instance['tf_twitter_account'] : '@plately';
        $show = ($instance['tf_twitter_count']) ? $instance['tf_twitter_count'] : 5;
		
        //$title = apply_filters('widget_title', $instance['tf_twitter_title'] );
        //$account = $instance['tf_twitter_account'];
        //$show = $instance['tf_twitter_count'];

        // Output
		echo $before_widget ;

		// start

        if ( $title ) {echo $before_title . $title . $after_title;}
        
		echo '<ul id="twitter_update_list"></ul>
		      <script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>';
		//echo '<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/'.$account.'.json?callback=twitterCallback2&amp;count='.$show.'"></script>';
		echo '<script type="text/javascript" src="http://api.twitter.com/1/statuses/user_timeline/'.$account.'.json?callback=twitterCallback2&count='.$show.'"></script>';

		// echo widget closing tag
        
		echo $after_widget;	
	
	}

	//The widget form seen in 'Widgets' screen
    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['tf_twitter_title'] = strip_tags( $new_instance['tf_twitter_title'] );
        $instance['tf_twitter_account'] = strip_tags( $new_instance['tf_twitter_account'] );
        $instance['tf_twitter_count'] = strip_tags( $new_instance['tf_twitter_count'] );

        return $instance;

    }

    function form( $instance ) {

        $defaults = array( 'tf_twitter_title' => __('Twitter Feed', 'themeforce'), 'tf_twitter_account' => '@plately' , 'tf_twitter_count' => '5');
        $instance = wp_parse_args( (array) $instance, $defaults );
        $show = $instance['tf_twitter_count'];

        ?>

        <p>

            <label for="twitter-title"><?php echo __('Widget Title:'); ?>

                <input style="width: 200px;" id="<?php echo $this->get_field_id('tf_twitter_title'); ?>" name="<?php echo $this->get_field_name('tf_twitter_title'); ?>" type="text" value="<?php echo $instance['tf_twitter_title']; ?>" />

            </label>
        
        </p>

        <p>
            <label for="twitter-account"><?php echo __('Twitter Account:'); ?>

                <input style="width: 200px;" id="<?php echo $this->get_field_id('tf_twitter_account'); ?>" name="<?php echo $this->get_field_name('tf_twitter_account'); ?>" type="text" value="<?php echo $instance['tf_twitter_account']; ?>" />

            </label>
        
        </p>

		
		<p>

            <label for="twitter-show"><?php echo __('Display Tweets:'); ?>

            <select style="width: 200px;" id="<?php echo $this->get_field_id('tf_twitter_count'); ?>" name="<?php echo $this->get_field_name('tf_twitter_count'); ?>" type="text">

                <?php for( $i=1; $i<=10; $i++ ): ?>

                    <option value="<?php echo $i; ?>" <?php selected( $show, $i ); ?>><?php echo $i; ?></option>

                <?php endfor; ?>

            </select>

            </label>

        </p>

		<?php
	}
}

/* register widget. */
function tf_register_twitter_widget() {
	register_widget( 'tf_twitter_widget' );
}

/* Add  function to the widgets_init hook. */
add_action( 'widgets_init', 'tf_register_twitter_widget' );
?>