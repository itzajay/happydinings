<?php
    $category_block = "";
    $args = array(
        'post_type' => 'tf_categorybox',
        'meta_key' => 'display_order',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'tax_query' => array(
            array(
                'taxonomy' => 'tf_menutype',
                'terms' => $menu_id,
            )
        )
    );
    $design_array = array(
        'full' => 'Full',
        'list' => 'List',
        'short' => 'Short'
    );
    $posts = get_posts($args);

    $the_query = new WP_Query($args);
    // while($the_query->have_posts()) : $the_query->the_post();
    foreach ( $posts as $post ) :
        $cat_id =  get_post_custom_values('food_category_id', $post->ID);
		$cat_id = $cat_id[0];
    ?>
    <div id='foodmenuv2_cat_<?php echo $post->ID; ?>' class='foodmenuv2-catwrap' food-post-id='<?php echo $cat_id; ?>'>
        <div class="foodmenuv2-catwrap">
            <div class="foodmenuv2-catbar">
                <div class="foodmenuv2-catbar-move" id='sort_<?php echo $post->ID; ?>'></div>
                <span>Category</span>
                <select name="category-box-category" class="edit-cat-cat">
                    <?php 
                        foreach ( $categories as $category ):
                            $selected = null;
                            if ( $category->term_id == $cat_id ) $selected = " selected='selected'";
                            echo "<option value='{$category->term_id}'{$selected}>{$category->name}</option>";
                        endforeach; 
                    ?>
                </select>
                <span>Design</span>

                <?php $design_style = get_post_custom_values('block_design', $post->ID); ?>
                <select name="category-box-style" category-block="<?php echo $cat_id; ?>" class="edit-cat-design">
                    <?php
                        foreach ( $design_array as $key => $value ) {
                            $selected = null;
                            if ( $design_style[0] == $key ) $selected = " selected='selected'";
                            echo "<option value='{$key}'{$selected}>{$value}</option>";
                        }
                    ?>
                </select>
                <span>Show Header</span>
                <?php 
                    $show_header_value = get_post_custom_values('show_header', $post->ID); 
                    $checked = null;
                    if ( !empty($show_header_value[0]) ) $checked = " checked='checked'";
                ?>
                <input type="hidden" name="category_block_id" value="<?php echo $post->ID; ?>" class="category_block_id">
                <input type="checkbox" name="show_header" class="food-btn show_header" value="on" <?php echo $checked; ?>>
                <input type='hidden' value='<?php echo $menu_id; ?>' name="menu_id" class='food-btn menu-id' />
                <a href='#' class='tf-tiny tf-foodmenu-remove-cat remove-cat-btn' category-id='<?php echo $cat_id; ?>' post-id='<?php echo $post->ID; ?>' style='float: right; top: 1px;'>Remove Category</a>
                <a href='admin-ajax.php?action=food_item_form&menu_id=<?php echo $menu_id ?>&category_id=<?php echo $cat_id; ?>' class='tf-tiny new-item-btn fancybox fancybox.ajax' style='float: right; top: 1px;margin-right:10px'>Add Menu Item</a>
            </div>
            <div id="foodcat_<?php echo $cat_id; ?>" class="foodmenuv2-catarea fullitems ui-sortable-item">
                <?php
                    echo do_shortcode("[foodmenu id='".$menu_id."' category_id='".$cat_id."' category_box_id='".$post->ID."' admin='yes']");
                ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>