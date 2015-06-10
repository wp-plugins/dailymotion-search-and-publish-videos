jQuery(document).ready(function() {     
	
	jQuery('#parent_cat').change(function(){
	jQuery('#spinner').show();
	var parentCat=jQuery('#parent_cat').val();
	var data = {
	action: 'category_select_action',
	dsp_ajax_gallery_nonce : dsp_plugin_vars.dsp_ajax_gallery_nonce,
	parent_cat_ID:parentCat
	};
	 jQuery.post(ajaxurl, data, function(response) {
		jQuery('#sub_cat_disabled').removeAttr("disabled").html(response);
		jQuery('#parent_cat_id_hidden').val(parentCat);
		jQuery('#spinner').hide();
		return false;
		});
	});
	
	
	jQuery('#sub_cat_disabled').change(function(){
	jQuery('#spinner').show();
	var childCat=jQuery('#sub_cat_disabled').val();
	var data = {
	action: 'category_select_action2',
	dsp_ajax_gallery_nonce : dsp_plugin_vars.dsp_ajax_gallery_nonce,
	child_cat_ID:childCat
	};
	 jQuery.post(ajaxurl, data, function(response) {
		jQuery('#sub_child_disabled').removeAttr("disabled").html(response);
		jQuery('#child_cat_id_hidden').val(childCat);
		jQuery('#spinner').hide();
		return false;
		});
	});
	
	
	jQuery('#sub_child_disabled').change(function(){
	jQuery('#spinner').show();
	var subchildCat=jQuery('#sub_child_disabled').val();
	var data = {
	//action: 'category_select_action3',
	//dsp_ajax_gallery_nonce : dsp_plugin_vars.dsp_ajax_gallery_nonce,
	subchild_cat_ID:subchildCat
	};
	 jQuery.post(ajaxurl, data, function(response) {
		jQuery('#subchild_cat_id_hidden').val(subchildCat);
		jQuery('#spinner').hide();
		return false;
		});
	});  	
	
	
	jQuery('#reset').click(function(){
	jQuery('#parent_cat_id_hidden').val('');
	jQuery('#parent_cat_name').val('');
	jQuery('#child_cat_id_hidden').val('');
	jQuery('#child_cat_name').val('');
	jQuery('#subchild_cat_id_hidden').val('');
	jQuery('#subchild_cat_name').val('');
	});
	


});    

jQuery('#publish_table .publish_button').live('click', function ($) {
	jQuery('#spinner').show();
	var $tr = jQuery(this).closest('tr');
	var publishAction=$tr.find('#ajax_publish_videos').val();
	var publishEntry=$tr.find('#ajax_entry_id').val();
	var publishTitle=$tr.find('#ajax_title').val();
	var publishDuration=$tr.find('#ajax_duration').val();
	var publishViews=$tr.find('#ajax_views').val();
	var publishParentCat=$tr.find('#ajax_parent_cat').val();
	var publishChildCat=$tr.find('#ajax_child_cat').val();
	var publishSubChild=$tr.find('#ajax_subchild_cat').val();
	var publishThumbnail=$tr.find('#ajax_thumbnail_url').val();
	var publishSearch=$tr.find('#ajax_search').val();
	var publishPage=$tr.find('#ajax_page').val();
	var publishUser=$tr.find('#ajax_user').val();
	var publishSort=$tr.find('#ajax_sort').val();
	var publishResults=$tr.find('#ajax_results').val();	

	
	var data = {
	action: 'publish_video',
	publishAction:publishAction,
	publishEntry:publishEntry,
	publishTitle:publishTitle,
	publishDuration:publishDuration,
	publishViews:publishViews,
	publishParentCat:publishParentCat,
	publishChildCat:publishChildCat,
	publishSubChild:publishSubChild,
	publishThumbnail:publishThumbnail,
	publishSearch:publishSearch,
	publishPage:publishPage,
	publishUser:publishUser,
	publishSort:publishSort,
	publishResults:publishResults,
	};
	 jQuery.post(ajaxurl, data, function(response) {
		jQuery('#success_response').html(response);
		jQuery('#spinner').hide();
		return false;
		});

});

function pagination_ajax(){

	jQuery('a.paginator').live('click', function ($) {
		jQuery('#spinner').show();
		var hrefurl = jQuery(this).attr("href");
		var arr = hrefurl.split('&p=');
		var pageSearch=jQuery('#ajax_search').val();
		var pageUser=jQuery('#ajax_user').val();
		var pageSort=jQuery('#ajax_sort').val();
		var pageResults=jQuery('#ajax_results').val();	
		var page = arr[1];
		
		var data = {
			action: 'pagination',
			hrefurl:hrefurl,
			search:pageSearch,
			p:page,
			user:pageUser,
			sort:pageSort,
			results:pageResults,
			};
			
		jQuery.post(ajaxurl, data, function(response) {
		jQuery('#video_response').html(response);
		jQuery('#spinner').hide();
		return false;
		});
	
	});
};