var Wd_Slider = function() {

};

Wd_Slider.prototype = {
	init: function() {
		jQuery('.main .slider_container .slider .right')
			.hover(
				function() {
					var me = jQuery(this);
					me.stop(true, false);
					me.animate({left: '-513px'}, 300);
				},

				function() {
					var me = jQuery(this);
					me.stop(true, false);
					me.animate({left: '0px'}, 300);
				}

			);
	}
};