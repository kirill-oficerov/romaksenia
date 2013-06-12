<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.0
 */

get_header(); 

if( function_exists( 'simplecatch_display_div' ) ) {
	$themeoption_layout = simplecatch_display_div();
}

	if (have_posts()) { ?>
		<? while (have_posts()) {
			the_post(); ?>

			<div <?php post_class();?>>
				<div class="col8">
					<h3 style="padding-top: 10px;"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
						<?php
							$search = get_search_query();
							$search = htmlspecialchars_decode($search);
							$title = get_the_title();
							echo Wd_Pages_Search::highlightString($search, $title);

						?></a></h3>
					<?php
//						@todo kirill search get_the_excerpt
						$excerpt = Wd_Pages_Search::getExcerpt($search);
						echo Wd_Pages_Search::highlightString($search, $excerpt);
					?>
				</div>
				<div class="row-end"></div>
			</div> <!-- .post -->
		<hr />
		<? } ?>
		</div>
		<?
			// Checking WP Page Numbers plugin exist
			if ( function_exists('wp_pagenavi' ) ) {
				wp_pagenavi();
			// Checking WP-PageNaviplugin exist
			} elseif ( function_exists('wp_page_numbers' ) ) {
				wp_page_numbers();
			} else { ?>
				<ul class="default-wp-page">
					<li class="previous"><?php next_posts_link( __( 'Previous', 'simplecatch' ) ); ?></li>
					<li class="next"><?php previous_posts_link( __( 'Next', 'simplecatch' ) ); ?></li>
				</ul>
			<? }
	} else { ?>
		<h2 class="search_no_result">
			По вашему запросу не найдено результатов
			<?php //printf( __( 'Your search <span> "%s" </span> did not match any documents', 'simplecatch' ), get_search_query() ); ?>
		</h2>
	<a href="<?=HTTP_HOST . '/' . 'sitemap'?>">Карта сайта</a>

<? } ?>
<?// if( $themeoption_layout == 'right-sidebar' ) {
//		get_sidebar();
//	} ?>

<?php get_footer(); ?>