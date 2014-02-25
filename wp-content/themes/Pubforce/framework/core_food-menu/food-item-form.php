<!-- start the foodmenuv2-modal-wrap -->
<div id="foodmenuv2-modal-wrap">
    <form method="post" id="food-menu-item" enctype="multipart/form-data">
        <input type="hidden" name="update_food_item" value="true" />
        <input type="hidden" name="id" value="<?php echo (isset($post->ID)) ? $post->ID : ""; ?>" />
        <input type="hidden" name="category_id" value="<?php echo $_GET['category_id']; ?>" />
        <input type="hidden" name="menu_id" value="<?php echo $_GET['menu_id']; ?>" />
        <!-- start the content div -->
        <div class="content">
            <!-- start the tf-options-page div -->
            <div class="tf-options-page">
                <!-- start the thumb div -->
                <div class="thumb">
                    <div class="rwmb-drag-drop upload-form">
                        <p class="select_file_wrapper">
                            <input type="button" class="button rwmb-drag-drop-inside" value="Select File" id="_thumbnail_id-browse-button" style="position: relative; z-index: 0;">
                        </p>
                        <?php if(!empty($image)){ ?>
                            <img src="<?php echo $image; ?>" class="item-form-image" />        
                            <div class="image-options">
                                <a class="delete-image" href="#">Delete</a>
                            </div>
                        <?php } ?>
                        <div id="file_upload_container" class="plupload html5">
                            <input type="file" name="foodmenu_item_image" multiple="multiple" accept="image/jpeg,image/png,image/gif" class="item-image-button">
                        </div>
                    </div>
                </div>
                <!-- end the thumb div -->
                <!-- start the field div -->
                <div style="min-height:210px"> 
                    <input type="text" value="<?php echo (isset($post->post_title)) ? $post->post_title : ""; ?>" placeholder="Name" name="foodmenu_item_name" class="tf_foodmenu_item_name">
                    <textarea placeholder="Description" name="foodmenu_item_description">
                        <?php echo (isset($post->post_content)) ? $post->post_content : "";?>
                    </textarea>
                    <input type="hidden" id="delete-item-food-image" value="0" name="delete-item-food-image" />
                </div>
                <!-- end the field div -->
                <div class="tf_foodmenu_options_container">
                    <?php
                        if(isset($post)){
                            $post_custom_fields = get_post_custom($post->ID);
                            if(isset($post_custom_fields['_edit_lock']) || isset($post_custom_fields['display_order']) || isset($post_custom_fields['_thumbnail_id'])){
                                unset($post_custom_fields['_edit_lock']);
								unset($post_custom_fields['display_order']);
								unset($post_custom_fields['_thumbnail_id']);
                            }
                            for($i = 0; $i < sizeof($post_custom_fields)/2; $i++){
                    ?>
                                <div class="price-list">
                                    <input type="text" value="<?php echo $post_custom_fields['food_menu_item_size_'.$i][0]; ?>" placeholder="Size" name="tf_foodmenu_item_option_name[]" class="tf_foodmenu_item_option_name">
                                    <input type="text" value="<?php echo $post_custom_fields['food_menu_item_price_'.$i][0]; ?>" placeholder="Price" name="tf_foodmenu_item_option_price[]" class="tf_foodmenu_item_option_price">
                                </div>
                    <?php            
                            }
                    ?>
                    <?php }else{ ?>
                        <div class="price-list">
                            <input type="text" value="" placeholder="Size" name="tf_foodmenu_item_option_name[]" class="tf_foodmenu_item_option_name">
                            <input type="text" value="" placeholder="Price" name="tf_foodmenu_item_option_price[]" class="tf_foodmenu_item_option_price">
                        </div>
                    <?php } ?>
                </div>
                <a class="tf-tiny tf_foodmenu_add_item_option" href="#">Add Price Option</a>
                <?php if(isset($post->ID)){ ?>
                        <input type="submit" value="Update" class="food-save">
                <?php }else{ ?>
                    <input type="submit" value="Create" class="food-save">
                <?php } ?>
            </div>
            <!-- end the tf-options-page div -->
        </div>
        <!-- end the content div -->
    </form>
    <div id="wait_user" style="display:none">
    </div>
</div>
<!-- end the foodmenuv2-modal-wrap -->