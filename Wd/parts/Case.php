<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: Oficerov Kirill
 * Date: 13.04.13
 */

class Wd_Parts_Case {

	public static function get_content() {
		global $wpdb;

		$query = "SELECT * FROM wp_terms
INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id = wp_terms.term_id
INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
INNER JOIN wp_posts ON wp_posts.ID = wp_term_relationships.object_id
WHERE wp_terms.slug = 'cases' AND wp_posts.post_status = 'publish'

ORDER BY post_date DESC
LIMIT 3";
		$terms = $wpdb->get_results($query);

		echo '
		<div class="header">
			<div class="label">
					<a href="http://' . $_SERVER['HTTP_HOST'] . '/cases/">Кейсы</a>
			</div>
			<div class="hr"></div>
		</div>
	    <div class="clear">&nbsp;</div>
		<div class="content">
			<ul class="cases">';
		foreach($terms as $post) {
			echo '<li>';
			setup_postdata((object)$post);
			$picture = get_the_post_thumbnail($post->ID, 'featured', '' );
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
			}
	?>
<!--	<a rel="prettyPhoto" href=--><?//=$fullSizeImage?><!-- title="--><?php //the_title_attribute( 'echo=0' ) ?><!--">-->
<!--									--><?php //echo $picture ?>
<!--									</a>-->
									<?
			echo '
			<div>
				<a rel="prettyPhoto" href=' . $fullSizeImage . ' title="' . the_title_attribute( 'echo=0' ) . '"><img class="featured_image" src="' . $thumbnailSrc . '"></a>
				<div class="public_date">' . Wd::getReadableDate(date('d-m-Y', strtotime($post->post_date))) . '</div>
				<div class="title"><a href="#">' . $post->post_title . '</a></div>
			</div>';
			echo '</li>';
		}
		echo '
			</ul>
		</div>';

	}




}
