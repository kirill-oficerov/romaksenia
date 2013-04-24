<?php
require_once('../Wd.php');
Wd::run();
$connection = mysql_connect('127.0.0.1', 'root', '');
mysql_select_db('santanam_wp1', $connection);
mysql_query('SET NAMES "utf8";');

$query = mysql_query('
SELECT

wpp.ID AS wpp_post_id,
wpp.settings AS wpp_settings,
"||||",
UNIX_TIMESTAMP(wpp2.post_modified) as wpp2_token,
wpp2.ID as image_id,
wpp2.guid as image_name

FROM wp_posts wpp
INNER JOIN wp_postmeta wppm ON wppm.post_id = wpp.ID
INNER JOIN wp_posts wpp2 ON wppm.meta_value = wpp2.ID
WHERE wppm.meta_key =  "_thumbnail_id"

', $connection);
ini_set('error_reporting', 32767);

while($result = mysql_fetch_assoc($query)) {
	$matches = array();
	preg_match('/wp-content.uploads(.*)$/', $result['image_name'], $matches);

	$imageName = SERVER_IMAGES_UPLOAD_DIR . $matches[1];
	if(file_exists($imageName)) {
		$dimensions = null;
		if(isset($result['wpp_settings']) && !empty($result['wpp_settings'])) {
			$settings = unserialize($result['wpp_settings']);
			if(isset($settings['height']) && isset($settings['width'])) {
				$dimensions['height'] = $settings['height'];
				$dimensions['width'] = $settings['width'];
			}

		}
		$token = $result['wpp2_token'];
		$newImageName = Wd_Parts_Image::CreateImageByPath(
			$imageName,
			Wd_Parts_Image::SIZE_FRONT,
			$dimensions,
			$token
		);
		saveSettings($result['wpp_post_id'], array('featuredImageName' => $newImageName));
		echo "<pre>".print_r($imageName . ' exists', true)."</pre>\n\n";
	} else {
		echo "<pre>".print_r($imageName . ' does not exist', true)."</pre>\n\n";
	}


}

function saveSettings($postId, array $newSettings) {


	$connection = mysql_connect('127.0.0.1', 'root', '');
	mysql_select_db('santanam_wp1', $connection);
	mysql_query('SET NAMES "utf8";');
	$query = mysql_query(
		'SELECT settings FROM wp_posts WHERE ID=' . intval($postId), $connection
	);

	$postSettings = mysql_fetch_assoc($query);
	$postSettings = $postSettings['settings'];
	$postSettings = unserialize($postSettings);
	if($postSettings) {
		$postSettings = array_merge($postSettings, $newSettings);
	} else {
		$postSettings = $newSettings;
	}
	$query = 'UPDATE wp_posts SET settings=\'' . serialize($postSettings) . '\' WHERE ID=' . intval($postId);
	mysql_query($query);
}