<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: Oficerov Kirill
 * Date: 13.04.13
 */

class Wd_Parts_Slider {

	public static function get_content() {
		global $wpdb;

		$query = "SELECT posts.*, images.guid as image_guid FROM wp_posts as posts
					LEFT JOIN wp_posts as images ON posts.show_at_slider = images.ID
					WHERE posts.show_at_slider IS NOT NULL
					LIMIT 2";
		$terms = $wpdb->get_results($query);
		if(count($terms) == 2) {
			usort($terms, function($value1, $value2) {
				$firstPostSettings = unserialize($value1->settings);
				$secondPostSettings = unserialize($value2->settings);
				return $firstPostSettings['slider']['order'] > $secondPostSettings['slider']['order'];
			});
			$firstPost = $terms[0];
			$secondPost = $terms[1];
			?>
			<div class="slider_container">
				<div class="slider">
					<div class="left">
						<a href="<?=get_permalink($firstPost->ID)?>"><img src="<?=$firstPost->image_guid?>"></a>
					</div>
					<div class="right">
						<div class="toggler"><div></div></div>
						<div class="slide">
							<a href="<?=get_permalink($secondPost->ID)?>"><img src="<?=$secondPost->image_guid?>"></a>
						</div>
					</div>
				</div>
			</div>
			<?

		}
	}
}
