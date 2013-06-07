(function($) {



window.Admin_Custom_Common = function(options) {
	var me = this;
	me.ajaxSaveFeaturedSettings = null;
	me.ajaxSaveSliderSettings = null;
	me.ajaxRemoveSliderImage = null;
	me.options = $.extend(me.options, options);


	me.init = function() {
		jQuery('.save_feature_settings').live('click', function(e) {
			me.onClickSaveFeatureSettings(e);
		});
		jQuery('#save_slider_settings').live('click', function(e) {
			me.onClickSaveSliderSettings(e);
		});
		jQuery('#remove_slider_image').live('click', function(e) {
			me.onClickRemoveSliderImage(e);
		});
			jQuery('.show_image_in_slider').live('change', function(e) {
				me.onChangeShowImageInSlider(e);
			});


		$('#categorydiv label.selectit:contains("Ивенты") input').bind('change', function() {
			if(this.checked) {
				jQuery('#show_event_at_main').attr('checked','checked');
			} else {
				jQuery('#show_event_at_main').removeAttr('checked');

			}
		});
	},
	me.onClickSaveFeatureSettings = function(event) {
		if(me.ajaxSaveFeaturedSettings) {
			alert('Последний запрос в обработке');
			return;
		}
		var button = jQuery(event.currentTarget);
		var id = button.attr('rel');
		var featuredWidth = jQuery('[name="featured_width_' + id + '"]').val();
		var featuredHeight = jQuery('[name="featured_height_' + id + '"]').val();
		var preloader = jQuery('.savesend .preloader');
		me.ajaxSaveFeaturedSettings = jQuery.ajax({
			url: me.options.urlCustomAjax,
			type: 'post',
			data: {
				featuredWidth: featuredWidth,
				featuredHeight: featuredHeight,
				id: post_id,
				settingName: 'feature-settings',
				imageId: id
			},
			beforeSend: function() {
				preloader.show();
			},
			success: function(data) {
				if(data != undefined) {
					if(data.errors != undefined) {
						alert(data.errors);
					}
				}
			},
			error: function() {
				alert('server error');
			},
			complete: function() {
				preloader.hide();
				me.ajaxSaveFeaturedSettings = null;
			}
		});

	},
	me.onClickSaveSliderSettings = function(event) {
		if(me.ajaxSaveSliderSettings) {
			alert('Последний запрос в обработке');
			return;
		}
		var text = jQuery('#slider_text').val();
		var order = jQuery('#slider_order').val();
		var preloader = jQuery('.slider_settings .preloader');
		me.ajaxSaveSliderSettings = jQuery.ajax({
			url: me.options.urlCustomAjax,
			type: 'post',
			data: {
				text: text,
				order: order,
				id: post_id,
				settingName: 'slider-settings'
			},
			beforeSend: function() {
				preloader.show();
			},
			success: function(data) {
				if(data != undefined) {
					if(data.errors != undefined) {
						alert(data.errors);
					}
				}
			},
			error: function() {
				alert('server error');
			},
			complete: function() {
				preloader.hide();
				me.ajaxSaveSliderSettings = null;
			}
		});
	},
	me.onClickRemoveSliderImage = function(event) {
		if(me.ajaxRemoveSliderImage) {
			alert('Последний запрос в обработке');
			return;
		}
		jQuery('#remove_slider_image').css('opacity', '0.5');
		var post_id = jQuery('#post_ID').val();
		me.ajaxRemoveSliderImage = jQuery.ajax({
			url: me.options.urlCustomAjax,
			type: 'post',
			data: {
				id: post_id,
				removeImage: 1,
				settingName: 'slider-settings'
			},
			beforeSend: function() {
			},
			success: function(data) {
				if(data != undefined) {
					if(data.errors != undefined) {
						alert(data.errors);
					}
					if(data.slider_image_removed == 1) {
						jQuery('#slider_image_preview_small').hide().removeAttr('src');
						jQuery('#remove_slider_image').css('opacity', '1').hide();
					}
				}
			},
			error: function() {
				alert('server error');
			},
			complete: function() {
				me.ajaxRemoveSliderImage = null;
			}
		});
	},
	me.onChangeShowImageInSlider = function(event) {
		if(me.ajaxSaveSliderSettings) {
			alert('Последний запрос в обработке');
			return;
		}
		var checkbox = jQuery(event.currentTarget);
		var state = checkbox.get(0).checked;
		var imageId = checkbox.parents('[id^=media-item-]').attr('id');
		imageId = imageId.split('-');
		imageId = imageId[2];
		var preloader = jQuery('#media-item-' + imageId + ' .slider_settings.submit .preloader');
		me.ajaxSaveSliderSettings = jQuery.ajax({
			url: me.options.urlCustomAjax,
			type: 'post',
			dataType: 'json',
			data: {
				imageId: imageId,
				state: state ? 1 : 0,
				id: post_id,
				settingName: 'slider-settings'
			},
			beforeSend: function() {
				preloader.show();
			},
			success: function(data) {
				if(data != undefined) {
					if(data.errors != undefined) {
						alert(data.errors);
					}
					if(data.slider_image_set != undefined) {
						if(data.slider_image_set == '1') {
							jQuery('#slider_image img').show().attr('src', data.slider_image_src);
							jQuery('#slider_image_preview_small', window.parent.document).show().attr('src', data.slider_image_src);
							jQuery('#remove_slider_image', window.parent.document).show();
							jQuery('.show_image_in_slider:not(#media-item-' + imageId  + ' .show_image_in_slider)').each(function() {
								this.checked = false;
							});
						} else {
							jQuery('#slider_image img').hide().removeAttr('src');
							jQuery('#slider_image_preview_small', window.parent.document).hide().removeAttr('src');
							jQuery('#remove_slider_image', window.parent.document).hide();
						}
					}
				}
			},
			error: function() {
				alert('server error');
			},
			complete: function() {
				preloader.hide();
				me.ajaxSaveSliderSettings = null;
			}
		});
	}

};

})(jQuery);