jQuery(function($){
	$('.foodmenuv2-addcat').delegate('#add-food-cat', 'change',function(){
		var value = jQuery("#add-food-cat").val();
		if(value == 'create-new'){
			jQuery("#create-food-cat").css("display","");
			jQuery("#add-food-cat").css("display","none");
		}
	});

	$('.foodmenuv2-addcat').delegate('#food-cat', 'submit',function(){
		var url = "admin-ajax.php"; // the script where you handle the form input.
		var form_data = jQuery('#food-cat').serializeArray();
		
		jQuery.ajax({
			type: "POST",
			url: url,
			data: {action:'save_category_block',val:form_data},
			dataType: 'json',
			success: function(data){
				$('#category_blocks').html(data);
			},
			error: function(){
				console.log("Error");
			}
		});
		return false; // avoid to execute the actual submit of the form.
	});
	
    $('a.fancybox').fancybox();
	
	var options = { 
        target: '#output2',   // target element(s) to be updated with server response 
        beforeSubmit: showRequest,  // pre-submit callback 
        success:function(responseText, statusText, xhr, $form)  { 
			$.fancybox.close();
			$('#category_blocks').html(responseText);
		} ,  // post-submit callback
        url: ajaxurl,
        type: 'post',
        data:{action:'save_food_item'},
        dataType: 'json'
    };
    
    // bind to the form's submit event
    $("body").on('submit','#food-menu-item',function() {
        $(this).ajaxSubmit(options);
        return false; 
    });
    
    // pre-submit callback 
    function showRequest(formData, jqForm, options) { 
        var queryString = $.param(formData);
        $("#wait_user").css('display','block');
        return true; 
    }
	
	$(".ui-sortable").sortable({
        placeholder: "ui-state-highlight",
        start: function(event, ui) {
            var current_id = ui.item.attr('id');
            $('#'+current_id+' #foodcat_4').hide("2000");
            //ui.placeholder.height(ui.item.height());
        },
        stop: function(event, ui) {
            var current_id = ui.item.attr('id');
            $('#'+current_id+' #foodcat_4').show("2000");
            var new_index = ui.item.index();
        },
        update: function(event, ui) {
            var all_data = $(this).sortable("serialize");
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {action: 'update_display_order',value:all_data},
                datatype: 'json',
                success: function(data){
                    console.log("success");
                },
                error: function(){
                    console.log("error");
                }
            });
        }
    });
	$( ".ui-sortable" ).disableSelection();
    
    $(".ui-sortable-item").sortable({
        placeholder: "ui-state-highlight",
        start: function(event, ui) {
            ui.placeholder.height(ui.item.height());
        },
        update: function(event, ui) {
            var all_data = $(this).sortable("toArray");
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {action: 'update_item_display_order',value:all_data},
                datatype: 'json',
                success: function(data){
                    console.log("success");
                },
                error: function(){
                    console.log("error");
                }
            });
        }
    });
	
	// menu validation
	$("#nav-menu-header").on('click','#save_menu_header', function(e){
        var menu_name = $("#menu-name").val();
        if(menu_name == ""){
            $("#empty_error").css('display','block');
            return false;
        }else{
            return true;
        }
    });
	
	// delete the food item image
	$("body").on('click','.delete-image', function(e){
        e.preventDefault();
        $('.image-options').css('display','none');
        $('#food-menu-item .thumb img').css('display','none');
        $('#delete-item-food-image').val(1);
    });
	
	// remove the delete category block
	$("body").on('click','.tf-foodmenu-remove-cat', function(e){
        e.preventDefault();
        var current_div = $(this);
        var post_id = current_div.attr('post-id');
        var category_id = current_div.attr('category-id');
		$.ajax({
            type: "POST",
            url: ajaxurl,
            data: {action: 'delete_category_block',id:post_id},
            datatype: 'json',
            success: function(data){
				console.log(current_div.closest("#foodmenuv2_cat_"+category_id));
                console.log("success");
                current_div.closest("#foodmenuv2_cat_"+category_id).fadeOut(500);
            },
            error: function(){
                console.log("error");
            }
        });
    });
	
	// delete the food item
	$("body").on('click', '.foodmenuv2-icon-delete', function() {
        var className = jQuery(this);
        var post_id = className.attr('data-post-id');
        $.ajax({
            type: "POST",
            url: 'admin-ajax.php',
            data: {action:'delete_post',id:post_id},
            dataType: 'json',
            success: function(data){
                console.log("success");
                className.closest(".foodmenuv2-itemfull").fadeOut(500);
            },
            error: function(){
                console.log("error");
            }
        });
    });
	
	
	//add price and size textbox in food item form
	$("body").on('click', 'a.tf_foodmenu_add_item_option', function(e) {
        e.preventDefault();
        var len = $('.tf_foodmenu_options_container .price-list').length;
        if(len < 3){
            var price_list_content = "<div class='price-list'>";
            price_list_content += "<input type='text' placeholder='Size' name='tf_foodmenu_item_option_name[]' class='tf_foodmenu_item_option_name'>";
            price_list_content += "<input type='text' placeholder='Price' name='tf_foodmenu_item_option_price[]' class='tf_foodmenu_item_option_price'>";
            price_list_content += "</div>";
            $('.tf_foodmenu_options_container').append(price_list_content);
        }
    });
	
	// edit category form
	$(".foodmenuv2-addcat").on('click','.tf-foodmenu-edit-cat',function(){
        var category_id = $('#add-food-cat').val();
        var category_name = $('#add-food-cat :selected').text();
        $('.foodmenuv2-editcat').toggle('slow');
        $('#category_id').val(category_id);
        $('#food_category_name').val(category_name);
    });
	
	
	$('.foodmenuv2-editcat').on('click','#category-edit-food',function(){
        $.ajax({
            type: 'post',
            url:ajaxurl,
            data:{action: 'update_food_category',category_id: $('#category_id').val(),category_name: $('#food_category_name').val()},
            datatype: 'json',
            success: function(data){
                console.log("success");
                $('.foodmenuv2-editcat').css('display','none');
                $('#add-food-cat :selected').text(data)
            },
            error: function(){
                console.log("error");
            }
        });
    });
	
	$('body').on('change','#edit-cat-design',function(){
		console.log($('#menu-id').val());
        $.ajax({
            type: 'post',
            url:ajaxurl,
            data:{
				action: 'update_food_category_block',
				menu_id:$('#menu-id').val(),
				design_block: $('#edit-cat-design').val(),
				show_header: $('#show_header').val(),
				category_block_id:$(this).attr('category-block')
			},
            datatype: 'json',
            success: function(data){
                console.log("success");
				$('#category_blocks').html(data);
            },
            error: function(){
                console.log("error");
            }
        });
		return false;
    });
	
});