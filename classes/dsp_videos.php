<?php 
/*
** Video Dashboard
*/
function dsp_dashboard_page() {
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
	<div id="spinner"><img src="<?php echo DSP_PLUGIN_IMAGES_DIR. 'load-indicator.gif';?>" alt="Loading..."/></div>
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
		Total Results: <select name="results">
		<option name="100" value="100"<?php if ( $sort_selected == '100') echo 'selected'; ?> >100</option>
		<option name="200" value="200"<?php if ( $sort_selected == '200') echo 'selected'; ?> >200</option>
		</select>
		Search by User ID: <input type="text" name="user" value="<?php echo ( $_POST['user'] ? $_POST['user'] : $_GET['user'] ); ?>">
		<input class="button-primary" type="submit" name="submit" value="GO!">
	</form>
</div>
<?php 
}
?>
</div>
<div id="success_response"></div>
<?php
}elseif ( $video_source == 'youtube' || $video_source == 'vimeo'  ) {
	?>
	<h1 style="text-align:center;">Coming Soon</h1>
	<?php }?>


	<div id="video_response"><?php video_table($search, $basequeryurl='', $size='', $page='', $user); ?></div>

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


function video_table($search, $basequeryurl='', $size='', $page='', $user=''){
if ( ( isset ($_POST['search']) || isset ($_GET['search'])  && $_POST['search'] !== '' ) || ( isset ($_POST['user']) || isset ($_GET['user'])  && $_POST['user'] !== '' ) ) {
	$search = $_POST['search'] ? $_POST['search'] : $_GET['search'] ;
	$user = $_POST['user'] ? $_POST['user'] : $_GET['user'] ;
	$sort = $_POST['sort'] ? $_POST['sort']  : $_GET['sort'];
	$size = 10;
	$page = isset( $_GET['p'] ) ? intval( $_GET['p'] ) : isset ( $_POST['p']) ? intval ($_POST['p']): 1 ;
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

	echo "<br/><table id='publish_table' border='1' width='100%'>";
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
	<td><?php echo  $post_published; ?></td>
	<td style="text-align:center;">
	<input type="hidden" id="ajax_publish_videos" value="publish">
	<input type="hidden" name="ajax_entry_id" id="ajax_entry_id" value="<?php echo $entry_id; ?>">
	<input type="hidden" id="ajax_title" value="<?php echo $title; ?>">
	<input type="hidden" id="ajax_duration" value="<?php echo $duration; ?>">	
	<input type="hidden" id="ajax_views" value="<?php echo $views; ?>">	
	<input type="hidden" id="ajax_parent_cat" value="<?php echo $parent_cat; ?>">
	<input type="hidden" id="ajax_child_cat" value="<?php echo $child_cat; ?>">	
	<input type="hidden" id="ajax_subchild_cat" value="<?php echo $subchild_cat; ?>">	
	<input type="hidden" id="ajax_thumbnail_url" value="<?php echo $thumbnail_url; ?>">	
	<input type="hidden" id="ajax_search" value="<?php echo $search; ?>">	
	<input type="hidden" id="ajax_page" value="<?php echo $page; ?>">	
	<input type="hidden" id="ajax_user" value="<?php echo $user; ?>">		
	<input type="hidden" id="ajax_sort" value="<?php echo $sort; ?>">		
	<input type="hidden" id="ajax_results" value="<?php echo $results; ?>">		
	
	<div id="spinner"><img src="<?php echo DSP_PLUGIN_IMAGES_DIR. 'load-indicator.gif';?>" alt="Loading..."/></div>
	
	<a  href="javascript:void(0)" class="publish_button button-primary">Publish Video</a></td>
	</tr>
		<?php
	}
		dsp_pagination($page, $size, $basequeryurl, $sort, $search, $user, $results);
			echo "</table>";
		dsp_pagination($page, $size, $basequeryurl, $sort, $search, $user, $results);
	} elseif ( ( isset ($_POST['user']) && $_POST['user'] === '') && ( isset ($_POST['search']) && $_POST['search'] === '') )  {
		echo "<div class=\"error\" style='text-align:left;margin:5px 0 2px;'><h2>Please type a search keyword</h2></div>";
	} else {
	echo "<div class=\"error\" style='text-align:center;margin:5px 0 2px;'><h2>Please start by typing a search keyword above!</h2></div>";
	}
}

