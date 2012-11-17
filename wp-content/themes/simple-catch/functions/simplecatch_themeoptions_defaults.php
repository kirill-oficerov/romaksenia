<?php
/**
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.3.4
 */

/**
 * Set the default values for all the settings. If no user-defined values
 * is available for any setting, these defaults will be used.
 */
global $simplecatch_options_defaults;
$simplecatch_options_defaults = array(
 	'disable_slogan' 			=> get_template_directory_uri().'/images/logo.png',
 	'remove_header_logo'		=> '0',
 	'remove_site_title'			=> '0',
 	'remove_site_description'	=> '0',
 	'featured_logo_footer' 		=> get_template_directory_uri().'/images/logo-foot.png',
 	'remove_footer_logo'		=> '0',
 	'fav_icon'					=> get_template_directory_uri().'/images/favicon.ico',
 	'remove_favicon'			=> '0',
	'heading_color'				=> '#444444',
 	'meta_color'				=> '#999999',
 	'text_color'				=> '#555555',
 	'link_color'				=> '#000000',
 	'widget_heading_color'		=> '#666666',
 	'widget_text_color'			=> '#666666',
 	'exclude_slider_post'		=> '0',
 	'front_page_category'		=> array(),
 	'slider_qty'				=> 4,
 	'featured_slider'			=> array(),
 	'remove_noise_effect'		=> '0',
 	'transition_effect'			=> 'fade',
 	'transition_delay'			=> 4,
 	'transition_duration'		=> 1,
 	'social_facebook'			=> '',
 	'social_twitter'			=> '',
 	'social_googleplus'			=> '',
 	'social_pinterest'			=> '',
 	'social_youtube'			=> '',
 	'social_vimeo'				=> '',
 	'social_linkedin'			=> '',
 	'social_slideshare'			=> '',
 	'social_foursquare'			=> '',
 	'social_flickr'				=> '',
 	'social_tumblr'				=> '',
 	'social_deviantart'			=> '',
 	'social_dribbble'			=> '',
 	'social_myspace'			=> '',
 	'social_wordpress'			=> '',
 	'social_rss'				=> '',
 	'social_delicious'			=> '',
 	'social_lastfm'				=> '',
 	'custom_css'				=> '',
 	'google_verification'		=> '',
 	'yahoo_verification'		=> '',
 	'bing_verification'			=> '',
 	'analytic_header'			=> '',
 	'analytic_footer'			=> '',
 	'sidebar_layout'			=> 'right-sidebar',
 	'more_tag_text'				=> 'Continue Reading &rarr;',
 	'search_display_text'		=> 'Type KeyWord',
 	'search_button_text'		=> 'Search',
 	'excerpt_length'			=> 30,
	'feed_url'					=> ''
 );
global $simplecatch_options_settings;
$simplecatch_options_settings = simplecatch_options_set_defaults( $simplecatch_options_defaults );

function simplecatch_options_set_defaults( $simplecatch_options_defaults ) {
	$simplecatch_options_settings = array_merge( $simplecatch_options_defaults, (array) get_option( 'simplecatch_options', array() ) );
	return $simplecatch_options_settings;
}

?>