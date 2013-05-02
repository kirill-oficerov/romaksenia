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
		if(!defined('WD_RUN_ALREADY')) {
			self::setConsts();
			self::registerAutoload();
		}
	}

	protected static function setConsts() {
		define('WD_RUN_ALREADY', true);
		define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']); // "../wedigital/www/"
		define('WD_DIR', DOCUMENT_ROOT . '\\Wd\\');
		define('SIMPLE_CATCH_DIR', DOCUMENT_ROOT . '/wp-content/themes/simple-catch/');

		define('HTTP_HOST', 'http://' . $_SERVER['HTTP_HOST']); // wedigital.by
		define('HTTP_IMAGES_DIR', HTTP_HOST . '/wp-content/themes/simple-catch/images/');
		define('HTTP_IMAGES_UPLOAD_DIR', HTTP_HOST . '/wp-content/uploads/');
		define('SERVER_IMAGES_UPLOAD_DIR', DOCUMENT_ROOT . '/wp-content/uploads/');
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

	public static function mb_str_replace($search, $replace, $subject) {
		$searchPosition = mb_strpos($subject, $search, null, 'UTF-8');
		$leftPart = mb_substr($subject, 0, $searchPosition);
		$rightPart = mb_substr($subject, $searchPosition + mb_strlen($search));
		return $leftPart . $replace . $rightPart;
	}

	public static function get_first_dot($text) {
		$length = mb_strlen($text, 'UTF-8');
		$dotPosition = -1;
		$tagOpened = false;
		for($i = 0; $i < $length; $i++) {
			$current = mb_substr($text, $i, 1, 'UTF-8');
			if($current == '.' && !$tagOpened) {
				$dotPosition = $i;
				break;
			} elseif($current == '<') {
				$tagOpened = true;
			} elseif($current == '>') {
				$tagOpened = false;
			}
		}
		return $dotPosition;
	}

	public static function pathinfo_utf($path) {

		if (strpos($path, '/') !== false)
			$basename = end(explode('/', $path));
		elseif (strpos($path, '\\') !== false)
			$basename = end(explode('\\', $path));
		else
			return false;

		if (!$basename)
			return false;

		$dirname = substr($path, 0,
			strlen($path) - strlen($basename) - 1);

		if (strpos($basename, '.') !== false) {
			$extension = end(explode('.', $path));
			$filename = substr($basename, 0,
				strlen($basename) - strlen($extension) - 1);
		} else {
			$extension = '';
			$filename = $basename;
		}

		return array (
			'dirname' => $dirname,
			'basename' => $basename,
			'extension' => $extension,
			'filename' => $filename
		);
	}
}