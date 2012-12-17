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
            <div class="col7 copyright no-margin-left">
				<?php if( function_exists( 'simplecatch_footerlogo' ) ) :
						simplecatch_footerlogo(); 
					  endif;	
				?><?php _e( 'Copyright', 'simplecatch' ); ?> &copy; <?php echo date("Y"); ?> <span><a href="http://wedigital.by"><?php bloginfo('name')?></span></a>. <?php _e( 'All Right Reserved.', 'simplecatch' ); ?>
            </div><!-- .col7 -->
            
           <?php do_action( 'simplecatch_credits' ); ?>
            
		</div><!-- .layout-978 -->
		<div style="float: right; margin-right: 50px; color: #999;">
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
</body>
</html>