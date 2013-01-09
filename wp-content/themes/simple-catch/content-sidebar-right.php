<?php
/**
 * This is the template that displays page/post with right sidebar
 *
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.3.2
 */
?>
<? get_header(); ?>
		<div id="main" class="layout-978">
        <? // @todo kirill header 2 ?>
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
						$query = "SELECT * FROM wp_posts WHERE post_title IN ('Контакты') AND post_type IN ('page', 'post')";
						$terms = $wpdb->get_results($query);
						?>
					</div><!-- .social-search -->
					<div class="header-icons-container">
						<a class="icons home-icon" href="<?= HTTP_HOST . '/'?>">&nbsp;</a>
						<a class="icons contacts-icon" href="<?= HTTP_HOST . '/' . $terms[0]->post_name?>">&nbsp;</a>
						<a class="icons sitemap-icon" href="<?= HTTP_HOST . '/sitemap'?>">&nbsp;</a>
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













        	<div id="content" class="col8 wd-full-post" style=" ">

				<?php while ( have_posts() ):the_post();
					if( function_exists( 'simplecatch_loop') ) simplecatch_loop(); 
				?>
					<div class="row-end"></div>
					
					<?php comments_template(); ?>
				
				<?php endwhile; ?>
                
        	</div><!-- #content -->
            
      	 	<?php
//			@todo kirill sidebar ( !is_single() && !is_page() )
			if(!is_single() && !is_page()) {
				get_sidebar();
			}
			?>
            
		</div><!-- #main --> 