<?php
/*
*
* Dailymotion Search API to display Results
*
*/
function dailymotion_video_table($search='', $basequeryurl='', $size='', $page='', $user=''){
if ( get_option('parent_cat_id_hidden') != '' ) { ?>
	<div id="ocv_wrapper" class="dailymotion_3">
	<h3 class="ocv_step">Daily<em>motion</em> Search Videos</h3>
	<?php 
	if ( isset ( $_POST['search'] ) ) 
	$search = $_POST['search'];
	if ( isset ( $_POST['sort'] ) )  {
	$sort = $_POST['sort'];
	}else{
	$sort = 'relevance';
	}
	if ( isset ( $_POST['results'] ) )  {
	$results = $_POST['results'];
	}else{
	$results = '100';
	}	
	if ( isset ( $_POST['user'] ) )
	$user = $_POST['user'];
	?>
		<form method="POST">
			Keyword: <input type="text" name="search" value="<?php if ( $search ) echo ( $search ); ?>">
			Sort: <select name="sort">
			<option name="sort" value="relevance"<?php if ( $sort == 'relevance') echo 'selected'; ?> >relevance</option>
			<option name="sort" value="recent"<?php if ( $sort == 'recent') echo 'selected'; ?> >recent</option>
			</select>
			User ID: <input type="text" name="user" value="<?php   if ( $user ) echo ( $user ); ?>">
			<input class="button-primary" type="submit" name="submit" value="GO!">
		</form>
	</div>
	<div id="success_response"></div>
	<?php
}
	if ( ( isset ($_POST['search']) && $_POST['search'] !== '' ) || ( isset ($_POST['user']) && $_POST['user'] !== '' && $_POST['search'] === '' ) ) {
		$family_filter = ( get_option ('ocv_familyfilter') ) ? get_option ('ocv_familyfilter') : 'true';
		$search = $_POST['search'];
		if ( isset ( $_POST['user'] ) )
		$user = $_POST['user'];
		$sort = $_POST['sort'];
		$size = 10;
		$page = isset( $_GET['p'] ) ? intval( $_GET['p'] ) : isset ( $_POST['p']) ? intval ($_POST['p']): 1 ;
		$search = str_replace(' ', '+', $search);
		$from = $size * ( $page - 1 );
	
		if ( $search && !$user) {	
			$url="https://api.dailymotion.com/videos?search=".esc_html( $search ).
			"&fields=id,owner,title,description,url,views_total,owner.username,owner.screenname,duration,updated_time,thumbnail_180_url,thumbnail_url&language=en&limit=100&sort=".esc_html( $sort )."&page=".esc_html( $page )."&family_filter=".esc_html( $family_filter )."";
		}else if ( $user && !$search ) {
			$url="https://api.dailymotion.com/user/".esc_html( $user ).
			"/videos?fields=id,owner,title,description,url,views_total,owner.username,owner.screenname,duration,updated_time,thumbnail_180_url,thumbnail_url&language=en&limit=100&sort=recent&page=".esc_html( $page )."&family_filter=".esc_html( $family_filter )."";
		}else if ( $user && $search) {
			$url="https://api.dailymotion.com/user/".esc_html( $user )."/videos?search=".esc_html( $search ).
			"&fields=id,owner,title,description,url,views_total,owner.username,owner.screenname,duration,updated_time,thumbnail_180_url,thumbnail_url&language=en&limit=100&sort=".esc_html( $sort )."&page=".esc_html( $page )."&family_filter=".esc_html( $family_filter )."";
		}
	//print_r ($url);
	if ($url) 
		
		//Checking if file_get_contents fails for any reason then move to CURL
		
		if ( ini_get('allow_url_fopen') ){
			$json = file_get_contents ( $url, true );
		}else{ 
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL,$url);
			$json=curl_exec($ch);
		}
	
	if ( $json ) {
		
	$content = json_decode($json, true);

		echo "<br/><table id='publish_table'  class='stripe' cellspacing='0' width='100%'>";
		echo "<thead>";
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
		echo "</thead>";
		echo "<tfoot>";
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
		echo "</tfoot>";			
	foreach ($content['list'] as $entry ) {

		$title = $entry['title'];
		$duration = number_format( $entry['duration']/60 );
		$views = number_format( $entry['views_total'] );
		$url_link = $entry['url'];
		$userid = $entry['owner.username'];
		$author = $entry['owner.screenname'];
		$entry_id = $entry['id'];
		$description = $entry['description'];
		$epoch = $entry['updated_time'];
		$dt = new DateTime("@$epoch"); // convert UNIX timestamp to PHP DateTime
		$post_published = $dt->format('d-m-Y H:i:s'); // output = 2012-08-15 00:00:00 
		$thumbnail_url = $entry['thumbnail_url'];
		$small_thumb = $entry['thumbnail_180_url'];
		$parent_cat = get_option('parent_cat_id_hidden');
		$child_cat =  get_option('child_cat_id_hidden');
		$subchild_cat =  get_option('subchild_cat_id_hidden');
		$basequeryurl = 'admin.php?page=ocv_dailymotion';

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
	
	
	<div id="spinner"><img src="<?php echo OCV_PLUGIN_IMAGES_DIR. 'load-indicator.gif';?>" alt="Loading..."/></div>
	
	<a  href="javascript:void(0)" class="publish_button button-primary">Publish Video</a></td>
	
	<input type="hidden" id="ajax_publish_videos" value="publish">
	<input type="hidden" name="ajax_entry_id" id="ajax_entry_id" value="<?php echo esc_attr( $entry_id ); ?>">
	<input type="hidden" id="ajax_title" value="<?php echo esc_html ( $title ); ?>">
	<input type="hidden" id="ajax_description" value="<?php echo esc_html( $description ); ?>">
	<input type="hidden" id="ajax_duration" value="<?php echo esc_attr ( $duration ); ?>">	
	<input type="hidden" id="ajax_views" value="<?php echo esc_attr ( $views ); ?>">	
	<input type="hidden" id="ajax_parent_cat" value="<?php echo esc_html ( $parent_cat ); ?>">
	<input type="hidden" id="ajax_child_cat" value="<?php echo esc_html ( $child_cat ); ?>">	
	<input type="hidden" id="ajax_subchild_cat" value="<?php echo esc_html ( $subchild_cat ); ?>">	
	<input type="hidden" id="ajax_thumbnail_url" value="<?php echo esc_url ( $thumbnail_url ); ?>">	
	<input type="hidden" id="ajax_search" value="<?php echo esc_html ( $search ); ?>">	
	<input type="hidden" id="ajax_page" value="<?php echo esc_attr ( $page ); ?>">	
	<input type="hidden" id="ajax_user" value="<?php echo esc_attr ( $user ); ?>">		
	<input type="hidden" id="ajax_sort" value="<?php echo esc_attr ( $sort ); ?>">		
	<input type="hidden" id="ajax_results" value="<?php echo esc_attr ( $results ); ?>">	
	<input type="hidden" id="ajax_contentType" value="dailymotion">		
	</tr>	
		<?php
	}
			echo "</table>";
		}else{
			echo "<br /><div class=\"error\" style='text-align:center;margin:5px 2px;'><h2>I tried so much .. and you still managed to break it?  what did you do? Huh?</h2></div>";
		}
	} elseif ( ( isset ($_POST['user']) && $_POST['user'] === '') && ( isset ($_POST['search']) && $_POST['search'] === '') )  {
		echo "<div class=\"error\" style='text-align:left;margin:5px 0 2px;'><h2>Please type a search keyword</h2></div>";
	} else {
	echo "<div class=\"error\" style='text-align:center;margin:5px 0 2px;'><h2>Please start by typing a search keyword above!</h2></div>";
	}
}
