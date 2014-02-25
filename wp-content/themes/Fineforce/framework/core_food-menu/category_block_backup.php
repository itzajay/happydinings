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
                'terms' => $infos['menu-id']
            )
        )
    );
    $the_query = new WP_Query($args);
    while($the_query->have_posts()) : $the_query->the_post();
        $cat_id =  get_post_custom_values('food_category_id');
		$cat_id = $cat_id[0];
        $category_block .= "<div id='foodmenuv2_cat_{$cat_id}' class='foodmenuv2-catwrap' food-post-id='{$cat_id}'>";
            $category_block .= "<div class='foodmenuv2-catwrap'>";
                $category_block .="<div class='foodmenuv2-catbar'>";
                    $category_block .= "<div class='foodmenuv2-catbar-move' id='sort_'".get_the_ID()."'></div>";
                    $category_block .= "<span>Category</span>";
                    $category_block .= "<select id='edit-cat-cat'>";
                        foreach($categories as $category){
                            if($category->term_id == $cat_id){
                                $selected = " selected = 'selected'";
                            }else{
                                $selected = null;
                            }
                            $category_block .= "<option value='{$category->term_id}'{$selected}>{$category->name}</option>";
                        }
                    $category_block .= "</select>";
                    $category_block .= "<span>Design</span>";
                    $category_block .= "<select id='edit-cat-design' category-block='{$cat_id}'>";         
                        $design_value = get_post_custom_values('block_design');
                        $design_array = array(
                            'full' => 'Full',
                            'list' => 'List',
                            'short' => 'Short'
                        );
                        foreach($design_array as $key => $design){
                            if($design_value[0] == $key){
                                $selected = "selected = 'selected'";
                            }else{
                                $selected = null;
                            }
                            $category_block .= '<option value="'.$key.'"'.$selected.'>'.$design.'</option>';
                        }
                    $category_block .= "</select>";
                    $category_block .= "<span>Show Header</span>";
                        $show_header_value = get_post_custom_values('show_header');
                        if($show_header_value[0] == 1){
                            $status = "yes";
                            $checked = "checked = 'checked'";
                        }else{
                            $status = "no";
                            $checked = null;
                        }
					$menu_id = $infos['menu-id'];
                    $category_block .= "<input type='checkbox'". $checked ." category-block='{$cat_id}' id='show_header' class='food-btn' />";
                    $category_block .= "<input type='hidden' value='{$menu_id}'  id='menu-id' class='food-btn' />";
                    $category_block .= "<a href='#' class='tf-tiny tf-foodmenu-remove-cat remove-cat-btn' category-id='".$cat_id."' post-id='".get_the_ID()."' style='float: right; top: 1px;'>Remove Category</a>";
                    $category_block .= "<a href='admin-ajax.php?action=food_item_form&menu_id='".$menu_id."'&category_id='".$cat_id."' class='tf-tiny new-item-btn fancybox fancybox.ajax' style='float: right; top: 1px;margin-right:10px'>Add Menu Item</a>";
					$category_block .= "</div>";
                    $category_block .= "<div id='foodcat_4' class='foodmenuv2-catarea fullitems ui-sortable-item'>";
                            $args = array(
								'post_type' => 'tf_foodmenu',
								'meta_key' => 'display_order',
								'orderby' => 'meta_value',
								'order' => 'ASC',
								'tax_query' => array(
									array(
										'taxonomy' => 'tf_foodmenucat',
										'terms' => $cat_id
									)
								)
							);
                            query_posts($args);
                            while(have_posts()) : the_post();
                                $category_block .= do_shortcode("[foodmenu id='".get_the_ID()."' category_id='".$cat_id."' admin='yes']");
                            endwhile;
                    $category_block .= "</div>";
            $category_block .= "</div>";
        $category_block .= "</div>";
    endwhile;
return $category_block;
?>