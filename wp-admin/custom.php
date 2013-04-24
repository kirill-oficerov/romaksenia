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
	}
}
