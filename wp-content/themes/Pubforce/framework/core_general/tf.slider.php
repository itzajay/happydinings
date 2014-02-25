<?php

/*
 * Slides (V2)
 * 
 * This is the second iteration of TF Slides, with the goal of creating a slider system that scales. Additional
 * slide types should be easy to add, manage and display.
 * 
 */


/**
 * Register Custom Post Type
 */
function create_slider_postype() {

    $args = array(
        'label' => __( 'Slider' ),
        'can_export' => true,
        'public' => true,
        'show_ui' => false,
        'show_in_nav_menus' => false,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array( "slug" => "food-menu" ),
        'supports'=> array('title', 'thumbnail', 'editor', 'custom-fields') ,
    );

	register_post_type( 'tf_slider', $args);

    tf_slider_legacy_support_update();
}

add_action( 'init', 'create_slider_postype' );

/**
 * Register Slider Page
 */
function themeforce_slider_addpage() {
    add_submenu_page('themes.php', __( 'Manage Slides', 'themeforce' ), __( 'Slides', 'themeforce' ), 'manage_options', 'tf_slider', 'tf_slider_page');
}

add_action( 'admin_menu', 'themeforce_slider_addpage' );

add_action( 'load-appearance_page_tf_slider', function() {
	
	TF_Upload_Image_Well::enqueue_scripts();
	
} );

// Load jQuery & relevant CSS

/**
 * Load Slider JS Scripts
 */
function themeforce_slider_scripts() {
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script( 'jquery-ui-draggable' );
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_script( 'tfslider', TF_URL . '/assets/js/themeforce-slider2.js', array( 'jquery'), TF_VERSION  );
}

add_action( 'admin_print_scripts-appearance_page_tf_slider', 'themeforce_slider_scripts' );

function themeforce_slider_options_scripts($hook) {
	if($hook == "appearance_page_tf_slider"){
		wp_enqueue_script('ui-core', TF_URL . '/assets/js/jquery.ui.core.js', array( 'jquery'), TF_VERSION);
		wp_enqueue_script('ui-widget', TF_URL . '/assets/js/jquery.ui.widget.js', array( 'jquery'), TF_VERSION);
		wp_enqueue_script('ui-mouse', TF_URL . '/assets/js/jquery.ui.mouse.js', array( 'jquery'), TF_VERSION);
		wp_enqueue_script('ui-sortable', TF_URL . '/assets/js/jquery.ui.sortable.js', array( 'jquery'), TF_VERSION);
	}
}
add_action( 'admin_enqueue_scripts', 'themeforce_slider_options_scripts' );

/**
 * Create Slider Page
 */
function tf_slider_page() {

    $slide_data = tf_get_slide_data(); ?>

    <div class="wrap tf-slides-page">
        <div class="tf-options-page">

        <?php screen_icon(); ?>
        <h2>Slides</h2>

        <form method="post" action="" name="" onsubmit="return checkformf( this );">

            <input type="hidden" name="tf_current_theme" id="tf_current_theme" value="<?php echo get_current_theme(); ?>" />

            <ul id="tf-slides-list">

                <?php foreach ( $slide_data as $slide ):

                    //Check to see if the slide is a template slide from the template database, if it is, use the direct url to the file as stored in meta
                    $slide_img_url = ( strpos( $slide->meta['tfslider_image'][0], 'http://template-' ) !== false ) ? $slide->meta['tfslider_image'][0] : $slide->thumbnail; ?>

                    <!--Display Slide-->
                    <li id="listItem_<?php echo $slide->ID; ?>" class="menu-item-handle slide-item">

                        <input type="hidden" name="slider[id][<?php echo $slide->ID; ?>]" value="<?php echo $slide->ID; ?>" />

                        <div class="slide-thumbnail" style="background-image:url( <?php echo ( $slide_img_url ) ? $slide_img_url : TF_URL . '/assets/images/slider-empty.jpg'; ?> )">

                            <!-- Controls -->
                            <div class="slide-itembar-control">
                                    <div class="slide-icon-move"></div>
                                    <div class="slide-icon-edit"></div>
                                    <div class="slide-icon-delete"></div>
                            </div>

                            <!-- Image Warning -->
                            <?php echo ( $slide->warning ) ? $slide->warning : ''; ?>

                            <div class="slide-change-image" ><a href="#" class="button"><?php echo __( 'Change image', 'themeforce' ); ?></a></div>

                            <div class="slide-image-well"><?php tf_output_edit_slide_image_well( $slide ); ?></div>

                            <div class="clear"></div>


                        </div>

                        <!-- Auto-Updating Preview -->
                        <!-- <input type="button" class="slide-switchimage tf-tiny" value="Switch Image" /> -->

                        <!-- Auto-Updating Preview -->
                        <div class="slide-content-preview">
                            <div class="preview-header"><?php echo $slide->header; ?></div>
                            <div class="preview-desc"><?php echo $slide->desc; ?></div>
                            <div class="preview-button"><?php echo $slide->button; ?></div>
                        </div>


                        <div class="slide-edit">

                            <div class="clear"></div>

                            <!-- Slide Type Selection -->
                            <div class="slide-type-selection">
                                <div class="label" style="float:left;line-height:33px;font-weight:bold;margin-right:10px;"><?php echo __( 'Slide Design' , 'themeforce' ); ?></div>
                                <?php tf_output_slide_types( $slide ); ?>
                            </div>

                            <div class="clear"></div>

                            <!-- Slide Type : Image -->
                            <div class="slide-edit-image">
                                <input class="slide-content-link" data-meta="link" type="text" placeholder="Slide Link URL" value="<?php echo $slide->link; ?>" />
                            </div>

                            <!-- Slide Type : Content -->
                            <div class="slide-edit-content">
                                <input class="slide-content-header" type="text" data-meta="header" placeholder="Title / Header" value="<?php echo $slide->header; ?>" />
                                <textarea class="slide-content-desc" data-meta="desc" rows="2"><?php echo $slide->desc; ?></textarea>
                                <input class="slide-content-button" data-meta="button" type="text" placeholder="Button Text" value="<?php echo $slide->button; ?>" />
                                <input class="slide-content-link" data-meta="link" type="text" placeholder="Button Link URL" value="<?php echo $slide->link; ?>" />
                            </div>

                        </div>

                        <!-- Slide Data : Order -->
                        <input type="hidden" name="slider[order][<?php echo $slide->ID; ?>]" value="<?php $slide->order; ?>" />

                    </li>

	    	<?php endforeach; ?>

        </ul>

        <input type="hidden" name="update_post" value="1"/>

        </form>

        <div style="clear:both"></div>

        <?php tf_output_new_slide_image_well(); ?>

        </div>
        <div style="clear:both"></div>
    </div>
    <?php
}

function tf_get_slide_data() {

    $postdata = array();

    $args = array(
        'post_type' => 'tf_slider',
        'post_status' => 'publish',
        'orderby' => 'meta_value_num',
        'meta_key' => '_tfslider_order',
        'order' => 'ASC',
        'posts_per_page' => 99
    );

    $slide_posts = get_posts( $args );

    foreach( $slide_posts as $key => $slide_post ) {

        $postdata[$key]->post = $slide_post;
        $postdata[$key]->ID = ( $slide_post->ID );

        $postdata[$key]->meta = get_post_custom( $postdata[$key]->ID );

        $postdata[$key]->image_id = $postdata[$key]->meta["_thumbnail_id"][0];
        $postdata[$key]->order = $postdata[$key]->meta["_tfslider_order"][0];
        $postdata[$key]->type = ( $postdata[$key]->meta["_tfslider_type"][0] ) ? $postdata[$key]->meta["_tfslider_type"][0] : 'image';
        $postdata[$key]->header = $postdata[$key]->meta["tfslider_header"][0];
        $postdata[$key]->desc = $postdata[$key]->meta["tfslider_desc"][0];
        $postdata[$key]->button = $postdata[$key]->meta["tfslider_button"][0];
        $postdata[$key]->link = $postdata[$key]->meta["tfslider_link"][0];

        $postdata[$key]->image = reset( wp_get_attachment_image_src( get_post_thumbnail_id( $postdata[$key]->ID ), 'full' ) );

        if ( get_current_theme() == 'Pubforce' )
            $postdata[$key]->thumbnail = wpthumb( $postdata[$key]->image, 'width=520&height=303&crop=1', false );
        else
            $postdata[$key]->thumbnail = wpthumb( $postdata[$key]->image, 'width=680&height=180&crop=1', false );

        // Warning Statement
        $postdata[$key]->image_size = getimagesize( $postdata[$key]->image );


        //We need a better framework to implement this because slides are not fixed width, there are different slide stlyes that use different widths
//        if ( $postdata[$key]->image_size && $postdata[$key]->image_size[0] < TF_SLIDERWIDTH && $postdata[$key]->image_size[1] < TF_SLIDERHEIGHT ) {
//
//            $postdata[$key]->warning = '<div class="tf-notice slide-notice">Oops, the <strong>dimensions</strong> of the image below aren\'t quite enough. Please ensure the image is at least <strong>' . TF_SLIDERWIDTH . 'px wide by ' . TF_SLIDERHEIGHT . 'px high.</strong></div>';
//
//        } else if ( $postdata[$key]->image_size  ) {
//
//            if ( $postdata[$key]->image_size[0] < TF_SLIDERWIDTH ) {
//                $postdata[$key]->warning = '<div class="tf-notice slide-notice">Oops, the <strong>width</strong> of the image below is too short. Please ensure the image is at least <strong>' . TF_SLIDERWIDTH . 'px wide.</strong></div>';
//            }
//
//            if ( $postdata[$key]->image_size[1] < TF_SLIDERHEIGHT ) {
//                $postdata[$key]->warning = '<div class="tf-notice slide-notice">Oops, the <strong>height</strong> of the image below is too short. Please ensure the image is at least <strong>' . TF_SLIDERHEIGHT . 'px high.</strong></div>';
//            }
//        }

    }

    return $postdata;
}

function tf_output_slide_types( $slide_data ) {

    // - slide types per theme
    switch( TF_THEME ) {

        case 'baseforce':
            $types = array('image','content');
            break;

        default:
            $types = array('image');
    }

    foreach ( $types as $item ) {

        if ( $item == $slide_data->type )
            $checked = 'checked="checked"';
        else
            $checked = '';

        echo '<input type="radio" name="slide-type-' . $slide_data->ID . '" id="' . $item . '-' . $slide_data->ID . '" value="' . $item . '" ' . $checked . '/>';
        echo '<label for="' . $item . '-' . $slide_data->ID . '"><img src="' . TF_URL . '/assets/images/slide-type-' . $item . '.png" /></label>';
    }
}

function tf_output_edit_slide_image_well( $slide ) {

    $value['allowed_extensions'] = ( ! empty( $value['allowed_extensions'] ) ) ? $value['allowed_extensions'] : array( 'jpeg', 'jpg', 'png', 'gif' );

    $drop_text = ! empty( $value['drop_text'] ) ? $value['drop_text'] : __( 'Drop image here', 'themeforce');

    $value['size'] = ( get_current_theme() == 'Pubforce' ) ? 'width=680&height=300&crop=1' : 'width=680&height=180&crop=1';

    $uploader = new TF_Upload_Image_Well( '_tf_slider_slide_image_well_' . $slide->ID, $slide->image_id,
        array(
            'size' => $value['size'],
            'drop_text' => $drop_text,
            'allowed_extensions' => $value['allowed_extensions'],
            'display_placeholder' => false,
            'html_fields' => array( array( 'class' => '', 'name' => 'post_id', 'value' => $slide->ID ) )
        )
    );
    $uploader->admin_print_styles();
    $uploader->html();
}

function tf_output_new_slide_image_well() {

    ?>
    <h3><?php echo __( 'Create New Slide', 'themeforce' ); ?></h3>
    <div class="tf-settings-wrap">
    	<form class="form-table" method="post" action="" name="" onsubmit="return checkformf( this );">

    	<table>
   			<tr>
			    <?php
			    // TODO Would be nice to have the 250x100 thumbnail replace the upload button once the image is ready
			    ?>
			    <th><label><?php echo __( 'Pick an Image', 'themeforce' ); ?><span class="required">*</span></label></th>
			    <td><?php
                    $well = new TF_Upload_Image_Well( 'tfslider_image', '', array( 'size' => 'width=420&height=200&crop=1' ) );
                    $well->html();
                    ?>
                </td>
			</tr>

		</table>

        <input type="hidden" name="new_post" value="1"/>
        <input style="margin-top:25px" type="submit" name="submitpost" class="tf-button tf-major right" value="<?php echo __( 'Create New Slide', 'themeforce' ); ?>"/>

    	</form>
    </div>
    <?php
}

// Update Slide Order

add_action( 'wp_ajax_tf_slides_update_order', function() {

    $post_id = (int) $_POST['postid'];
    $order_id = (int) $_POST['neworder'];

    update_post_meta( $post_id, '_tfslider_order', $order_id );

} );

// Update Slide Type

add_action( 'wp_ajax_tf_slides_update_type', function() {

    $post_id = $_POST['postid'];
    $type = $_POST['type'];

    update_post_meta( $post_id, '_tfslider_type', $type );

} );

// Update Slide Content

add_action( 'wp_ajax_tf_slides_update_content', function() {

    $post_id = (int) $_POST['postid'];
    $key = 'tfslider_' . $_POST['key'];
    $value = $_POST['value'];

    update_post_meta( $post_id, $key, $value );

    echo 'ok';

} );

// Delete Slide

add_action( 'wp_ajax_tf_slides_delete', function() {

    $post_id = (int) $_POST['postid'];

    wp_delete_post( $post_id, true );

} );

//Change Slide Image
add_action( 'wp_ajax_tf_slides_change_image', function() {

    $post_id = (int) $_POST['post_id'];
    $image_id = (int) $_POST['image_id'];

    $size = ( get_current_theme() == 'Pubforce' ) ? 'width=680&height=300&crop=1' : 'width=680&height=180&crop=1';

    $src = wp_get_attachment_image_src( $image_id, $size );

    update_post_meta( $post_id, '_thumbnail_id', $image_id );
    update_post_meta( $post_id, 'tfslider_image', $src['url'] );

    echo $src[0];

    exit;
} );

// Save New Slide
// Needs to be updated to Slides V2

function themeforce_slider_catch_submit() {

    // Grab POST Data

    if ( isset($_POST['new_post'] ) == '1') {
        $post_title = 'Slide'; // New - Static as one field is always required between post title & content. This field will always be hidden now.

        $imageurl = reset( wp_get_attachment_image_src( $_POST['tfslider_image'], 'large' ) );
        $imageid = (int) $_POST['tfslider_image'];

        if ( !$imageurl ) {$imageurl = TF_URL . '/assets/images/slider-empty.jpg'; }
        $link = $_POST['tfslider_link'];
        $button = $_POST['tfslider_button'];

        $new_post = array(
              'ID' => '',
              'post_type' => 'tf_slider',
              'post_author' => get_current_user_id(),
              'post_content' => 'Slides do not have any WP content, everything is stored in meta.',
              'post_title' => $post_title,
              'post_status' => 'publish',
            );

        // Create New Slide
        $post_id = wp_insert_post( $new_post );

        // Update Meta Data
        $order_id = intval( $post_id )*100;

        set_post_thumbnail( $post_id, $imageid );

        update_post_meta( $post_id, '_tfslider_order', $order_id);
        update_post_meta( $post_id, 'tfslider_image', $imageurl);

        // Exit
        wp_redirect( wp_get_referer() );
        exit;
    }
}

add_action('admin_init', 'themeforce_slider_catch_submit');

// Needs to be updated to Slides V2

function themeforce_slider_display() {

    // Query Custom Post Types
    $args = array(
        'post_type' => 'tf_slider',
        'post_status' => 'publish',
        'orderby' => 'meta_value_num',
        'meta_key' => '_tfslider_order',
        'order' => 'ASC',
        'posts_per_page' => 99
    );

    // - query -
    $my_query = null;
    $my_query = new WP_query( $args );

    $c = 1;

    while ( $my_query->have_posts() ) : $my_query->the_post();

        // - variables -
        $custom = get_post_custom( get_the_ID() );
        $id = ( $my_query->post->ID );
        $order = $custom["_tfslider_order"][0];
        $type = $custom["_tfslider_type"][0];

        $header = $custom["tfslider_header"][0];
        $desc = $custom["tfslider_desc"][0];
        $button = $custom["tfslider_button"][0];
        $link = $custom["tfslider_link"][0];

        // - image (with fallback support)
        $meta_image = $custom["tfslider_image"][0];
        $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

        if ( $post_image[0] && strpos( $meta_image, 'http://template-' ) === false ) {
            $image = $post_image[0];
        } else {
            $image = $meta_image;
        }

        // output

        // update mobile bg if not set yet
        if ($c == 1 && get_option( 'tf_mobilebg' ) == '') {
        	update_option('tf_mobilebg', $image);
        }

        $c++;

        // **** Theme Specific

        if ( TF_THEME == 'baseforce' ) {

            switch($type) {

                case 'content':

                    echo '<li class="slide-type-content">';
                    $b_image = wpthumb( $image, 'width=560&height=250&crop=1', false);
                    echo '<div class="slide-image" style="background-image:url(' . $b_image . ')"></div>';
                    echo '<div class="slide-content">';
                    echo '<h2>'. $header . '</h2>';
                    echo '<p>'. $desc . '</p>';
                    echo '<a class="slide-button" href="' . $link . '">'. $button . '</a>';
                    echo '</div>';
                    echo '</li>';

                break;

                default:

                    echo '<li class="slide-type-image">';
                    $b_image = wpthumb( $image, 'width=940&height=250&crop=1', false);
                    echo '<div class="slide-image" style="background-image:url(' . $b_image . ')"></div>';
                    echo '</li>';

            }

        }

         if ( TF_THEME == 'chowforce' ) {

    		echo '<li>';
    		    if ( $link ) {echo '<a href="' . $link . '">';}
    		        $resized_image = wpthumb( $image, 'width=960&height=250&crop=1', false);
    		        echo '<div class="slideimage-full" style="background:url(' . $resized_image . ') no-repeat;" alt="' . __('Slide', 'themeforce') . '"></div>';
    		    if ( $link ) {echo '</a>';}
    		echo '</li>';

          }

          if ( TF_THEME == 'pubforce' ) {
                echo '<li>';
                    if ( $link ) {echo '<a href="' . $link . '">';}
                        $resized_image = wpthumb( $image, 'width=540&height=300&crop=1', false);
                        echo '<div class="slideimage" style="background:url(' . $resized_image . ') no-repeat;" alt="' . __('Slide', 'themeforce') . '"></div>';
                    if ( $link ) {echo '</a>';}
                echo '</li>';
    	  }

          if ( TF_THEME == 'fineforce' )
            {
                echo '<li>';
                    if ( $link ) {echo '<a href="' . $link . '">';}
                        $resized_image = wpthumb( $image, 'width=1000&height=250&crop=1', false);
                        echo '<div class="slideimage" style="background:url(' . $resized_image . ') no-repeat;" alt="' . __('Slide', 'themeforce') . '"></div>';
                    if ( $link ) {echo '</a>';}
                echo '</li>';
            }

         // fallback check

         $emptycheck[] = $image;

    endwhile;

    // **** Theme Specific
    // fallback functions when no slides exist
    // TODO Consider replacing this with a more universal solution

    if ( $emptycheck == '' ) {

        if ( TF_THEME == 'chowforce' ) {
            echo '<li><div class="slideimage-full" style="background:url(' . get_bloginfo( 'template_url' ) . '/images/defaults/slide1.jpg) no-repeat;" alt="Slide"></li>';
            echo '<li><div class="slidetext"><h3>Yelp Integration</h3><p>Want to show off your Yelp rating? That\'s no problem. If you\'re not in a Yelp country, but use Qype instead, that works too! Just add your API and you\'ll be all set.</p></div><div class="slideimage" style="background:url(' . get_bloginfo( 'template_url' ) . '/images/defaults/slide2.jpg) no-repeat;" alt="Slide"></li>';
            echo '<li><div class="slidetext"><h3>No more PDF Menus</h3><p>With our designs, search engines will recognize your food menus and visitors won\'t have to download any PDF\'s or otherwise.</p></div><div class="slideimage" style="background:url(' . get_bloginfo( 'template_url' ) . '/images/defaults/slide3.jpg) no-repeat;" alt="Slide"></li>';
            echo '<li><div class="slidetext"><h3>Foursquare Integration</h3><p>Display your Foursquare Photos & Tips without any problem. You can do similar things with Gowalla. All you need to do is sign-up for an API Key & enter it (everyone gets one and it takes 2 minutes).</p></div><div class="slideimage" style="background:url(' . get_bloginfo( 'template_url' ) . '/images/defaults/slide4.jpg) no-repeat;" alt="Slide"></li>';
        }

        if ( TF_THEME == 'pubforce' ) {
            echo '<li><div class="slideimage" style="background:url(' . get_bloginfo( 'template_url' ) . '/images/defaults/slide1.jpg) no-repeat;" alt="Slide"></li>';
            echo '<li><div class="slideimage" style="background:url(' . get_bloginfo( 'template_url' ) . '/images/defaults/slide2.jpg) no-repeat;" alt="Slide"></li>';
            echo '<li><div class="slideimage" style="background:url(' . get_bloginfo( 'template_url' ) . '/images/defaults/slide3.jpg) no-repeat;" alt="Slide"></li>';
        }

        if ( TF_THEME == 'fineforce' ) {
            echo '<li><div class="slideimage" style="background:url(' . get_bloginfo( 'template_url' ) . '/images/default_food_1.jpg) no-repeat;" alt="Slide"></li>';
            echo '<li><div class="slideimage" style="background:url(' . get_bloginfo( 'template_url' ) . '/images/default_food_2.jpg) no-repeat;" alt="Slide"></li>';
            echo '<li><div class="slideimage" style="background:url(' . get_bloginfo( 'template_url' ) . '/images/default_food_3.jpg) no-repeat;" alt="Slide"></li>';
        }

    }

}

//Slider legacy update
function tf_slider_legacy_support_update() {

    if ( get_option( '_tf_slider_legacy_support_complete_1' ) || strpos( DB_NAME, 'template-' ) !== false )
        return;

    $args = array(
        'post_type' => 'tf_slider',
        'post_status' => 'publish',
        'orderby' => 'meta_value_num',
        'meta_key' => '_tfslider_order',
        'order' => 'ASC',
        'posts_per_page' => -1,

    );

    $post_query = new WP_Query( $args );

    foreach( $post_query->posts as $post ) {

        if ( ! get_post_meta( $post->ID, 'tfslider_image', true ) || get_post_meta( $post->ID, '_thumbnail_id', true ) )
            continue;

        $img_url = get_post_meta( $post->ID, 'tfslider_image', true );

        global $wpdb;

        $attachment_id = $wpdb->get_var( "SELECT ID FROM wp_posts WHERE post_type = 'attachment' AND guid = '$img_url'" );

        if ( ! $attachment_id )
            return;

        //if its a pre-created example image, just re-upload
        if ( strpos( $img_url, 'http://template' ) !== false ) {

            $dir = wp_upload_dir();

            $image_rel_path = get_post_meta( $attachment_id, '_wp_attached_file', true );

            $image_exploded = explode( '/', $image_rel_path );

            $image_name = end( $image_exploded );

            if ( strpos( $image_name, '.' ) === false || count( $image_exploded ) == 1 )
                    $image_name = end( explode( '\\', $image_rel_path ) );

            copy( $img_url, $dir['path'] . '/' . $image_name );

            $image_rel = substr( $dir['subdir'], 1 ) . '/' . $image_name;

            wp_update_post( array( 'ID' => $attachment_id, 'post_parent' => $post->ID ) );
            update_post_meta( $post->ID, '_thumbnail_id', $attachment_id );
            update_post_meta( $post->ID, 'tfslider_image', wp_get_attachment_url( $attachment_id ) );

            update_post_meta( $attachment_id, '_wp_attached_file', $image_rel );

            $meta =  wp_get_attachment_metadata( $attachment_id );
            $meta['sizes'] = array();
            $meta['file'] = $image_rel;

            wp_update_attachment_metadata( $attachment_id, $meta );
        } else {
            
            wp_update_post( array( 'ID' => $attachment_id, 'post_parent' => $post->ID ) );
            update_post_meta( $post->ID, '_thumbnail_id', $attachment_id );
            update_post_meta( $post->ID, 'tfslider_image', wp_get_attachment_url( $attachment_id ) );

        }
    }

    // tfh_update_theme_css_file();

    update_option( '_tf_slider_legacy_support_complete_1', true );

    wp_redirect( add_query_arg( 'updated_legacy', 'true' ) );

    exit;
}
