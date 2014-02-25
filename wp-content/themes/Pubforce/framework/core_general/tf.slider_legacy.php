<?php

/*
 * Goal of TF Slider
 * 
 * - Create a Slider Post Type
 * - Create a Single Options Page whereby:
 * --- All Sliders are created/modified/deleted
 * --- Sorted via jQuery UI
 * 
 */


// Create Slider Post Type

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

}

add_action( 'init', 'create_slider_postype' );

// Register Page

function themeforce_slider_addpage() {
    add_submenu_page('themes.php', 'Slider Page Title', 'Slides', 'manage_options', 'themeforce_slider', 'themeforce_slider_page');
}

add_action( 'admin_menu', 'themeforce_slider_addpage' );

add_action( 'load-appearance_page_themeforce_slider', function() {
	
	TF_Upload_Image_Well::enqueue_scripts();
	
} );

// Load jQuery & relevant CSS

// js
function themeforce_slider_scripts() {
    // standards
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script( 'jquery-ui-draggable' );
    wp_enqueue_script( 'thickbox' );
    // other
    wp_enqueue_script( 'jalerts', TF_URL . '/assets/js/jquery.alerts.js', array(), TF_VERSION  );

    // option page settings
    wp_enqueue_script( 'tfslider', TF_URL . '/assets/js/themeforce-slider.js', array( 'jquery'), TF_VERSION  );
}

add_action( 'admin_print_scripts-appearance_page_themeforce_slider', 'themeforce_slider_scripts' );

// css
function themeforce_slider_styles() {
    wp_enqueue_style( 'jalerts', TF_URL . '/assets/css/jquery.alerts.css', array(), TF_VERSION );
    wp_enqueue_style( 'tfslider', TF_URL . '/assets/css/themeforce-slider.css', array(), TF_VERSION );
}

add_action( 'admin_print_styles', 'themeforce_slider_styles' );

// Create Page

function themeforce_slider_page() {
    ?>
    <div class="wrap tf-slider-page">
    <div class="tf-options-page">
    <?php screen_icon(); ?>
    <h2>Slider Options</h2>
    <h3>Manage Slides</h3>
    <form method="post" action="" name="" onsubmit="return checkformf( this );">
    <ul id="tf-slider-list"> 
    
    	<?php
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
			

        while ( $my_query->have_posts() ) : $my_query->the_post();
            
            // - variables -
			
            $custom = get_post_custom( get_the_ID() );
            $id = ( $my_query->post->ID );
            $order = $custom["_tfslider_order"][0];
            
            $link = $custom["tfslider_link"][0];

            // - image (with fallback) -

            $meta_image = $custom["tfslider_image"][0];
            $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

            if ( $post_image[0] ) {
                $image = $post_image[0];
            } else {
                $image = $meta_image;
            }

            $thumbnail = wpthumb( $image, 'width=628&height=100&crop=1', false);
            
            // Warning Statement
            $imagesize = getimagesize($image);
            
            if ( $imagesize ) {
                if ( $imagesize[0] < TF_SLIDERWIDTH && $imagesize[1] < TF_SLIDERHEIGHT ) {
                    echo '<div class="tf-notice">Oops, the dimensions of the image below aren\'t quite enough. Please ensure the image is at least <strong>' . TF_SLIDERWIDTH . 'px wide by ' . TF_SLIDERHEIGHT . 'px high.</strong></div>';
                } else {     
                    
                    if ($imagesize[0] < TF_SLIDERWIDTH ) {
                    	echo '<div class="tf-notice">Oops, the width of the image below is too short. Please ensure the image is at least <strong>' . TF_SLIDERWIDTH . 'px wide.</strong></div>';
                    }
                    
                    if ($imagesize[1] < TF_SLIDERHEIGHT ) {
                    	echo '<div class="tf-notice">Oops, the height of the image below is too short. Please ensure the image is at least <strong>' . TF_SLIDERHEIGHT . 'px high.</strong></div>';
                    }
                }
            }      
                
             // Display Slide   
            
             echo '<li id="listItem_' . $id . '" class="menu-item-handle slider-item">';
             echo '<div class="slider-controls">';
                 echo '<div class="handle"></div>';
                 echo '<div class="slider-edit"></div>';
                 echo '<div class="slider-delete"></div>';
             echo '</div>';
             
             // ID
             echo '<input type="hidden" name="' . 'slider[id][' . $id . ']" value="' . $id . '" />';
             
             // Thumbnail
             echo '<div class="slider-thumbnail">';
             if ( $thumbnail ) {echo '<img src="' . $thumbnail . '"/>';} else { echo '<img src="' . TF_URL . '/assets/images/slider-empty.jpg">';}
             echo '</div>';
             
             // Content
             echo '<div class="slider-content">';
             echo '<p><span>' . $link . '</span><input style="display:none;" placeholder=" Link ( Optional )" type="text" name="' . 'slider[link][' . $id . ']" size="45" id="input-title" value="' . $link  . '" /></p>';
             echo '</div>';
             
             // Update Sortable List
             echo '<input type="hidden" name="' . 'slider[order][' . $id . ']" value="' . $order . '" id="input-title"/>';
             
             // Update Delete Field
             echo '<input type="hidden" name="' . 'slider[delete][' . $id . ']" value="false" id="input-title"/>';
             echo '</li>';     
                         
		endwhile;   
	    ?>

    </ul> 
    
    <input type="hidden" name="update_post" value="1"/> 
    
    <input style="margin-top:10px" type="submit" name="updatepost" value="Update Slides" class="tf-button tf-major right" /> 
    </form>
    <div style="clear:both"></div>

    <div id="tf-options-panel">
    
    <h3>Create New Slide</h3>
    <div class="tf-settings-wrap">
    	<form class="form-table" method="post" action="" name="" onsubmit="return checkformf( this );">
    	
    	<table>
   			<tr>
			    <?php 
			    // TODO Would be nice to have the 250x100 thumbnail replace the upload button once the image is ready 
			    ?>
			    <th><label>Pick an Image<span class="required">*</span></label></th>
			    <td><?php
			    if ( get_option( $value['id'] ) != "") { 
			    	$val = stripslashes(get_option( $value['id'])  ); 
			    } else { 
			    	$val =  $value['std']; 
			    }
			    
			    $well = new TF_Upload_Image_Well( 'tfslider_image', $val, array( 'size' => 'width=250&height=100&crop=1' ) );
			    $well->html();
			    ?>
			    </td>
			</tr>
			<tr>
			    <th><label>Slide Link</label></th>
			    <td>
			        <input type="text"  placeholder="http:// ( Optional )" name="tfslider_link" size="45" id="input-title"/><br />
			        <span class="desc">If you'd like your slide to link to a page, enter the URL here.</span>
			    </td>
			</tr> 
		
		</table>
		</div>
    	    <input type="hidden" name="new_post" value="1"/> 
    	    
    	    <input style="margin-top:25px" type="submit" name="submitpost" class="tf-button tf-major right" value="Create New Slide"/> 
    	    
    	</form>
    </div>
    </div>
</div>
    <?php
        
}

// Save New Slide

function themeforce_slider_catch_submit() {
        
        // Establish Defaults
    
        $link = null;
        $button = null;
    
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
              'post_author' => $user->ID, 
              'post_content' => '',
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
        if ( $link ) {update_post_meta( $post_id, 'tfslider_link', $link);}
        if ( $button ) {update_post_meta( $post_id, 'tfslider_button', $button);}
        
        // Exit
        wp_redirect( wp_get_referer() );
        exit;
        }
}

add_action('admin_init', 'themeforce_slider_catch_submit');

// Update Slide
// TODO Add rest of slide content (only testing sort order atm)

function themeforce_slider_catch_update() {
    
    if ( isset($_POST['update_post'] ) == '1') {
    	foreach ( $_POST['slider']['order'] as $key => $val ) {
    	    
    	    // Grab General Data
    	    $my_post = array();
    	    $my_post['ID'] = $_POST['slider']['id'][$key];
    	    // New - not necessary - $my_post['post_title'] = $_POST['slider']['title'][$key];
    	    
    	    // Grab Delete Setting
    	    $delete = $_POST['slider']['delete'][$key];
    	          
    	    if ($delete == 'true') {
    	        
    	        // Delete selected sliders
    	        wp_delete_post( $key, true );
    	    
    	            
    	    } else {
		
    	        // Update Regular Post
    	        wp_update_post( $my_post );
    	        
    	        // Establish Defaults
    	        $link = null;
    	        $button = null;
    	        
    	        // Update Meta
    	        $link = $_POST['slider']['link'][$key];
    	        $slider_order = intval( $_POST['slider']['order'][$key] );

    	        if ( $link ) {update_post_meta($key, 'tfslider_link', $link);}
    	        update_post_meta($key, '_tfslider_order', $slider_order);
    	    }
    	}    
    	    
    	wp_redirect( wp_get_referer() );
    	exit;
    }
}

add_action('admin_init', 'themeforce_slider_catch_update');

//TODO Could benefit from using transients api for scalability
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
            $link = $custom["tfslider_link"][0];

            // - image (with fallback support)
            $meta_image = $custom["tfslider_image"][0];
            $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

            if ( $post_image[0] ) {
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
            
            if ( TF_THEME == 'baseforce' )
                {
                $b_image = wpthumb( $image, 'width=960&height=250&crop=1', false);
                echo '<img src="' . $b_image . '" alt="" />';
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
?>