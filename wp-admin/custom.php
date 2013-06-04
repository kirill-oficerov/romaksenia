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
			} elseif(isset($inputData['imageId'])) {
				$src = '';
				global $wpdb;
				if(!$inputData['state']) {
					Wd_Parts_Post::SaveSettings($inputData['id'], array(
						'slider' => array(
							'src' => $src,
						)
					));
					$query = 'UPDATE wp_posts SET show_at_slider = NULL WHERE ID=' . intval($inputData['id']);
				} else {
					$query = 'SELECT guid FROM wp_posts WHERE ID=' . intval($inputData['imageId']);
					$src = array_pop($wpdb->get_results($query));
					$src = mb_substr($src->guid, strlen($_SERVER['HTTP_ORIGIN']), mb_strlen($src->guid), 'UTF-8');
					Wd_Parts_Post::SaveSettings($inputData['id'], array(
						'slider' => array(
							'src' => mysql_real_escape_string($src),
						)
					));
					$query = 'UPDATE wp_posts SET show_at_slider=' . intval($inputData['imageId']) . ' WHERE ID=' . intval($inputData['id']);
				}
				$wpdb->get_results($query);
				echo json_encode(array('slider_image_src' => $src));
			}
		} catch(Exception $e) {
			echo json_encode(array('errors' => $e->getMessage()));
		}
	}
}
