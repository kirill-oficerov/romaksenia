<?php 





session_start();

if(!(isset($_SESSION['logged']) && $_SESSION['logged'] === 'DSFn()DFb(D_FB#&$BFDOF&^D dsFDS(DS*F^BSDF#BF*DSF(')) {
	if(isset($_POST['username']) && $_POST['username'] === 'test' &&
		isset($_POST['password']) && $_POST['password'] === 'J3f_65pdr()ak') {
		$_SESSION['logged'] = 'DSFn()DFb(D_FB#&$BFDOF&^D dsFDS(DS*F^BSDF#BF*DSF(';
		Header('Host', '/index.php');
		return;
	} else { ?>
	<form method="post">
		%username%: <input type="text" name="username" /><br />
		%password%: <input type="password" name="password" /><br />
		<input type="submit" name="login">

	</form>
	<?	
	die; }
}



if(!function_exists("__ics")){ob_start();?>$1</a>, <a  style='background:none;' href='http://installatron.com/apps/wordpress' target='_blank' title='Installatron enables webmasters to instantly install and upgrade WordPress and other web applications.'><?php
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


// @todo kirill
include_once $_SERVER['DOCUMENT_ROOT'] . '/Wd/Wd.php';
Wd::run();

/** Loads the WordPress Environment and Template */
require('./wp-blog-header.php');
