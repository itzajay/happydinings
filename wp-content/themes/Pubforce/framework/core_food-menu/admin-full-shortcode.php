<!-- Individual Item Block-->
<div data-post-id="<?php echo get_the_ID(); ?>" id="<?php echo get_the_ID(); ?>" class="foodmenuv2-itemfull foodmenuv2_item">
    <!-- Individual Item Options -->
    <div class="foodmenuv2-itembar">
        <div class="foodmenuv2-itembar-control">
            <div class="foodmenuv2-icon-move"></div>
            <a href="admin-ajax.php?action=food_item_form&id=<?php echo get_the_ID(); ?>&menu_id=<?php echo $menu_id; ?>" class="foodmenuv2-icon-edit fancybox fancybox.ajax" style="display:block;"></a>
            <div data-post-id="<?php echo get_the_ID(); ?>" class="foodmenuv2-icon-delete"></div>
        </div>
    </div>
    <!-- Individual Item block start -->
    <div itemprop="menu" class="full-menu foodmenu-item">
        <?php if(has_post_thumbnail()){ ?>
            <span class="thumb">
                <img src="<?php echo wp_get_attachment_thumb_url(get_post_thumbnail_id(get_the_ID())); ?>" class="item-image"/>
            </span>
            <!-- start the text -->
            <div class="text image_have">
        <?php }else{ ?>
        <!-- start the text -->
        <div class="text">
        <?php } ?>
            <!-- start the title -->
            <div class="title">
                <div class="left"><?php echo get_the_title(); ?></div>
                <div class="right">
                    <?php
                        $design_value = get_post_custom_values('food_menu_item_price_0');
                        echo $design_value[0];
                    ?>
                </div>
            </div>
            <!-- end the title -->
            <div class="desc"><?php echo substr(get_the_content(),0,300); ?></div>
            <!-- start the extrasizes -->
            <div class="extrasizes">
                <?php
                    $custom_fields = get_post_custom(get_the_ID());
                    for($i = 0; $i < sizeof($custom_fields)/2 -1; $i++){
                        if(isset($custom_fields['food_menu_item_size_'.$i])){
                ?>
                    <?php echo $custom_fields['food_menu_item_size_'.$i][0]; ?> <strong><?php echo $custom_fields['food_menu_item_price_'.$i][0]; ?></strong> | 
                <?php
                        }
                    }
                ?>
            </div>
            <!-- end the extrasizes-->
        </div>
        <!-- end the text -->
    </div>
</div>           
<!-- Individual Item Block end --> 