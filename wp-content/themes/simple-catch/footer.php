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
		    <!--Akavita counter start-->
<!--		    <script type="text/javascript">var AC_ID=56808;var AC_TR=false;-->
<!--		    (function(){var l='http://adlik.akavita.com/acode.js'; var t='text/javascript';-->
<!--			    try {var h=document.getElementsByTagName('head')[0];-->
<!--				    var s=document.createElement('script'); s.src=l;s.type=t;h.appendChild(s);}catch(e){-->
<!--				    [removed](unescape('%3Cscript src="'+l+'" type="'+t+'"%3E%3C/script%3E'));}})();-->
<!--		    </script><span id="AC_Image"></span>-->
<!--		    <noscript><a target='_blank' href='http://www.akavita.by/'>-->
<!--			    <img src='http://adlik.akavita.com/bin/lik?id=56808&it=1'-->
<!--			         border='0' height='1' width='1' alt='Akavita'/>-->
<!--		    </a></noscript>-->
		    <!--Akavita counter end-->
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

			// social fix
			var intervalSocial = null;
			var catchSocialLoaded = function() {
				if($('.yashare-auto-init').length > 0) {
					clearInterval(intervalSocial);
					$('.yashare-auto-init').each(function() {
						var yashareBlock = $(this);
						var newTitle = encodeURIComponent(yashareBlock.siblings(':eq(0)').find('a').text());
						var newHref = encodeURIComponent(yashareBlock.siblings(':eq(0)').find('a').attr('href'));
						yashareBlock.find('a').each(function() {
							var a = $(this);

							a.attr({'href':
								a.attr('href').replace(/url=http[^&]*/,'url=' + newHref).replace(/title=.*/, 'title=' + newTitle)
							});
						});


//						$('.yashare-auto-init').eq(0).find('a').eq(0).attr('href').replace(/url=http[^&]*/,'url=http222222')
// title
// $('.yashare-auto-init:eq(0)').siblings(':eq(0)').find('a').text()
						// href
						// $('.yashare-auto-init:eq(0)').siblings(':eq(0)').find('a').attr('href')
						// encodeURIComponent
					});
				}
			};
			var intervalSocial = setTimeout(catchSocialLoaded, 100);



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
<!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter19155310 = new Ya.Metrika({id:19155310, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/19155310" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->


</body>
</html>