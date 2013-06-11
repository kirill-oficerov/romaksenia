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

	/**
	 * Should run once. Sets constants for WD
	 */
	protected static function setConsts() {
		define('WD_RUN_ALREADY', true);
		define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'] . (substr($_SERVER['DOCUMENT_ROOT'], -1, 1) !== '/' ? '/' : '')); // "../wedigital/www/"
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

	/**
	 * @param $text
	 * @return int position of the first dot of the specified parameter $text
	 */
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

	/**
	 * @param $path
	 * @return array|bool it's like function pathinfo() but works with urf paths
	 */
	public static function pathinfo_utf($path) {

		if (strpos($path, '/') !== false) {
			$basename = end(explode('/', $path));
		} elseif (strpos($path, '\\') !== false) {
			$basename = end(explode('\\', $path));
		} else {
			return false;
		}

		if (!$basename) {
			return false;
		}

		$dirname = substr($path, 0, strlen($path) - strlen($basename) - 1);

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

	/**
	 * @param $date like '04.05.2013'
	 * @return bool|string
	 *      false on error or '4 may 2013'
	 */
	public static function getReadableDate($date) {
		$date = str_replace(array('/', '-', ' '), '.', $date);
		$dateParts = explode('.', $date);
		if(count($dateParts) != 3) {
			return false;
		}
		$days = ltrim($dateParts[0], '0');
		$month = '';
		switch(intval($dateParts[1])) {
			case 1: $month = 'января'; break;
			case 2: $month = 'февраля'; break;
			case 3: $month = 'марта'; break;
			case 4: $month = 'апреля'; break;
			case 5: $month = 'мая'; break;
			case 6: $month = 'июня'; break;
			case 7: $month = 'июля'; break;
			case 8: $month = 'августа'; break;
			case 9: $month = 'сентября'; break;
			case 10: $month = 'октября'; break;
			case 11: $month = 'ноября'; break;
			case 12: $month = 'декабря'; break;
		}
		return $days . ' ' . $month . ($dateParts[2] != date('Y') ? (' ' . $dateParts[2]) : '');
	}
}