<?php
	$current_menu_id = -1;
	$current_menu_name = '';
	$current_menu = null;
	if ( !empty($menus) ) {
		if ( isset($_GET['menu-id']) && $_GET['menu-id'] != -1 ) {
			foreach ( $menus as $menu ) {
				if ( $_GET['menu-id'] == $menu->term_id ) {
					$current_menu_id = $menu->term_id;
					$current_menu_name = $menu->name;
					$current_menu = $menu;
					break;
				}
			}
		} 
		if ( !isset($_GET['menu-id']) ) {
			$current_menu_id = $menus[0]->term_id;
			$current_menu_name = $menus[0]->name;
			$current_menu = $menus[0];
		}
	}
?>
<div class="wrap">
	<div class="icon32" id="icon-themes"><br></div>
	<h2>Food Menus</h2>
	<!-- start the menu tab -->
	<div class="nav-tabs-wrapper foodmenuv2-nav">
		<div class="nav-tabs">
			<?php foreach($menus as $menu): ?>
				<a class="nav-tab" food_menu_id="<?php echo $menu->term_id; ?>" href="<?php echo admin_url() . 'admin.php?page=foodmenu&menu-id=' . $menu->term_id; ?>"><?php echo $menu->name; ?></a>
			<?php endforeach; ?>
			<a class="nav-tab menu-add-new" food_menu_id="-1" href="<?php echo admin_url(); ?>admin.php?page=foodmenu&menu-id=-1"><abbr title="Add menu">+</abbr></a>
		</div>
	</div>
	<form method="post">
		<div class="foodmenuv2-header" id="nav-menu-header">
			<div class="submitbox" id="submitpost">
				<div style="overflow:auto;padding:15px 10px;" class="major-publishing-actions">
					<label for="menu-name" class="menu-name-label howto open-label">
						<span>Menu Name</span>
						<input type="text" placeholder="Enter menu name here" value="<?php echo $current_menu_name; ?>" title="Enter menu name here" class="menu-name regular-text menu-item-textbox input-with-default-title" id="menu-name" name="menu-name">
						<div id="empty_error" style="display:none">Value Required.</div>
					</label>
					<input type="hidden" name="menu-id" value="<?php echo $current_menu_id; ?>"/>
					<div style="float:left;" class="publishing-action">
						<?php if( $current_menu_id != -1 ) { ?>
							<input type="submit" value="Save Menu" class="button-primary menu-save" id="save_menu_header" name="create-menu">
							<input type="submit" value="Delete Menu" class="tf-tiny food-menu-delete">
						<?php } else { ?>
							<input type="submit" value="Create Menu" class="button-primary menu-save" id="save_menu_header" name="create-menu">
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!-- end the menu tab -->
	<div class="foodmenuv2-addcat">
		<form method="post" action="" id="food-cat">
			<input type="hidden" name="update_food-cat" value="true" />  
			<span>Category</span>
			<select name="add-food-cat" id="add-food-cat">  
				<?php
					foreach($categories as $category){
						echo '<option value="'.$category->term_id.'">'.$category->name.'</option>';
					}
				?>
				<optgroup label=" ------------ "></optgroup>
				<option value="create-new" class="create-new-category">+ Create New</option>
			</select>
			<input id="create-food-cat" name="create-food-cat" value="" placeholder="Name" style="display: none;" type="text">
			<span>Design</span>
			<select name="add-cat-design" id="add-cat-design">
				<?php
					foreach($design_array as $key => $design){
						echo '<option value="'.$key.'">'.$design.'</option>';
					}
				?>
			</select>
			<input type="hidden" name="menu-id" value="<?php echo $current_menu_id; ?>" />
			<input class="tf-tiny tf-foodmenu-add-cat food-btn" value="Add Category" type="submit">
			<input class="tf-tiny tf-foodmenu-edit-cat food-btn" style="margin-left:5px;" value="Edit Category" type="button">
		</form>
	</div>
</div>
<div style="display:none" class="foodmenuv2-editcat">
	<span>Category</span>
	<input type="hidden" id="category_id" />
	<input type="text" id="food_category_name" style="width:200px; margin-right:10px" />
	<input type="button" value="Rename Category" style="position:relative;top:1px;" id="category-edit-food" class="tf-tiny tf-foodmenu-rename-cat"/>
</div>
<?php // print_r($return_value); ?>
<?php include('tfh_content_area.php'); ?>
<script>
	jQuery(function($){
		var menu_id = '<?php echo $current_menu_id; ?>';
		if(menu_id ==  null){
			$('.nav-tabs-wrapper .nav-tabs a:first').addClass("nav-tab-active");   
		}else{
			$('.nav-tabs-wrapper').find('[food_menu_id="'+menu_id+'"]').addClass("nav-tab-active");
		}
	});
	function GetQueryStringParams(param){
		var page_url = window.location.search.substring(1);
		var url_variables = page_url.split('&');
		for (var i = 0; i < url_variables.length; i++) {
			var parameter_name = url_variables[i].split('=');
			if (parameter_name[0] == param){
				return parameter_name[1];
			}
		}
	}
	jQuery(function($){
		$('.food-menu-delete').click(function(){
			$('.food-menu-delete').attr('name','delete_food_menu');
		});   
	});
</script>