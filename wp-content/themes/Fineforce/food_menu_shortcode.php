<?php
        $args = array(
            'post_type' => 'food',
            'post_parent' => 0,
            'meta_key' => 'display_order',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'food_menu',
                    'terms' => $food_menu
                )
            )
        );
        $the_query = new WP_Query($args);
        while($the_query->have_posts()) : $the_query->the_post();
        //$menu_category = get_the_term_list( get_the_ID(), 'category_food');
            $cat_value =  wp_get_post_terms(get_the_ID(),'category_food');
            $shortcode_food .= '<h2 class="menu-title">'.$cat_value[0]->name.get_the_ID().'</h2>';
                $args = array('post_parent' => get_the_ID(),'post_type' => 'food','meta_key' => 'display_order','orderby' => 'meta_value','order' => 'ASC');
                query_posts($args);
                while(have_posts()) : the_post();
                $parent_id = get_post(get_the_ID())->post_parent;
                $shortcode_food .= '<div itemprop="menu" class="full-menu">';
                if(has_post_thumbnail()){
                    $shortcode_food .= '<a href="'.wp_get_attachment_thumb_url(get_post_thumbnail_id(get_the_ID())).'" class="thumb fancybox">';
                        $shortcode_food .= '<img alt="Example Item 1" src="'.wp_get_attachment_thumb_url(get_post_thumbnail_id(get_the_ID())).'">';
                    $shortcode_food .= '</a>';
                    $shortcode_food .= '<div class="thumb-text">';
                }else{
                    $shortcode_food .= '<div class="text">';
                }
                $shortcode_food .= '<div class="title">';
                        $shortcode_food .= '<div class="left menu-item-title">'.get_the_title().'</div>';
                        $shortcode_food .= '<div class="right">';
                                $design_value = get_post_custom_values('food_menu_item_price_0');
                                $shortcode_food .= $design_value[0];
                        $shortcode_food .= '</div>';
                    $shortcode_food .= '</div>';
                    
                    $shortcode_food .= '<div class="extrasizes">';
                            $custom_fields = get_post_custom(get_the_ID());
                            for($i = 0; $i < sizeof($custom_fields)/2 -1; $i++){
                                if(isset($custom_fields['food_menu_item_size_'.$i])){
                                        $shortcode_food .= $custom_fields['food_menu_item_size_'.$i][0].'<strong>'.$custom_fields['food_menu_item_price_'.$i][0].'</strong> | ';
                                }
                            }
                    $shortcode_food .= '</div>';
        
                    $shortcode_food .= '<div class="desc">';
                        $shortcode_food .= get_the_content();
                    $shortcode_food .= '</div>';
                $shortcode_food .= '</div>';
            $shortcode_food .= '</div>';
        endwhile;
        wp_reset_query();
endwhile;
return $shortcode_food;
?>