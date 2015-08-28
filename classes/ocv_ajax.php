<?php 
/*
** AJAX FUNCTION
*/

function ocv_parent_function(){
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

function ocv_child_function() {
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

//DailyMotion Category Selection
function implement_ajax() {
	
		ocv_parent_function();
		
}

function implement_ajax_2() {
	
		ocv_child_function();

}

//Youtube Category Selection

function implement_ajax_youtube() {
	
		ocv_parent_function();
		
}
function implement_ajax_2_youtube() {
	
		ocv_child_function();

}

//Vimeo Category Selection

function implement_ajax_vimeo() {
	
		ocv_parent_function();
		
}
function implement_ajax_2_vimeo() {
		
		ocv_child_function();
		
}

//Publish Video AJAX Helper Function
function implement_ajax_video(){
if ( $_POST['publishAction'] == 'publish' ){
	$ocv_video_post_title = get_option('ocv_video_post_title');
	$post_title = ( $ocv_video_post_title ) ? $ocv_video_post_title : '' ;
	$post_title .= $_POST['publishTitle'];
	$post_description = $_POST['publishDescription'];
	$post_description_add = get_option('ocv_video_post_description');
	$post_entry_id = $_POST['publishEntry'];
	$post_duration = $_POST['publishDuration'];
	$post_views = $_POST['publishViews'];
	$post_parent_cat = $_POST['publishParentCat'];
	$post_child_cat = $_POST['publishChildCat'];
	$post_subchild_cat = $_POST['publishSubChild'];
	$post_thumbnail_url = $_POST['publishThumbnail'];
	$ocv_video_width = get_option('ocv_video_width') ? get_option('ocv_video_width') : '100%';
	$ocv_video_height = get_option('ocv_video_height') ? get_option('ocv_video_height') : '480';
	$ocv_syndication_key = get_option('ocv_syndication_key') ? get_option('ocv_syndication_key') : '';
	$ocv_video_autoplay = get_option('ocv_video_autoplay') ? get_option('ocv_video_autoplay') : '1' ;
	$ocv_video_post_format = get_option('ocv_video_post_format') ? get_option('ocv_video_post_format') : 'video' ;
	$ocv_video_post_status = get_option('ocv_video_post_status') ? get_option('ocv_video_post_status') : 'publish' ;
	$ocv_custom_field_video_embed = get_option('ocv_custom_field_video_embed');
	$youtube_related = get_option('youtube_related');
	$youtube_controls = get_option('youtube_controls');
	$youtube_showinfo = get_option('youtube_showinfo');	
	$ocv_related = get_option('ocv_related');
	$ocv_controls = get_option('ocv_controls');
	$ocv_showinfo = get_option('ocv_showinfo');		
	$youtube_size = get_option('youtube_size');	
	$ocv_size = get_option('ocv_size');	
	$vimeo_size = get_option('vimeo_size');	
	$youtube_autoplay = get_option('youtube_autoplay');	
	$vimeo_autoplay = get_option('vimeo_autoplay');	
	$content_type = $_POST['publishcontentType'];
	if ( 'youtube' == $content_type ) {
	$video_embed_code = '<iframe '.esc_attr( $youtube_size ).' src="http://www.youtube.com/embed/'.esc_html( $post_entry_id ).'?rel='.intval( $youtube_related ).'&autoplay='.intval( $youtube_autoplay ).'&controls='.intval( $youtube_controls ).'&showinfo='.intval( $youtube_showinfo ).' frameborder="0" allowfullscreen"></iframe>';	
	}elseif ( 'vimeo' == $content_type ) {
	$video_embed_code = '<iframe '.esc_attr( $vimeo_size ).' src="https://player.vimeo.com/video/'.esc_html( $post_entry_id ).'?autoplay='.intval( $vimeo_autoplay ).'frameborder="0" allowfullscreen"></iframe>';	
	}else{
	$video_embed_code = '<iframe '.esc_attr( $ocv_size ).' src="http://www.dailymotion.com/embed/video/'.esc_html( $post_entry_id ).'?autoplay='.intval( $ocv_video_autoplay ).'&logo=0&related='.intval( $ocv_related ).'&chromeless='.intval( $ocv_controls ).'&info='.intval( $ocv_showinfo ).'&syndication='.intval( $ocv_syndication_key ).'" frameborder="0" allowfullscreen"></iframe>';
	}
	$post_content = $ocv_custom_field_video_embed ? '' : $video_embed_code;
	$post_content .= $post_description;
	$post_content .= $post_description_add;
// Prepare data array
			$data = array(
			  'post_id' => NULL,
			  'post_title'    => sanitize_text_field ( $post_title ),
			  'post_content' => $post_content,
			  'post_type'  => 'post',
			  'post_status'   => sanitize_text_field ( $ocv_video_post_status),
			  'post_category' => array ($post_parent_cat,$post_child_cat,$post_subchild_cat)			  
			);
	$post_id = post_exists( $post_title );
	if (!$post_id) {
		$ocv_post_id = wp_insert_post( $data );
		set_post_format($ocv_post_id, sanitize_text_field ($ocv_video_post_format ) );
		if ( $ocv_custom_field_video_embed ) {
		add_post_meta($ocv_post_id, $ocv_custom_field_video_embed, $video_embed_code, true); 
		}
		add_post_meta($ocv_post_id, 'time_video', $post_duration.':00', true); 
		$upload_dir = wp_upload_dir();
		$image_data = file_get_contents($post_thumbnail_url);
		$filename = basename($post_thumbnail_url);
	if(wp_mkdir_p($upload_dir['path']))
		$file = $upload_dir['path'] . '/' .( wp_generate_password( 4, false ) ).$filename;
	else
		$file = $upload_dir['basedir'] . '/' .( wp_generate_password( 4, false ) ). $filename;
	file_put_contents($file, $image_data);
	$wp_filetype = wp_check_filetype($filename, null );
	$attachment = array(
		'post_mime_type' => $wp_filetype['type'],
		'post_title' => sanitize_file_name($filename),
		'post_content' => '',
		'post_status' => 'inherit'
	);
	$attach_id = wp_insert_attachment( $attachment, $file, $ocv_post_id );
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
	wp_update_attachment_metadata( $attach_id, $attach_data );
	set_post_thumbnail( $ocv_post_id, $attach_id );
	}
	// If a pointer has already been created for this post, throw duplicate error
	elseif ( !empty ( $post_id ) ) {
		echo "<div class=\"error\" style='margin:5px 0 2px;clear:both;'>";
		echo "	<p><strong>DUPLICATE ERROR:</strong>  <em>" . esc_html( $data['post_title'] ) . "</em> already exists in this site. <strong><a href='" . esc_url( admin_url( "post.php?action=edit&post=" . intval( $post_id ) ) ) . "'>Edit</a></strong></p>";
		echo "</div>";
	}	
	if( !empty ( $ocv_post_id ) ){
		echo "<div class=\"updated\" style='margin:5px 0 2px;clear:both;'>";
		echo "	<p><strong>Hurray!!</strong>  <em>" . esc_html( $data['post_title'] ) . "</em> was successfully posted. Now you can <strong><a href=\"" . esc_url( admin_url( "post.php?action=edit&post=" . intval( $ocv_post_id) ) ) . "\">Edit</a></strong> it or Publish Next Video.</p>";
		echo "</div><hr />";
	}
}
	die();
}