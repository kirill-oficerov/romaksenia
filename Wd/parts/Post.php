<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: Oficerov Kirill
 * Date: 13.04.13
 */

class Wd_Parts_Post {

	/**
	 * @param $postId
	 * @param array $settings like
	 *      array(
	 *          'featuredImageName' => '/4/2013/logo.jpg'
	 *      )
	 */
	public static function SaveSettings($postId, array $newSettings) {
		$query = 'SELECT settings FROM wp_posts WHERE ID=' . intval($postId);
		global $wpdb;
		$postSettings = $wpdb->get_results($query);
		if($postSettings) {
			$postSettings = array_pop($postSettings);
			$postSettings = unserialize($postSettings->settings);
			if($postSettings) {
				$postSettings = array_merge_recursive($postSettings, $newSettings);
			} else {
				$postSettings = $newSettings;
			}
			$query = 'UPDATE wp_posts SET settings=\'' . serialize($postSettings) . '\' WHERE ID=' . intval($postId);
			$wpdb->get_results($query);
		}
	}
}