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
      
	if (have_posts()): ?>
<!--		<h2 class="entry-title">--><?php //printf( __( 'Showing results for: <span class="img-title">%s</span>', 'simplecatch' ), get_search_query() ); ?><!--</h2>-->
		<div class="search-result-container">
		<?php while (have_posts()) : the_post(); ?>
		
			<div <?php post_class();?>>
				
				<h3 style="padding-top: 10px;"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
					<?php
						$search = get_search_query();
						$search = htmlspecialchars_decode($search);
						$title = get_the_title();
						echo Wd_Pages_Search::highlightString($search, $title);
//						echo str_ireplace($search, '<span class="select-search-result">' . $search . '</span>', $title)

					?></a></h3>
				<?php
//					$excerpt = get_the_excerpt();
//					@todo kirill search get_the_excerpt
					$excerpt = Wd_Pages_Search::getExcerpt($search);
					echo Wd_Pages_Search::highlightString($search, $excerpt);

//					echo str_replace($search, '<span class="select-search-result">' . $search . '</span>', $excerpt)
				?>
				<div class="row-end"></div>
			</div> <!-- .post -->
		<hr style="padding-top: 20px;"/>
		</div>
		<?php endwhile; 
			// Checking WP Page Numbers plugin exist
			if ( function_exists('wp_pagenavi' ) ) : 
				wp_pagenavi();
			
			// Checking WP-PageNaviplugin exist
			elseif ( function_exists('wp_page_numbers' ) ) : 
				wp_page_numbers();
				 
			else: ?>
				<ul class="default-wp-page">
					<li class="previous"><?php next_posts_link( __( 'Previous', 'simplecatch' ) ); ?></li>
					<li class="next"><?php previous_posts_link( __( 'Next', 'simplecatch' ) ); ?></li>
				</ul>         
		
			<?php endif; 
		
	else : ?>
		<h2 style="font-size: 20px;">
			По вашему запросу не найдено результатов<br>
			<!--			--><?php //printf( __( 'Your search <span> "%s" </span> did not match any documents', 'simplecatch' ), get_search_query() ); ?>
		</h2>
	<a style="text-transform: uppercase; font-size: 12px; font-family: ProximaNovaReg; margin-left: 2px;" href="<?=HTTP_HOST . '/' . 'sitemap'?>">Карта сайта</a>

<!--		<div class="post">-->
<!--			<h5>--><?php //_e( 'A few suggestions', 'simplecatch' ); ?><!--</h5>-->
<!--			<ul>-->
<!--				<li>--><?php //_e( 'Make sure all words are spelled correctly', 'simplecatch' ); ?><!--</li>-->
<!--				<li>--><?php //_e( 'Try different keywords', 'simplecatch' ); ?><!--</li>-->
<!--				<li>--><?php //_e( 'Try more general keywords', 'simplecatch' ); ?><!--</li>-->
<!--			</ul> -->
<!--		</div> -->
	<!-- .post -->
		
<?php endif; ?>

    </div> <!-- #content -->
            
 	<?php
//    if( $themeoption_layout == 'right-sidebar' ) {
//        get_sidebar();
//    }?>
            <div style="clear: both;"></div>
</div> <!-- #main -->
	            <div style="clear: both;"></div>

</div> <!-- #main -->

<?php get_footer(); ?> 