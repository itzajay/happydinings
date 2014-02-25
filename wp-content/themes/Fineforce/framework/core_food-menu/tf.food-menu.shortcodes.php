<?php
/*
 * FOOD MENU SHORTCODES (CUSTOM POST TYPE)
 *
 * [tf-menu-full id='Desserts' header='yes' currency='yes' type='menu']
 * [tf-menu-list id='Mains' header='yes' currency='yes' type='menu']
 * [tf-menu-short id='Mains' header='yes' currency='yes' type='menu']
 *
 */

function tf_menu_all ( $atts ) {

    extract(shortcode_atts(array(
        'id' => '', // Menu Name or Post ID
        'category_id' => '',
        'admin' => '',
        'category_box_id' => ''
    ), $atts));
    
    
    $menus = tf_foodmenu_get_menus($atts['category_id']);
    
    $menu = $menus[$atts['id']];
    
    if(!empty($atts['category_box_id'])){
        $menu_categories = $menu['categories'];
        unset($menu['categories']);
        $menu['categories'] = array(
            $atts['category_box_id'] => $menu_categories[$atts['category_box_id']]
        );
    }

    $output = '';
    foreach ( $menu['categories'] as $key => $id ) {
        $cat_info = get_term($atts['category_id'],'tf_foodmenucat');
        $style = get_post_custom_values('block_design', $key); // get_term_meta( $id, '_design_style_' . $atts['id'], true );
        $style = $style[0];
        $atts['header'] = 'yes'; // get_term_meta( $id, '_show_header_' . $atts['id'], true ) ? 'yes' : 'no';
        $category = get_term( $id, 'tf_foodmenucat' );

        $cat_atts = array(
            'id' => $category->slug, // Menu Name or Post ID
            'header' => $atts['header'], // Menu Section Header On or Off
            'type' => 'menu', // Menu or Single
            'align' => $align,
            'admin' => $atts['admin'],
            'menu_id' => $atts['id'],
        );

        switch ( $style ){

            case 'full':
                $output .= tf_menu_full( $cat_atts );
                break;

            case 'list':
                $output .= tf_menu_list ( $cat_atts );
                break;

            case 'relaxed':
                $output .= tf_menu_relaxed ( $cat_atts );
                break;

            case 'short':
                if ( is_page_template('page-full.php')) {
                    $output .= tf_menu_list ( $cat_atts );
                } else {
                    $output .= tf_menu_short ( $cat_atts );
                }
                break;

            default:
                $output .= tf_menu_full ( $cat_atts );
                break;
        }

        $i++;
    }

    $output .= '<div class="clearfix"></div>';
    return $output;
}

add_shortcode('foodmenu', 'tf_menu_all' );

// 1) FULL MENU
//***********************************************
function tf_menu_full( $atts ) {

    // - get options -
    $defaultfx = get_option( 'tf_menu_currency_symbol' );

    // - define arguments -
    extract(shortcode_atts(array(
        'id' => '', // Menu Name or Post ID
        'header' => 'yes', // Menu Section Header On or Off
        'currency'=> $defaultfx, // Currency On or Off
        'type' => 'menu', // Menu or Single
        'align' => '', // For full width
        'posts_per_page' => 99,
        'admin' => '',
        'menu_id' => '',
    ), $atts));

    ob_start();

    // ===== OPTIONS =====

    // - full-width check -


    // - full-width fallback -
    // is page template doesn't work within shortcode, will need to force an align on "visual shortcodes".

    // - currency -
    $fx = null;
    if ( $currency == 'true' ) {
        $fx = get_option( 'tf_currency_symbol' );
    }

    // - taxonomy group or single post -
    if ( $type == "menu" ) {
        $posttype = 'tf_foodmenucat';
    } else {
        $posttype = 'p';
    }
    
    // ===== LOOP: FULL MENU SECTION =====

    // - get options -
    $sortfield = get_option( 'tf_menu_sort_key' );
    $metakey = null;
    $orderby = 'title';

    if ( $sortfield == 'true' ) {
        $orderby = 'menu_order';
    }

    if ( $posttype == 'p' ) {
        $metakey = 'null';
        $orderby = 'title';
    }

    $args = array(
        'post_type' => 'tf_foodmenu',
        $posttype => $id,
        'post_status' => 'publish',
        'orderby' => $orderby,
        'meta_key' => $metakey,
        'order' => 'ASC',
        'posts_per_page' => 99
    );

    $term = get_term_by( 'slug', $id, 'tf_foodmenucat' );
    $term_name = $term->name;

    if ( $header == "yes" && $atts['admin'] != "yes" ) {
        echo '<h2 class="menu-title">' . $term_name . '</h2>';
    }
    

    $my_query = new WP_Query( $args );

    $i = 1;

    while ( $my_query->have_posts() ) : $my_query->the_post();

        // - full page col switching -
        if ( is_page_template('page-full.php')) { $align = ( ($i % 2) ? 'left' : 'right' ); }

        // - variables -
        $custom = get_post_custom( get_the_ID() );
        $category = get_terms( 'tf_foodmenucat' );
        $price1 = $custom["food_menu_item_price_0"][0];
        $price2 = $custom["food_menu_item_price_1"][0];
        $price3 = $custom["food_menu_item_price_2"][0];
        $size1 = $custom["food_menu_item_size_0"][0];
        $size2 = $custom["food_menu_item_size_1"][0];
        $size3 = $custom["food_menu_item_size_2"][0];
        $post_image_id = get_post_thumbnail_id( get_the_ID() );

        if ( $post_image_id ) {
            if ( $thumbnail = wp_get_attachment_image_src( $post_image_id, 'width=60&height=60&crop=1', false) )
                (string) $thumbnail = $thumbnail[0];

            if ( $large = wp_get_attachment_image_src( $post_image_id, 'large' ) )
                ( string ) $large = $large[0];
        }
        if($atts['admin'] == "yes"){
            include('admin-full-shortcode.php');
        }else{

            // - output -
            if ( $align ) { echo '<div style="clear:' . $align . '"></div><div class="' . $align . ' half-col">';}
    
            ?>
            <div class="full-menu" itemprop="menu">
    
            <?php if ( has_post_thumbnail() ) { ?>
                <a class="thumb" href="<?php echo $large; ?>"><img src="<?php echo $thumbnail; ?>" alt="<?php the_title(); ?>" /></a>
                <div class="thumb-text">
            <?php } else { ?>
                <div class="text">
            <?php } ?>
    
            <div class="title">
                <div class="left menu-item-title"><?php the_title(); ?></div>
                <div class="right"><?php echo $fx; echo $price1 ?></div>
            </div>
            <div class="desc"><?php the_content_rss(); ?></div>
    
            <?php if ( $size2 == "" ) { ?>
                        </div><?php } else { ?>
                        <div class="extrasizes"><?php echo $size2 ?> <strong> <?php echo $fx; echo $price2 ?></strong>
                <?php if ( $size3 == "" ) {?></div></div><?php ;} else { ?> , <?php echo $size3 ?><strong> <?php echo $fx; echo $price3 ?></strong></div></div><?php ;}} ?>
            </div>
        
            <?php
        
            // - full page col switching -
            if ( $align ) { echo '</div>'; }
        }

    $i++;

    endwhile;

    echo '<div class="clearfix"></div>';

    wp_reset_query();

    // ===== RETURN: FULL MENU SECTION =====

    $output = ob_get_contents();
    ob_end_clean();

    return $output;

}

add_shortcode('tf-menu-full', 'tf_menu_full');


//------------------------------------------------------------------------------


// 2) LIST MENU
//***********************************************

function tf_menu_list ( $atts ) {

    extract(shortcode_atts(array(
        'id' => '', // Menu Name or Post ID
        'header' => 'yes',
        'currency'=> get_option( 'tf_menu_currency_symbol' ),
        'type' => 'menu', // Menu or Single
        'posts_per_page' => 99,
        'align' => '', // For full width
        'admin' => '',
        'menu_id' => '',
    ), $atts));

    // ===== OUTPUT FUNCTION =====

    ob_start();

    // ===== OPTIONS =====

    // - full-width check -


    // - currency -
    $fx = null;
    if ( $currency=='true' ) {
        $fx = get_option( 'tf_currency_symbol' );}

    // - taxonomy group or single post -
    if ( $type=="menu" ) {
        $posttype = 'tf_foodmenucat';
    } else {
        $posttype = 'p';
    }

    // ===== LOOP: LIST MENU SECTION =====

    // - get options -
    $sortfield = get_option( 'tf_menu_sort_key' );
    $metakey = null;
    $orderby = 'title';

    if ( $sortfield=='true' ) {
        $orderby = 'menu_order';
    }

    if ( $posttype=='p' ) {
        $metakey = 'null';
        $orderby = 'title';
    }

    // - arguments -
    $args = array(
        'post_type' => 'tf_foodmenu',
        $posttype => $id,
        'post_status' => 'publish',
        'orderby' => $orderby,
        'meta_key' => $metakey,
        'order' => 'ASC',
        'posts_per_page' => 99,
        'align' => '', // For full width
    );

    // - header text -
    $term = get_term_by('slug', $id, 'tf_foodmenucat');
    $term_name = $term->name;

    if ( $header=="yes" && $atts['admin'] != 'yes' ) {
        echo '<h2 class="menu-title">'.  $term_name .'</h2>';
    }

    // - query -
    $my_query = null;
    $my_query = new WP_query( $args );

    $i = 1;

    while ( $my_query->have_posts() ) : $my_query->the_post();

        if ( is_page_template('page-full.php')) { $align = ( ($i % 2) ? 'left' : 'right' ); }

        // - variables -
        $custom = get_post_custom( get_the_ID() );
        $price1 = $custom["food_menu_item_price_0"][0];
        $price2 = $custom["food_menu_item_price_1"][0];
        $price3 = $custom["food_menu_item_price_2"][0];
        $size1 = $custom["food_menu_item_size_0"][0];
        $size2 = $custom["food_menu_item_size_1"][0];
        $size3 = $custom["food_menu_item_size_2"][0];

        // - output -
        if($atts['admin'] == "yes"){
            include('admin-list-shortcode.php');
        }else{
            // - full page col switching -
            if ( $align ) { echo '<div style="clear:' . $align . '"></div><div class="' . $align . ' half-col">';}
            ?>
        
            <div class="mid-menu" itemprop="menu">
                <div class="leftbox">
                    <div class="title"><div class="left menu-item-title"><?php the_title(); ?></div></div>
                    <div class="desc"><?php the_content_rss(); ?></div>
                </div>
                <div class="rightbox"><?php if ( $size1!="" ) { ?><div class="size"><?php echo $size1 ?></div><?php ;} ?><div class="price"><?php echo $fx; echo $price1 ?></div></div>
                <?php if ( $size2!="" ) {?><div class="rightbox"><div class="size"><?php echo $size2 ?></div><div class="price"><?php echo $fx; echo $price2 ?></div></div><?php ;} ?>
                <?php if ( $size3!="" ) {?><div class="rightbox"><div class="size"><?php echo $size3 ?></div><div class="price"><?php echo $fx; echo $price3 ?></div></div><?php ;} ?>
            </div>
        
            <?php
        
            // - full page col switching -
            if ( $align ) { echo '</div>';}
        }

    $i++;

    endwhile;

    echo '<div class="clearfix"></div>';


    wp_reset_query();

    $output = ob_get_contents();
    ob_end_clean();

    return $output;

}

add_shortcode('tf-menu-list', 'tf_menu_list');


//------------------------------------------------------------------------------


// 3) SMALL MENU
//***********************************************

function tf_menu_short ( $atts ) {

    $defaultfx = get_option( 'tf_menu_currency_symbol' );

    extract(shortcode_atts(array(
        'id' => '', // Menu Name or Post ID
        'header' => 'yes',
        'currency'=> $defaultfx,
        'type' => 'menu', // Menu or Single
        'admin' => '',
        'menu_id' => '',
    ), $atts));

    // ===== OUTPUT FUNCTION =====

    ob_start();

    // ===== OPTIONS =====

    // - currency -
    $fx = null;
    if ( $currency=='true' ) {
        $fx = get_option( 'tf_currency_symbol' );}

    // - taxonomy group or single post -
    if ( $type=="menu" ) {
        $posttype = 'tf_foodmenucat';
    } else {
        $posttype = 'p';
    }

    // ===== LOOP: SMALL MENU SECTION =====

    // - get options -
    $sortfield = get_option( 'tf_menu_sort_key' );
    $metakey = null;
    $orderby = 'title';

    if ( $sortfield=='true' ) {
        $orderby = 'menu_order';
    }

    if ( $posttype=='p' ) {
        $metakey = 'null';
        $orderby = 'title';
    }

    // - arguments -
    $args = array(
        'post_type' => 'tf_foodmenu',
        $posttype => $id,
        'post_status' => 'publish',
        'orderby' => $orderby,
        'meta_key' => $metakey,
        'order' => 'ASC',
        'posts_per_page' => 99,
    );

    // - header text -
    $term = get_term_by('slug', $id, 'tf_foodmenucat');
    
    $term_name = $term->name;

    if ( $header=="yes" && $atts['admin'] != 'yes' ) {
        echo '<h2 class="menu-title">'.  $term_name .'</h2>';
    }

    // - query -
    $counter = 1;
    $global_counter = 0;
    $my_query = null;
    $my_query = new WP_query( $args );
    while ( $my_query->have_posts() ) : $my_query->the_post();

        // - variables -
        $custom = get_post_custom( get_the_ID() );
        $price1 = $custom["food_menu_item_price_0"][0];
        $price2 = $custom["food_menu_item_price_1"][0];
        $price3 = $custom["food_menu_item_price_2"][0];
        $size1 = $custom["food_menu_item_size_0"][0];
        $size2 = $custom["food_menu_item_size_1"][0];
        $size3 = $custom["food_menu_item_size_2"][0];
        $odd_even_checker = ( $counter%2 ) ? TRUE : FALSE;
        
        if($atts['admin'] == "yes"){
            include('admin-short-shortcode.php');
        }else{
            // - output -
        ?>
            <div class="small-menu <?php if ( !$odd_even_checker ) { ?>right<?php } else { ?>left<?php } ?>"  itemprop="menu">
                <div class="leftbox">
                    <div class="title"><div class="lefttext menu-item-title"><?php the_title(); ?></div></div>
                    <div class="desc"><?php the_content_rss(); ?></div>
                </div>
                <div class="rightbox"><?php if ( $size1!="" ) { ?><div class="size"><?php echo $size1 ?></div><?php ;} ?><div class="price"><?php echo $fx; echo $price1 ?></div></div>
                <?php if ( $size2!="" ) {?><div class="rightbox"><div class="size"><?php echo $size2 ?></div><div class="price"><?php echo $fx; echo $price2 ?></div></div><?php ;} ?>
                <?php if ( $size3!="" ) {?><div class="rightbox"><div class="size"><?php echo $size3 ?></div><div class="price"><?php echo $fx; echo $price3 ?></div></div><?php ;} ?>
            </div>
        
            <div style="clear:<?php if ( $odd_even_checker ) { ?>right<?php } else { ?>left<?php } ?>;"></div>
    <?php
        }
        $counter++;
    endwhile;
    ?><div class="clearfix"></div><?php
    wp_reset_query();

    $output = ob_get_contents();
    ob_end_clean();

    return $output;

}

add_shortcode('tf-menu-short', 'tf_menu_short');

// 4) RELAXED MENU
//***********************************************
function tf_menu_relaxed( $atts ) {

    // - get options -
    $defaultfx = get_option( 'tf_menu_currency_symbol' );

    // - define arguments -
    extract(shortcode_atts(array(
        'id' => '', // Menu Name or Post ID
        'header' => 'yes', // Menu Section Header On or Off
        'currency'=> $defaultfx, // Currency On or Off
        'type' => 'menu', // Menu or Single
        'align' => '', // For full width
        'posts_per_page' => 99,
        'menu_id' => '',
    ), $atts));

    ob_start();

    // ===== OPTIONS =====

    // - full-width check -


    // - full-width fallback -
    // is page template doesn't work within shortcode, will need to force an align on "visual shortcodes".

    // - currency -
    $fx = null;
    if ( $currency == 'true' ) {
        $fx = get_option( 'tf_currency_symbol' );
    }

    // - taxonomy group or single post -
    if ( $type == "menu" ) {
        $posttype = 'tf_foodmenucat';
    } else {
        $posttype = 'p';
    }

    // ===== LOOP: FULL MENU SECTION =====

    // - get options -
    $sortfield = get_option( 'tf_menu_sort_key' );
    $metakey = null;
    $orderby = 'title';

    if ( $sortfield == 'true' ) {
        $orderby = 'menu_order';
    }

    if ( $posttype == 'p' ) {
        $metakey = 'null';
        $orderby = 'title';
    }

    $args = array(
        'post_type' => 'tf_foodmenu',
        $posttype => $id,
        'post_status' => 'publish',
        'orderby' => $orderby,
        'meta_key' => $metakey,
        'order' => 'ASC',
        'posts_per_page' => 99
    );

    $term = get_term_by( 'slug', $id, 'tf_foodmenucat' );
    $term_name = $term->name;

    if ( $header == "yes" ) {
        echo '<h2 class="menu-title">' . $term_name . '</h2>';
    }

    $my_query = new WP_Query( $args );

    $i = 1;

    while ( $my_query->have_posts() ) : $my_query->the_post();

        // - full page col switching -
        if ( is_page_template('page-full.php')) { $align = ( ($i % 2) ? 'left' : 'right' ); }

        // - variables -
        $custom = get_post_custom( get_the_ID() );
        $category = get_terms( 'tf_foodmenucat' );
        $price1 = $custom["food_menu_item_price_0"][0];
        $price2 = $custom["food_menu_item_price_1"][0];
        $price3 = $custom["food_menu_item_price_2"][0];
        $size1 = $custom["food_menu_item_size_0"][0];
        $size2 = $custom["food_menu_item_size_1"][0];
        $size3 = $custom["food_menu_item_size_2"][0];
        $post_image_id = get_post_thumbnail_id( get_the_ID() );

        if ( $post_image_id ) {
            if ( $thumbnail = wp_get_attachment_image_src( $post_image_id, 'width=60&height=60&crop=1', false) )
                (string) $thumbnail = $thumbnail[0];

            if ( $large = wp_get_attachment_image_src( $post_image_id, 'large' ) )
                ( string ) $large = $large[0];
        }

        // - output -
        if ( $align ) { echo '<div style="clear:' . $align . '"></div><div class="' . $align . ' half-col">';}

        ?>
        <div class="full-menu" itemprop="menu">

        <?php if ( has_post_thumbnail() ) { ?>
            <a class="thumb" href="<?php echo $large; ?>"><img src="<?php echo $thumbnail; ?>" alt="<?php the_title(); ?>" /></a>
            <div class="thumb-text">
        <?php } else { ?>
            <div class="text">
        <?php } ?>

        <div class="title-relaxed">
            <div class="left menu-item-title"><?php the_title(); ?><span><?php echo $fx; echo $price1 ?></span></div>
        </div>
        <div class="desc-relaxed">
        <?php the_content_rss(); ?>
        <?php if ( $size2 == "" ) { ?>
	        		<?php } else { ?>
            <br /> ( <?php echo $size2 ?> <?php echo $fx; echo $price2 ?>
            <?php if ( $size3 == "" ) {?> ) <?php ;} else { ?> , <?php echo $size3 ?> <?php echo $fx; echo $price3 ?> ) <?php ;}} ?>
        </div>
    </div>
    </div>

    <?php

        // - full page col switching -
        if ( $align ) { echo '</div>'; }

        $i++;

    endwhile;

    echo '<div class="clearfix"></div>';

    wp_reset_query();

    // ===== RETURN: FULL MENU SECTION =====

    $output = ob_get_contents();
    ob_end_clean();

    return $output;

}

add_shortcode('tf-menu-relaxed', 'tf_menu_relaxed');


/**
 * Registers the Insert Shortcode tinymce plugin for Food menu.
 *
 */
function tf_food_menu_register_tinymce_buttons() {

    if ( !current_user_can( 'edit_posts' ) ||
        ( isset( $_GET['post'] ) && !in_array( get_post_type( $_GET['post'] ), array( 'post', 'page' ) ) ) ||
        ( isset( $_GET['post_type'] ) && !in_array( $_GET['post_type'], array( 'post', 'page' ) ) ) )
        return;

    add_filter( 'mce_external_plugins', 'tf_food_menu_add_tinymce_plugins' );
}
add_action( 'load-post.php', 'tf_food_menu_register_tinymce_buttons' );
add_action( 'load-post-new.php', 'tf_food_menu_register_tinymce_buttons' );


/**
 * Adds the Insert Shortcode tinyMCE plugin for the food menu.
 *
 * @param array $plugin_array
 * @return array
 */
function tf_food_menu_add_tinymce_plugins( $plugin_array ) {
    $plugin_array['tf_food_menu_shortcode_plugin'] = TF_URL . '/core_food-menu/tinymce_plugins/insert_shortcode.js';

    return $plugin_array;
}

/**
 * Adds Insert Bar above Page Edit
 */
function tf_food_menu_add_insert_bar_to_edit_page() {
    ?>

<div id="tf-above-editor-insert-area">

    <strong><?php _e('Insert','themeforce') ?>:</strong>

    <a class="tf-button tf-inlinemce" id="add-foodmenu-button" href="#"><img src="<?php echo TF_URL . '/core_food-menu/tinymce_plugins/food_20.png' ?>"/><span>Food Menu</span></a>

    <div id="menu-menu-id-wrap" class="hidden">
        <select id="menu-menu-id">
            <option value=""><?php _e('Select Food Menu','themeforce') ?></option>
            <?php foreach ( tf_foodmenu_get_menus() as $key => $menu ) : ?>
            <option value="<?php echo $key ?>"><?php echo $menu['menu-name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php // debug('test'); ?>

    <?php do_action( 'tf_above_editor_insert_items' ) ?>
</div>

<script type="text/javascript">

    jQuery( function($) {

        $( '#tf-above-editor-insert-area' ).insertBefore( '#postdivrich' );

        $( '#tf-above-editor-insert-area' ).on( 'change.foodmenu', '#menu-menu-id', function(e) {
            e.preventDefault();
            e.stopPropagation();
            menu_id = $(this).val();

            if ( !menu_id || menu_id == 0 )
                return;

            var shortcode = '[foodmenu id="' + menu_id + '"]'

            send_to_editor( shortcode );

        } );

        $( '#add-foodmenu-button' ).on( 'click', function(e) {
            e.preventDefault();
            $( this ).addClass('hidden');
            $( '#menu-menu-id-wrap' ).fadeIn();
        } )
        window.TFFoodMenus = <?php echo json_encode( tf_foodmenu_get_menus() ) ?>;
    });

</script>

<?php
}
add_action( 'edit_page_form', 'tf_food_menu_add_insert_bar_to_edit_page' );