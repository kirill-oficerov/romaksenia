<?php
/**
 * This is the template that displays page/post with right sidebar
 *
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.3.2
 */
global $wp_object_cache;
get_header();
?>
		<div class="main">

			<div class="header">
				<div class="top">
					<div class="logo">
						<a href="http://<?=$_SERVER['HTTP_HOST']?>"><img src="/wp-content/themes/simple-catch/images/logo.png" /></a>
					</div>
					<div class="header_info">
						<div class="about">
							<a href="<?=HTTP_HOST?>/about">О проекте</a>
						</div>
						<div class="contacts">
							<a href="<?=HTTP_HOST?>/contacts">Контактная информация</a>
						</div>
					</div>
				</div>
				<div class="clear">&nbsp;</div>
				<div class="grey_line">
					<div class="menu">
						<ul>
							<li class="icons articles"><a href="http://<?=$_SERVER['HTTP_HOST']?>/articles/"><span>Статьи</span></a></li>
							<li class="icons cases"><a href="http://<?=$_SERVER['HTTP_HOST']?>/cases/"><span>Кейсы</span></a></li>
							<li class="icons events"><a href="http://<?=$_SERVER['HTTP_HOST']?>/events/"><span>События</span></a></li>
						</ul>

					</div>
					<div class="menu_right">
						<div class="send_news">
							<a href="javascript:void(0);" class="make_popup">Прислать новость</a>
						</div>
						<div class="search">
							<form method="get" class="search_form" action="<?=HTTP_HOST?>">
								<div class="background">
									<input type="text" name="s" value="Искать тут">
								</div>
								<input type="submit">
								<div class="submit_search">
									<div class="icons button"></div>
								</div>
							</form>
						</div>
					</div>

				</div>
			</div>
			<div class="clear">&nbsp;</div>

				<? while ( have_posts() )  {
					the_post();
					if( function_exists( 'simplecatch_loop') ) {
						simplecatch_loop();
					}
				} ?>
