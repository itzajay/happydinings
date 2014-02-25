<?php 

/**
 * Adds the OpenGraph meta tags to the head.
 * 
 */

function tf_add_og_meta_tags() {

    global $post;

    if ( is_admin() )
        return;

    // Required OG Title

    ?>

    <meta property="og:title" content="<?php the_title(); ?>" />
    <meta property="og:url" content="<?php the_permalink(); ?>" />

    <?php

    // Required OG Image

    ?>

    <meta property="og:image" content="<?php $logo = wp_get_attachment_image_src( get_option('tf_logo_id'), 'large' ); echo $logo[0]; ?>" />

    <?php

    // Slider Images

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

        // - image (with fallback support)
        $meta_image = $custom["tfslider_image"][0];
        $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

        if ( $post_image[0] && strpos( $meta_image, 'http://template-' ) === false ) {
            $image = $post_image[0];
        } else {
            $image = $meta_image;
        }

        $thumb = wpthumb( $image, 'width=200&height=200&crop=1', false);

        echo '<meta property="og:image" content="' . $thumb . '" />';

    endwhile;

   // Template specific

    if ( is_single() ) {

        ?>

        <meta property="og:type" content="article" />
        <meta property="og:description" content="<?php the_excerpt(); ?>" />

        <?php

    }

    if ( is_front_page() ) {

        ?>

        <meta property="og:type" content="website" />

        <?php


    } elseif ( !is_front_page() && is_home() ) {

        ?>

        <meta property="og:type" content="blog" />

        <?php

    } elseif ( is_page() ) {

        ?>

        <meta property="og:type" content="article" />

        <?php

    }

    ?>

    <?php

}

add_action( 'wp_head', 'tf_add_og_meta_tags' );