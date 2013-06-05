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

<div class="content">
	<ul class="cases">
		<?
		if ( have_posts() ) {
			while( have_posts() ) {
				the_post();
				global $post;

				$excerpt = the_excerpt(false);
				$content = mb_substr($excerpt, 3);
				$content = mb_substr($content, 0, -5);
				?>

				<li>
					<div>
						<div class="image_container">
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
									$picture = str_replace($fullSizeImage, '"' . $thumbnailSrc . '"', $picture);
								}
								?>
								<a rel="prettyPhoto" href=<?=$fullSizeImage?> title="<?php the_title_attribute( 'echo=0' ) ?>">
									<?php echo $picture ?>
									</a>
									<? } ?>
						</div>
						<div class="public_date"><?=Wd::getReadableDate(date('d-m-Y', strtotime($post->post_date)))?></div>
						<div class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>
						<div class="excerpt">
							<?
							$matches = array();
							preg_match('~<a[^>]+readmore[^>]*>Далее</a>~', $content, $matches);
							$content = str_replace($matches[0], '', $content);
							echo $content;
							if(strpos(substr($content, -10, 10), '<br />') === false) {
								echo "<br />";
							}
							?>
						</div>
					</div>
				</li>

			<? }
		} else { ?>
			<div class="post">
				<h2>К сожалению, в этой категории ещё нет статей. Но будут обязательно!</h2>
			</div><!-- .post -->
		<?php } ?>
	</ul>
</div>