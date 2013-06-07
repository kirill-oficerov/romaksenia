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
			$firstImage = $terms[0];
			$secondImage = $terms[1];
			?>
			<div style="position: relative; float: left; z-index: 1;">
				<a href="#"><img style="width: 750px; height: 310px;" src="<?=$firstImage->image_guid?>"></a>
			</div>
			<div style="position: relative; float: left: z-index: 2;">
				<div style="float: left; line-height: 100%; text-align: center; height: 100%; width: 51px;"><div style="background:url("images/icons.png") no-repeat -48px -19px; width: 51px; height: 51px;"></div></div>
				<div style="float: left; margin: 0 0 0 5px;">
					<a href="#"><img style="width: 750px; height: 310px;" src="<?=$secondImage->image_guid?>"></a>
				</div>
			</div>
			<?

		}
	}
}
