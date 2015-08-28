<?php
/**
 * Plugin Name: DailyMotion Search & Publish
 * Plugin URI: http://www.walihassan.com
 * Description: Search Any Youtube / Dailymotion & Vimeo Videos and Publish them as post just with one click
 * Version: 3.0
 * Author: Wali Hassan
 * Author URI: http://www.walihassan.com
 * License: GPL2
 */ 
define( 'OCV_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'OCV_PLUGIN_JS_URL', plugins_url( 'js/', __FILE__ ) );
define( 'OCV_PLUGIN_CSS_URL', plugins_url( 'css/', __FILE__ ) );
define( 'OCV_PLUGIN_CLASS_DIR', OCV_PLUGIN_DIR.'classes/' );
define( 'OCV_PLUGIN_IMAGES_DIR',  plugins_url( 'images/', __FILE__ ) );
define( 'OCV_PLUGIN_VENDOR_DIR',  plugins_url( 'vendor/', __FILE__ ) );

include ( OCV_PLUGIN_CLASS_DIR .'ocv_dailymotion.php' );
include ( OCV_PLUGIN_CLASS_DIR .'ocv_youtube.php' );
include ( OCV_PLUGIN_CLASS_DIR .'ocv_vimeo.php' );
include ( OCV_PLUGIN_CLASS_DIR .'ocv_user_settings.php' );
include ( OCV_PLUGIN_CLASS_DIR .'ocv_ajax.php' );
include ( OCV_PLUGIN_CLASS_DIR .'ocv_dm.php' );

class OCV_Plugin_Class {
	
	public function __construct() {
		add_action( 'admin_init', array ($this, 'register_ocv_settings' ) );
		add_action( 'admin_enqueue_scripts', array ($this, 'ocv_plugin_js' ) );		
		add_action( 'admin_menu', array ($this, 'ocv_create_menu') );		
		add_action( 'wp_ajax_category_select_action', 'implement_ajax' );
		add_action( 'wp_ajax_category_select_action2', 'implement_ajax_2' );
		add_action( 'wp_ajax_category_select_action_youtube', 'implement_ajax_youtube' );
		add_action( 'wp_ajax_category_select_action2_youtube', 'implement_ajax_2_youtube' );		
		add_action( 'wp_ajax_category_select_action_vimeo', 'implement_ajax_vimeo' );
		add_action( 'wp_ajax_category_select_action2_vimeo', 'implement_ajax_2_vimeo' );	
		add_action( 'wp_ajax_publish_video', 'implement_ajax_video' );
		add_action( 'wp_ajax_pagination_youtube', 'pagination_ajax_youtube' );
		add_action( 'wp_ajax_pagination_vimeo', 'pagination_ajax_vimeo' );
		add_action( 'wp_ajax_pagination_dailymotion', 'pagination_ajax_dailymotion' );		
		add_action( 'wp_ajax_nopriv_category_select_action', 'implement_ajax' );
		add_action( 'wp_ajax_nopriv_category_select_action2', 'implement_ajax_2' );
	}
	
	//Register Admin Scripts for the Plugin
	public function ocv_plugin_js() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );  		
		wp_enqueue_script( 'jquery-ui-tabs' );  
		wp_enqueue_script ( 'jquery-tables', 'http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js');
		wp_enqueue_script( 'ocv_plugin_js', OCV_PLUGIN_JS_URL . 'ocv_plugin.js' ); 
		wp_enqueue_style( 'ocv_plugin_css', OCV_PLUGIN_CSS_URL . 'ocv_plugin.css' ); 
		wp_enqueue_style( 'ocv_plugin_font', OCV_PLUGIN_CSS_URL . 'font-awesome.css' );
		wp_enqueue_style( 'jquery-style-tables', 'http://cdn.datatables.net/1.10.7/css/jquery.dataTables.css' ); 
		wp_enqueue_style( 'jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css' );
		wp_localize_script( 'ocv_plugin_js', 'ocv_plugin_vars', 
			array(
				'ajaxurl' =>  admin_url( 'admin-ajax.php' ),
				'pluginurl' => plugins_url ('ocv_vids.php')
				)
		);
	}
	
	public function register_ocv_settings() {
		
		//DailyMotion Category Selection
		register_setting( 'ocv_settings-group', 'parent_cat_id_hidden' );
		register_setting( 'ocv_settings-group', 'child_cat_id_hidden' );
		register_setting( 'ocv_settings-group', 'subchild_cat_id_hidden' );
		
		//Youtube Category Selection
		register_setting( 'ocv_settings-group-youtube', 'youtube_parent_cat_id_hidden' );
		register_setting( 'ocv_settings-group-youtube', 'youtube_child_cat_id_hidden' );
		register_setting( 'ocv_settings-group-youtube', 'youtube_subchild_cat_id_hidden' );

		//Vimeo Category Selection
		register_setting( 'ocv_settings-group-vimeo', 'vimeo_parent_cat_id_hidden' );
		register_setting( 'ocv_settings-group-vimeo', 'vimeo_child_cat_id_hidden' );
		register_setting( 'ocv_settings-group-vimeo', 'vimeo_subchild_cat_id_hidden' );
		
		//Theme Settings
		register_setting( 'ocv_settings-new', 'video_source' );		
		register_setting( 'ocv_settings-user', 'ocv_custom_field_video_embed' );
		register_setting( 'ocv_settings-user', 'ocv_video_post_title' );
		register_setting( 'ocv_settings-user', 'ocv_video_post_description' );
		register_setting( 'ocv_settings-user', 'ocv_video_post_status' );	
		register_setting( 'ocv_settings-user', 'ocv_video_post_format' );
		
		//Dailymotion Settings page
		register_setting( 'ocv_settings-dm', 'ocv_syndication_key' );
		register_setting( 'ocv_settings-dm', 'ocv_size' );
		register_setting( 'ocv_settings-dm', 'ocv_video_autoplay' );
		register_setting( 'ocv_settings-dm', 'ocv_related' );
		register_setting( 'ocv_settings-dm', 'ocv_controls' );
		register_setting( 'ocv_settings-dm', 'ocv_showinfo' );
		register_setting( 'ocv_settings-dm', 'ocv_familyfilter' );
		
		//Youtube Settings page
		register_setting( 'ocv_settings-yt', 'youtube_public_key' );
		register_setting( 'ocv_settings-yt', 'youtube_related' );
		register_setting( 'ocv_settings-yt', 'youtube_controls' );
		register_setting( 'ocv_settings-yt', 'youtube_showinfo' );
		register_setting( 'ocv_settings-yt', 'youtube_size' );
		register_setting( 'ocv_settings-yt', 'youtube_autoplay' );
		
		//Vimeo Settings Page
		register_setting( 'ocv_settings-vm', 'vimeo_client_id' );
		register_setting( 'ocv_settings-vm', 'vimeo_client_secret' );
		register_setting( 'ocv_settings-vm', 'vimeo_size' );
		register_setting( 'ocv_settings-vm', 'vimeo_autoplay' );
	}
	
	// Create Admin Menu for OCV Plugin
	public function ocv_create_menu() {
		
		add_menu_page('One Click Videos', 'One Click Videos', 'manage_options', 'ocv_settings' );
		add_submenu_page('ocv_settings', 'User Settings', ' - User Settings', 'manage_options', 'ocv_settings', 'ocv_user_settings', 'dashicons-video-alt3' );
		add_submenu_page('ocv_settings', 'DailyMotion', ' - DailyMotion Videos', 'manage_options', 'ocv_dailymotion', 'ocv_dailymotion' );
		add_submenu_page('ocv_settings', 'Youtube', ' - Youtube Videos', 'manage_options', 'ocv_youtube', 'ocv_youtube' );
		add_submenu_page('ocv_settings', 'Vimeo', ' - Vimeo Videos', 'manage_options', 'ocv_vimeo', 'ocv_vimeo' );		
	}
	
}

$ocv_plugin_class = new OCV_Plugin_Class();