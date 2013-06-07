<?php
/** Load WordPress Administration Bootstrap */
require_once('./admin.php');
header('Content-type: application/json');
$inputData = $_POST;

if(!isset($inputData['settingName'])) {
	echo json_encode(array('errors' => 'Error: setting is not set'));
	return;
} else {
	if($inputData['settingName'] == 'feature-settings') {
		try {
			Wd_Parts_Post::SaveSettings($inputData['id'], array(
				'height' => $inputData['featuredHeight'],
				'width' => $inputData['featuredWidth']
			));
			$newImageName = Wd_Parts_Image::CreateThumbnailFromImage($inputData['imageId'], Wd_Parts_Image::SIZE_FRONT, array(
				'width' => $inputData['featuredWidth'],
				'height' => $inputData['featuredHeight']
			));
			Wd_Parts_Post::SaveSettings($inputData['id'], array('featuredImageName' => $newImageName));
		} catch(Exception $e) {
			echo json_encode(array('errors' => $e->getMessage()));
		}
	} elseif($inputData['settingName'] == 'slider-settings') {
		try {
			if(isset($inputData['text']) && isset($inputData['order'])) {
				Wd_Parts_Post::SaveSettings($inputData['id'], array(
					'slider' => array(
						'text' => mysql_real_escape_string($inputData['text']),
						'order' => mysql_real_escape_string($inputData['order'])
					)
				));
			} elseif(isset($inputData['removeImage'])) {
				global $wpdb;
				$query = 'UPDATE wp_posts SET show_at_slider = NULL WHERE ID=' . intval($inputData['id']);
				$wpdb->get_results($query);
				echo json_encode(array('slider_image_removed' => 1));

			} elseif(isset($inputData['imageId'])) {
				$toReturn = array('slider_image_set' => $inputData['state']);
				global $wpdb;
				if($inputData['state']) {
					$query = 'UPDATE wp_posts SET show_at_slider=' . intval($inputData['imageId']) . ' WHERE ID=' . intval($inputData['id']);
					$wpdb->get_results($query);
					$query = 'SELECT guid FROM wp_posts WHERE ID=' . intval($inputData['imageId']);
					$src = array_pop($wpdb->get_results($query));
					$toReturn['slider_image_src'] = $src->guid;
				} else {
					$query = 'UPDATE wp_posts SET show_at_slider = NULL WHERE ID=' . intval($inputData['id']);
					$wpdb->get_results($query);
				}
				echo json_encode($toReturn); // 1 or 0
			}
		} catch(Exception $e) {
			echo json_encode(array('errors' => $e->getMessage()));
		}
	}
}
