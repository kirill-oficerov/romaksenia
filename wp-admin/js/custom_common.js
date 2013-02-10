(function($) {



window.Admin_Custom_Common = function(options) {
	var me = this;
	me.ajaxSaveFeaturedSettings = null;
	me.options = $.extend(me.options, options);


	me.init = function() {
		jQuery('.save_feature_settings').live('click', function(e) {
			me.onClickSaveFeatureSettings(e);
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
			url: me.options.urlSaveCustomSettings,
			type: 'post',
			data: {
				featuredWidth: featuredWidth,
				featuredHeight: featuredHeight,
				id: post_id,
				settingName: 'feature-settings'
			},
			beforeSend: function() {
				preloader.show();
			},
			success: function(data) {
				console.debug(data);
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

	}

};

})(jQuery);