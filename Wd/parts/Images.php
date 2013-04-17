<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: Oficerov Kirill
 * Date: 13.04.13
 */

class Wd_Parts_Images {

	const SIZE_FRONT = 'size_front';

	public static $_sizes = array(
		self::SIZE_FRONT => 0
	);

	/**
	 * @param $imagePath @string server patch of original image
	 * @param $sizeName @const Wd_Parts_Images::SIZE_*
	 * @param $dimensions @array|null array('width', 'height')
	 * @param $token string|int 01339324934
	 * @return mixed
	 */
	public static function CreateImageByPath($imagePath, $sizeName, $dimensions, $token) {
		$originImage = new Imagick();
		$originImage->readimage($imagePath);
		if(is_null($dimensions)) {
			$dimensions['height'] = $originImage->getimageheight();
			$dimensions['width'] = $originImage->getimagewidth();
 		}
		$newImageNameParts = explode('.', $imagePath);
		$originExtension = array_pop($newImageNameParts);
		if($originExtension == 'png') {
			$originImage->resizeimage($dimensions['width'], $dimensions['height'], imagick::FILTER_UNDEFINED, 1);
		} else {
			$originImage->scaleimage($dimensions['width'], $dimensions['height']);
			$originImage->setimagecompression(imagick::COMPRESSION_JPEG);
			$originImage->setimagecompressionquality(80);
		}
		$newImageName = implode('.', $newImageNameParts) . '_' . Wd_Parts_Images::$_sizes[$sizeName] . '_' . $token . '.' . $originExtension;
		$originImage->stripImage();
		$originImage->writeImage($newImageName);
		$originImage->clear();
		// make a relative path
		$matches = array();
		preg_match('/wp-content.uploads(.*)$/', $newImageName, $matches);
		return $matches[1];
	}
}