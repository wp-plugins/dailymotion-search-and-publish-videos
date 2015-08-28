<?php 
/*
** Video Dashboard
*/
function ocv_dailymotion() {
?>
<div id="ocv_main_wrap">
<div id="ocv_page_wrap">
<div class="ocv_title"><img src="<?php echo ( OCV_PLUGIN_IMAGES_DIR .'one_click_videos.png' );?>" style="width:25%;">
<p class="ocv_title_text">© 2015 <a href="http://codecanyon.net/user/ropstam">Ropstam BPO</a><br />One Click Solution to Publish Videos as Wordpress Post</p></div>
<div id="ocv_wrap">
<div id="category_source">
	<h3 class="ocv_step">Select Category & Sub-Categories</h3>
	<form method="post" action="options.php">
    <?php settings_fields( 'ocv_settings-group' ); ?>
    <?php do_settings_sections( 'ocv_settings-group' ); 
	$selected="";?>
	<div id="spinner"><img src="<?php echo OCV_PLUGIN_IMAGES_DIR. 'load-indicator.gif';?>" alt="Loading..."/></div>
	<div id="parent_cat_div"><?php wp_dropdown_categories( "show_option_none=Select parent category&orderby=name&depth=1&hierarchical=1&id=parent_cat&hide_empty=0" ); ?></div>
	<div id="sub_cat_div"><select name="sub_cat_disabled" id="sub_cat_disabled" disabled="disabled"><option>Select parent category first!</option></select></div>
	<div id="sub_child_div" ><select name="sub_child_disabled" id="sub_child_disabled" disabled="disabled"><option>Select Child category first!</option></select></div>
		<input class="button-primary categories" type="submit" name="submit" value="Save Categories">
	<br /><br />
	<div id="published_cat">
	<h3>Your Videos will be posted to the following categories</h3>
		<input type="hidden" id="parent_cat_id_hidden" name="parent_cat_id_hidden" value="<?php echo get_option( 'parent_cat_id_hidden' ); ?>">
		Main Category:<input type="text" id="parent_cat_name" value="<?php  echo get_cat_name( get_option( 'parent_cat_id_hidden' ) ); ?>" readonly>
		<input type="hidden" id="child_cat_id_hidden"  name="child_cat_id_hidden" value="<?php echo get_option( 'child_cat_id_hidden' ); ?>">
		Sub Category<input type="text" id="child_cat_name" value="<?php  echo get_cat_name( get_option( 'child_cat_id_hidden' ) ); ?>" readonly>
		<input type="hidden" id="subchild_cat_id_hidden" name="subchild_cat_id_hidden" value="<?php echo get_option( 'subchild_cat_id_hidden' ); ?>">
		Sub Sub Category<input type="text" id="subchild_cat_name" value="<?php  echo get_cat_name( get_option( 'subchild_cat_id_hidden' ) ); ?>" readonly>
		<input type="button" class="button-primary" value="Reset" id="reset"/>  
    </div>
</form>
</div>
</div>


<div id="video_response"><?php dailymotion_video_table( $search='', $basequeryurl='', $size='', $page='', $user='' ); ?></div>
</div>
<?php
}