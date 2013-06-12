<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.0
 */
get_header(); ?>
		<div class="main">
            	<div class="error404">
		            <div class="content" style="">
			            404<br>
			            <div>Такой страницы нет, но есть другие :-)</div>
			            <div class="clear">&nbsp;</div>

			            <?
			            $map = array();
			            $query = "SELECT * FROM wp_terms WHERE wp_terms.name IN ('Ивенты', 'Кейсы')";
			            $terms = $wpdb->get_results($query);
			            foreach($terms as $value) {
				            $map[$value->name] = $value->slug;
			            }
			            $query = "SELECT * FROM wp_posts WHERE post_title IN ('Статьи', 'О Нас', 'Контакты') AND post_type IN ('page', 'post')";
			            $terms = $wpdb->get_results($query);
			            foreach($terms as $value) {
			                $map[$value->post_title] = $value->post_name;
			            }
						?>
			            <div class="links">
				            <div>
					            <a href="<?=HTTP_HOST?>">Главная</a>
				            </div>
				            <div>
					            <a href="<?=HTTP_HOST?>/<?=$map['Статьи']?>" >Статьи</a>
				            </div>
				            <div>
					            <a href="<?=HTTP_HOST?>/<?=$map['Кейсы']?>" >Кейсы</a>
				            </div>
				            <div>
					            <a href="<?=HTTP_HOST?>/<?=$map['Ивенты']?>" >События</a>
				            </div>
				            <div>
					            <a href="<?=HTTP_HOST?>/<?=$map['О нас']?>" >О нас</a>
				            </div>
				            <div>
					            <a href="<?=HTTP_HOST?>/<?=$map['Контакты']?>" >Контакты</a>
				            </div>
				            <div class="clear">&nbsp;</div>

			            </div>
		            </div>
	            </div>
	<div class="clear">&nbsp;</div>
</div>
<?php get_footer(); ?>