<?php
/**
 * The template for displaying the footer.
 *
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.0
 */
?>
	<div id="footer">
    	<div class="layout-978" style="float: left; min-width: 0px;">
			<?php //Displaying footer logo ?>
            <div class="col7 copyright" style="margin-left: 21px;">
	            Copyright &copy; <?php echo date("Y"); ?> <span><a href="http://wedigital.by"><?php bloginfo('name')?></span></a>&nbsp;All Right Reserved.
            </div><!-- .col7 -->
            
           <?php do_action( 'simplecatch_credits' ); ?>
            
		</div><!-- .layout-978 -->
		<div style="float: right; margin-right: 50px; color: #999;">
			<div style="float: left; width: 43px;">
				RSS:
				<div style="clear: both;"></div>
				<a href="<?=HTTP_HOST?>/feed" target="_blank" class="icons rss" style="margin-top: 7px;"></a>
				<div style="clear: both;"></div>
			</div>
			<div style="float: left; ">
				Мы в соцсетях:
				<div style="clear: both;"></div>
				<a href="http://www.facebook.com/wedigitalby" target="_blank" class="icons facebook" style="margin-top: 7px;"></a>
				<a href="https://twitter.com/wedigitalby" target="_blank" class="icons twitter" style="margin-top: 7px;"></a>
				<div style="clear: both;"></div>
			</div>
			<div style="float: left; margin-left:8px;">
			Электронная почта:
			<div style="clear: both;"></div>
				<a href="mailto://info@wedigital.by">info@wedigital.by</a>
			<div style="clear: both;"></div>
		</div>
		</div>
	</div><!-- #footer -->      
<?php wp_footer(); ?>
<script type="text/javascript">
	(function($) {
		$(function() {
//			(function() {
//				var tk = document.createElement('script');
//				tk.src = 'http://fonts.gawker.com/zvc4iwz.js';
//				tk.type = 'text/javascript';
//				tk.async = 'true';
//				tk.onload = tk.onreadystatechange = function() {
//					var rs = this.readyState;
//					if (rs && rs != 'complete' && rs != 'loaded') return;
//					try { Typekit.load(); } catch (e) {}
//				};
//				var s = document.getElementsByTagName('script')[0];
//				s.parentNode.insertBefore(tk, s);
//			})();

			jQuery('.searchform .search').each(function() {
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
		});



	})(jQuery);
	function wdPrettyPhoto() {

		$('.post a > img').each(function() {
			$(this).parent().prettyPhoto({
				social_tools:'<div class="jeeeeeeeeeeeeeeeeeeeeeeeeeeey"></div>',
				show_title: false

			});
		});
	}

</script>
<!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter19155310 = new Ya.Metrika({id:19155310, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/19155310" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
</body>
</html>