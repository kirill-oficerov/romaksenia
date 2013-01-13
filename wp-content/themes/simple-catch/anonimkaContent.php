<?php
/**
 * This is the template that displays content for index and archive page
 *
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.3.2
 */
global $wp_object_cache;
get_header();
?>
<script type="text/javascript">
	if($ == undefined) {
		var $ = jQuery;
	}
	(function($) {
		$(function() {
			wdPrettyPhoto();
		});
	})(jQuery);
</script>
<?
// top post
//echo "<pre>".print_r('1', true)."</pre>\n\n";
global $wpdb;

$query = "SELECT wp_posts.* FROM wp_terms
INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id = wp_terms.term_id
INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
INNER JOIN wp_posts ON wp_posts.ID = wp_term_relationships.object_id
WHERE wp_terms.slug = 'anonimka' AND wp_posts.post_name = 'about' AND wp_posts.post_status = 'publish'
ORDER BY post_date DESC";

$postTop = $wpdb->get_results($query);
if(count($postTop) > 0) {
//$post = get_post($postId[0]->id);
$post = $postTop[0];
$post->filter = 'raw';
$post->ancestors = array();
setup_postdata($post);
//	$_GLOBAL['post'] = $postTop[0];
?>
<div <?php post_class(); ?> >
	<div class="col8">
		<div style="float: left; margin-right: -150px; width: 100%; ">
			<h2 class="entry-title" style="margin: 10px 150px 3px 0px; ">
				<a href="<?php the_permalink() ?>" title="" rel="bookmark" ><?php the_title(); ?></a>
			</h2>
		</div>
		<!--	                --><?//
//                    // tags
//					$tags = $wp_object_cache->get($post->ID, 'category_relationships');
//                    $output = '<ul class="category-list tags">';
//                    foreach($tags as $key => $tag) {
//	                    if(!is_null($tag->category_settings)) {
//							$categorySettings = unserialize($tag->category_settings);
//	                    }
//	                    $output .= '<li ' . (isset($categorySettings['class']) ? 'class="' . $categorySettings['class'] . '"' : '') . ' ><a  href="' . HTTP_HOST . '/category/' . $tag->slug . '">' . $tag->name . '</a></li>';
//	                    unset($categorySettings);
//                    }
//                    $output .= '</ul>';
//	                echo $output;
//	                ?>


		<?php $excerpt = the_excerpt(false);
//		                    $contentBegin = strrpos($excerpt, '<p style="" rel="begin-of-the-excerpt-text">');
//		                    $content = substr($excerpt, $contentBegin);
		$content = substr($excerpt, 3);
		$content = substr($content, 0, -5);
		echo '<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
				<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none"
				data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,lj,gplus,pinterest"></div>'
		?>
		<div class="clear" style="height: 1px; width: 1px; "></div>

		<div style="text-align: right; float: right; margin: 0px 0px 0px 15px;">
			<?
			$picture = get_the_post_thumbnail( null, 'featured', '' );
			if(!empty($picture)) {
				$pictureSrc = array();
				preg_match('/src="[^"]+"/', $picture, $pictureSrc);
				$settings = unserialize($post->settings);
				if($settings) {
					$width = $settings['width'];
					$height = $settings['height'];
					$picture = str_replace('<img', '<img style="width:' . $width . 'px; height:' . $height . 'px;"', $picture);
				}
				?>
                                    <a rel="prettyPhoto" href=<?=substr($pictureSrc[0], 4)?> title="<?php the_title_attribute( 'echo=0' ) ?>">
<!--				                    --><?php // the_post_thumbnail( 'featured' ); ?>
				                    <?php echo $picture ?>
			                    </a>
			                        <? } ?>
		</div>
		<? echo $content ?>
	</div>
	<div class="row-end"></div>
</div><!-- .post -->
<hr />

<? } ?>

































			<?php if ( have_posts() ) :
                while( have_posts() ):
	                the_post(); ?>

                        <?php
	                    global $post;
	                if($post->post_name == 'about') {
		                continue;
	                }
	                ?>
                <div <?php post_class(); ?> >
	                    <div class="col8">
                            <div style="float: left; margin-right: -150px; width: 100%; ">
			                    <h2 class="entry-title" style="margin: 10px 150px 3px 0px; ">
	                                <a href="<?php the_permalink() ?>" title="" rel="bookmark" ><?php the_title(); ?></a>
	                            </h2>
                            </div>
<!--	                --><?//
//                    // tags
//					$tags = $wp_object_cache->get($post->ID, 'category_relationships');
//                    $output = '<ul class="category-list tags">';
//                    foreach($tags as $key => $tag) {
//	                    if(!is_null($tag->category_settings)) {
//							$categorySettings = unserialize($tag->category_settings);
//	                    }
//	                    $output .= '<li ' . (isset($categorySettings['class']) ? 'class="' . $categorySettings['class'] . '"' : '') . ' ><a  href="' . HTTP_HOST . '/category/' . $tag->slug . '">' . $tag->name . '</a></li>';
//	                    unset($categorySettings);
//                    }
//                    $output .= '</ul>';
//	                echo $output;
//	                ?>


	                    <?php $excerpt = the_excerpt(false);
//		                    $contentBegin = strrpos($excerpt, '<p style="" rel="begin-of-the-excerpt-text">');
//		                    $content = substr($excerpt, $contentBegin);
		                    $content = substr($excerpt, 3);
		                    $content = substr($content, 0, -5);
		                    echo '<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
				<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none"
				data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,lj,gplus,pinterest"></div>'
		                    ?>
		                    <div class="clear" style="height: 1px; width: 1px; "></div>

		                    <div style="text-align: right; float: right; margin: 0px 0px 0px 15px;">
			                    <?
			                        $picture = get_the_post_thumbnail( null, 'featured', '' );
				                    if(!empty($picture)) {
					                    $pictureSrc = array();
					                    preg_match('/src="[^"]+"/', $picture, $pictureSrc);
					                    $settings = unserialize($post->settings);
					                    if($settings) {
						                    $width = $settings['width'];
						                    $height = $settings['height'];
						                    $picture = str_replace('<img', '<img style="width:' . $width . 'px; height:' . $height . 'px;"', $picture);
					                    }
					                    ?>
                                    <a rel="prettyPhoto" href=<?=substr($pictureSrc[0], 4)?> title="<?php the_title_attribute( 'echo=0' ) ?>">
<!--				                    --><?php // the_post_thumbnail( 'featured' ); ?>
				                    <?php echo $picture ?>
			                    </a>
			                        <? } ?>
		                    </div>
		                    <? echo $content ?>
	                    </div>
                        <div class="row-end"></div>
                    </div><!-- .post -->
                    <hr />
                    
          			<?php endwhile;
                    
            		// Checking WP Page Numbers plugin exist
					if ( function_exists('wp_pagenavi' ) ) : 
						wp_pagenavi();
					
					// Checking WP-PageNaviplugin exist
					elseif ( function_exists('wp_page_numbers' ) ) : 
						wp_page_numbers();
						   
					else: 
						global $wp_query;
						if ( $wp_query->max_num_pages > 1 ) : 
					?>
							<ul class="default-wp-page">
								<li class="previous"><? next_posts_link( 'Предыдущие' );?></li>
								<li class="next"><? previous_posts_link('Следующие'); ?></li>
								<div class="clear" style="margin-bottom: 10px;"></div>
							</ul>
                        <?php endif;
 					endif; 
                    ?>

                    			
			<?php else : ?>
                    <div class="post">
                        <h2>К сожалению, в этой категории ещё нет статей. Но будут обязательно!</h2>
                    </div><!-- .post -->
			
			<?php endif; ?>