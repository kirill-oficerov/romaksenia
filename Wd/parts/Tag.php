<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: Oficerov Kirill
 * Date: 13.04.13
 */

class Wd_Parts_Tag {

	const TAGS_URL = '/tags';
	const TAGS_TEMPLATE = 'tagsContent';

	public static function is_page_tag() {
		return strpos($_SERVER['REQUEST_URI'], self::TAGS_URL) === 0;
	}

	public static function get_tags_template() {
		return self::TAGS_TEMPLATE;
	}

	public static function get_tag() {
		return mysql_real_escape_string(substr($_SERVER['REQUEST_URI'], strlen(self::TAGS_URL) + 1) );
	}

}