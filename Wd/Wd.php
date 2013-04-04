<?php
class Wd {

	const TAGS_URL = '/tags';

	protected static $_cache = array();

	public static function get($key) {
		if(!isset(self::$_cache[$key])) {
			$className = ucfirst($key);
			require_once 'settings/' . $className . '.php';
			self::$_cache[$key] = new $className();
		}
		return self::$_cache[$key];
	}

	public static function run() {
		if(!defined('WD_RUN_ALREADY')) {
			self::setConsts();
			self::registerAutoload();
		}
	}

	protected static function setConsts() {
		define('WD_RUN_ALREADY', true);
		define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/');
		define('WD_DIR', $_SERVER['DOCUMENT_ROOT'] . '\\Wd\\');
		define('SIMPLE_CATCH_DIR', $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/simple-catch/');

		define('HTTP_HOST', 'http://' . $_SERVER['HTTP_HOST']);
		define('HTTP_IMAGES_DIR', HTTP_HOST . '/wp-content/themes/simple-catch/images/');
	}

	protected static function registerAutoload() {
		spl_autoload_register('self::registerAutoloadRealization');
	}
	protected static function registerAutoloadRealization($className) {
		$parts = explode('_', $className);
		$fileName = array_pop($parts);
		array_shift($parts);
		foreach($parts as &$value) {
			$value = strtolower($value);
		}
		if(file_exists(DOCUMENT_ROOT . '/Wd/' . implode('/', $parts) . '/' . $fileName . '.php')) {
			require_once DOCUMENT_ROOT . '/Wd/' . implode('/', $parts) . '/' . $fileName . '.php';
		}
	}

	public static function is_page_tag() {
		return strpos($_SERVER['REQUEST_URI'], self::TAGS_URL) === 0;
	}

	public static function get_tags_template() {
//		return SIMPLE_CATCH_DIR . 'tagsContent.php';
		return 'tagsContent';
	}
	public static function get_tag() {
		return mysql_real_escape_string(substr($_SERVER['REQUEST_URI'], strlen(self::TAGS_URL) + 1) );
	}

	public static function mb_str_replace($search, $replace, $subject) {
		$searchPosition = mb_strpos($subject, $search, null, 'UTF-8');
		$leftPart = mb_substr($subject, 0, $searchPosition);
		$rightPart = mb_substr($subject, $searchPosition + mb_strlen($search));
		return $leftPart . $replace . $rightPart;
	}

}