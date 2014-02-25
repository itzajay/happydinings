<?php
/* ------------------- THEME FORCE ---------------------- */

if ( tf_is_premium_active() ) {
    require_once( TF_PATH . '/core_events/tf.events.widget.php' );
    require_once( TF_PATH . '/core_events/tf.events.rss.php' );
}
require_once( TF_PATH . '/core_events/tf.events.ical.php' );
require_once( TF_PATH . '/core_events/tf.events.quick-edit.php' );
require_once( TF_PATH . '/core_events/tf.events.shortcodes.php' );

if ( ! tf_is_premium_active() ) {

    add_filter( 'admin_menu', function(){

        global $menu;

        foreach( $menu as $key => &$menu_item ) {

            if( in_array( $menu_item[0], array( 'Events' ) ) )
                unset( $menu[$key] );
        }

    }, 11 );
}

/*
 * EVENTS FUNCTION (CUSTOM POST TYPE)
 */

// 1. Custom Post Type Registration ( Events )

function create_event_postype() {

	$labels = array(
	    'name' => _x('Events', 'post type general name', 'themeforce'),
	    'singular_name' => _x('Event', 'post type singular name', 'themeforce'),
	    'add_new' => _x('Add New', 'events', 'themeforce'),
	    'add_new_item' => __('Add New Event', 'themeforce'),
	    'edit_item' => __('Edit Event', 'themeforce'),
	    'new_item' => __('New Event', 'themeforce'),
	    'view_item' => __('View Event', 'themeforce'),
	    'search_items' => __('Search Events', 'themeforce'),
	    'not_found' =>  __('No events found', 'themeforce'),
	    'not_found_in_trash' => __('No events found in Trash', 'themeforce'),
	    'parent_item_colon' => '',
	);
	
	$args = array(
	    'label' 		=> __( 'Events' ),
	    'labels' 		=> $labels,
	    'public' 		=> true,
	    'can_export' 	=> true,
	    'show_ui' 		=> true,
	    '_builtin' 		=> false,
	    'capability_type' => 'post',
	    'menu_icon' 	=> get_bloginfo( 'template_url' ).'/framework/assets/images/event_16.png',
	    'hierarchical' 	=> false,
	    'rewrite' 		=> array( 'slug' => 'events' ),
	    'supports'		=> array( 'title', 'thumbnail', 'excerpt', 'editor', 'tf_quick_add' ) ,
	    'show_in_nav_menus' => true,
	    'taxonomies' 	=> array( 'tf_eventcategory')
	);
	
	register_post_type( 'tf_events', $args);

}

add_action( 'init', 'create_event_postype' );

// 2. Custom Taxonomy Registration (Event Types)

function create_eventcategory_taxonomy() {

    $labels = array(
        'name' => __( 'Categories', 'themeforce'),
        'singular_name' => __( 'Category', 'themeforce'),
        'search_items' =>  __( 'Search Categories', 'themeforce' ),
        'popular_items' => __( 'Popular Categories', 'themeforce' ),
        'all_items' => __( 'All Categories', 'themeforce' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Edit Category', 'themeforce' ),
        'update_item' => __( 'Update Category', 'themeforce' ),
        'add_new_item' => __( 'Add New Category', 'themeforce' ),
        'new_item_name' => __( 'New Category Name', 'themeforce' ),
        'separate_items_with_commas' => __( 'Separate categories with commas', 'themeforce' ),
        'add_or_remove_items' => __( 'Add or remove categories', 'themeforce' ),
        'choose_from_most_used' => __( 'Choose from the most used categories', 'themeforce' ),
    );

    register_taxonomy('tf_eventcategory', 'tf_events', array(
        'label' => __('Event Category', 'themeforce'),
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'event-category', 'themeforce' ),
    ));

}

add_action( 'init', 'create_eventcategory_taxonomy', 0 );

// 3. Show Columns

add_filter ("manage_edit-tf_events_columns", "tf_events_edit_columns");
add_action ("manage_posts_custom_column", "tf_events_custom_columns");

function tf_events_edit_columns( $columns ) {

    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "tf_col_ev_thumb" => '',
        "tf_col_ev_date" => __( 'When', 'themeforce' ),
        "title" => __( 'Name', 'themeforce' ),
        "tf_col_ev_cat" => __( 'Category', 'themeforce' ),
        "tf_col_ev_desc" => __( 'Description', 'themeforce' )
        );

    return $columns;

}

function tf_events_custom_columns( $column ) {

    global $post;
    $custom = get_post_custom();
    switch ( $column )

        {
            case "tf_col_ev_cat":
                // - show taxonomy terms -
                $eventcats = get_the_terms($post->ID, "tf_eventcategory");
                $eventcats_html = array();
                if ( $eventcats ) {
                    foreach ($eventcats as $eventcat) {
                        $event = $eventcat->name;
                        echo '<span class="cat-default cat-' . strtolower($event) . '">' . $event . '</span>';
                        }
                } else {
                echo '';
                }
            break;
            case "tf_col_ev_date":
                
                // - show dates -
                
                $startd = $custom["tf_events_startdate"][0];
                $endd = $custom["tf_events_enddate"][0];
                $day = date("j", $startd);
                $month = date("M", $endd);
                $year = date("y", $endd);
                $weekday = date("l", $endd);
                
                // - show times -
                
                $startt = $custom["tf_events_startdate"][0];
                $endt = $custom["tf_events_enddate"][0];
                $time_format = get_option( 'time_format' );
                $starttime = date($time_format, $startt);
                $endtime = date($time_format, $endt);
                
                echo '<div class="ev_block"><div class="ev_day">' . $day . '</div></div><div class="ev_block"><div class="ev_monthyear"><strong>' . $month . '</strong> ' . $year . '</div><div class="ev_weekday tf-detail">'. $weekday . '</div><div class="tf-detail">' . $starttime . ' to ' . $endtime . '</div></div>';
                
            break;
            case "tf_col_ev_thumb":
                // - show thumb -
                echo '<div class="table-thumb">';
		            the_post_thumbnail( 'width=60&height=60&crop=1' );
                echo '</div>';
            break;
            case "tf_col_ev_desc";
                the_excerpt();
		       	tf_events_inline_data( $post->ID );
            break;

        }
}

// 4. Show Meta-Box

add_action( 'admin_init', 'tf_events_create' );

function tf_events_create() {
    add_meta_box('tf_events_meta', __( 'Events', 'themeforce' ), 'tf_events_meta', 'tf_events');
}

function tf_events_meta () {

    // - grab data -

    global $post;
    $custom = get_post_custom( $post->ID );
    $meta_sd = $custom["tf_events_startdate"][0];
    $meta_ed = $custom["tf_events_enddate"][0];
    $meta_st = $meta_sd;
    $meta_et = $meta_ed;

    // - grab wp time format -

    $date_format = get_option( 'date_format' ); // Not required in my code
    $time_format = get_option( 'time_format' );

    // - populate today if empty, 00:00 for time -

    if ($meta_sd == null) { $meta_sd = time(); $meta_ed = $meta_sd; $meta_st = 0; $meta_et = 0;}

    // - convert to pretty formats -

    $clean_sd = date("D, M d, Y", $meta_sd);
    $clean_ed = date("D, M d, Y", $meta_ed);
    $clean_st = date("H:i", $meta_st);
    $clean_et = date("H:i", $meta_et);

    // - security -

    echo '<input type="hidden" name="tf-events-nonce" id="tf-events-nonce" value="' .
    wp_create_nonce( 'tf-events-nonce' ) . '" />';

    // - output -

    ?>
    <div class="tf-meta">
        <ul>
            <li><label><?php _e('Start Date', 'themeforce'); ?></label><input name="tf_events_startdate" class="tfdate" value="<?php echo $clean_sd; ?>" /></li>
            <li><label><?php _e('Start Time', 'themeforce'); ?></label><input name="tf_events_starttime" value="<?php echo $clean_st; ?>" /><em><?php _e('Use 24h format (7pm = 19:00)', 'themeforce'); ?></em></li>
            <li><label><?php _e('End Date', 'themeforce'); ?></label><input name="tf_events_enddate" class="tfdate" value="<?php echo $clean_ed; ?>" /></li>
            <li><label><?php _e('End Time', 'themeforce'); ?></label><input name="tf_events_endtime" value="<?php echo $clean_et; ?>" /><em><?php _e('Use 24h format (7pm = 19:00)', 'themeforce'); ?></em></li>
        </ul>
    </div>
    <?php
}

// 5. Save Data

add_action ('save_post', 'save_tf_events');

function save_tf_events(){

    global $post;

    // - check nonce & permissions

    if ( !wp_verify_nonce( $_POST['tf-events-nonce'], 'tf-events-nonce' )) {
        return $post->ID;
    }

    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;

    // - convert back to unix & update post

    if ( !isset($_POST["tf_events_startdate"]) ):
        return $post;
        endif;
        $updatestartd = strtotime ( $_POST["tf_events_startdate"] . $_POST["tf_events_starttime"] );
        update_post_meta($post->ID, "tf_events_startdate", $updatestartd );

    if ( !isset($_POST["tf_events_enddate"]) ):
        return $post;
        endif;
        $updateendd = strtotime ( $_POST["tf_events_enddate"] . $_POST["tf_events_endtime"]);
        update_post_meta($post->ID, "tf_events_enddate", $updateendd );

}

// 6. Customize Update Messages

add_filter('post_updated_messages', 'events_updated_messages');

function events_updated_messages( $messages ) {

  global $post, $post_ID;

  $messages['tf_events'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Event updated. <a href="%s">View item</a>', 'themeforce'), esc_url( get_permalink( $post_ID ) ) ),
    2 => __('Custom field updated.', 'themeforce'),
    3 => __('Custom field deleted.', 'themeforce'),
    4 => __('Event updated.', 'themeforce'),
    /* translators: %s: date and time of the revision */
    5 => isset( $_GET['revision'] ) ? sprintf( __('Event restored to revision from %s', 'themeforce'), wp_post_revision_title( ( int ) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Event published. <a href="%s">View event</a>', 'themeforce'), esc_url( get_permalink( $post_ID ) ) ),
    7 => __('Event saved.'),
    8 => sprintf( __('Event submitted. <a target="_blank" href="%s">Preview event</a>', 'themeforce'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
    9 => sprintf( __('Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event</a>', 'themeforce'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i', 'themeforce' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
    10 => sprintf( __('Event draft updated. <a target="_blank" href="%s">Preview event</a>', 'themeforce'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
  );

  return $messages;
}

// 7. JS Datepicker UI

function events_styles() {
    global $post_type;
    if ( 'tf_events' != $post_type )
        return;
    wp_enqueue_style('ui-datepicker', TF_URL . '/assets/css/jquery-ui-1.8.9.custom.css', array(), TF_VERSION );
}

function events_scripts() {
    global $post_type;
//    if ( 'tf_events' != $post_type )
//    return;
    // wp_deregister_script( 'jquery-ui-core' ); TODO removed deregister, seems to have no conflicting issues.
    //wp_enqueue_script('jquery-ui', TF_URL . '/assets/js/jquery-ui-1.8.9.custom.min.js', array( 'jquery'), TF_VERSION );
    //wp_enqueue_script('ui-datepicker', TF_URL . '/assets/js/jquery.ui.datepicker.js', array(), TF_VERSION );
    wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('ui-datepicker-settings', TF_URL . '/assets/js/themeforce-admin.js', array( 'jquery'), TF_VERSION  );
}

if ( in_array( $GLOBALS['pagenow'], array( 'edit.php') ) ) {
    add_action( 'admin_print_styles', 'events_styles', 1000 );
    add_action( 'admin_print_scripts', 'events_scripts', 1000 );
}


// 8. Create New Terms

add_action( 'init', 'create_events_tax', 10 );

function create_events_tax() {

    if ( get_option('tf_added_default_events_terms' ) != 'updated') {
        // Create the terms
        if (term_exists('Featured', 'tf_eventcategory') == false ) {
            wp_insert_term(
              __('Featured', 'themeforce'),
              'tf_eventcategory'
              );
         }
        if (term_exists('Football', 'tf_eventcategory') == false ) {
            wp_insert_term(
              __('Football', 'themeforce'),
              'tf_eventcategory'
              );
         }
         if (term_exists('Quiz Night', 'tf_eventcategory') == false ) {
            wp_insert_term(
              __('Quiz Night', 'themeforce'),
              'tf_eventcategory'
              );
         }
         // Register update so that it's not repeated
         update_option( 'tf_added_default_events_terms', 'updated' );
    }
}

/**
 * Events have custom permalinks including their category.
 * 
 * @param string $permalink
 * @param object $post
 * @return string
 */
function tf_event_permalink( $permalink, $post, $leavename ) {
	
	if ( $post->post_type !== 'tf_events' || strpos( $permalink, '?' ) )
		return $permalink;
	
	$terms = wp_get_object_terms( $post->ID, 'tf_eventcategory' );
	$term_slug = null;
	
	foreach( $terms as $t ) {
		if ( $t->slug != 'featured' ) {
			$term_slug = $t->slug;
			break;
		}
	}
	
	if ( $term_slug === null )		
		$term_slug = 'uncategorized';
	
	return trailingslashit( get_bloginfo( 'url' ) ) . 'events/' . $term_slug . '/'. ( $leavename ? '%postname%' : $post->post_name  ) . '/';
}
add_filter( 'post_type_link', 'tf_event_permalink', 10, 3 );

class TFDateSelector {

	private $date;
	private $id;
	
	public function __construct( $id ) {
		$this->id = $id;
	}
	
	public function setDate( $date ) {
		
		if( $date )
			$this->date = (int) $date;
		else
			$this->date = time();
	}
	
	public function getDateFromPostData() { return $this->getDateFromData( $_POST ); }
	
	public function getDateFromPostDataDatePicker() { return $this->getDateFromDataDatePicker( $_POST ); }
	
	public function getDateFromDataDatePicker( $data ) {
	
		$date_from_post['day'] = $data[$this->id . '-day'];
		
		if ( $data[$this->id . '-ampm'] == 'am'  ){
			if( $data[$this->id . '-hour'] == '12' )
				$date_from_post['hour'] = '00';
			else
				$date_from_post['hour'] =  $data[$this->id . '-hour'];
		}else{
			if ( $data[$this->id . '-hour'] == '12' )
				$date_from_post['hour'] = $data[$this->id . '-hour'];
			else	
				$date_from_post['hour'] = (string) ( (int) $data[$this->id . '-hour'] + 12);
		}
		
		$date_from_post['minute'] =  $data[$this->id . '-minute'];
		
		$date_from_post['day'] = str_replace( '- ', '', $date_from_post['day'] );		
		$date = strtotime( $date_from_post['day'] .' '. $date_from_post['hour'] .':'. $date_from_post['minute'] . ':00'  );
			
		return $date;
	}
	
	public function getDateFromData( $data ) {
		
		$y = $data[ $this->id . '_aa' ];
		$m = $data[ $this->id . '_mm' ];
		$d = $data[ $this->id . '_jj' ];
		$h = $data[ $this->id . '_hh' ];
		$mn = $data[ $this->id . '_mn' ];
		$ss = $data[ $this->id . '_ss' ];
		
		$date = strtotime( "$y-$m-$d $h:$mn:$ss" );
		
		return $date;
	}
	
	public function getHTML() {
		
		global $post;
		$_post = $post;
		$post = (object) array( 'post_date_gmt' => date( 'Y-m-d H:i:s', $this->date ), 'post_date' =>  date( 'Y-m-d H:i:s', $this->date ), 'post_status' => 'publish' );
		
		ob_start();
		touch_time( 1, 1, 0, 1 );
		$data = ob_get_contents();
		ob_end_clean();
		
		$data = preg_replace( '/name="([^"]+)"/', 'name="' . $this->id . '_$1"', $data );
		
		$post = $_post;

		return $data;
	}
	
	public function getDatePickerHTML() {
		$minute_options = array( '00', '15', '30','45' );

		ob_start();  ?>
				
                <input type="text" name="<?php echo $this->id . '-day'; ?>" class="tf_ev_inputdate" id="<?php echo $this->id . '-day'; ?>" value="<?php echo date( 'D - j M - y', $this->date ) ?>"/>
                <div class="tf_ev_inputspacer"> @ </div>
                
                <select name="<?php echo $this->id . '-hour'; ?>"  class="tf_ev_inputtime" id="<?php echo $this->id . '-hour'; ?>">
                		<?php for( $hour = 1; $hour < 13; $hour++ ): ?>
                			<option value="<?php echo $hour?>" <?php if ( date( 'g', $this->date ) == $hour ) echo 'selected="selected"' ?>><?php echo $hour?></option>
                		<?php endfor; ?>
                </select>
     
                <div class="tf_ev_inputspacer"> : </div>
                
                <select name="<?php echo $this->id . '-minute'; ?>"  class="tf_ev_inputtime" id="<?php echo $this->id . '-minute'; ?>">
                		<?php foreach( $minute_options as $value ): ?>
                			<option value="<?php echo $value?>" <?php if ( date( 'i', $this->date ) == $value ) echo 'selected="selected"' ?>><?php echo $value?></option>
                		<?php endforeach; ?>
                </select>
                
                <select name="<?php echo $this->id . '-ampm'; ?>" class="tf_ev_inputtime" id="<?php echo $this->id . '-ampm'; ?>">
                	<option value="am" <?php if ( (int) date( 'H', $this->date ) < 13) echo 'selected="selected"'; ?>>am</option>
                	<option value="pm" <?php if ( (int) date( 'H', $this->date ) > 11) echo 'selected="selected"'; ?>>pm</option>
                </select>
                                   				
	     	<?php $data=ob_get_contents();
		
		ob_end_clean(); ?>
			
		<?php return $data;

	}
	
}

add_action( 'parse_query', 'set_events_order' );
function set_events_order( $obj){
	if ( ($obj->query_vars['post_type'] != 'tf_events') || ( $obj->query_vars['orderby'] ) )
		return;
		
	$obj->query_vars['order'] = 'desc';
	$obj->query_vars['orderby'] = 'meta_value_num';
	$obj->query_vars['meta_key'] ='tf_events_enddate';
	return $obj;

}

add_action( 'admin_footer', function( ) {

    $wp_list_table = _get_list_table('WP_Posts_List_Table');

    if ( ! $wp_list_table->has_items() )
        $wp_list_table->inline_edit();

} );