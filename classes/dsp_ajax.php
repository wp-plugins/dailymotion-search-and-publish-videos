<?php 
/*
** AJAX FUNCTION
*/
function implement_ajax() {
    $parent_cat_ID = $_POST['parent_cat_ID'];
    if ( isset($parent_cat_ID) )
    {
        $has_children = get_categories("parent=$parent_cat_ID&hide_empty=0");
        if ( $has_children ) {
            wp_dropdown_categories("show_option_none=Select Child category&orderby=name&depth=0&hierarchical=1&id=child_cat&parent=$parent_cat_ID&hide_empty=0");
        } else {
            ?><select name="sub_cat_disabled" id="sub_cat_disabled" disabled="disabled"><option>No child categories!</option></select><?php
        }
        die();
    }
}
function implement_ajax_2() {
	$child_cat_ID =  $_POST['child_cat_ID'];
	if ( isset($child_cat_ID) )
    {
        $has_children = get_categories("child_of=$child_cat_ID&hide_empty=0");
        if ( $has_children ) {
            wp_dropdown_categories("show_option_none=Select Child category&orderby=name&hierarchical=1&id=sub_child_cat&parent=$child_cat_ID&hide_empty=0");
        } else {
            ?><select name="sub_child_disabled" id="sub_child_disabled" disabled="disabled"><option>No child categories!</option></select><?php
        }
        die();
    }// end if
}