var Wd_Popup = function() {

};

Wd_Popup.prototype = {
	init: function() {
		jQuery('.make_popup').click(function() {
			jQuery('.popup_overlay, .popup').show();
		});
		jQuery('.popup_overlay, .popup .header .close').click(function() {
			jQuery('.popup_overlay, .popup').hide();
		});
		window.onkeyup = function(event) {
			if(event.keyCode == 27) {
				jQuery('.popup_overlay, .popup').hide();
			}
		};
		jQuery('.send_news').click(function() {

		});
		this.init_();
	}
};