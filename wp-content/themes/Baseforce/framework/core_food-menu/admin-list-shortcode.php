<div data-post-id="<?php echo get_the_ID(); ?>" class="foodmenuv2-itemfull foodmenuv2_item">
    <!-- Individual Item Options -->    	        
    <div class="foodmenuv2-itembar">
    	<div class="foodmenuv2-itembar-control">
        	<div class="foodmenuv2-icon-move"></div>
        	<a href="admin-ajax.php?action=food_item_form&id=<?php echo get_the_ID(); ?>&menu_id=<?php echo $menu_id; ?>" class="foodmenuv2-icon-edit fancybox fancybox.ajax" style="display:block;"></a>
        	<div data-post-id="<?php echo get_the_ID(); ?>" class="foodmenuv2-icon-delete"></div>
        </div>
    </div>
    <!-- Individual Item Content-->    	        
    <div class="mid-menu foodmenu-item">
        <div class="leftbox">
            <div class="title"><div class="left"><?php echo get_the_title(); ?></div></div>
            <div class="desc"><?php echo substr(get_the_content(),0,300); ?></div>
        </div>
        <div class="rightbox">
            <?php
                $custom_fields = get_post_custom(get_the_ID());
                for($i = 0; $i < sizeof($custom_fields)/2 -1; $i++){
                    if(isset($custom_fields['food_menu_item_size_'.$i])){
            ?>
                        <div class="size"><?php echo $custom_fields['food_menu_item_size_'.$i][0]; ?></div>
                        <div class="price"><?php echo $custom_fields['food_menu_item_price_'.$i][0]; ?></div>
            <?php
                    }
                }
            ?>
        </div>
    </div>
</div>