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
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(''); ?></title>
<link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/sansus-webissimo" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_uri(); ?>" />
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
		wp_enqueue_script('prettyPhoto', '/Wd/js/prettyPhoto/js/jquery.prettyPhoto.js');
		wp_enqueue_style('prettyPhoto', '/Wd/js/prettyPhoto/css/prettyPhoto.css');

		//  post
		wp_enqueue_script('post', '/Wd/js/post.js');

	}
//	if(is_single()) {
		add_action( 'wp_enqueue_scripts', 'my_scripts_method' ); // На внешней части сайта (в теме оформления)
//	}
	wp_head();
?>
</head>
<body <?php body_class(); ?>>
<div id="header">
	<div class="top-bg"></div>
  		<div class="layout-978">
        	<?php 
        		// Funcition to show the header logo, site title and site description
        		if ( function_exists( 'simplecatch_headerdetails' ) ) :
					simplecatch_headerdetails(); 
				endif;
			?>
			<div id="mainmenu">
			    <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</div><!-- #mainmenu-->

			<div class="social-search">
				<?php
                    // simplecatch_headersocialnetworks displays social links given from theme option in header 
                    if ( function_exists( 'simplecatch_headersocialnetworks' ) ) :
                        simplecatch_headersocialnetworks(); 
                    endif;
                    // get search form
                    get_search_form();
                ?>      
        	</div><!-- .social-search -->
			  <div class="header-icons-container">
				  <a class="icons home-icon" href="<?= HTTP_HOST . '/'?>">&nbsp;</a>
				  <a class="icons contacts-icon" href="<?= HTTP_HOST . '/контакты'?>"></a>
				  <a class="icons sitemap-icon" href="<?= HTTP_HOST . '/'?>">&nbsp;</a>
			  </div>
    		<div class="row-end"></div>
            <div class="row-end"></div>

        <?php
			// This function passes the value of slider effect to js file
			if( function_exists( 'simplecatch_pass_slider_value' ) ) {
				simplecatch_pass_slider_value();
			}
			// Display slider in home page and breadcrumb in other pages 
			if ( function_exists( 'simplecatch_sliderbreadcrumb' ) ) :
				simplecatch_sliderbreadcrumb(); 
			endif;
		?> 
	</div><!-- .layout-978 -->
</div><!-- #header -->