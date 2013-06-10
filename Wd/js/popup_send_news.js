var Wd_Popup_Send_News = function(options) {
	this.options = jQuery.extend(this.options, options);
	this.resultField = jQuery('.send_news .content .result');
	this.ajaxSendNews = null;
};

Wd_Popup_Send_News.prototype = {
	init: function() {
		var me = this;
		jQuery('.make_popup').click(function() {
			jQuery('.popup_overlay, .popup').show();
			me.resultField.hide().removeClass('success').removeClass('fail');
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
	},
	init_: function() {
		var me = this;
		jQuery('.send_news .content .send_news').click(function() { me.onClickSendNews(); });
	},
	onClickSendNews: function() {
		var me = this;
		me.resultField.hide();

		if(me.ajaxSendNews) {
			me.showResult(false, 'Предыдущий запрос в обработке');
			return;
		}
		var header = jQuery('.send_news .content .header_input').val();
		if(jQuery.trim(header) == '' || jQuery.trim(header) == 'Заголовок') {
			me.showResult(false, 'Заголовок не задан');
			return;
		}
		var content = jQuery('.send_news .content .news_content').val();
		if(jQuery.trim(content) == '' || jQuery.trim(content) == 'Описание') {
			me.showResult(false, 'Описание не задано');
			return;
		}
		me.ajaxSendNews = jQuery.ajax({
			type: 'post',
			dataType: 'json',
			url: me.options.urlSendNews,
			data: {
				header: header,
				content: content
			},
			beforeSend: function() {

			},
			success: function(data) {
				if(data != undefined) {
					if(data['errors'] != undefined) {
						me.showResult(false, data['errors']);
					} else {
						me.showResult(true, 'Успешно отправлено');
					}
				}
			},
			error: function () {

			},
			complete: function() {
				me.ajaxSendNews = null;
			}
		});
	},
	showResult: function(status, text) {
		var me = this;
		me.resultField.removeClass('success').removeClass('fail');
		me.resultField.addClass(status ? 'success' : 'fail').text(text).show();
	}
};