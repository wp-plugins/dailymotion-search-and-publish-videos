<?php 
/*
** Video Dashboard
*/
function dsp_dashboard_page($search, $basequeryurl='', $search='', $size='', $page='') {
?>
<div id="dsp_main_wrap">
<div id="dsp_page_wrap">
<div id="dsp_wrap">
	<div id="video_source">
	<hr />
		<h1 class="dsp_step"> Step 1 </h1>
			<h3 class="dsp_step">Select Your Video Source</h3>
				<form method="post" action="options.php">
				<?php 
				settings_fields( 'dsp-settings-new' ); 
				do_settings_sections( 'dsp-settings-new' ); 
				$video_source = get_option('video_source');
				?>
					<select id="video_source" name="video_source">
					<option value=""<?php if ( $video_source == '') echo 'selected=selected'; ?>>Select a Source</option>
					<option value="youtube"<?php if ( $video_source == 'youtube') echo 'selected=selected'; ?>>YouTube</option>
					<option value="dailymotion"<?php if ( $video_source == 'dailymotion') echo 'selected=selected'; ?>>DailyMotion</option>
					<option value="vimeo"<?php if ( $video_source == 'vimeo') echo 'selected=selected'; ?>>Vimeo</option>
					</select>
					<input class="button-primary" type="submit" name="submit" value="Save Source">
				</form>
	<hr />
</div>
<?php 
if ( $video_source == 'dailymotion' ) { 
?>
<div id="category_source">
	<h1 class="dsp_step"> Step 2 </h1>
	<h3 class="dsp_step">Select Category & Sub-Categories</h3>
	<form method="post" action="options.php">
    <?php settings_fields( 'dsp-settings-group' ); ?>
    <?php do_settings_sections( 'dsp-settings-group' ); 
	$selected="";?>
	<div id="parent_cat_div" style="float:left"><?php wp_dropdown_categories("show_option_none=Select parent category&orderby=name&depth=1&hierarchical=1&id=parent_cat&hide_empty=0"); ?></div>
	<div id="sub_cat_div" style="float:left"><select name="sub_cat_disabled" id="sub_cat_disabled" disabled="disabled"><option>Select parent category first!</option></select></div>
	<div id="sub_child_div" ><select name="sub_child_disabled" id="sub_child_disabled" disabled="disabled"><option>Select Child category first!</option></select></div>
		<input class="button-primary categories" type="submit" name="submit" value="Save Categories">
	<br /><br />
	<div id="published_cat">
	<h3>Videos will be posted to the following category + sub-categories</h3>
		<input type="hidden" id="parent_cat_id_hidden" name="parent_cat_id_hidden" value="<?php echo get_option('parent_cat_id_hidden'); ?>">
		Main Category:<input type="text" id="parent_cat_name" value="<?php  echo get_cat_name(get_option('parent_cat_id_hidden')); ?>">
		<input type="hidden" id="child_cat_id_hidden"  name="child_cat_id_hidden" value="<?php echo get_option('child_cat_id_hidden'); ?>">
		Sub Category<input type="text" id="child_cat_name" value="<?php  echo get_cat_name(get_option('child_cat_id_hidden')); ?>">
		<input type="hidden" id="subchild_cat_id_hidden" name="subchild_cat_id_hidden" value="<?php echo get_option('subchild_cat_id_hidden'); ?>">
		Sub Sub Category<input type="text" id="subchild_cat_name" value="<?php  echo get_cat_name(get_option('subchild_cat_id_hidden')); ?>">
		<input type="button" class="button-primary" value="Reset" id="reset"/>  
    </div>
</form>
</div>
</div>
<?php 
 if ( get_option('parent_cat_id_hidden') != '' ) { ?>
<div id="dsp_wrapper">
<h1 class="dsp_step"> Step 3 </h1>
	<h3 class="dsp_step">Daily<em>motion</em> Search Videos</h3>
	<form method="POST">
		Search Keyword: <input type="text" name="search" value="<?php echo ( $_POST['search'] ? $_POST['search'] : $_GET['search'] ); ?>">
		Sort: <select name="sort">
		<?php $sort_selected = $_POST['sort'] ? $_POST['sort'] : $_GET['sort']; ?>
		<option name="relevance" value="relevance"<?php if ( $sort_selected == 'relevance') echo 'selected'; ?> >relevance</option>
		<option name="recent" value="recent"<?php if ( $sort_selected == 'recent') echo 'selected'; ?> >recent</option>
		</select>
		Search by User ID: <input type="text" name="user" value="<?php echo ( $_POST['user'] ? $_POST['user'] : $_GET['user'] ); ?>">
		Total Results: <select name="results">
		<option name="100" value="100"<?php if ( $sort_selected == '100') echo 'selected'; ?> >100</option>
		<option name="200" value="200"<?php if ( $sort_selected == '200') echo 'selected'; ?> >200</option>
		</select>
		<input class="button-primary" type="submit" name="submit" value="GO!">
	</form>
</div>
<?php 
}
?>
</div>
<?php
//dsp_info_html();
if ( $_GET['action'] == 'publish' && ( !isset ( $_POST['search'] )  && ( !isset ( $_POST['user'] )) ) ){		
	$dsp_video_post_title = get_option('dsp_video_post_title') ? get_option('dsp_video_post_title').' ' : '';
	$post_title .= $dsp_video_post_title;
	$post_title .= $_GET['title'];
	$post_entry_id = $_GET['entry_id'];
	$post_duration = $_GET['duration'];
	$post_views = $_GET['views'];
	$post_parent_cat =$_GET['parent_cat'];
	$post_child_cat =$_GET['child_cat'];
	$post_subchild_cat = $_GET['subchild_cat'];
	$post_thumbnail_url = $_GET['thumbnail_url'];
	$dsp_video_width = get_option('dsp_video_width') ? get_option('dsp_video_width') : '100%';
	$dsp_video_height = get_option('dsp_video_height') ? get_option('dsp_video_height') : '480';
	$dsp_syndication_key = get_option('dsp_syndication_key') ? get_option('dsp_syndication_key') : '';
	$dsp_video_autoplay = get_option('dsp_video_autoplay') ? get_option('dsp_video_autoplay') : '1' ;
	$dsp_video_post_format = get_option('dsp_video_post_format') ? get_option('dsp_video_post_format') : 'video' ;
	$dsp_video_post_status = get_option('dsp_video_post_status') ? get_option('dsp_video_post_status') : 'publish' ;
	$dsp_custom_field_video_embed = get_option('dsp_custom_field_video_embed');
	$video_embed_code = '<iframe frameborder="0" width="'.esc_html( $dsp_video_width ).'" height="'.esc_html( $dsp_video_height ).'" src="http://www.dailymotion.com/embed/video/'.esc_html( $post_entry_id ).'?autoplay='.intval( $dsp_video_autoplay['radio'] ).'&logo=0&hideInfos=1&syndication='.intval( $dsp_syndication_key ).'"></iframe>';
	$post_content = $dsp_custom_field_video_embed ? '' : $video_embed_code;
// Prepare data array
			$data = array(
			  'post_id' => NULL,
			  'post_title'    => sanitize_text_field ( $post_title ),
			  'post_content' => $post_content,
			  'post_type'  => 'post',
			  'post_status'   => sanitize_text_field ( $dsp_video_post_status['radio'] ),
			  'post_category' => array ($post_parent_cat,$post_child_cat,$post_subchild_cat)			  
			);
	$post_id = post_exists( $post_title );
	if (!$post_id) {
		$dsp_post_id = wp_insert_post( $data );
		set_post_format($dsp_post_id, sanitize_text_field ($dsp_video_post_format['radio'] ) );
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
if ( ( isset ($_POST['search']) || isset ($_GET['search'])  && $_POST['search'] !== '' ) || ( isset ($_POST['user']) || isset ($_GET['user'])  && $_POST['user'] !== '' ) ) {
	$search = $_POST['search'] ? $_POST['search'] : $_GET['search'] ;
	$user = $_POST['user'] ? $_POST['user'] : $_GET['user'] ;
	$sort = $_POST['sort'] ? $_POST['sort']  : $_GET['sort'];
	$size = 10;
	$page = isset( $_GET['p'] ) ? intval( $_GET['p'] ) : 1;
	$search = str_replace(' ', '+', $search);
	$from = $size * ( $page - 1 );
	if ( $search && !$user) {	
	$url="https://api.dailymotion.com/videos?search=".esc_html( $search ).
	"&fields=id,owner,title,url,views_total,owner.username,owner.screenname,duration,updated_time,thumbnail_180_url,thumbnail_url&language=en&sort=".esc_html( $sort )."&page=".esc_html( $page )."";
	}else if ( $user && !$search ) {
	$url="https://api.dailymotion.com/user/".esc_html( $user ).
	"/videos?fields=id,owner,title,url,views_total,owner.username,owner.screenname,duration,updated_time,thumbnail_180_url,thumbnail_url&language=en&sort=recent&page=".esc_html( $page )."";;
	}else if ( $user && $search) {
	$url="https://api.dailymotion.com/user/".esc_html( $user )."/videos?search=".esc_html( $search ).
	"&fields=id,owner,title,url,views_total,owner.username,owner.screenname,duration,updated_time,thumbnail_180_url,thumbnail_url&language=en&sort=".esc_html( $sort )."&page=".esc_html( $page )."";;
	}
	//print_r ($url);
	$json = file_get_contents ( $url, true );
	$content = json_decode($json, true);
	//var_dump ( $content );
	echo "<br/><table border='1' width='100%'>";
	echo "<tr>";
	echo "<th>Video</th>";
	echo "<th>Title</th>";
	echo "<th>User ID</th>";
	echo "<th>User Name</th>";
	echo "<th>Duration</th>";
	echo "<th>Views</th>";
	echo "<th>Published</th>";
	echo "<th>Action</th>";
	echo "</tr>";
	foreach ($content['list'] as $entry ) {
		$title = $entry['title'];
		$duration = number_format( $entry['duration']/60 );
		$views = number_format( $entry['views_total'] );
		$url_link = $entry['url'];
		$userid = $entry['owner.username'];
		$author = $entry['owner.screenname'];
		$entry_id = $entry['id'];
		$epoch = $entry['updated_time'];
		$dt = new DateTime("@$epoch"); // convert UNIX timestamp to PHP DateTime
		$post_published = $dt->format('d-m-Y H:i:s'); // output = 2012-08-15 00:00:00 
		$results = $_POST['results'] ? $_POST['results']  : $_GET['results'];
		$thumbnail_url = $entry['thumbnail_url'];
		$small_thumb = $entry['thumbnail_180_url'];
		$parent_cat = get_option('parent_cat_id_hidden');
		$child_cat =  get_option('child_cat_id_hidden');
		$subchild_cat =  get_option('subchild_cat_id_hidden');
		$basequeryurl = 'admin.php?page=dsp_dashboard';
		$url_data = admin_url( $basequeryurl . '&action=publish&entry_id='.esc_html($entry_id).'&title='.esc_html($title).'&duration='.intval($duration).'&views='.intval($views).'&parent_cat='.intval($parent_cat).'&child_cat='.intval($child_cat).'&thumbnail_url='.esc_url( $thumbnail_url ).'&subchild_cat='.intval($subchild_cat) .'&search='.esc_html( $search ).'&p=' . intval( $page ) .'&user=' . esc_html( $user ) .'&sort=' . esc_html( $sort ).'&results=' . esc_html( $results ) );
	?>
	<tr>
	<td><img src="<?php echo $small_thumb; ?>" width="200" height="125"></td>
	<td><a target="_blank" href="<?php echo $url_link; ?>" title="<?php echo $title; ?>" rel="nofollow">
	<strong><?php echo $title; ?></strong></a></td>
	<td><?php echo $userid; ?></td>
	<td><?php echo $author; ?></td>
	<td><?php echo  $duration; ?> minutes</td>
	<td><?php echo  $views; ?> views </td>
	<td><?php echo  $post_published; ?> </td>
	<td style="text-align:center;"><a href="<?php echo ( $url_data ); ?>" class="button-primary">Publish Video</a></td>
	</tr>
		<?php
	}
		dsp_pagination($results, $page, $size, $basequeryurl, $sort, $search, $user, $results);
			echo "</table><hr />";
		dsp_pagination($results, $page, $size, $basequeryurl, $sort, $search, $user, $results);
	} if ( ( isset ($_POST['user']) && $_POST['user'] === '') && ( isset ($_POST['search']) && $_POST['search'] === '') )  {
		echo "<div class=\"error\" style='text-align:left;margin:5px 0 2px;'><h2>Please type a search keyword</h2></div>";
	}	
	}else{ 
	if ( $video_source == 'youtube' || $video_source == 'vimeo'  ) {
	?>
	<h1 style="text-align:center;">Coming Soon</h1>
	<?php }?>
	</div></div>
	<?php
		//dsp_info_html();
		}
?>
</div>
<?php
}
function dsp_info_html(){
?>
	<div id="dsp_footer_section">
		<img src="<?php echo ( DSP_PLUGIN_IMAGES_DIR .'dsp_logo.jpg' );?>" style="width:100%;">
		<br/><br/>
		<strong>
		DailyMotion Search & Publish Videos PLUGIN is developed by <a href="http://www.walihassan.com" target="_blank">Wali Hassan Jafferi</a> and distributed FREE. </br><br/>
		You are allowed to modify / customize or re-use this plugin and I'll appreciate if you can just leave credits.</br><br/>
		Please do not send requests on my Facebook / Twitter profiles. Please follow the procedure below:</br><br/>
		</strong>
		<strong>Requests: </strong> Please <a href="mailto:walihassanjafferi@gmail.com?Subject=DSP%20Plugin%20Request" target="_top">Email Me</a> for any add-on features. <br/><br/>
		<strong>Feedback: </strong>Please visit <a href="http://www.walihassan.com/dailymotion-search-and-publish-videos-wordpress-plugin/" target="_blank">Comments Section</a> and leave your comments. <br/><br/>
		<strong>Support: </strong>Please create a ticket at <a href="https://wordpress.org/support/plugin/dailymotion-search-and-publish-videos" target="_blank">Wordpress Support Forum</a> and dont forget to leave review & ratings.
	</div>
<?php
}