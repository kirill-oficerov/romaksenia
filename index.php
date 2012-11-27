<?php if(!function_exists("__ics")){ob_start();?>$1</a>, <a  style='background:none;' href='http://installatron.com/apps/wordpress' target='_blank' title='Installatron enables webmasters to instantly install and upgrade WordPress and other web applications.'><?php
switch (mt_rand(0,2))
{
case 0:echo "Automated by Installatron";break;
case 1:echo "Powered by Installatron";break;
case 2:echo "Installed by Installatron";break;
}
?></a>.<?php define("__ICV",ob_get_contents());ob_end_clean();function __ics($b,$m){return preg_replace('!([^"]powered\\s+by\\s+(?:<a href=.[^\'"]+.>)?\\s*WordPress)\\.?\\s*</a>\\.?!sim',__ICV,$b);} ob_start("__ics");}?><?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/**
 * custom
 */

define('DOCUMENT_ROOT', realpath('.') . '\\');
define('CUSTOM_DIR', realpath('.') . '\\custom\\');
spl_autoload_register(function($className) {
	$parts = explode('_', $className);
	$fileName = array_pop($parts);
	if(file_exists(DOCUMENT_ROOT . implode('/', $parts) . '/' . $fileName . '.php')) {
		require_once DOCUMENT_ROOT . implode('/', $parts) . '/' . $fileName . '.php';
	}
});
/** Loads the WordPress Environment and Template */
require('./wp-blog-header.php');
