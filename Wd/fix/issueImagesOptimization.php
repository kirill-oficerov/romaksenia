<?php
require_once('../Wd.php');
Wd::run();
$connection = mysql_connect('127.0.0.1', 'root', '');
mysql_select_db('santanam_wp1', $connection);
$query = mysql_query('
SELECT wpp.settings as wpp_settings, wpp.post_modified as wpp_token, "<-wpp wppm->", wppm.* FROM wp_posts wpp
INNER JOIN wp_postmeta wppm ON wppm.post_id = wpp.ID

WHERE wppm.meta_key = "_wp_attached_file"
', $connection);


while($result = mysql_fetch_assoc($query)) {
//	echo "<pre>".print_r($result, true)."</pre>\n\n";
//	echo "<pre>".print_r(SERVER_IMAGES_UPLOAD_DIR . $result['meta_value'], true)."</pre>\n\n";
	if(file_exists(SERVER_IMAGES_UPLOAD_DIR . $result['meta_value'])) {
		$dimensions = null;
		if(isset($result['wpp_settings']) && !empty($result['wpp_settings'])) {
			$settings = unserialize($result['wpp_settings']);
			if(isset($settings['height']) && isset($settings['width'])) {
				$dimensions['height'] = $settings['height'];
				$dimensions['width'] = $settings['width'];
			}

		}
		$token = new DateTime($result['wpp_token']);
		$token = $token->getTimestamp();
		Wd_Parts_Images::CreateImageByPath(
			SERVER_IMAGES_UPLOAD_DIR . $result['meta_value'],
			Wd_Parts_Images::SIZE_FRONT,
			$dimensions,
			$token
		);
		echo "<pre>".print_r(SERVER_IMAGES_UPLOAD_DIR . $result['meta_value'] . ' exists', true)."</pre>\n\n";
	}
	
}