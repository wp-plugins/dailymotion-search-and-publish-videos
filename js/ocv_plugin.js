jQuery(document).ready(function() {
	
	//User Settings Page jQuery Tabs    
	jQuery( "#ocv_user-tabs" ).tabs(); 
	
	//Inititate jQuery DataTables for Videos Table 
    jQuery('#publish_table').dataTable( {
         "pagingType": "simple_numbers",
		 "sDom": '<"wrapper"lfptip>',
		"bFilter": false,
		"bLengthChange": false,
		"bInfo": false
    } );
	
	//Category Switch Function DailyMotion
	jQuery('#parent_cat').change(function(){
	jQuery('#spinner').show();
	var parentCat=jQuery('#parent_cat').val();
	var data = {
	action: 'category_select_action',
	ocv_ajax_gallery_nonce : ocv_plugin_vars.ocv_ajax_gallery_nonce,
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
	ocv_ajax_gallery_nonce : ocv_plugin_vars.ocv_ajax_gallery_nonce,
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
	//ocv_ajax_gallery_nonce : ocv_plugin_vars.ocv_ajax_gallery_nonce,
	subchild_cat_ID:subchildCat
	};
	 jQuery.post(ajaxurl, data, function(response) {
		jQuery('#subchild_cat_id_hidden').val(subchildCat);
		jQuery('#spinner').hide();
		return false;
		});
	});  	
	
	//RESET Categories
	jQuery('#reset').click(function(){
	jQuery('#parent_cat_id_hidden').val('');
	jQuery('#parent_cat_name').val('');
	jQuery('#child_cat_id_hidden').val('');
	jQuery('#child_cat_name').val('');
	jQuery('#subchild_cat_id_hidden').val('');
	jQuery('#subchild_cat_name').val('');
	});
	
	
	//Category Switch Function Youtube
	jQuery('#parent_cat').change(function(){
	jQuery('#spinner').show();
	var parentCat=jQuery('#parent_cat').val();
	var data = {
	action: 'category_select_action_youtube',
	ocv_ajax_gallery_nonce : ocv_plugin_vars.ocv_ajax_gallery_nonce,
	parent_cat_ID:parentCat
	};
	 jQuery.post(ajaxurl, data, function(response) {
		jQuery('#sub_cat_disabled').removeAttr("disabled").html(response);
		jQuery('#youtube_parent_cat_id_hidden').val(parentCat);
		jQuery('#spinner').hide();
		return false;
		});
	});
	
	
	jQuery('#sub_cat_disabled').change(function(){
	jQuery('#spinner').show();
	var childCat=jQuery('#sub_cat_disabled').val();
	var data = {
	action: 'category_select_action2_youtube',
	ocv_ajax_gallery_nonce : ocv_plugin_vars.ocv_ajax_gallery_nonce,
	child_cat_ID:childCat
	};
	 jQuery.post(ajaxurl, data, function(response) {
		jQuery('#sub_child_disabled').removeAttr("disabled").html(response);
		jQuery('#youtube_child_cat_id_hidden').val(childCat);
		jQuery('#spinner').hide();
		return false;
		});
	});
	
	
	jQuery('#sub_child_disabled').change(function(){
	jQuery('#spinner').show();
	var subchildCat=jQuery('#sub_child_disabled').val();
	var data = {
	//action: 'category_select_action3',
	//ocv_ajax_gallery_nonce : ocv_plugin_vars.ocv_ajax_gallery_nonce,
	subchild_cat_ID:subchildCat
	};
	 jQuery.post(ajaxurl, data, function(response) {
		jQuery('#youtube_subchild_cat_id_hidden').val(subchildCat);
		jQuery('#spinner').hide();
		return false;
		});
	});  	
	
	//RESET Categories
	jQuery('#reset').click(function(){
	jQuery('#parent_cat_id_hidden_youtube').val('');
	jQuery('#parent_cat_name').val('');
	jQuery('#child_cat_id_hidden_youtube').val('');
	jQuery('#child_cat_name').val('');
	jQuery('#subchild_cat_id_hidden_youtube').val('');
	jQuery('#subchild_cat_name').val('');
	});
	
	//Category Switch Function VIMEO
	jQuery('#parent_cat').change(function(){
	jQuery('#spinner').show();
	var parentCat=jQuery('#parent_cat').val();
	var data = {
	action: 'category_select_action_vimeo',
	ocv_ajax_gallery_nonce : ocv_plugin_vars.ocv_ajax_gallery_nonce,
	parent_cat_ID:parentCat
	};
	 jQuery.post(ajaxurl, data, function(response) {
		jQuery('#sub_cat_disabled').removeAttr("disabled").html(response);
		jQuery('#vimeo_parent_cat_id_hidden').val(parentCat);
		jQuery('#spinner').hide();
		return false;
		});
	});
	
	
	jQuery('#sub_cat_disabled').change(function(){
	jQuery('#spinner').show();
	var childCat=jQuery('#sub_cat_disabled').val();
	var data = {
	action: 'category_select_action2_vimeo',
	ocv_ajax_gallery_nonce : ocv_plugin_vars.ocv_ajax_gallery_nonce,
	child_cat_ID:childCat
	};
	 jQuery.post(ajaxurl, data, function(response) {
		jQuery('#sub_child_disabled').removeAttr("disabled").html(response);
		jQuery('#vimeo_child_cat_id_hidden').val(childCat);
		jQuery('#spinner').hide();
		return false;
		});
	});
	
	
	jQuery('#sub_child_disabled').change(function(){
	jQuery('#spinner').show();
	var subchildCat=jQuery('#sub_child_disabled').val();
	var data = {
	//action: 'category_select_action3',
	//ocv_ajax_gallery_nonce : ocv_plugin_vars.ocv_ajax_gallery_nonce,
	subchild_cat_ID:subchildCat
	};
	 jQuery.post(ajaxurl, data, function(response) {
		jQuery('#vimeo_subchild_cat_id_hidden').val(subchildCat);
		jQuery('#spinner').hide();
		return false;
		});
	});  	
	
	//RESET Categories
	jQuery('#reset').click(function(){
	jQuery('#parent_cat_id_hidden_vimeo').val('');
	jQuery('#parent_cat_name').val('');
	jQuery('#child_cat_id_hidden_vimeo').val('');
	jQuery('#child_cat_name').val('');
	jQuery('#subchild_cat_id_hidden_vimeo').val('');
	jQuery('#subchild_cat_name').val('');
	});
	


}); 

   
//Publish Video Function
jQuery('#publish_table .publish_button').live('click', function ($) {
	jQuery('#spinner').show();
	var $tr = jQuery(this).closest('tr');
	var publishAction=$tr.find('#ajax_publish_videos').val();
	var publishEntry=$tr.find('#ajax_entry_id').val();
	var publishTitle=$tr.find('#ajax_title').val();
	var publishDescription=$tr.find('#ajax_description').val();
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
	var publishcontentType=$tr.find('#ajax_contentType').val();	

	
	var data = {
	action: 'publish_video',
	publishAction:publishAction,
	publishEntry:publishEntry,
	publishTitle:publishTitle,
	publishDescription:publishDescription,
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
	publishcontentType:publishcontentType,
	};
	 jQuery.post(ajaxurl, data, function(response) {
		jQuery('#success_response').html(response);
		jQuery('#spinner').hide();
		return false;
		});

});