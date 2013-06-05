<?php /* Template Name: Articles */
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




//set_query_var('pagename', '');
//set_query_var('name', '');
//wp_reset_query();
//function gloss_remove_glossary_cat($wp_query) {
//	set_query_var('pagename', 'кейсы');
$query = '';
$paged = get_query_var('paged');
if($paged) {
	$query = array('paged' => $paged);
}
query_posts($query);
//}
//add_action('pre_get_posts', 'gloss_remove_glossary_cat' );

get_template_part('content'); ?>
</div> <!-- articles -->
<div class="clear">&nbsp;</div>

<?php get_footer(); ?>
</div>



</div><!-- #main -->

