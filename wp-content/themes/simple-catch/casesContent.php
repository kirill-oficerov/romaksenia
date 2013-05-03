<?php
/**
 * This is the template that displays content for cases page
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
			<?php if ( have_posts() ) : 
                while( have_posts() ):
	                the_post(); ?>

                        <?php
	                    global $post;

	                ?>
                <div <?php post_class(); ?> >
	                    <div class="col8">
                            <div style="float: left; margin-right: -150px; width: 100%; ">
			                    <h2 class="entry-title" style="margin: 10px 150px 3px 0px; ">
	                                <a href="<?php the_permalink() ?>" title="" rel="bookmark" ><?php the_title(); ?></a>
	                            </h2>
                            </div>
<!--	                --><?//
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
		                    <div class="post_date"><?=(date('d.m.Y', strtotime($post->post_date)))?></div>
		                    <div class="clear" style="height: 1px; width: 1px; "></div>
		                    <div style="text-align: right; float: right; margin: 0px 0px 0px 15px;">
			                    <?
			                        $picture = get_the_post_thumbnail( null, 'featured', '' );
				                    if(!empty($picture)) {
					                    $pictureSrc = array();
					                    preg_match('/src="[^"]+"/', $picture, $pictureSrc);
					                    $settings = unserialize($post->settings);
					                    $fullSizeImage = substr($pictureSrc[0], 4);
					                    if($settings) {
						                    if(isset($settings['width']) && isset($settings['height'])) {
							                    $width = $settings['width'];
							                    $height = $settings['height'];
							                    $picture = str_replace('<img', '<img style="width:' . $width . 'px; height:' . $height . 'px;"', $picture);
						                    }
						                    $matches = array();
						                    preg_match('/"(.*wp-content.uploads).*$/', $fullSizeImage, $matches);
						                    $thumbnailSrc = $matches[1] . '/' . $settings['featuredImageName'];
						                    $picture = str_replace('src="' . $fullSizeImage . '"', 'src="' . $thumbnailSrc . '"', $picture);
					                    }
					                    ?>
                                    <a rel="prettyPhoto" href=<?=substr($pictureSrc[0], 4)?> title="<?php the_title_attribute( 'echo=0' ) ?>">
				                    <?php echo $picture ?>
			                    </a>
			                        <? } ?>
		                    </div>
		                    <?
		                    $matches = array();
		                    preg_match('~<a[^>]+readmore[^>]*>Далее</a>~', $content, $matches);
		                    $content = str_replace($matches[0], '', $content);
		                    echo $content;
		                    ?>
		                    <br>
		                    <?=$matches[0]?>

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