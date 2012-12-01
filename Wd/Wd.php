<?php
class Wd {

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
		self::setConsts();
		self::registerAutoload();
	}

	protected static function setConsts() {
		define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/');
		define('WD_DIR', $_SERVER['DOCUMENT_ROOT'] . '\\Wd\\');
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
}