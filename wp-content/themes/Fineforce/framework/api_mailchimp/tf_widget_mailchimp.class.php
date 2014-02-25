<?php
/**
 * @author James Lafferty
 * @since 0.1
 */

class TF_Widget_MailChimp extends WP_Widget {

	private $default_failure_message;
	private $default_loader_graphic = '/framework/assets/images/ajax-loader.gif';
	private $default_signup_text;
	private $default_success_message;
	private $default_title;
	private $successful_signup = false;
	private $subscribe_errors;

	private $tf_mc_plugin;

	/**
	 * @author James Lafferty
	 * @since 0.1
	 */

	public function TF_Widget_MailChimp () {

		$this->default_failure_message = __('There was a problem processing your submission.');
		$this->default_signup_text = __('Join now!');
		$this->default_success_message = __('Thank you for joining our mailing list. Please check your email for a confirmation link.');
		$this->default_title = __('Sign up for our Newsletter');

		$widget_options = array('classname' => 'widget_tf_mailchimp', 'description' => __( "Displays a sign-up form for a MailChimp mailing list.", 'themeforce'));

		$this->WP_Widget('tf_widget_mailchimp', __('Newsletter ( MailChimp )', 'themeforce'), $widget_options);

		$this->tf_mc_plugin = TF_MC_Plugin::get_instance();

		$this->default_loader_graphic = get_bloginfo( 'template_url' ) . $this->default_loader_graphic;

		add_action('parse_request', array(&$this, 'process_submission'));

        add_action('init' , array(&$this, 'mailchimp_js'));

	}

	/**
	 * @author James Lafferty
	 * @since 0.1
	 */

	public function form ( $instance ) {

		$mcapi = $this->tf_mc_plugin->get_mcapi();

		if ( false != $mcapi ) {

			$this->lists = $mcapi->lists();

			$defaults = array(

				'failure_message' => $this->default_failure_message,
				'title' => $this->default_title,
				'signup_text' => $this->default_signup_text,
				'success_message' => $this->default_success_message,
				'collect_first' => false,
				'collect_last' => false

			);

			$vars = wp_parse_args($instance, $defaults);

			extract( $vars );

			$form = '<h3>' . __('General Settings', 'themeforce') . '</h3><p><label>' . __('Title :', 'themeforce') . '<input class="widefat" id=""' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . $title . '" /></label></p>';

			$form .= '<p><label>' . __('Select a Mailing List :', 'themeforce') . '';

			$form .= '<select class="widefat" id="' . $this->get_field_id( 'current_mailing_list' ) . '" name="' . $this->get_field_name( 'current_mailing_list' ) . '">';

			foreach ($this->lists['data'] as $key => $value) {

				$selected = ( isset($current_mailing_list ) && $current_mailing_list == $value['id']) ? ' selected="selected" ' : '';

				$form .= '<option ' . $selected . 'value="' . $value['id'] . '">' . __($value['name'], 'themeforce') . '</option>';

			}

			$form .= '</select></label></p><p><strong>N.B.</strong> ' . __('This is the list your users will be signing up for in your sidebar.', 'themeforce') . '</p>';

			$form .= '<p><label>' . __('Sign Up Button Text :', 'themeforce') . '<input class="widefat" id="' . $this->get_field_id( 'signup_text' ) .'" name="' . $this->get_field_name( 'signup_text' ) . '" value="' . $signup_text . '" /></label></p>';

			$form .= '<h3>' . __('Personal Information', 'themeforce') . '</h3><p>' . __("These fields won't (and shouldn't) be required. Should the widget form collect users' first and last names?", 'themeforce') . '</p><p><input type="checkbox" class="checkbox" id="' . $this->get_field_id( 'collect_first' ) . '" name="' . $this->get_field_name( 'collect_first' ) . '" ' . checked($collect_first, true, false) . ' /> <label for="' . $this->get_field_id( 'collect_first' ) . '" >' . __('Collect first name.', 'themeforce') . '</label><br /><input type="checkbox" class="checkbox" id="' . $this->get_field_id( 'collect_last' ) . '" name="' . $this->get_field_name( 'collect_last' ) . '" ' . checked($collect_last, true, false) . ' /> <label>' . __('Collect last name.', 'themeforce') . '</label></p>';

			$form .= '<h3>' . __('Notifications', 'themeforce') . '</h3><p>' . __('Use these fields to customize what your visitors see after they submit the form', 'themeforce') . '</p><p><label>' . __('Success :', 'themeforce') . '<textarea class="widefat" id="' . $this->get_field_id( 'success_message' ) . '" name="' . $this->get_field_name( 'success_message' ) . '">' . $success_message . '</textarea></label></p><p><label>' . __('Failure :', 'themeforce') . '<textarea class="widefat" id="' . $this->get_field_id( 'failure_message' ) . '" name="' . $this->get_field_name( 'failure_message' ) . '">' . $failure_message . '</textarea></label></p>';

		} else { //If an API key hasn't been entered, direct the user to set one up.

			$form = $this->tf_mc_plugin->get_admin_notices();

		}

		echo $form;

	}

	/**
	 * @author James Lafferty
	 * @since 0.1
	 */

	public function process_submission () {

		if (isset($_GET[$this->id_base . '_email'])) {

			header("Content-Type: application/json");

			//Assume the worst.
			$response = '';
			$result = array('success' => false, 'error' => $this->get_failure_message( $_GET['tf_mc_number']) );

			$merge_vars = array();

			if (! is_email($_GET[$this->id_base . '_email'])) { //Use WordPress's built-in is_email function to validate input.

				$response = json_encode( $result ); //If it's not a valid email address, just encode the defaults.

			} else {

				$mcapi = $this->tf_mc_plugin->get_mcapi();

				if (false == $this->tf_mc_plugin) {

					$response = json_encode( $result );

				} else {

					if (isset($_GET[$this->id_base . '_first_name']) && is_string($_GET[$this->id_base . '_first_name'])) {

						$merge_vars['FNAME'] = $_GET[$this->id_base . '_first_name'];

					}

					if (isset($_GET[$this->id_base . '_last_name']) && is_string($_GET[$this->id_base . '_last_name'])) {

						$merge_vars['LNAME'] = $_GET[$this->id_base . '_last_name'];

					}

					$subscribed = $mcapi->listSubscribe( $this->get_current_mailing_list_id($_GET['tf_mc_number'] ), $_GET[$this->id_base . '_email'], $merge_vars);

					if (false == $subscribed) {

						$response = json_encode( $result );

					} else {

						$result['success'] = true;
						$result['error'] = '';
						$result['success_message'] =  $this->get_success_message( $_GET['tf_mc_number'] );
						$response = json_encode( $result);

					}

				}

			}

			exit($response );

		} elseif (isset($_POST[$this->id_base . '_email'])) {

			$this->subscribe_errors = '<div class="error">'  . $this->get_failure_message( $_POST['tf_mc_number'] ) .  '</div>';

			if (! is_email($_POST[$this->id_base . '_email'])) {

				return false;

			}

			$mcapi = $this->tf_mc_plugin->get_mcapi();

			if (false == $mcapi) {

				return false;

			}

			if (is_string($_POST[$this->id_base . '_first_name'])  && '' != $_POST[$this->id_base . '_first_name']) {

				$merge_vars['FNAME'] = strip_tags($_POST[$this->id_base . '_first_name']);

			}

			if (is_string($_POST[$this->id_base . '_last_name']) && '' != $_POST[$this->id_base . '_last_name']) {

				$merge_vars['LNAME'] = strip_tags($_POST[$this->id_base . '_last_name']);

			}

			$subscribed = $mcapi->listSubscribe( $this->get_current_mailing_list_id($_POST['tf_mc_number'] ), $_POST[$this->id_base . '_email'], $merge_vars);

			if (false == $subscribed) {

				return false;

			} else {

				$this->subscribe_errors = '';

				setcookie($this->id_base . '-' . $this->number, $this->hash_mailing_list_id(), time() + 31556926);

				$this->successful_signup = true;

				$this->signup_success_message = '<p>' . $this->get_success_message( $_POST['tf_mc_number'] ) . '</p>';

				return true;

			}

		}

	}

	/**
	 * @author James Lafferty
	 * @since 0.1
	 */

	public function update ($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['collect_first'] = ! empty( $new_instance['collect_first'] );

		$instance['collect_last'] = ! empty( $new_instance['collect_last'] );

		$instance['current_mailing_list'] = esc_attr( $new_instance['current_mailing_list'] );

		$instance['failure_message'] = esc_attr( $new_instance['failure_message'] );

		$instance['signup_text'] = esc_attr( $new_instance['signup_text'] );

		$instance['success_message'] = esc_attr( $new_instance['success_message'] );

		$instance['title'] = esc_attr( $new_instance['title'] );

		return $instance;

	}

	/**
	 * @author James Lafferty
	 * @since 0.1
	 */

	public function widget ($args, $instance) {

		extract( $args );

		if ( (isset($_COOKIE[$this->id_base . '-' . $this->number]) && $this->hash_mailing_list_id( $this->number ) == $_COOKIE[$this->id_base . '-' . $this->number]) || false == $this->tf_mc_plugin->get_mcapi()) {

			return 0;

		} else {

			$widget = $before_widget . $before_title . $instance['title'] . $after_title;

			if ( $this->successful_signup ) {

				$widget .= $this->signup_success_message;

			} else {

				$collect_first = '';

				if ( $instance['collect_first'] ) {

					$collect_first = '<label><span>' . __('First Name :', 'themeforce') . '</span><input type="text" name="' . $this->id_base . '_first_name" /></label><br />';

				}

				$collect_last = '';

				if ( $instance['collect_last'] ) {

					$collect_last = '<label><span>' . __('Last Name :', 'themeforce') . '</span><input type="text" name="' . $this->id_base . '_last_name" /></label><br />';

				}

				$widget .= '<form action="' . $_SERVER['REQUEST_URI'] . '" id="' . $this->id_base . '_form-' . $this->number . '" method="post">' . $this->subscribe_errors . $collect_first . $collect_last . '<label><span>' . __('E-mail :', 'themeforce') . '<input type="hidden" name="tf_mc_number" value="' . $this->number . '" /></span><input type="text" name="' . $this->id_base . '_email" /></label><br/><input class="tf-newsletter-link" type="submit" name="' . __($instance['signup_text'], 'themeforce') . '" value="' . __($instance['signup_text'], 'themeforce') . '" /></form><script type="text/javascript"> jQuery(\'#' . $this->id_base . '_form-' . $this->number . '\').tf_mc_widget({"url" : "' . $_SERVER['PHP_SELF'] . '", "cookie_id" : "'. $this->id_base . '-' . $this->number . '", "cookie_value" : "' . $this->hash_mailing_list_id() . '", "loader_graphic" : "' . $this->default_loader_graphic . '"}); </script>';

			}

			$widget .= $after_widget;

			echo $widget;

		}

	}

	/**
	 * @author James Lafferty
	 * @since 0.1
	 */

	private function hash_mailing_list_id () {

		$options = get_option( $this->option_name );

		$hash = md5( $options[$this->number]['current_mailing_list'] );

		return $hash;

	}

	/**
	 * @author James Lafferty
	 * @since 0.1
	 */

	private function get_current_mailing_list_id ($number = null) {

		$options = get_option( $this->option_name );

		return $options[$number]['current_mailing_list'];

	}

	/**
	 * @author James Lafferty
	 * @since 0.5
	 */

	private function get_failure_message ($number = null) {

		$options = get_option( $this->option_name );

		return $options[$number]['failure_message'];

	}

	/**
	 * @author James Lafferty
	 * @since 0.5
	 */

	private function get_success_message ($number = null) {

		$options = get_option( $this->option_name );

		return $options[$number]['success_message'];

	}

    public function mailchimp_js() {

            if ( is_active_widget(false, false, $this->id_base, true) ) {

                wp_enqueue_script('tf-mc-widget', TF_URL . '/assets/js/mailchimp-widget-min.js', array( 'jquery' ), TF_VERSION );

            }

    }

}

?>