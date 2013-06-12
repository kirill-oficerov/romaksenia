<?php
/**
 * The template for displaying the footer.
 *
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.0
 */
?>
<div class="h140"></div>
</div> <!-- height 100% main -->
<div class="footer">
	<div class="left">
		<div class="icons logo"></div>
		<div class="copyright">© 2013. Перепечатка материалов с указанием ссылки приветствуется.</div>
	</div>
	<div class="right">
		<div class="design">
			<div class="icons n97"></div>
			<div class="n97_link">
				Дизайн: <a href="#">Nineseven</a>
			</div>
		</div>
	</div>
</div> <!-- my footer -->
<?php wp_footer(); ?>
<script type="text/javascript">
	(function($) {
		$(function() {

			jQuery('.header .search input,' +
				'.send_news .content input,' +
				'.send_news .content textarea').each(function() {
				var default_value = this.value;
				jQuery(this).focus(function() {
					if(this.value == default_value) {
						this.value = '';
					}
				});
				jQuery(this).blur(function() {
					if(this.value == '') {
						this.value = default_value;
					}
				});
			});




			<!-- google -->
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-37511838-1']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
			<!-- /google -->





			window.wdPopupSendNews = new Wd_Popup_Send_News({
				urlSendNews: '<?=Wd_Parts_SendNews::SEND_NEWS_URL?>'
			});
			window.wdPopupSendNews.init();
			jQuery('.header .search .submit_search').click(function() {
				jQuery('.search_form').submit();
			});
		});



	})(jQuery);
	function wdPrettyPhoto() {

		$('.post a > img').each(function() {
			$(this).parent().prettyPhoto({
				social_tools:'<div class="jeeeeeeeeeeeeeeeeeeeeeeeeeeey"></div>',
				show_title: false,
				deeplinking: false

			});
		});
	}

</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter19155310 = new Ya.Metrika({id:19155310, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/19155310" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<div class="popup_overlay" style="display: none;">

</div>
<div class="popup send_news" style="display: none;">
	<div class="clear">&nbsp;</div>
	<div class="popup_container">
		<div class="header">
			<div class="label">Прислать новость</div>
			<div class="close"></div>
		</div>
		<div class="clear">&nbsp;</div>
		<div class="content">
			<input class="header_input" type="text" value="Заголовок">
			<textarea rows="1" cols="1" class="news_content">Описание</textarea>
			<div class="send_news">Отправить в редакцию</div>
			<div class="result"></div>
		</div>
	</div>
</div>
</body>
</html>