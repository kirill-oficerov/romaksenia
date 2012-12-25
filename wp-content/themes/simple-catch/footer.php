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
				<?php if( function_exists( 'simplecatch_footerlogo' ) ) :
	            // @todo kirill footer
//						simplecatch_footerlogo();
					  endif;	
				?><?php _e( 'Copyright', 'simplecatch' ); ?> &copy; <?php echo date("Y"); ?> <span><a href="http://wedigital.by"><?php bloginfo('name')?></span></a>. <?php _e( 'All Right Reserved.', 'simplecatch' ); ?>
            </div><!-- .col7 -->
            
           <?php do_action( 'simplecatch_credits' ); ?>
            
		</div><!-- .layout-978 -->
		<div style="float: right; margin-right: 50px; color: #999;">
			<div style="float: left; width: 43px;">
				RSS:
				<div style="clear: both;"></div>
				<a href="<?=HTTP_HOST?>/feed" target="_blank" class="icons rss" ></a>
				<div style="clear: both;"></div>
			</div>
			<div style="float: left;">
				Мы в соцсетях:
				<div style="clear: both;"></div>
				<a href="http://www.facebook.com/wedigitalby" target="_blank" class="icons facebook" style=""></a>
				<a href="https://twitter.com/wedigitalby" target="_blank" class="icons twitter" style=""></a>
				<div style="clear: both;"></div>
			</div>
			<div style="float: left; margin-left: 8px;">
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
			(function() {
				var tk = document.createElement('script');
				tk.src = 'http://fonts.gawker.com/zvc4iwz.js';
				tk.type = 'text/javascript';
				tk.async = 'true';
				tk.onload = tk.onreadystatechange = function() {
					var rs = this.readyState;
					if (rs && rs != 'complete' && rs != 'loaded') return;
					try { Typekit.load(); } catch (e) {}
				};
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(tk, s);
			})();


		});







	})(jQuery);


</script>
</body>
</html>