<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section 
 *
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.0
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta name="google-site-verification" content="COf4Fim1XzvA3mRfghLvHfOJLqMAvF7p6TYV92LzqO4" />
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(''); ?></title>
<? global $wp_version; ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_uri(); echo '?ver=' . $wp_version?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	// @todo kirill js
	function my_scripts_method() {
		// prettyPhoto
		wp_enqueue_script('jquery');
		wp_enqueue_script('prettyPhoto', '/Wd/js/prettyPhoto/js/jquery.prettyPhoto.js');
		wp_enqueue_style('prettyPhoto', '/Wd/js/prettyPhoto/css/prettyPhoto.css');

		//  post
//		wp_enqueue_script('post', '/Wd/js/post.js');
		wp_enqueue_script('post', '/Wd/js/slider.js');
		wp_enqueue_script('popup', '/Wd/js/popup.js');
		wp_enqueue_script('popup_send_news', '/Wd/js/popup_send_news.js');

	}
	add_action( 'wp_enqueue_scripts', 'my_scripts_method' ); // На внешней части сайта (в теме оформления)
	wp_head();
?>
</head>
<?
/*
<body <?php body_class(); ?>>
*/
?>
<body>
