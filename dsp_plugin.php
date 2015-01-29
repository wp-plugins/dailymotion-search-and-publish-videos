<?php
/**
 * Plugin Name: DailyMotion Search & Publish Videos
 * Plugin URI: http://www.walihassan.com/contact
 * Description: Searches Dailymotion Videos and publish them as post
 * Version: 1.1
 * Author: Wali Hassan
 * Author URI: http://www.walihassan.com
 * License: GPL2
 */
 
define( 'DSP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'DSP_PLUGIN_JS_URL', plugins_url( 'js/', __FILE__ ) );
define( 'DSP_PLUGIN_CSS_URL', plugins_url( 'css/', __FILE__ ) );
define( 'DSP_PLUGIN_CLASS_DIR', DSP_PLUGIN_DIR.'classes/' );
include ( DSP_PLUGIN_CLASS_DIR .'dsp_videos.php');
include ( DSP_PLUGIN_CLASS_DIR .'dsp_pagination.php');

add_action('wp_ajax_category_select_action', 'implement_ajax');
add_action('wp_ajax_category_select_action2', 'implement_ajax_2');
add_action('wp_ajax_nopriv_category_select_action', 'implement_ajax');
add_action('wp_ajax_nopriv_category_select_action2', 'implement_ajax_2');

function dsp_plugin_js() {
	wp_enqueue_script('jquery');  
	wp_enqueue_script( 'dsp_plugin_js', DSP_PLUGIN_JS_URL . 'dsp_plugin.js' ); 
	wp_enqueue_style( 'dsp_plugin_css', DSP_PLUGIN_CSS_URL . 'dsp_plugin.css' ); 
	wp_localize_script( 'dsp_plugin_js', 'dsp_plugin_vars', 
        array(
            'ajaxurl' =>  admin_url( 'admin-ajax.php' ),
			'pluginurl' => plugins_url ('dsp_vids.php')
            )
	);
}
add_action( 'admin_enqueue_scripts', 'dsp_plugin_js' );
add_action('admin_menu', 'dsp_create_menu');

function dsp_create_menu() {

	add_menu_page('DSP Plugin Settings', 'DSP VIDEOS', 'administrator', 'dsp_settings', 'dsp_settings_page');
	add_action( 'admin_init', 'register_dsp_settings' );
}

function register_dsp_settings() {

	register_setting( 'dsp-settings-group', 'parent_cat_id_hidden' );
	register_setting( 'dsp-settings-group', 'child_cat_id_hidden' );
	register_setting( 'dsp-settings-group', 'subchild_cat_id_hidden' );
}

//AJAX FUNCTION
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
