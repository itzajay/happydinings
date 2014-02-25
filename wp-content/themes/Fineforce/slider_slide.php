<div class="wrap tf-slides-page">
    <div class="tf-options-page">
        <div class="icon32" id="icon-themes"><br></div>
        <h2>Slides</h2>
        <ul id="tf-slides-list" class="ui-sortable">
            <?php
                $attachment_ids = get_option('slide_attachment_id');
                foreach($attachment_ids as $id):
            ?>
                <li class="menu-item-handle slide-item" id="listItem_66">
                    <div class="slide-thumbnail" style="width:678px;background-image: url('<?php echo wp_get_attachment_url($id); ?>');">
                        <div class="slide-change-image">
                            <form action="" method="post">
                                <input type="hidden" name="delete_slide" value="true" />
                                <input type="hidden" name="delete_slide_id" value="<?php echo $id; ?>" />
                                <input type="submit" value="Delete" class="button" />
                            </form>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <h3>Create New Slide</h3>
        <div class="tf-settings-wrap">
            <form action="" method="post" class="form-table" enctype="multipart/form-data">
                <table>
                    <tbody>
                        <tr>
                            <th>
                                <label>Pick an Image<span class="required">*</span></label>
                            </th>
                            <td>
                                <div id="tfslider_image-container" class="hm-uploader " style="width: 420px;">
                                    <input type="hidden" value="true" name="baseforce_slider"/>
                                    <div>
                                        <input type="button" class="button" value="Select Files" id="tfslider_image-browse-button" style="position: relative; z-index: 0;" />
                                    </div>
                                    <input type="file" name="upload-slide" id="upload-slide"/>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="submit" value="Create New Slide" class="tf-button tf-major right upload_slides" name="submitpost" style="margin-top:25px">
            </form>
        </div>
    </div>
    <div style="clear:both"></div>
</div>