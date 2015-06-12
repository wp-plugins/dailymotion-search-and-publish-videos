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

function implement_ajax_video(){
if ( $_POST['publishAction'] == 'publish' ){		
	$dsp_video_post_title = get_option('dsp_video_post_title') ? get_option('dsp_video_post_title').' ' : '';
	$post_title .= $dsp_video_post_title;
	$post_title .= $_POST['publishTitle'];
	$post_entry_id = $_POST['publishEntry'];
	$post_duration = $_POST['publishDuration'];
	$post_views = $_POST['publishViews'];
	$post_parent_cat =$_POST['publishParentCat'];
	$post_child_cat =$_POST['publishChildCat'];
	$post_subchild_cat = $_POST['publishSubChild'];
	$post_thumbnail_url = $_POST['publishThumbnail'];
	$dsp_video_width = get_option('dsp_video_width') ? get_option('dsp_video_width') : '100%';
	$dsp_video_height = get_option('dsp_video_height') ? get_option('dsp_video_height') : '480';
	$dsp_syndication_key = get_option('dsp_syndication_key') ? get_option('dsp_syndication_key') : '';
	$dsp_video_autoplay = get_option('dsp_video_autoplay') ? get_option('dsp_video_autoplay') : '1' ;
	$dsp_video_post_format = get_option('dsp_video_post_format') ? get_option('dsp_video_post_format') : 'video' ;
	$dsp_video_post_status = get_option('dsp_video_post_status') ? get_option('dsp_video_post_status') : 'publish' ;
	$dsp_custom_field_video_embed = get_option('dsp_custom_field_video_embed');
	$video_embed_code = '<iframe frameborder="0" width="'.esc_html( $dsp_video_width ).'" height="'.esc_html( $dsp_video_height ).'" src="http://www.dailymotion.com/embed/video/'.esc_html( $post_entry_id ).'?autoplay='.intval( $dsp_video_autoplay ).'&logo=0&hideInfos=1&syndication='.intval( $dsp_syndication_key ).'"></iframe>';
	$post_content = $dsp_custom_field_video_embed ? '' : $video_embed_code;
// Prepare data array
			$data = array(
			  'post_id' => NULL,
			  'post_title'    => sanitize_text_field ( $post_title ),
			  'post_content' => $post_content,
			  'post_type'  => 'post',
			  'post_status'   => sanitize_text_field ( $dsp_video_post_status),
			  'post_category' => array ($post_parent_cat,$post_child_cat,$post_subchild_cat)			  
			);
	$post_id = post_exists( $post_title );
	if (!$post_id) {
		$dsp_post_id = wp_insert_post( $data );
		set_post_format($dsp_post_id, sanitize_text_field ($dsp_video_post_format ) );
		if ( $dsp_custom_field_video_embed ) {
		add_post_meta($dsp_post_id, $dsp_custom_field_video_embed, $video_embed_code, true); 
		}
		add_post_meta($dsp_post_id, 'time_video', $post_duration.':00', true); 
		$upload_dir = wp_upload_dir();
		$image_data = file_get_contents($post_thumbnail_url);
		$filename = basename($post_thumbnail_url);
	if(wp_mkdir_p($upload_dir['path']))
		$file = $upload_dir['path'] . '/' . $filename;
	else
		$file = $upload_dir['basedir'] . '/' . $filename;
	file_put_contents($file, $image_data);
	$wp_filetype = wp_check_filetype($filename, null );
	$attachment = array(
		'post_mime_type' => $wp_filetype['type'],
		'post_title' => sanitize_file_name($filename),
		'post_content' => '',
		'post_status' => 'inherit'
	);
	$attach_id = wp_insert_attachment( $attachment, $file, $dsp_post_id );
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
	wp_update_attachment_metadata( $attach_id, $attach_data );
	set_post_thumbnail( $dsp_post_id, $attach_id );
	}
	// If a pointer has already been created for this post, throw duplicate error
	elseif ( !empty ( $post_id ) ) {
		echo "<div class=\"error\" style='margin:5px 0 2px;clear:both;'>";
		echo "	<p><strong>DUPLICATE ERROR:</strong>  <em>" . esc_html( $data['post_title'] ) . "</em> already exists in this site. <strong><a href='" . esc_url( admin_url( "post.php?action=edit&post=" . intval( $post_id ) ) ) . "'>Edit</a></strong></p>";
		echo "</div>";
	}	
	if( !empty ( $dsp_post_id ) ){
		echo "<div class=\"updated\" style='margin:5px 0 2px;clear:both;'>";
		echo "	<p><strong>Hurray!!</strong>  <em>" . esc_html( $data['post_title'] ) . "</em> was successfully posted. Now you can <strong><a href=\"" . esc_url( admin_url( "post.php?action=edit&post=" . intval( $dsp_post_id) ) ) . "\">Edit</a></strong> it or Publish Next Video.</p>";
		echo "</div><hr />";
	}
}
	die();
}