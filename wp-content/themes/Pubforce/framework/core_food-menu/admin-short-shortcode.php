<div data-post-id="<?php echo get_the_ID(); ?>" class="foodmenuv2-itemhalf foodmenuv2_item">
    <!-- Individual Item Options -->
    <div class="foodmenuv2-itembar">
        <div class="foodmenuv2-itembar-control">
            <div class="foodmenuv2-icon-move"></div>
            <a style="display:block;" class="foodmenuv2-icon-edit fancybox fancybox.ajax" href="admin-ajax.php?action=food_item_form&id=<?php echo get_the_ID(); ?>&menu_id=<?php echo $menu_id; ?>"></a>
            <div class="foodmenuv2-icon-delete" data-post-id="<?php echo get_the_ID(); ?>"></div>
        </div>
    </div>
    <div class="small-menu left foodmenu-item">
        <div class="leftbox">
            <div class="title"><div class="lefttext"><?php echo get_the_title(); ?></div></div>
            <div class="desc"><?php echo substr(get_the_content(),0,300); ?></div>
        </div>              
        <div class="rightbox">
            <?php
                $custom_fields = get_post_custom(get_the_ID());
                for($i = 0; $i < sizeof($custom_fields)/2 -1; $i++){
                    if(isset($custom_fields['food_menu_item_size_'.$i])){
            ?>
                        <div class="rightbox"><div class="size"><?php echo $custom_fields['food_menu_item_size_'.$i][0]; ?></div><div class="price"><?php echo $custom_fields['food_menu_item_price_'.$i][0]; ?></div></div>
            <?php
                    }
                }
            ?>
        </div>
    </div>
</div>