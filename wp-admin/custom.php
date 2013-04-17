<?php
/** Load WordPress Administration Bootstrap */
require_once('./admin.php');
header('Content-type: application/json');
$inputData = $_POST;

class WP_Admin_Custom {
	public function __construct() {

	}
	public function SaveFeaturedSettings($data) {
		if(!isset($data['id']) || empty($data['id'])) {
			echo json_encode(array('errors' => 'Error: id is not set'));
			return;
		}
		if(!isset($data['featuredWidth']) || empty($data['featuredWidth'])) {
			echo json_encode(array('errors' => 'Error: featured width is not set'));
			return;

		}
		if(!isset($data['featuredHeight']) || empty($data['featuredHeight'])) {
			echo json_encode(array('errors' => 'Error: featured height is not set'));
			return;

		}

		$height = intval($data['featuredHeight']);
		$width = intval($data['featuredWidth']);
		global $wpdb;
		$query = 'SELECT * FROM wp_posts WHERE ID=' . intval($data['id']);
		$post = $wpdb->get_results($query);
		if(empty($post)) {
			echo json_encode(array('errors' => 'Error: post not found'));
			return;
		}
		$post = array_pop($post);
		if(isset($post->settings) && !empty($post->settings)) {
			$settings = unserialize($post->settings);
		} else {
			$settings = array();
		}
		$settings['width'] = $width;
		$settings['height'] = $height;
		$serializedSettings = serialize($settings);
		$query = 'UPDATE wp_posts SET settings = \'' . $serializedSettings . '\' WHERE ID=' . intval($data['id']);
		$wpdb->get_results($query);
	}

	public function CreateImage($imageId, $sizeName, $dimensions) {
		global $wpdb;
		$query = 'SELECT * FROM wp_posts WHERE ID=' . intval($imageId);
		$image = $wpdb->get_results($query);
		if(!count($image)) {
			throw new Exception('no such an image with specified id');
		}
		$image = array_pop($image);
		$imageName = $image->guid;
		$imageName = DOCUMENT_ROOT . str_replace(HTTP_HOST, '', $imageName);
		return Wd_Parts_Images::CreateImageByPath($imageName, $sizeName, $dimensions, strtotime($image->post_modified));
	}
}

if(!isset($inputData['settingName'])) {
	echo json_encode(array('errors' => 'Error: setting is not set'));
	return;
} else {
	$wpAdminCustom = new WP_Admin_Custom();
	if($inputData['settingName'] == 'feature-settings') {
		$wpAdminCustom->SaveFeaturedSettings($inputData);
		try {
			$newImageName = $wpAdminCustom->CreateImage($inputData['imageId'], Wd_Parts_Images::SIZE_FRONT, array(
				'width' => $inputData['featuredWidth'],
				'height' => $inputData['featuredHeight']
			));
			Wd_Parts_Post::SaveSettings($inputData['id'], array('featuredImageName' => $newImageName));
		} catch(Exception $e) {
			echo json_encode(array('errors' => $e->getMessage()));

		}
	}
}
