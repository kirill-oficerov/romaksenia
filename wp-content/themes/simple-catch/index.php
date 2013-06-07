<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a Simple Catch theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.0
 */



get_header(); 
	
	if( function_exists( 'simplecatch_display_div' ) ) {
		$themeoption_layout = simplecatch_display_div();
	}
	// @todo kirill tags
	if(Wd_Parts_Tag::is_page_tag()) {
		get_template_part(Wd_Parts_Tag::get_tags_template());
	} else {
		get_template_part('content');
	}
?>
	</div>
	<div class="clear">&nbsp;</div>

	<div class="events">
		<? Wd_Parts_Event::get_content(); ?>
	</div>
	<div class="cases">
		<? Wd_Parts_Case::get_content(); ?>
	</div>
	<div class="clear">&nbsp;</div>

	<?php 
//    if( $themeoption_layout == 'right-sidebar' ) {
//        get_sidebar();
//    }?>

<script type="text/javascript">
	(function($){
		$(function() {
			window.wdSlider = new Wd_Slider();
			window.wdSlider.init();
		})
	})(jQuery);
</script>
<? get_footer(); ?>