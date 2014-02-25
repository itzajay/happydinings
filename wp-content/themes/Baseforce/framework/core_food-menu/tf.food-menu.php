<?php
/* ------------------- THEME FORCE ---------------------- */

require_once( TF_PATH . '/core_food-menu/tf.food-menu.shortcodes.php' );

/*
 * FOOD MENU FUNCTION (CUSTOM POST TYPE)
 */

// 1. Custom Post Type Registration (Menu Items)

function tf_create_foodmenu_postype() {

    $labels = array(
        'name' => __( 'Food Menu' ),
        'singular_name' => __( 'Food Menu' ),
        'add_new' => __( 'Add Menu Item' ),
        'add_new_item' => __( 'Add New Menu Item' ),
        'edit' => __( 'Edit' ),
        'edit_item' => __( 'Edit Menu Item' ),
        'new_item' => __( 'New Menu Item' ),
        'view' => __( 'View Menu Item' ),
        'view_item' => __( 'View Menu Item' ),
        'search_items' => __( 'Search Menu Items' ),
        'not_found' => __( 'No  Menu Items found' ),
        'not_found_in_trash' => __( 'No  Menu Items found in Trash' ),
        'parent' => __( 'Parent Menu Item' ),
    );

    $args = array(
        'label' => __('Food Menu'),
        'labels' => $labels,
        'public' => true,
        'can_export' => true,
        'show_ui' => true,
        '_builtin' => false,
        '_edit_link' => 'post.php?post=%d',
        'capability_type' => 'post',
        'menu_icon' => get_bloginfo( 'template_url' ).'/framework/assets/images/food_16.png',
        'hierarchical' => false,
        'rewrite' => array( "slug" => "food-menu"),
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
			'custom-fields',
			'page-attributes',
			'tf_quick_add'
		),
        'show_in_nav_menus' => false
    );

	register_post_type( 'tf_foodmenu', $args);

}

add_action( 'init', 'tf_create_foodmenu_postype' );

// 2. Custom Taxonomy Registration (Menu Types)

function tf_create_foodmenucategory_taxonomy() {

    $labels = array(
        'name' => __( 'Menu Categories' ),
        'singular_name' => __( 'Food Menu Category' ),
        'search_items' =>  __( 'Search Food Menu Categories' ),
        'popular_items' => __( 'Popular Food Menu Categories' ),
        'all_items' => __( 'All Food Menu Categories' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Edit Food Menu Category' ),
        'update_item' => __( 'Update Food Menu Category' ),
        'add_new_item' => __( 'Add New Food Menu Category' ),
        'new_item_name' => __( 'New Food Menu Category Name' ),
    );

    register_taxonomy('tf_foodmenucat', 'tf_foodmenu', array(
        'label' => __('Menu Category'),
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'menus' ),
    ));
}

add_action( 'init', 'tf_create_foodmenucategory_taxonomy', 0 );


// register custom foodmenu post type
function tf_create_categorybox_posttype() {
    $labels = array(
        'name' => __( 'Category Box' ),
        'singular_name' => __( 'Category Box' ),
        'add_new' => __( 'Add Category Box' ),
        'add_new_item' => __( 'Add New Category Box' ),
        'edit' => __( 'Edit' ),
        'edit_item' => __( 'Edit Category Box' ),
        'new_item' => __( 'New Category Box' ),
        'view' => __( 'View Category Box' ),
        'view_item' => __( 'View Category Box' ),
        'search_items' => __( 'Search Category Boxes' ),
        'not_found' => __( 'No  Category Boxes found' ),
        'not_found_in_trash' => __( 'No  Category Boxes found in Trash' ),
        'parent' => __( 'Parent Menu Item' ),
    );

    $args = array(
        'label' => __('Food Menu'),
        'labels' => $labels,
        'public' => false,
        'can_export' => true,
        '_builtin' => false,
        '_edit_link' => 'post.php?post=%d',
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array( "slug" => "category-box" ),
        'supports' => array(
			'title',
			'editor',
			'thumbnail',
			'custom-fields',
			'page-attributes'
		),
        'show_in_nav_menus' => false
    );

    register_post_type( 'tf_categorybox', $args);
}

add_action( 'init', 'tf_create_categorybox_posttype' );

function tf_create_foodmenutype_taxonomy() {

    $labels = array(
        'name' => __( 'Menu Types' ),
        'singular_name' => __( 'Food Menu Type' ),
        'search_items' =>  __( 'Search Food Menu Types' ),
        'popular_items' => __( 'Popular Food Menu Types' ),
        'all_items' => __( 'All Food Menu Types' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Edit Food Menu Type' ),
        'update_item' => __( 'Update Food Menu Type' ),
        'add_new_item' => __( 'Add New Food Menu Type' ),
        'new_item_name' => __( 'New Food Menu Type' ),
    );

    register_taxonomy('tf_menutype', 'tf_categorybox', array(
        'label' => __('Menu Type'),
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'menutypes' ),
    ));
}

add_action( 'init', 'tf_create_foodmenutype_taxonomy', 0 );

// 2.5 Add a food menu link

function tf_add_foodmenu_link() {
    // add the custom link
    add_menu_page( 
        'Food Menu', 
        'Food Menu', 
        'read', 
        'foodmenu', 
        'render_foodmenu', 
        get_bloginfo( 'template_url' ).'/framework/assets/images/food_16.png',
        26 
    );
}

add_action( 'admin_menu', 'tf_add_foodmenu_link' );

function render_foodmenu() {
	$taxonomy = 'tf_menutype';
	$design_array = array(
		'full' => 'Full',
		'list' => 'List',
		'short' => 'Short'
	);
    
    $menus = get_terms( $taxonomy, array('orderby' => 'id', 'hide_empty' => 0));
	
	$categories = get_terms( 'tf_foodmenucat', array('orderby' => 'id', 'hide_empty' => 0));
    
    include( 'tfh_foodmenu.php' );
}

function show_save_error_message() {
	showMessage("The menu could not be saved. Please try again with a different name.", true);
}

function foodmenu_post_handler() {
	if(isset($_POST['delete_food_menu'])){
		wp_delete_term($_POST['menu-id'],'tf_menutype');
		wp_redirect( admin_url() . 'admin.php?page=foodmenu' );
	}
	if(!empty($_POST['menu-name']) && isset($_POST['create-menu'])){
		if($_POST['menu-id'] == -1){
			$term = wp_insert_term($_POST['menu-name'],'tf_menutype');
        }else{
			$term = wp_update_term($_POST['menu-id'],'tf_menutype',array('name' => $_POST['menu-name']));
		}
		if (empty($term->errors)) {
			wp_redirect( admin_url() . 'admin.php?page=foodmenu&menu-id=' . $term['term_id'] );
		} else {
			// show error message
			add_action('admin_notices', 'show_save_error_message');
		}
	}
    
    if(isset($_POST['update_food-cat'])){ save_category_block(); }
}

add_action( 'admin_init', 'foodmenu_post_handler' );

function save_category_block(){
	if(!empty($_POST)){
		$data = $_POST;
		$infos = array();
		foreach($data['val'] as $field){
			$infos[$field['name']] = $field['value'];
		}
    }

    // the selected or created food category
    $foodCategoryTerm = array();
    
    // create a new category if 'create-food-cat' is passed
    if ( !empty($infos['create-food-cat']) ) {
    	$newTerm = wp_insert_term(
    		$infos['create-food-cat'],
    		'tf_foodmenucat'
    	);
    	$foodCategoryTerm = get_term($newTerm['term_id'], 'tf_foodmenucat');
    } else {
    	// $foodCategoryTerm = get_term_by('slug', $infos['add-food-cat'], 'tf_foodmenucat');
    	$foodCategoryTerm = get_term($infos['add-food-cat'], 'tf_foodmenucat');
    }

    // debug($foodCategoryTerm);
    // exit;

    // create the post array
    $post = array(
    	'comment_status' => 'closed',
    	'ping_status' => 'closed',
    	'post_author' => $current_user->ID,
    	'post_content' => "",
    	'post_status' => 'publish',
    	'post_title' => 'tf_categorybox',
    	'post_type' => 'tf_categorybox',
    );

    $post_id = wp_insert_post($post, true);

    if ( $post_id ) {
    	// set the post term
    	wp_set_post_terms( $post_id, $infos['menu-id'], 'tf_menutype' );

    	// set meta values
    	update_post_meta( $post_id, 'block_design', $infos['add-cat-design'] );
    	update_post_meta( $post_id, 'display_order', 1 );
    	update_post_meta( $post_id, 'show_header', 1 );
    	update_post_meta( $post_id, 'food_category_id', $foodCategoryTerm->term_id );

    	// custom_fields var for view
    	$custom_fields = get_post_custom( $post_id );
    	$categories = get_terms( 'tf_foodmenucat', array('orderby' => 'id', 'hide_empty' => 0));
    	$menu_id = $infos['menu-id'];
    	die(include('category_block.php'));
    }

    /*if(!empty($infos['create-food-cat'])){
		$term_id = wp_insert_term(
			$infos['create-food-cat'],
			'tf_foodmenucat'
		);
		$current_user = wp_get_current_user();
		$post = array(
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_author' => $current_user->ID,
			'post_content' => "",
			'post_status' => 'publish',
			'post_title' => $infos['create-food-cat'],
			'post_type' => 'tf_categorybox',
			'tax_input' => array(
				'tf_menutype' => $infos['menu-id']
			)
		);
		$post_id = wp_insert_post($post);
		// wp_update_term(
		// 	$term_id['term_id'],
		// 	'tf_foodmenucat',
		// 	array(
		// 		'description' => $post_id 
		// 	)
		// );
		update_post_meta($post_id,'block_design',$infos['add-cat-design']);
		update_post_meta($post_id,'display_order',1);
		update_post_meta($post_id,'show_header',1);
		update_post_meta($post_id,'food_category_id',$term_id['term_id']);
		$custom_fields = get_post_custom($post_id);
		$categories = get_terms('tf_foodmenucat',array('orderby'=>'id','hide_empty'=>0));
		die(json_encode(include('category_block.php')));
	}else{
		$category_id = $infos['add-food-cat'];
		$category_term = get_term($category_id,'tf_foodmenucat');
		$post_id = $category_term->description;
		wp_set_post_terms($post_id,$infos['menu-id'],'tf_menutype',true);
		update_post_meta($post_id,'block_design',$infos['add-cat-design']);
		$custom_fields = get_post_custom($post_id);
		$categories = get_terms('tf_foodmenucat',array('orderby'=>'id','hide_empty'=>0));
		die(json_encode(include('category_block.php')));
	}*/
}
add_action('wp_ajax_save_category_block','save_category_block');

function food_item_form(){
	if(isset($_GET['id'])){
		$post = get_post($_GET['id']);
		$image = wp_get_attachment_thumb_url(get_post_thumbnail_id($_GET['id']));
	}
	$menu_id = $_GET['menu_id'];
	die(include('food-item-form.php'));
}
add_action('wp_ajax_food_item_form','food_item_form');

function save_food_item(){
	if($_POST){
		if(empty($_POST['id'])){
			$args = array(
				'category_id'=> $_POST['category_id'],
				'name' => ($_POST['foodmenu_item_name'])? $_POST['foodmenu_item_name'] : "Example Item 1",
				'content' => ($_POST['foodmenu_item_description'])? $_POST['foodmenu_item_description'] : "Just another item.."
			);
			$image_id = save_item_image($_FILES);
			$new_food_id = save_custom_post_data(null,null,$args);
			$is_set_image = set_post_thumbnail($new_food_id,$image_id);
			$image_id = get_post_thumbnail_id($new_food_id);
			foreach($_POST['tf_foodmenu_item_option_name'] as $key => $size){
				if(!empty($size) && !empty($_POST['tf_foodmenu_item_option_price'][$key])){
					create_custom_field(
						$new_food_id,
						'food_menu_item_size_'.$key,
						$size
					);
					create_custom_field(
						$new_food_id,
						'food_menu_item_price_'.$key,
						$_POST['tf_foodmenu_item_option_price'][$key]
					);
					create_custom_field(
						$new_food_id,
						'display_order',
						1
					);
				}
			}
			$post = get_post($new_food_id,ARRAY_A);
			$custom_fields = get_post_custom($post['ID']);
			$custom_values = array();
			for($i = 0;$i < sizeof($custom_fields)/2; $i++){
				$custom_values['size_'.$i] = $custom_fields['food_menu_item_size_'.$i][0];
				$custom_values['price_'.$i] = $custom_fields['food_menu_item_price_'.$i][0];
			}
			$category_food = wp_get_post_terms($new_food_id,'tf_foodmenucat');
			$return_val = array(
				'id' => $post['ID'],
				'title' => $post['post_title'],
				'content' => $post['post_content'],
				'parent_id' => $category_food[0]->term_id,
				'custom_fields' => $custom_values,
				'image' => wp_get_attachment_thumb_url($image_id)
			);
			$infos['menu-id'] = $_POST['menu_id'];
			$categories = get_terms('tf_foodmenucat',array('orderby'=>'id','hide_empty'=>0));
			//die(json_encode(include('category_block.php')));
		}else{
			$my_post = array(
				'ID' => $_POST['id'],
				'post_content' => $_POST['foodmenu_item_description'],
				'post_title' => $_POST['foodmenu_item_name']
			);
			if($_POST['delete-item-food-image'] == 1){
				wp_delete_attachment(get_post_thumbnail_id($_POST['id']));
			}
			if(!empty($_FILES)){
				$image_id = save_item_image($_FILES);
				$is_set_image = set_post_thumbnail($_POST['id'],$image_id);
			}else{
				$image_id = get_post_thumbnail_id($_POST['id']);
			}
			wp_update_post($my_post);
			$post = get_post($_POST['id'],ARRAY_A);
			foreach($_POST['tf_foodmenu_item_option_name'] as $key => $size){
				if(!empty($size) && !empty($_POST['tf_foodmenu_item_option_price'][$key])){
					update_post_meta(
						$_POST['id'],
						'food_menu_item_size_'.$key,
						$size
					);
					update_post_meta(
						$_POST['id'],
						'food_menu_item_price_'.$key,
						$_POST['tf_foodmenu_item_option_price'][$key]
					);
				}else{
					delete_post_meta(
						$_POST['id'],
						'food_menu_item_size_'.$key,
						$size
					);
					delete_post_meta(
						$_POST['id'],
						'food_menu_item_price_'.$key,
						$_POST['tf_foodmenu_item_option_price'][$key]
					);
				}
			}
			$custom_fields = get_post_custom($post['ID']);
			$custom_values = array();
			for($i = 0;$i < sizeof($custom_fields)/2; $i++){
				$custom_values['size_'.$i] = $custom_fields['food_menu_item_size_'.$i][0];
				$custom_values['price_'.$i] = $custom_fields['food_menu_item_price_'.$i][0];
			}
			$return_val = array(
				'id' => $post['ID'],
				'title' => $post['post_title'],
				'content' => $post['post_content'],
				'parent_id' => $post['post_parent'],
				'custom_fields' => $custom_values,
				'image' => wp_get_attachment_thumb_url($image_id),
				'edit' => 1
			);
			$infos['menu-id'] = $_POST['menu_id'];
			$categories = get_terms('tf_foodmenucat',array('orderby'=>'id','hide_empty'=>0));
			//die(json_encode(include('category_block.php')));
		}
		$menu_id = $infos['menu-id'];
		die(include('category_block.php'));
	}
}
add_action('wp_ajax_save_food_item','save_food_item');

function create_custom_field($post_id,$key,$value){
	if(!empty($post_id) && !empty($key) && !empty($value)){
		add_post_meta($post_id,$key,$value);
	}
}

function save_custom_post_data($term_id = null,$cat = null,$args = null){
	$current_user = wp_get_current_user();
	if(!empty($cat)){
		$post = array(
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_author' => $current_user->ID,
			'post_content' => "",
			'post_status' => 'publish',
			'post_title' => $args['name'],
			'post_type' => 'tf_foodmenu',
			'tax_input' => array(
				'tf_foodmenucat' => array(($term_id['category_food'])? $term_id['category_food'] : $cat)
			)
		);
	}elseif(!empty($args['category_id'])){
		$post = array(
			'post_author' => $current_user->ID,
			'post_content' => $args['content'],
			'post_status' => 'publish',
			'post_title' => $args['name'],
			'post_type' => 'tf_foodmenu',
			'tax_input' => array(
				'tf_foodmenucat' => $args['category_id']
			)
		);
	}
	return wp_insert_post($post);
}

function save_item_image($file_image){
	// Get the type of the uploaded file. This is returned as "type/extension"
	$arr_file_type = wp_check_filetype(basename($file_image['foodmenu_item_image']['name']));
	$uploaded_file_type = $arr_file_type['type'];
	// Options array for the wp_handle_upload function. 'test_upload' => false
	$upload_overrides = array( 'test_form' => false ); 

	// Handle the upload using WP's wp_handle_upload function. Takes the posted file and an options array
	$uploaded_file = wp_handle_upload($file_image['foodmenu_item_image'], $upload_overrides);

	// If the wp_handle_upload call returned a local path for the image
	if(isset($uploaded_file['file'])) {
		// The wp_insert_attachment function needs the literal system path, which was passed back from wp_handle_upload
		$file_name_and_location = $uploaded_file['file'];
		

		// Generate a title for the image that'll be used in the media library
		$file_title_for_media_library = 'food-item';

		// Set up options array to add this file as an attachment
		$attachment = array(
			'guid' => $file_image['foodmenu_item_image']['name'],
			'post_mime_type' => $uploaded_file_type,
			'post_title' => $file_image['foodmenu_item_image']['name'],
			'post_content' => '',
			'post_status' => 'inherit'
		);

		// Run the wp_insert_attachment function. This adds the file to the media library and generates the thumbnails. If you wanted to attch this image to a post, you could pass the post id as a third param and it'd magically happen.
		$attach_id = wp_insert_attachment($attachment,$file_name_and_location);
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file_name_and_location );
		wp_update_attachment_metadata($attach_id,  $attach_data);
		return $attach_id;
	}
}

function update_item_display_order(){
	if($_POST){
		$index = 1;
		foreach($_POST['value'] as $id){
			update_post_meta($id, 'display_order', $index++);
		}
	}
}
add_action('wp_ajax_update_item_display_order','update_item_display_order');

function update_display_order(){
	if($_POST){
		$array = array();
		parse_str($_POST['value'],$array);
		$index = 1;
		foreach($array['foodmenuv2_cat'] as $key => $id){
			update_post_meta($id, 'display_order', $index++);
		}
	}
}
add_action('wp_ajax_update_display_order','update_display_order');

function delete_category_block(){
	if($_POST['id']){
		$post = get_post($_POST['id']);
		$custom_fields = get_post_custom($post->ID);
		$category_id = $custom_fields['food_category_id'];
		foreach($custom_fields as $key => $field){
			delete_post_meta($post->ID,$key);
		}
		$args = array(
			'post_parent' => $post->ID,
			'post_type' => 'tf_categorybox'
		);
		
		$get_children_array = get_children($args,ARRAY_A);
		$post_array = array_values($get_children_array);
		foreach($post_array as $post_value){
			wp_delete_post($post_value['ID']);
		}
		$sreturn_val = wp_delete_post($post->ID);
		return json_encode($return_val);
	}
}
add_action('wp_ajax_delete_category_block','delete_category_block');

function delete_post(){
	if($_POST){
		$delete = wp_delete_post($_POST['id']);
		die(json_encode($delete));
	}
}
add_action('wp_ajax_delete_post', 'delete_post');

function update_food_category(){
	if($_POST){
		wp_update_term(
			$_POST['category_id'],
			'tf_foodmenucat',
			array(
				'name' => $_POST['category_name']
			)
		);
		$category = get_term($_POST['category_id'],'tf_foodmenucat');
		$category_block_id = $category->description;
		$my_post = array();
		$my_post['ID'] = $category_block_id;
		$my_post['title'] = $_POST['category_name'];
		wp_update_post( $my_post );
		die($_POST['category_name']);
	}
}
add_action('wp_ajax_update_food_category', 'update_food_category');

function update_food_category_block(){
	if($_POST){
		// $category = get_term($_POST['category_block_id'],'tf_foodmenucat');
		// die(print_r($_POST));
		$category_block_id = $_POST['category_block_id'];
		update_post_meta($category_block_id, 'block_design', $_POST['design_block']);
		$show_header = ($_POST['show_header'] == 'on') ? 1 : 0;
		update_post_meta($category_block_id, 'show_header', $show_header);
		update_post_meta($category_block_id, 'food_category_id', $_POST['category_id'] );
		$custom_fields = get_post_custom($post['ID']);
		$infos['menu-id'] = $_POST['menu_id'];
		$categories = get_terms('tf_foodmenucat',array('orderby'=>'id','hide_empty'=>0));
		$menu_id = $_POST['menu_id'];
		die(include('category_block.php'));
	}
}
add_action('wp_ajax_update_food_category_block', 'update_food_category_block');

// 3. Show Columns

add_filter( "manage_edit-tf_foodmenu_columns", "tf_foodmenu_edit_columns" );
add_action( "manage_posts_custom_column", "tf_foodmenu_custom_columns" );

function tf_foodmenu_edit_columns( $columns ) {

 	$columns = array(
 		'cb' 				=> 	'<input type="checkbox" />',
 		'tf_col_menu_thumb' => '',
 		'title' 			=> __( 'Item' ),
 		'tf_col_menu_cat'	=> __( 'Section' ),
 		'tf_col_menu_size' 	=> __( 'Size(s)' ),
 		'tf_col_menu_price' => __( 'Price(s)' ),
        'tf_col_menu_desc' 	=> __( 'Description' )
 	);
 	
 	return $columns;
}

function tf_foodmenu_custom_columns( $column ) {
	global $post;
	$custom = get_post_custom();
	switch ( $column ) {
		case "tf_col_menu_id":

				echo $post->ID;
				break;

		case "tf_col_menu_cat":

				$menucats = get_the_terms($post->ID, "tf_foodmenucat");
				$menucats_html = array();
				if ( $menucats ) {
				foreach ($menucats as $menucat)
				        array_push($menucats_html, $menucat->name);
				
				echo implode($menucats_html, ", ");
				} else {
				        _e('None', 'themeforce');;
				}
				break;

		case "tf_col_menu_desc":

				add_filter( 'excerpt_length', '_tf_food_menu_excerpt_length' );
		       	the_excerpt();
		       	// FIX: tf_food_menu_inline_date( $post->ID );
		       	break;

		case "tf_col_menu_thumb":
		       
				echo '<div class="table-thumb">';
				the_post_thumbnail( 'width=60&height=60&crop=1' );
				echo '</div>';
				break;

		case "tf_col_menu_size":

				$size1 = $custom["tf_menu_size1"][0];
				$size2 = $custom["tf_menu_size2"][0];
				$size3 = $custom["tf_menu_size3"][0];
				$output = '';
				if ($size1 != '') { echo $size1; }
				if ($size2 != '') { echo '<br />'; echo $size2; }
				if ($size3 != '') { echo '<br />'; echo $size3; }
				break;

		case "tf_col_menu_price":

				$price1 = $custom["tf_menu_price1"][0];
				$price2 = $custom["tf_menu_price2"][0];
				$price3 = $custom["tf_menu_price3"][0];
				
				$output = '';
				if ($price1 != '') { echo get_option( 'tf_currency_symbol' ).' '.$price1; }
				if ($price2 != '') { echo '<br />'; echo get_option( 'tf_currency_symbol' ).' '.$price2; }
				if ($price3 != '') { echo '<br />'; echo get_option( 'tf_currency_symbol' ).' '.$price3; }
				break;
	}
}

// 4. Show Meta-Box

function tf_foodmenu_create_meta_boxes() {
    add_meta_box( 'tf_foodmenu_meta', __('Food Menu', 'themeforce'), 'tf_foodmenu_meta', 'tf_foodmenu' );
}
add_action( 'admin_init', 'tf_foodmenu_create_meta_boxes' );

function tf_foodmenu_meta() {

    global $post;
    $custom 	= get_post_custom( $post->ID );
    $metasize1 	= $custom["tf_menu_size1"][0];
    $metasize2 	= $custom["tf_menu_size2"][0];
    $metasize3 	= $custom["tf_menu_size3"][0];
    $metaprice1 = $custom["tf_menu_price1"][0];
    $metaprice2 = $custom["tf_menu_price2"][0];
    $metaprice3 = $custom["tf_menu_price3"][0];

    // - security -

    echo '<input type="hidden" name="tf-foodmenu-nonce" id="tf-foodmenu-nonce" value="' .
    wp_create_nonce( 'tf-foodmenu-nonce' ) . '" />';

    // - output -

    ?>

    <div class="tf-meta">
        <ul>
            <li><label>Size 1</label><input name="tf_menu_size1" value="<?php echo $metasize1; ?>" /><em><?php _e('All Sizes are Optional', 'themeforce'); ?></em></li>
            <li><label>Size 2</label><input name="tf_menu_size2" value="<?php echo $metasize2; ?>" /></li>
            <li><label>Size 3</label><input name="tf_menu_size3" value="<?php echo $metasize3; ?>" /></li>
            <li><label>Price 1</label><input name="tf_menu_price1" value="<?php echo $metaprice1; ?>" /><em><?php _e('Use the decimal format you want display (i.e. 1, 1.9 , 1.99)', 'themeforce'); ?></em></li>
            <li><label>Price 2</label><input name="tf_menu_price2" value="<?php echo $metaprice2; ?>" /></li>
            <li><label>Price 3</label><input name="tf_menu_price3" value="<?php echo $metaprice3; ?>" /></li>
        </ul>
    </div>

    <?php
}

// 5. Save Data
function save_tf_menuitem() {

    global $post;

    // - check nonce & permissions

    if ( !wp_verify_nonce( $_POST['tf-foodmenu-nonce'], 'tf-foodmenu-nonce' )) {
        return;
    }

    if ( !current_user_can( 'edit_post', $post->ID ) )
        return;

    // - update post
    if ( ! isset( $_POST["tf_menu_size1"] ) )
	    return;
    
    update_post_meta( $post->ID, "tf_menu_size1", $_POST["tf_menu_size1"] );

    if ( ! isset( $_POST["tf_menu_size2"] ) )
	    return;
    
    update_post_meta( $post->ID, "tf_menu_size2", $_POST["tf_menu_size2"] );

    if ( ! isset( $_POST["tf_menu_size1"] ) )
	    return;

    update_post_meta( $post->ID, "tf_menu_size3", $_POST["tf_menu_size3"] );

    if ( ! isset( $_POST["tf_menu_price1"] ) )
	    return;

    update_post_meta( $post->ID, "tf_menu_price1", $_POST["tf_menu_price1"] );

    if ( ! isset( $_POST["tf_menu_price2"] ) )
	    return $post;

    update_post_meta( $post->ID, "tf_menu_price2", $_POST["tf_menu_price2"] );

    if ( ! isset($_POST["tf_menu_price1"] ) )
	    return $post;

    update_post_meta( $post->ID, "tf_menu_price3", $_POST["tf_menu_price3"]  );
}
add_action( 'save_post', 'save_tf_menuitem' );
// 6. Customize Update Messages

function tf_menu_updated_messages( $messages ) {
	global $post, $post_ID;
	
	$messages['tf_foodmenu'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Menu item updated. <a href="%s">View item</a>'), esc_url( get_permalink( $post_ID ) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Menu item updated.'),
		5 => isset( $_GET['revision'] ) ? sprintf( __('Menu item restored to revision from %s'), wp_post_revision_title( ( int ) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Menu item published. <a href="%s">View menu item</a>'), esc_url( get_permalink( $post_ID ) ) ),
		7 => __('Menu saved.'),
		8 => sprintf( __('Menu item submitted. <a target="_blank" href="%s">Preview menu item</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
		9 => sprintf( __('Menu item scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview menu item</a>'),
		  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
		10 => sprintf( __('Menu item draft updated. <a target="_blank" href="%s">Preview menu item</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'tf_menu_updated_messages' );

// 7. Create Initial Terms

function tf_create_foodmenu_tax() {

    if ( get_option('tf_added_default_food_terms' ) != 'updated' ) {
        
        // Create the terms
        if ( term_exists( 'Appetizers', 'tf_foodmenucat' ) == false ) {
            wp_insert_term( 'Appetizers', 'tf_foodmenucat' );
		}
		
        if ( term_exists( 'Main Courses', 'tf_foodmenucat' ) == false ) {
        
            wp_insert_term( 'Main Courses', 'tf_foodmenucat' );
		}
        
        if ( term_exists( 'Desserts', 'tf_foodmenucat' ) == false ) {
			wp_insert_term( 'Desserts', 'tf_foodmenucat' );
		}
		
		// Register update so that it's not repeated
		update_option( 'tf_added_default_food_terms', 'updated' );
    }
}
add_action( 'init', 'tf_create_foodmenu_tax', 10 );

function tf_food_menu_restrict_manage_posts() {
	
	if( empty( $_GET['post_type'] ) || $_GET['post_type'] !== 'tf_foodmenu' )
		return;
	?>
	<style type="text/css">
		select[name="m"] { display: none; }
	</style>
	
	<select name="term">
		<option value="">Section</option>
		<?php foreach( get_terms( 'tf_foodmenucat' ) as $cat ) : ?>
			<option <?php selected( !empty( $_GET['term'] ) && $_GET['term'] == $cat->slug, true ) ?> value="<?php echo $cat->slug ?>"><?php echo $cat->name ?></option>
		<?php endforeach; ?>
	</select>
	<input name="taxonomy" value="tf_foodmenucat" type="hidden" />
	<?php

}
add_action( 'restrict_manage_posts', 'tf_food_menu_restrict_manage_posts' );


/**
 * Gets the varients of the food item (size and price).
 * 
 * @param int $post_id
 * @return array
 */
function tf_food_menu_get_food_varients( $post_id ) {

	$custom 	= get_post_custom( $post_id );
    $metasize1 	= $custom["tf_menu_size1"][0];
    $metasize2 	= $custom["tf_menu_size2"][0];
    $metasize3 	= $custom["tf_menu_size3"][0];
    $metaprice1 = $custom["tf_menu_price1"][0];
    $metaprice2 = $custom["tf_menu_price2"][0];
    $metaprice3 = $custom["tf_menu_price3"][0];
    
    $varients = array();
    
    if ( $metasize1 || $metaprice1 )
    	$varients[] = array( 'size' => $metasize1, 'price' => $metaprice1 );

    if ( $metasize2 || $metaprice2 )
    	$varients[] = array( 'size' => $metasize2, 'price' => $metaprice2 );
    
    if ( $metasize3 || $metaprice3 )
    	$varients[] = array( 'size' => $metasize3, 'price' => $metaprice3 );
    
    return $varients;
}

function tf_food_menu_update_food_varients( $post_id, $varients ) {
	
	update_post_meta( $post_id, 'tf_menu_size1', $varients[0]['size'] );
	update_post_meta( $post_id, 'tf_menu_size2', $varients[1]['size'] );
	update_post_meta( $post_id, 'tf_menu_size3', $varients[2]['size'] );
	update_post_meta( $post_id, 'tf_menu_price1', $varients[0]['price'] );
	update_post_meta( $post_id, 'tf_menu_price2', $varients[1]['price'] );
	update_post_meta( $post_id, 'tf_menu_price3', $varients[2]['price'] );			
}

function _tf_food_menu_excerpt_length() {
	return 7;
}
function themeforce_food_options_scripts($hook) {
	if($hook == "toplevel_page_foodmenu"){
		wp_enqueue_script('food-script', TF_URL . '/assets/js/food-script.js', array( 'jquery'), TF_VERSION);
		wp_enqueue_script('fancybox-script', TF_URL . '/assets/js/jquery.fancybox.js', array( 'jquery'), TF_VERSION);
		wp_enqueue_script('ajax-form', TF_URL . '/assets/js/jquery.form.js', array( 'jquery'), TF_VERSION);
		wp_enqueue_script('ui-core', TF_URL . '/assets/js/jquery.ui.core.js', array( 'jquery'), TF_VERSION);
		wp_enqueue_script('ui-widget', TF_URL . '/assets/js/jquery.ui.widget.js', array( 'jquery'), TF_VERSION);
		wp_enqueue_script('ui-mouse', TF_URL . '/assets/js/jquery.ui.mouse.js', array( 'jquery'), TF_VERSION);
		wp_enqueue_script('ui-sortable', TF_URL . '/assets/js/jquery.ui.sortable.js', array( 'jquery'), TF_VERSION);
	}
}
add_action( 'admin_enqueue_scripts', 'themeforce_food_options_scripts' );

function themeforce_food_options_styles($hook) {
	if($hook == "toplevel_page_foodmenu"){
		wp_enqueue_style('sortable', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css', false);
		wp_enqueue_style('fancybox', TF_URL . '/assets/css/jquery.fancybox.css', array(), TF_VERSION );
		wp_enqueue_style('food-style', TF_URL . '/assets/css/food-style.css', array(), TF_VERSION );
	}
}
add_action( 'admin_enqueue_scripts', 'themeforce_food_options_styles' );