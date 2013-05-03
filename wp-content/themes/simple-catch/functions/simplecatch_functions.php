<?php
/**
 * Register jquery scripts
 *
 * @register jquery cycle and custom-script
 * hooks action wp_enqueue_scripts
 */
function simplecatch_scripts_method() {
	//Register JQuery circle all and JQuery set up as dependent on Jquery-cycle
	wp_register_script( 'jquery-cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', array( 'jquery' ), '2.9999.5', true );

	//Enqueue Slider Script only in Front Page
	if ( is_home() || is_front_page() ) {
//		@todo kirill try make faster slider
//		wp_enqueue_script( 'simplecatch_slider', get_template_directory_uri() . '/js/simplecatch_slider.js', array( 'jquery-cycle' ), '1.0', true );
	}

	//Enqueue Search Script
	//		@todo kirill try make faster search

//	wp_enqueue_script ( 'simplecatch_search', get_template_directory_uri() . '/js/simplecatch_search.js', array( 'jquery' ), '1.0', true );

	//Browser Specific Enqueue Script i.e. for IE 1-6
	//		@todo kirill try make faster IE

//	$simplecatch_ua = strtolower($_SERVER['HTTP_USER_AGENT']);
//	if(preg_match('/(?i)msie [1-6]/',$simplecatch_ua)) {
//		wp_enqueue_script( 'pngfix', get_template_directory_uri() . '/js/pngfix.min.js' );
//	}
//	 if(preg_match('/(?i)msie [1-8]/',$simplecatch_ua)) {
//	 	wp_enqueue_style( 'iebelow8', get_template_directory_uri() . '/css/ie.css', true );
//	}

} // simplecatch_scripts_method
add_action( 'wp_enqueue_scripts', 'simplecatch_scripts_method' );


/**
 * Register Google Font Style
 *
 * @uses wp_register_style and wp_enqueue_style
 * @action wp_enqueue_scripts
 */
function simplecatch_load_google_fonts() {
    wp_register_style('google-fonts', 'http://fonts.googleapis.com/css?family=Lobster');
	wp_enqueue_style( 'google-fonts');
}
//	@todo kirill try make faster js
//add_action('wp_enqueue_scripts', 'simplecatch_load_google_fonts');


/**
 * Register script for admin section
 *
 * No scripts should be enqueued within this function.
 * jquery cookie used for remembering admin tabs, and potential future features... so let's register it early
 * @uses wp_register_script
 * @action admin_enqueue_scripts
 */
function simplecatch_register_js() {
	//jQuery Cookie
	wp_register_script( 'jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.min.js', array( 'jquery' ), '1.0', true );
}
add_action( 'admin_enqueue_scripts', 'simplecatch_register_js' );


/**
 * Enqueue Comment Reply Script
 *
 * We add some JavaScript to pages with the comment form
 * to support sites with threaded comments (when in use).
 * @used comment_form_before action hook
 */
function simplecatch_enqueue_comment_reply_script() {
	if ( comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
//	@todo kirill try make faster js
//add_action( 'comment_form_before', 'simplecatch_enqueue_comment_reply_script' );


/**
 * Modifying the Title
 *
 * function tied to the wp_title filter hook.
 * @uses filter wp_title
 */
function simplecatch_filter_wp_title( $title ) {
	global $page, $paged;

	// Get the Site Name
    $site_name = get_bloginfo( 'name' );


	// For Homepage
    if (  is_home() || is_front_page() ) {
		$filtered_title = $site_name;
        // Get the Site Description
        $site_description = get_bloginfo( 'description' );
		if ( !empty( $site_description ) )  {
        	// Append Site Description to title
        	$filtered_title .= ' &#124; '. $site_description;
		}
    }
	elseif( is_feed() ) {
		$filtered_title = '';
	}
	else {
		// Prepend name
		// @todo kirill title
//		 $filtered_title = $title .' &#124; '. $site_name;
		 $filtered_title = $title;
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$filtered_title .= ' &#124; ' . sprintf( __( 'Page %s', 'simplecatch' ), max( $paged, $page ) );
	}

	// Return the modified title
    return $filtered_title;

}
add_filter( 'wp_title', 'simplecatch_filter_wp_title' );


/**
 * Sets the post excerpt length to 30 words.
 *
 * function tied to the excerpt_length filter hook.
 * @uses filter excerpt_length
 */
function simplecatch_excerpt_length( $length ) {
	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;

	return $options[ 'excerpt_length' ];
}
add_filter( 'excerpt_length', 'simplecatch_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function simplecatch_continue_reading() {
	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;

	$more_tag_text = $options[ 'more_tag_text' ];
	return ' <a class="readmore" href="'. esc_url( get_permalink() ) . '">' . sprintf( __( '%s', 'simplecatch' ), esc_attr( $more_tag_text ) ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with simplecatch_continue_reading().
 *
 */
function simplecatch_excerpt_more( $more ) {
	return ' &hellip;' . simplecatch_continue_reading();
}
add_filter( 'excerpt_more', 'simplecatch_excerpt_more' );


/**
 * Adds Continue Reading link to post excerpts.
 *
 * function tied to the get_the_excerpt filter hook.
 */
function simplecatch_custom_excerpt( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= simplecatch_continue_reading();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'simplecatch_custom_excerpt' );


/**
 * Allows post queries to sort the results by the order specified in the post__in parameter.
 * Just set the orderby parameter to post__in
 *
 * uses action filter posts_orderby
 */
if ( !function_exists('simplecatch_sort_query_by_post_in') ) : //simple WordPress 3.0+ version, now across VIP

	add_filter('posts_orderby', 'simplecatch_sort_query_by_post_in', 10, 2);

	function simplecatch_sort_query_by_post_in($sortby, $thequery) {
		if ( isset($thequery->query['post__in']) && !empty($thequery->query['post__in']) && isset($thequery->query['orderby']) && $thequery->query['orderby'] == 'post__in' )
			$sortby = "find_in_set(ID, '" . implode( ',', $thequery->query['post__in'] ) . "')";
		return $sortby;
	}

endif;


/**
 * Get the header logo Image from theme options
 *
 * @uses header logo
 * @get the data value of image from theme options
 * @display Header Image logo
 *
 * @uses default logo if logo field on theme options is empty
 *
 * @uses set_transient and delete_transient
 */

function simplecatch_headerdetails() {
	//delete_transient( 'simplecatch_headerdetails' );

	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;

//	if ( ( !$simplecatch_headerdetails = get_transient( 'simplecatch_headerdetails' ) ) && ( empty( $options[ 'remove_header_logo' ] ) || empty( $options[ 'remove_site_title' ] ) || empty( $options[ 'remove_site_description' ] ) ) ) {

//		echo '<!-- refreshing cache -->';

		$simplecatch_headerdetails = '<div class="logo-wrap">';

		if( empty( $options[ 'remove_header_logo' ] ) || empty( $options[ 'remove_site_title' ] ) ) {
			$simplecatch_headerdetails .= '<h1 id="site-title">'.'<a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'">';

			if( empty( $options[ 'remove_header_logo' ] ) ) {
				if ( !empty( $options[ 'featured_logo_header' ] ) ):
					$simplecatch_headerdetails .= '<img src="'.esc_url( $options['featured_logo_header'] ).'" alt="'.get_bloginfo( 'name' ).'" />';
				else:
					// if empty featured_logo_header on theme options, display default logo
					$simplecatch_headerdetails .='<img src="'. get_template_directory_uri().'/images/logo.png" alt="logo" />';
				endif;
			}

			if ( empty( $options[ 'remove_site_title' ] ) ) {
				$simplecatch_headerdetails .= '<span>'.esc_attr( get_bloginfo( 'name', 'display' ) ).'</span>';
			}

			$simplecatch_headerdetails .= '</a></h1>';
		}

		if( empty( $options[ 'remove_site_description' ] ) ) {
			$simplecatch_headerdetails .= '<h2 id="site-description">'.esc_attr( get_bloginfo( 'description' ) ).'</h2>';
		}

		$simplecatch_headerdetails .= '</div><!-- .logo-wrap -->';

//	set_transient( 'simplecatch_headerdetails', $simplecatch_headerdetails, 86940 );
//	}
	echo $simplecatch_headerdetails;
} // simplecatch_headerdetails


/**
 * Get the footer logo Image from theme options
 *
 * @uses footer logo
 * @get the data value of image from theme options
 * @display footer Image logo
 *
 * @uses default logo if logo field on theme options is empty
 *
 * @uses set_transient and delete_transient
 */
function simplecatch_footerlogo() {
	//delete_transient('simplecatch_footerlogo');

	if ( !$simplecatch_footerlogo = get_transient( 'simplecatch_footerlogo' ) ) {
		global $simplecatch_options_settings;
        $options = $simplecatch_options_settings;

		echo '<!-- refreshing cache -->';
		if ( $options[ 'remove_footer_logo' ] == "0" ) :

			// if not empty featured_logo_footer on theme options
			if ( !empty( $options[ 'featured_logo_footer' ] ) ) :
				$simplecatch_footerlogo =
					'<img src="'.esc_url( $options[ 'featured_logo_footer' ] ).'" alt="'.get_bloginfo( 'name' ).'" />';
			else:
				// if empty featured_logo_footer on theme options, display default fav icon
				$simplecatch_footerlogo ='
					<img src="'. get_template_directory_uri().'/images/logo-foot.png" alt="footerlogo" />';
			endif;
		endif;


	set_transient( 'simplecatch_footerlogo', $simplecatch_footerlogo, 86940 );
	}
	echo $simplecatch_footerlogo;
} // simplecatch_footerlogo


/**
 * Get the favicon Image from theme options
 *
 * @uses favicon
 * @get the data value of image from theme options
 * @display favicon
 *
 * @uses default favicon if favicon field on theme options is empty
 *
 * @uses set_transient and delete_transient
 */
function simplecatch_favicon() {
	//delete_transient( 'simplecatch_favicon' );

	if( ( !$simplecatch_favicon = get_transient( 'simplecatch_favicon' ) ) ) {
		global $simplecatch_options_settings;
        $options = $simplecatch_options_settings;

		echo '<!-- refreshing cache -->';
		if ( $options[ 'remove_favicon' ] == "0" ) :
			// if not empty fav_icon on theme options
			if ( !empty( $options[ 'fav_icon' ] ) ) :
				$simplecatch_favicon = '<link rel="shortcut icon" href="'.esc_url( $options[ 'fav_icon' ] ).'" type="image/x-icon" />';
			else:
				// if empty fav_icon on theme options, display default fav icon
				$simplecatch_favicon = '<link rel="shortcut icon" href="'. get_template_directory_uri() .'/images/favicon.ico" type="image/x-icon" />';
			endif;
		endif;

	set_transient( 'simplecatch_favicon', $simplecatch_favicon, 86940 );
	}
	echo $simplecatch_favicon ;
} // simplecatch_favicon

//Load Favicon in Header Section
add_action('wp_head', 'simplecatch_favicon');

//Load Favicon in Admin Section
add_action( 'admin_head', 'simplecatch_favicon' );


/**
 * This function to display featured posts on homepage header
 *
 * @get the data value from theme options
 * @displays on the homepage header
 *
 * @useage Featured Image, Title and Content of Post
 *
 * @uses set_transient and delete_transient
 */

function simplecatch_sliders() {
	global $post;
	//delete_transient( 'simplecatch_sliders' );

	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;

	$postperpage = $options[ 'slider_qty' ];

	if( ( !$simplecatch_sliders = get_transient( 'simplecatch_sliders' ) ) && !empty( $options[ 'featured_slider' ] ) ) {
		echo '<!-- refreshing cache -->';

		$simplecatch_sliders = '
		<div class="featured-slider">';
			$get_featured_posts = new WP_Query( array(
				'posts_per_page' => $postperpage,
				'post__in'		 => $options[ 'featured_slider' ],
				'orderby' 		 => 'post__in',
				'ignore_sticky_posts' => 1 // ignore sticky posts
			));
			$i; while ( $get_featured_posts->have_posts()) : $get_featured_posts->the_post(); $i++;
				$title_attribute = apply_filters( 'the_title', get_the_title( $post->ID ) );
				$excerpt = get_the_excerpt();
				if ( $i == 1 ) { $classes = "slides displayblock"; } else { $classes = "slides displaynone"; }
				$simplecatch_sliders .= '
				<div class="'.$classes.'">
					<div class="featured">
						<div class="slide-image">';
							if( has_post_thumbnail() ) {

								$simplecatch_sliders .= '<a href="' . get_permalink() . '" title="Permalink to '.the_title('','',false).'">';

								if( !isset( $options[ 'remove_noise_effect'] ) ) {
									$options[ 'remove_noise_effect' ] = "0";
								}
								if( $options[ 'remove_noise_effect' ] == "0" ) {
									$simplecatch_sliders .= '<span class="img-effect pngfix"></span>';
								}

								$simplecatch_sliders .= get_the_post_thumbnail( $post->ID, 'slider', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class'	=> 'pngfix' ) ).'</a>';
							}
							else {
								$simplecatch_sliders .= '<span class="img-effect pngfix"></span>';
							}
							$simplecatch_sliders .= '
						</div> <!-- .slide-image -->
					</div> <!-- .featured -->
					<div class="featured-text">';
						if( $excerpt !='') {
							$simplecatch_sliders .= the_title( '<span>','</span>', false ).': '.$excerpt;
						}
						$simplecatch_sliders .= '
					</div><!-- .featured-text -->
				</div> <!-- .slides -->';
			endwhile; wp_reset_query();
		$simplecatch_sliders .= '
		</div> <!-- .featured-slider -->
			<div id="controllers">
			</div><!-- #controllers -->';

	set_transient( 'simplecatch_sliders', $simplecatch_sliders, 86940 );
	}
	echo $simplecatch_sliders;
} // simplecatch_sliders


/**
 * Display slider or breadcrumb on header
 *
 * If the page is home or front page, slider is displayed.
 * In other pages, breadcrumb will display if exist bread
 */
function simplecatch_sliderbreadcrumb() {

	// If the page is home or front page
	if ( is_home() || is_front_page() ) :
		// display featured slider
		if ( function_exists( 'simplecatch_sliders' ) ):
			simplecatch_sliders();
		endif;
	else :
		// if breadcrumb is not empty, display breadcrumb
		if ( function_exists( 'bcn_display_list' ) ):
			echo '<div class="breadcrumb">
					<ul>';
						bcn_display_list();
			 	echo '</ul>
					<div class="row-end"></div>
				</div> <!-- .breadcrumb -->';
		endif;

  	endif;
} // simplecatch_sliderbreadcrumb


/**
 * This function for social links display on header
 *
 * @fetch links through Theme Options
 * @use in widget
 * @social links, Facebook, Twitter and RSS
  */
function simplecatch_headersocialnetworks() {
	//delete_transient( 'simplecatch_headersocialnetworks' );

	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;

	if ( ( !$simplecatch_headersocialnetworks = get_transient( 'simplecatch_headersocialnetworks' ) ) &&  ( !empty( $options[ 'social_facebook' ] ) || !empty( $options[ 'social_twitter' ] ) || !empty( $options[ 'social_googleplus' ] ) || !empty( $options[ 'social_pinterest' ] ) || !empty( $options[ 'social_youtube' ] ) || !empty( $options[ 'social_linkedin' ] ) || !empty( $options[ 'social_slideshare' ] )  || !empty( $options[ 'social_foursquare' ] ) || !empty( $options[ 'social_rss' ] )   || !empty( $options[ 'social_vimeo' ] ) || !empty( $options[ 'social_flickr' ] ) || !empty( $options[ 'social_tumblr' ] ) || !empty( $options[ 'social_deviantart' ] ) || !empty( $options[ 'social_dribbble' ] ) || !empty( $options[ 'social_myspace' ] ) || !empty( $options[ 'social_wordpress' ] ) || !empty( $options[ 'social_delicious' ] ) || !empty( $options[ 'social_lastfm' ] ) ) )  {

		echo '<!-- refreshing cache -->';

		$simplecatch_headersocialnetworks .='
			<ul class="social-profile">';

				//facebook
				if ( !empty( $options[ 'social_facebook' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="facebook"><a href="'.esc_url( $options[ 'social_facebook' ] ).'" title="'.sprintf( esc_attr__( '%s in Facebook', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Facebook </a></li>';
				}

				//Twitter
				if ( !empty( $options[ 'social_twitter' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="twitter"><a href="'.esc_url( $options[ 'social_twitter' ] ).'" title="'.sprintf( esc_attr__( '%s in Twitter', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Twitter </a></li>';
				}

				//Google+
				if ( !empty( $options[ 'social_googleplus' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="google-plus"><a href="'.esc_url( $options[ 'social_googleplus' ] ).'" title="'.sprintf( esc_attr__( '%s in Google+', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Google+ </a></li>';
				}

				//Linkedin
				if ( !empty( $options[ 'social_linkedin' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="linkedin"><a href="'.esc_url( $options[ 'social_linkedin' ] ).'" title="'.sprintf( esc_attr__( '%s in Linkedin', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Linkedin </a></li>';
				}

				//Pinterest
				if ( !empty( $options[ 'social_pinterest' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="pinterest"><a href="'.esc_url( $options[ 'social_pinterest' ] ).'" title="'.sprintf( esc_attr__( '%s in Pinterest', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Twitter </a></li>';
				}

				//Youtube
				if ( !empty( $options[ 'social_youtube' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="you-tube"><a href="'.esc_url( $options[ 'social_youtube' ] ).'" title="'.sprintf( esc_attr__( '%s in YouTube', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' YouTube </a></li>';
				}

				//Vimeo
				if ( !empty( $options[ 'social_vimeo' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="viemo"><a href="'.esc_url( $options[ 'social_vimeo' ] ).'" title="'.sprintf( esc_attr__( '%s in Vimeo', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Vimeo </a></li>';
				}

				//Slideshare
				if ( !empty( $options[ 'social_slideshare' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="slideshare"><a href="'.esc_url( $options[ 'social_slideshare' ] ).'" title="'.sprintf( esc_attr__( '%s in Slideshare', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Slideshare </a></li>';
				}

				//Foursquare
				if ( !empty( $options[ 'social_foursquare' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="foursquare"><a href="'.esc_url( $options[ 'social_foursquare' ] ).'" title="'.sprintf( esc_attr__( '%s in Foursquare', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' foursquare </a></li>';
				}

				//Flickr
				if ( !empty( $options[ 'social_flickr' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="flickr"><a href="'.esc_url( $options[ 'social_flickr' ] ).'" title="'.sprintf( esc_attr__( '%s in Flickr', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Flickr </a></li>';
				}
				//Tumblr
				if ( !empty( $options[ 'social_tumblr' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="tumblr"><a href="'.esc_url( $options[ 'social_tumblr' ] ).'" title="'.sprintf( esc_attr__( '%s in Tumblr', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Tumblr </a></li>';
				}
				//deviantART
				if ( !empty( $options[ 'social_deviantart' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="deviantart"><a href="'.esc_url( $options[ 'social_deviantart' ] ).'" title="'.sprintf( esc_attr__( '%s in deviantART', 'simplecatch' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' deviantART </a></li>';
				}
				//Dribbble
				if ( !empty( $options[ 'social_dribbble' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="dribbble"><a href="'.esc_url( $options[ 'social_dribbble' ] ).'" title="'.sprintf( esc_attr__( '%s in Dribbble', 'simplecatch' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' Dribbble </a></li>';
				}
				//MySpace
				if ( !empty( $options[ 'social_myspace' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="myspace"><a href="'.esc_url( $options[ 'social_myspace' ] ).'" title="'.sprintf( esc_attr__( '%s in MySpace', 'simplecatch' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' MySpace </a></li>';
				}
				//WordPress
				if ( !empty( $options[ 'social_wordpress' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="wordpress"><a href="'.esc_url( $options[ 'social_wordpress' ] ).'" title="'.sprintf( esc_attr__( '%s in WordPress', 'simplecatch' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' WordPress </a></li>';
				}
				//RSS
				if ( !empty( $options[ 'social_rss' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="rss"><a href="'.esc_url( $options[ 'social_rss' ] ).'" title="'.sprintf( esc_attr__( '%s in RSS', 'simplecatch' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' RSS </a></li>';
				}
				//Delicious
				if ( !empty( $options[ 'social_delicious' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="delicious"><a href="'.esc_url( $options[ 'social_delicious' ] ).'" title="'.sprintf( esc_attr__( '%s in Delicious', 'simplecatch' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' Delicious </a></li>';
				}
				//Last.fm
				if ( !empty( $options[ 'social_lastfm' ] ) ) {
					$simplecatch_headersocialnetworks .=
						'<li class="lastfm"><a href="'.esc_url( $options[ 'social_lastfm' ] ).'" title="'.sprintf( esc_attr__( '%s in Last.fm', 'simplecatch' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' Last.fm </a></li>';
				}

				$simplecatch_headersocialnetworks .='
			</ul>
			<div class="row-end"></div>';

		set_transient( 'simplecatch_headersocialnetworks', $simplecatch_headersocialnetworks, 86940 );
	}
	echo $simplecatch_headersocialnetworks;
} // simplecatch_headersocialnetworks


/**
 * Site Verification  and Webmaster Tools
 *
 * If user sets the code we're going to display meta verification
 * @get the data value from theme options
 * @uses wp_head action to add the code in the header
 * @uses set_transient and delete_transient API for cache
 */

function simplecatch_site_verification() {
	//delete_transient( 'simplecatch_site_verification' );

	if ( ( !$simplecatch_site_verification = get_transient( 'simplecatch_site_verification' ) ) )  {

		global $simplecatch_options_settings;
        $options = $simplecatch_options_settings;
		echo '<!-- refreshing cache -->';

		$simplecatch_site_verification = '';
		//google
		if ( !empty( $options['google_verification'] ) ) {
			$simplecatch_site_verification .= '<meta name="google-site-verification" content="' .  $options['google_verification'] . '" />' . "\n";
		}

		//bing
		if ( !empty( $options['bing_verification'] ) ) {
			$simplecatch_site_verification .= '<meta name="msvalidate.01" content="' .  $options['bing_verification']  . '" />' . "\n";
		}

		//yahoo
		 if ( !empty( $options['yahoo_verification'] ) ) {
			$simplecatch_site_verification .= '<meta name="y_key" content="' .  $options['yahoo_verification']  . '" />' . "\n";
		}

		//site stats, analytics header code
		if ( !empty( $options['analytic_header'] ) ) {
			$simplecatch_site_verification .=  $options[ 'analytic_header' ] ;
		}
		set_transient( 'simplecatch_site_verification', $simplecatch_site_verification, 86940 );
	}
	echo $simplecatch_site_verification;
}
//@todo kirill try make faster simplecatch_site_verification
//add_action('wp_head', 'simplecatch_site_verification');


/**
 * This function loads the Footer Code such as Add this code from the Theme Option
 *
 * @get the data value from theme options
 * @load on the footer ONLY
 * @uses wp_footer action to add the code in the footer
 * @uses set_transient and delete_transient
 */
function simplecatch_footercode() {
	//delete_transient( 'simplecatch_footercode' );


	if ( ( !$simplecatch_footercode = get_transient( 'simplecatch_footercode' ) ) ) {

		global $simplecatch_options_settings;
        $options = $simplecatch_options_settings;
		echo '<!-- refreshing cache -->';

		//site stats, analytics header code
		if ( !empty( $options['analytic_footer'] ) ) {
			$simplecatch_footercode =  $options[ 'analytic_footer' ] ;
		}

	set_transient( 'simplecatch_footercode', $simplecatch_footercode, 86940 );
	}
	echo $simplecatch_footercode;
}
//@todo kirill try make faster simplecatch_footercode
//add_action('wp_footer', 'simplecatch_footercode');


/**
 * Hooks the Custom Inline CSS to head section
 *
 * @since Simple Catch 1.2.3
 */
function simplecatch_inline_css() {
	//delete_transient( 'simplecatch_inline_css' );

	if ( ( !$simplecatch_inline_css = get_transient( 'simplecatch_inline_css' ) ) ) {
		global $simplecatch_options_settings;
        $options = $simplecatch_options_settings;

		if( !isset( $options[ 'reset_color' ] ) ) {
			$options[ 'reset_color' ] = "2";
		}

		if( $options[ 'reset_color' ] == "0" ) {
			$simplecatch_inline_css	= '<!-- '.get_bloginfo('name').' Custom CSS Styles -->' . "\n";
	        $simplecatch_inline_css .= '<style type="text/css" media="screen">' . "\n";
			$simplecatch_inline_css .= "#main {
										   color: ".  $options[ 'text_color' ] .";
										}
										#main a {
										    color: ". $options[ 'link_color' ] .";
										}
										#main h1 a, #main h2 a, #main h3 a, #main h4 a, #main h5 a, #main h6 a {
										   color: ".  $options[ 'heading_color' ] .";
										}
										#main #content ul.post-by li, #main #content ul.post-by li a {
											color: ".  $options[ 'meta_color' ] .";
										}
										#sidebar h3, #sidebar h4, #sidebar h5 {
											color: ".  $options[ 'widget_heading_color' ] .";
										}
										#sidebar, #sidebar p, #sidebar a, #sidebar ul li a, #sidebar ol li a {
											color: ".  $options[ 'widget_text_color' ] .";
										}". "\n";
			$simplecatch_inline_css .= '</style>' . "\n";
		}


		echo '<!-- refreshing cache -->' . "\n";
		if( !empty( $options[ 'custom_css' ] ) ) {
			$simplecatch_inline_css	= '<!-- '.get_bloginfo('name').' Custom CSS Styles -->' . "\n";
	        $simplecatch_inline_css .= '<style type="text/css" media="screen">' . "\n";
			$simplecatch_inline_css .=  $options['custom_css'] . "\n";
			$simplecatch_inline_css .= '</style>' . "\n";
		}

	set_transient( 'simplecatch_inline_css', $simplecatch_inline_css, 86940 );
	}
	echo $simplecatch_inline_css;
}
//@todo kirill try make faster simplecatch_inline_css
//add_action('wp_head', 'simplecatch_inline_css');


/*
 * Function for showing custom tag cloud
 */
function simplecatch_custom_tag_cloud() {
?>
	<div class="custom-tagcloud"><?php wp_tag_cloud('smallest=12&largest=12px&unit=px'); ?></div>
<?php
}

/**
 * shows footer credits
 */
function simplecatch_footer() {
?>

<!--.col6 powered-by-->

<?php
}
add_filter( 'simplecatch_credits', 'simplecatch_footer' );


/**
 * Function to pass the slider value
 */
function simplecatch_pass_slider_value() {
	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;

	$transition_effect = $options[ 'transition_effect' ];
	$transition_delay = $options[ 'transition_delay' ] * 1000;
	$transition_duration = $options[ 'transition_duration' ] * 1000;
	wp_localize_script(
		'simplecatch_slider',
		'js_value',
		array(
			'transition_effect' => $transition_effect,
			'transition_delay' => $transition_delay,
			'transition_duration' => $transition_duration
		)
	);
}// simplecatch_pass_slider_value

/**
 * Alter the query for the main loop in home page
 * @uses pre_get_posts hook
 */
function simple_catch_alter_home( $query ){
	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;

    if ( $options[ 'exclude_slider_post'] != "0" && !empty( $options[ 'featured_slider' ] ) ) {
		if( $query->is_main_query() && $query->is_home() ) {
			$query->query_vars['post__not_in'] = $options[ 'featured_slider' ];
		}
	}
	if ( !empty( $options[ 'front_page_category' ] ) ) {
		if( $query->is_main_query() && $query->is_home() ) {
			$query->query_vars['category__in'] = $options[ 'front_page_category' ];
		}
	}
}
add_action( 'pre_get_posts','simple_catch_alter_home' );

/**
 * Add specific CSS class by filter
 * @uses body_class filter hook
 * @since Simple Catch 1.3.2
 */
function simplecatch_class_names($classes) {
	global $post;
	if( $post )
		$layout = get_post_meta( $post->ID,'simplecatch-sidebarlayout', true );
	if( empty( $layout ) || ( !is_page() && !is_single() ) )
		$layout='default';

	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;

	$themeoption_layout = $options['sidebar_layout'];

	if( ( $layout == 'no-sidebar' || ( $layout=='default' && $themeoption_layout == 'no-sidebar') ) ){
		$classes[] = 'no-sidebar';
	}
	return $classes;
}
add_filter('body_class','simplecatch_class_names');

/**
 * Display the page/post content
 * @since Simple Catch 1.3.2
 */
function simplecatch_content() {
	global $post;
	$layout = get_post_meta( $post->ID,'simplecatch-sidebarlayout', true );
	if( empty( $layout ) )
		$layout='default';

	get_header();














    if( $layout=='default') {
		global $simplecatch_options_settings;
        $options = $simplecatch_options_settings;

		$themeoption_layout = $options['sidebar_layout'];

		if( $themeoption_layout == 'left-sidebar' ) {
			get_template_part( 'content-sidebar','left' );
		}
		elseif( $themeoption_layout == 'right-sidebar' ) {
			get_template_part( 'content-sidebar','right' );
		}
		else {
			get_template_part( 'content-sidebar','no' );
		}
	}
	elseif( $layout=='left-sidebar' ) {
		get_template_part( 'content-sidebar','left' );
	}
	elseif( $layout=='right-sidebar' ) {
		get_template_part( 'content-sidebar','right' );
	}
	else{
		get_template_part( 'content-sidebar','no' );
	}

	get_footer();
 }

 /**
 * Display the page/post loop part
 * @since Simple Catch 1.3.2
 */
function simplecatch_loop() {
	global $post, $wp_object_cache;

	if( is_page() ): ?>
	<?php


		?>
		<div <?php post_class(); ?> >
			<?
			if(!is_single() && !is_page()) { ?>
				<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<? } else { ?>
				<div style="height: 20px;"></div>
       		<? }
			the_content();
			 wp_link_pages(array(
					'before'			=> '<div class="pagination">Pages: ',
					'after' 			=> '</div>',
					'link_before' 		=> '<span>',
					'link_after'       	=> '</span>',
					'pagelink' 			=> '%',
					'echo' 				=> 1
				) ); ?>
		</div><!-- .post -->

    <?php elseif( is_single() ): ?>

		<div <?php post_class(); ?>>
			<h2 class="entry-title post-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a></h2>
			<div class="clear" style="height: 1px; width: 1px; "></div>
            <?php
			$fullContent = get_the_content(null, false);
			$fullContent = apply_filters('the_content', $fullContent);
			$fullContent = str_replace(']]>', ']]&gt;', $fullContent);
			$contentBegin = strpos($fullContent, '<p style="" rel="begin-of-the-excerpt-text">');
			$content = substr($fullContent, $contentBegin);
			// deal with optimized images
			$matches = array();
			// $matches[1] - image path
			// $matches[2] - image width
			// $matches[3] - image height
			preg_match_all('/<a.+href="([^"]+)"[^<]+<img.+src="([^"]+)".+width="(\d+)".+height="(\d+)"[^>]+>/', $content, $matches);
			foreach($matches[1] as $key => $httpPath) {
				$httpPathParts = explode('wp-content/uploads/', $httpPath);
				if(isset($httpPathParts[1])) {
					$realpath = HTTP_IMAGES_UPLOAD_DIR . $httpPathParts[1];
					$pathInfo = Wd::pathinfo_utf($realpath);
					$newFile = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_' . Wd_Parts_Image::$_sizes[Wd_Parts_Image::SIZE_FRONT_CONTENT] .
						'__' . $matches[3][$key] . 'x' . $matches[4][$key] . '.' . $pathInfo['extension'];
//					$content = str_replace($matches[2][$key], $newFile, $content);


					$content = str_replace('src="' . $matches[2][$key] . '"', 'src="' . $newFile . '"', $content);
				}
			}
			?>
			<div class="clear" style="height: 1px; width: 1px; "></div>
			<?
			echo $content ?>
			<div class="clear" style="height: 1px; width: 1px; "></div>

			<?
			$tags = get_the_tags();
			if($tags !== false) {
				$tagsAmount = count($tags);
				$tags_output = '<div class="tags">
					<div class="label">Теги:</div>
					<ul>';
				$tagsCounter = 0;
				foreach($tags as $tag) {
					$tagsCounter++;
					$tags_output .= '<li><a href="' . HTTP_HOST . '/tags/' . $tag->slug . '">' . $tag->name . '</a>' . ( $tagsCounter < $tagsAmount ? ',' : '')  . '</li>';
				}
				$tags_output .= '</ul>
					<div class="clear" style="height: 1px; width: 1px; "></div>
				</div>';

				echo $tags_output;
				?>
			<? }

            // copy this <!--nextpage--> and paste at the post content where you want to break the page
			wp_link_pages(array(
					'before'			=> '<div class="pagination">Pages: ',
					'after' 			=> '</div>',
					'link_before' 		=> '<span>',
					'link_after'       	=> '</span>',
					'pagelink' 			=> '%',
					'echo' 				=> 1
				) );
			?>
			<?php do_action(
			'related_posts_by_category',
			array(
				'orderby' => 'post_date',
				'order' => 'DESC',
				'limit' => 5,
				'echo' => true,
				'before' => '<li>',
				'inside' => '&raquo; ',
				'outside' => '',
				'after' => '</li>',
				'rel' => 'nofollow',
				'type' => 'post',
				'image' => array(50, 50),
				'message' => 'No matches'
			)
		) ?>
			<script type="text/javascript">
				if($ == undefined) {
					var $ = jQuery;
				}
				(function($) {
					$(function() {
						wdPrettyPhoto();

						var blockquoteList = $('blockquote');
						if(blockquoteList.length > 0) {
							var leftImages = $('.alignleft');
							if(leftImages.length > 0) {
								blockquoteList.each(function() {
									var bq = $(this);
									var bqHeight = bq.height();
									var bqTop = bq.offset().top;
									leftImages.each(function() {
										var image = $(this);
										var imageTop = image.offset().top;
										var imageBottom = imageTop + image.height();

										if(bqTop > imageTop && bqTop < (imageBottom + bqHeight)) {
											// do the magic
											var imageWidth = image.width();
											bq.css({'margin-left':imageWidth + 30});
										}
									});
								});
							}

							// right

							var rightImages = $('.alignright');
							if(rightImages.length > 0) {
								blockquoteList.each(function() {
									var bq = $(this);
									var bqHeight = bq.height();
									var bqTop = bq.offset().top;
									rightImages.each(function() {
										var image = $(this);
										var imageTop = image.offset().top;
										var imageBottom = imageTop + image.height();

										if(bqTop > imageTop && bqTop < (imageBottom + bqHeight)) {
											// do the magic
											var imageWidth = image.width();
											bq.css({'margin-right':imageWidth + 30});
										}
									});
								});
							}
						}



					});
				})(jQuery);
			</script>
		</div> <!-- .post -->
	<?php endif;
}

/**
 * Display the header divx
 * @since Simple Catch 1.3.2
 */
function simplecatch_display_div() {
	// @todo kirill header
	?>
	<div id="main" class="layout-978">
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
		global $wpdb;
		$query = "SELECT * FROM wp_posts WHERE post_title IN ('Контакты') AND post_type IN ('page', 'post')";
		$terms = $wpdb->get_results($query);
		?>
        	</div><!-- .social-search -->
			  <div class="header-icons-container">
				  <a class="icons home-icon" href="<?= HTTP_HOST . '/'?>">&nbsp;</a>
				  <a class="icons contacts-icon" href="<?= HTTP_HOST . '/' . $terms[0]->post_name?>"></a>
				  <a class="icons sitemap-icon" href="<?= HTTP_HOST . '/sitemap'?>">&nbsp;</a>
			  </div>
    		<div class="row-end"></div>
            <div class="row-end"></div>

        <?php
//		@todo kirill try make faster header
		// This function passes the value of slider effect to js file

//	if( function_exists( 'simplecatch_pass_slider_value' ) ) {
//	simplecatch_pass_slider_value();
//	}
			// Display slider in home page and breadcrumb in other pages
//			if ( function_exists( 'simplecatch_sliderbreadcrumb' ) ) :
//				simplecatch_sliderbreadcrumb();
//			endif;
		?>
	</div><!-- .layout-978 -->
</div><!-- #header -->





	<?
	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;

	$themeoption_layout = $options['sidebar_layout'];

	if( $themeoption_layout == 'left-sidebar' ) {
		get_sidebar();
		echo '<div class="rubber-layout-keep-content"><div id="content" class="col8 rubber-layout-main">';
	}
	elseif( $themeoption_layout == 'right-sidebar' ) {
		echo '<div class="rubber-layout-keep-content"><div id="content" class="col8 no-margin-left rubber-layout-main">';
	}
	else {
		echo '<div class="rubber-layout-keep-content"><div id="content" class="col8 rubber-layout-main">';
	}
	return $themeoption_layout;
}

/**
 * Redirect WordPress Feeds To FeedBurner
 */
function simplecatch_rss_redirect() {
	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;

    if ($options['feed_url']) {
		$url = 'Location: '.$options['feed_url'];
		if ( is_feed() && !preg_match('/feedburner|feedvalidator/i', $_SERVER['HTTP_USER_AGENT']))
		{
			header($url);
			header('HTTP/1.1 302 Temporary Redirect');
		}
	}
}
add_action('template_redirect', 'simplecatch_rss_redirect');

/**
 * function that displays frquently asked question in theme option
 */
function simplecatch_faq() {
?>
		<h2><?php _e( 'FAQ: Frequently Asked Questions', 'simplecatch' ); ?></h2>
		<h3><?php _e( '1. How to change logo on Header and Footer? ', 'simplecatch' ); ?></h3>
		<ul>
			<li><?php  _e( 'Click on Theme Options under Appearance.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Design Settings Tab.', 'simplecatch' ); ?></li>
            <li><?php  _e( 'Click on Logo Options. You can see the default logo previews. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Now click on Change Header Logo and Change Footer Logo button to change the Header and Footer Logo respectively.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Browse the Logo image from desired location and upload it.', 'simplecatch' ); ?></li>
            <li><?php  _e( 'Once the upload in completed. Then click on insert into the Post.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Save button. Now you can see the previews. ', 'simplecatch' ); ?></li>
		</ul>

		<h3><?php  _e( '2. How to change Favicon? ', 'simplecatch' ); ?></h3>
		<ul>
			<li><?php  _e( 'Click on Theme Options under Appearance.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Design Settings Tab.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Fav Icon Options. You can see the default fav icon preview. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Now click on Change Fav Icon button. ', 'simplecatch' ); ?></li>
            <li><?php  _e( 'Browse the fav icon image from desired location and upload it.', 'simplecatch' ); ?></li>
            <li><?php  _e( 'Once the upload in completed. Then click on insert into the Post.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Save button. Now you can see the preview. ', 'simplecatch' ); ?></li>
		</ul>

		<h3><?php  _e( '3. How to change Content Background? ', 'simplecatch' ); ?></h3>
		<ul>
			<li><?php  _e( 'Click on Background under Appearance.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Now you can change the backgrond image and color', 'simplecatch' ); ?></li>
            <li><?php  _e( 'Read more about Custom Background', 'simplecatch' ); ?> <a href="<?php echo esc_url( __( 'http://en.support.wordpress.com/themes/custom-backgrounds/', 'simplecatch' ) ); ?>" target="_blank"><?php  _e( 'Click Here &rarr;', 'simplecatch' ); ?></a></li>
			<li><?php  _e( 'Click on Save button.', 'simplecatch' ); ?></li>
		</ul>

		<h3><?php  _e( '4. How to change Content Text Color? ', 'simplecatch' ); ?></h3>
		<ul>
			<li><?php  _e( 'Click on Theme Options under Appearance.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Design Settings Tab.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Content Color Options.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Slect the colors. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Save button.', 'simplecatch' ); ?></li>
		</ul>

		<h3><?php  _e( '5. Where to add Additional CSS Styles?', 'simplecatch' ); ?></h3>
		<ul>
			<li><?php  _e( 'If you are doing lot of customization then it is better to create child theme. But if you just want to change few CSS then follow the instruction.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Theme Options under Appearance.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Design Settings Tab.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Now click on Custom CSS. Then add in the custom CSS.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Save button. ', 'simplecatch' ); ?></li>
		</ul>

		<h3><?php  _e( '6. How to change default layout? ', 'simplecatch' ); ?></h3>
		<ul>
			<li><?php  _e( 'Click on Theme Options under Appearance.', 'simplecatch' ); ?></li>
            <li><?php  _e( 'Click on Design Settings Tab.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Default Layout.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Then check the layout you want to activate.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Save button.', 'simplecatch' ); ?></li>
		</ul>

		<h3><?php  _e( '7. How to set certain categories to display in Homepage / Frontpage ? ', 'simplecatch' ); ?></h3>
		<ul>
			<li><?php  _e( 'Click on Theme Options under Appearance.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Theme Settings Tab.', 'simplecatch' ); ?></li>
            <li><?php  _e( 'Click on Homepage / Frontpage category setting.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Then select the categories you want. You may select multiple categories by holding down the CTRL key.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Save button.', 'simplecatch' ); ?></li>
		</ul>

 		<h3><?php  _e( '8. How to change the Search Button text', 'simplecatch' ); ?></h3>
		<ul>
			<li><?php  _e( 'Click on Theme Options under Appearance.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Theme Settings Tab.', 'simplecatch' ); ?></li>
            <li><?php  _e( 'Click on Search Text Settings.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Then type in the text you want to change.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Save button.', 'simplecatch' ); ?></li>
		</ul>

 		<h3><?php  _e( '9. How to change the Excerpt Length and More Tag Text', 'simplecatch' ); ?></h3>
		<ul>
			<li><?php  _e( 'Click on Theme Options under Appearance.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Theme Settings Tab.', 'simplecatch' ); ?></li>
            <li><?php  _e( 'Click on Excerpt / More Tag Settings.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Type in the Number of Words and more tag text.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Save button.', 'simplecatch' ); ?></li>
		</ul>

		<h3><?php  _e( '10. How to Add Featured Slider? ', 'simplecatch' ); ?></h3>
		<ul>
			<li><?php  _e( 'Click on Featured Slider under Appearance. ', 'simplecatch' ); ?></li>
            <li><?php  _e( 'Click on Add Slider Options. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Add in the Post ID\'s  in Featured Slider Post#1, #2 respectively.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Save button. ', 'simplecatch' ); ?></li>
            <li><strong><?php  _e( 'Note:', 'simplecatch' ); ?></strong> <?php  _e( 'When you add the Post Id\'s, make sure you have added in the Featured Image in your Post. Read more about Featured Image', 'simplecatch' ); ?> <a href="<?php echo esc_url( __( 'http://en.support.wordpress.com/featured-images/#setting-a-featured-image', 'simplecatch' ) ); ?>" target="_blank"><?php _e( 'Click Here  &rarr;', 'simplecatch' ); ?></a></li>
            <li><strong><?php  _e( 'Note:', 'simplecatch' ); ?></strong> <?php  _e( 'If you are unable to find the post ID then you can install the Catch IDs Plugin to find the Post IDs', 'simplecatch' ); ?> <a href="<?php echo esc_url( __( 'http://wordpress.org/extend/plugins/catch-ids/', 'simplecatch' ) ); ?>" target="_blank"><?php _e( 'Click Here  &rarr;', 'simplecatch' ); ?></a></li>
		</ul>

		<h3><?php  _e( '11. How to insert Social links on the right side of header?', 'simplecatch' ); ?></h3>
		<ul>
			<li><?php  _e( 'Click on Social Links under Appearance.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Here you can see different social links like facebook, twitter etc. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Paste the social links URL on its respective fields. For example https://www.facebook.com/catchthemes. for facebook etc. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Save button. ', 'simplecatch' ); ?></li>
		</ul>

		<h3><?php  _e( '12. How to insert Site Verification IDs?', 'simplecatch' ); ?></h3>
		<ul>
			<li><?php  _e( 'Click on Webmaster Tools under Appearance. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Site Verification. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Enter the Google, Yahoo, Bling Site Verification ID respectivly for which you want to verify your site.', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Save button. ', 'simplecatch' ); ?></li>
		</ul>

		<h3><?php  _e( '13. How to insert Analytics / Other scripts?', 'simplecatch' ); ?></h3>
		<ul>
			<li><?php  _e( 'Click on Webmaster Tools under Appearance. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Analytic. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Here you can put different scripts like, google, facebook etc. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Enter the script on upper textarea which you want to load on header. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Enter the script on lower textarea which you want to load on footer. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Click on Save button. ', 'simplecatch' ); ?></li>
		</ul>

		<h3><?php  _e( '14. How to create pagination in single post/page if the post/page is too long? ', 'simplecatch' ); ?></h3>
		<ul>
			<li><?php  _e( 'Click on the post/page. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Edit the specific post/page in which you want to breakdown into more pages. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Now Keep the cursor to the exact place of post where you want page break. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Then copy this shortcode <!--nextpage--> and paste it. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'You can repeat this shortcode many times where you want to break down. ', 'simplecatch' ); ?></li>
			<li><?php  _e( 'Update the post. ', 'simplecatch' ); ?></li>
		</ul>

		<h3><?php  _e( '15. How to support developement of Simple Catch Theme? ', 'simplecatch' ); ?></h3>
		<ul>
			<li><?php _e( 'Support Simple Catch Theme by Donation', 'simplecatch' ); ?> <a href="<?php echo esc_url( __( 'http://catchthemes.com/donate/', 'simplecatch' ) ); ?>" target="_blank"><?php _e( 'Click Here  &rarr;', 'simplecatch' ); ?></a></li>
			<li><?php _e( 'Rate Simple Catch Theme 5 star on WordPress.org', 'simplecatch' ); ?> <a href="<?php echo esc_url( __( 'http://wordpress.org/extend/themes/simple-catch/', 'simplecatch' ) ); ?>" target="_blank"><?php _e( 'Click Here  &rarr;', 'simplecatch' ); ?></a></li>
			<li><?php _e( 'Like Us on Facebook', 'simplecatch' ); ?> <a href="<?php echo esc_url( __( 'https://www.facebook.com/catchthemes', 'simplecatch' ) ); ?>" target="_blank"><?php _e( 'Click Here  &rarr;', 'simplecatch' ); ?></a></li>
			<li><?php _e( 'Follow Us on Twitter', 'simplecatch' ); ?> <a href="<?php echo esc_url( __( 'https://twitter.com/catchthemes', 'simplecatch' ) ); ?>" target="_blank"><?php _e( 'Click Here  &rarr;', 'simplecatch' ); ?></a></li>
		</ul>

<?php
}

/**
 * function that displays frquently asked question in theme option
 */
function simplecatch_themesupport() {
?>
		<h2><?php _e( 'Support Simple Catch Theme ', 'simplecatch' ); ?></h2>
		<ul>
        	<li><?php _e( 'Support Simple Catch Theme by Donation', 'simplecatch' ); ?> <a href="<?php echo esc_url( __( 'http://catchthemes.com/donate/', 'simplecatch' ) ); ?>" target="_blank"><?php _e( 'Click Here  &rarr;', 'simplecatch' ); ?></a></li>
			<li><?php _e( 'Rate Simple Catch Theme 5 star on WordPress.org', 'simplecatch' ); ?> <a href="<?php echo esc_url( __( 'http://wordpress.org/extend/themes/simple-catch/', 'simplecatch' ) ); ?>" target="_blank"><?php _e( 'Click Here  &rarr;', 'simplecatch' ); ?></a></li>
			<li><?php _e( 'Like Us on Facebook', 'simplecatch' ); ?> <a href="<?php echo esc_url( __( 'https://www.facebook.com/catchthemes', 'simplecatch' ) ); ?>" target="_blank"><?php _e( 'Click Here  &rarr;', 'simplecatch' ); ?></a></li>
			<li><?php _e( 'Follow Us on Twitter', 'simplecatch' ); ?> <a href="<?php echo esc_url( __( 'https://twitter.com/catchthemes', 'simplecatch' ) ); ?>" target="_blank"><?php _e( 'Click Here  &rarr;', 'simplecatch' ); ?></a></li>
    	</ul>

<?php
}

?>