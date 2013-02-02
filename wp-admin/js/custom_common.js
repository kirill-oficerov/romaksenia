(function($) {
	var Admin_Custom_Common = function() {

	};

	Admin_Custom_Common.prototype = {
		init:function() {

			$('#categorydiv label.selectit:contains("Ивенты") input').bind('change', function() {
				if(this.checked) {
					jQuery('#show_event_at_main').attr('checked','checked');
				} else {
					jQuery('#show_event_at_main').removeAttr('checked');

				}
			});
		}
	};


	$(function() {
		var customCommon = new Admin_Custom_Common();
		customCommon.init();
	});
})(jQuery);