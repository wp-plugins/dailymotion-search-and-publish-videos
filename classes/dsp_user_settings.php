<?php /*** User Settings Admin Menu*/
function dsp_user_settings() {?><div id="dsp_page_wrap_user">	<h1>DailyMotion User Settings</h1>	<form method="post" action="options.php">		<?php settings_fields( 'dsp-settings-user' ); ?>		<?php do_settings_sections( 'dsp-settings-user' ); ?>		<table class="form-table">			<th scope="row"><h3 class="dsp_heading">Video Post Settings </h3></th>			<tr valign="top">			<th scope="row">Video Embed Custom Field</th>			<td><input type="text" name="dsp_custom_field_video_embed" value="<?php echo esc_attr( get_option('dsp_custom_field_video_embed') ); ?>" />			<p>If you want to embed your videos within the post content, simply leave this field empty.<br />			However, if your theme has a separate custom field for video embeds, please put the custom field ID here.</p></td>			</tr>						<tr valign="top">			<th scope="row">Prefix Video Title.</th>			<td><input type="text" name="dsp_video_post_title" value="<?php echo esc_attr( get_option('dsp_video_post_title') ); ?>" />			<p>Do you want to add something before your Video Post Title ( for example: Must Watch or Exclusive or Breaking ) ? <br/>			If so, please add that word in the field above and it will be added before your Post Title. <br />			Leave this field empty if you don't want anything added to videos post title.</p></td>			</tr>						<?php $dsp_video_post_status = get_option('dsp_video_post_status'); ?>			<tr valign="top">			<th scope="row">Post Status</th>			<td><input type="radio" name="dsp_video_post_status[radio]" value="publish" <?php checked('publish', $dsp_video_post_status['radio']); ?> />Publish			<input type="radio" name="dsp_video_post_status[radio]" value="draft" <?php checked('draft', $dsp_video_post_status['radio']); ?> />Draft			</td>			</tr>						<?php $dsp_video_post_format = get_option('dsp_video_post_format'); ?>			<tr valign="top">			<th scope="row">Post Format</th>			<td><input type="radio" name="dsp_video_post_format[radio]" value="standard" <?php checked('standard', $dsp_video_post_format['radio']); ?> />Standard			<input type="radio" name="dsp_video_post_format[radio]" value="video" <?php checked('video', $dsp_video_post_format['radio']); ?> />Video			</td>			</tr>						<th scope="row"><h3 class="dsp_heading">Player Settings</h3></th>			<tr valign="top">			<th scope="row">Syndication Key</th>			<td><input type="text" name="dsp_syndication_key" value="<?php echo esc_attr( get_option('dsp_syndication_key') ); ?>" />			<p>Your syndication key is a unique id which will allow Dailymotion to track the revenue generated by the video / widgets you are embedding. <br />			If you are not earning money from Dailymotion Videos you should signup as <a href="http://publisher.dailymotion.com" target="_blank">DailyMotion Publisher</a></p></td>			</tr>						<tr valign="top">			<th scope="row">Video Player Size</th>			<td>Width: <input type="text" name="dsp_video_width" value="<?php echo esc_attr( get_option('dsp_video_width') ); ?>" />			Height: <input type="text" name="dsp_video_height" value="<?php echo esc_attr( get_option('dsp_video_height') ); ?>" />			<p>For responsive video size, type 100% in width and 480 in height otherwise you can use your own settings<br/></td>			<?php $dsp_video_post_format = get_option('dsp_video_post_format'); ?>			</tr>						<?php $dsp_video_autoplay = get_option('dsp_video_autoplay'); ?>				<tr valign="top">			<th scope="row">AutoPlay Video</th>			<td><input type="radio" name="dsp_video_autoplay[radio]" value="1" <?php checked('1', $dsp_video_autoplay['radio']); ?> />Yes			<input type="radio" name="dsp_video_autoplay[radio]" value="0" <?php checked('0', $dsp_video_autoplay['radio']); ?> />No			</td>			</tr>					</table>				<?php submit_button(); ?>	</form></div><?php dsp_info_html();}