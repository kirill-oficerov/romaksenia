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
	 *          'featuredImageName' => '4/2013/logo.jpg'
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
				$postSettings = array_merge($postSettings, $newSettings);
			} else {
				$postSettings = $newSettings;
			}
			$query = 'UPDATE wp_posts SET settings=\'' . serialize($postSettings) . '\' WHERE ID=' . intval($postId);
			$wpdb->get_results($query);
		}
	}
	public static function AdminCreateFeaturedImage($postId, $thumbnailId) {
		$newImageName = Wd_Parts_Image::CreateThumbnailFromImage($thumbnailId, Wd_Parts_Image::SIZE_FRONT, array());
		Wd_Parts_Post::SaveSettings($postId, array('featuredImageName' => $newImageName));

	}

	/**
	 * creates optimized image for content of any post
	 */
	public static function AdminCreateFrontContentImage($postData) {
		$matches = array();
		preg_match_all('/<a.*href=\\\\"([^\\\\]+)\\\\"[^<]+<img.+width=\\\\"(\d+)\\\\".+height=\\\\"(\d+)\\\\"[^>]+>/', $postData['content'], $matches);
		// $matches[1] - image path
		// $matches[2] - image width
		// $matches[3] - image height
		foreach($matches[1] as $key => $httpPath) {
			$httpPathParts = explode('wp-content/uploads/', $httpPath);
			if(isset($httpPathParts[1])) {
				$realpath = SERVER_IMAGES_UPLOAD_DIR . $httpPathParts[1];
				if(file_exists($realpath)) {
					$pathInfo = pathinfo($realpath);
					$newFile = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_' . Wd_Parts_Image::$_sizes[Wd_Parts_Image::SIZE_FRONT_CONTENT] .
						'.' . $pathInfo['extension'];
					if(!file_exists($newFile)) {
						Wd_Parts_Image::CreateImageByPath($realpath, Wd_Parts_Image::SIZE_FRONT_CONTENT, array(
							'width' => $matches[2][$key],
							'height' => $matches[3][$key]
						), '');
					}
				}
			}
		}
	}

}