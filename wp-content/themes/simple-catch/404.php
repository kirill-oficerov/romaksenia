<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.0
 */
get_header(); ?>
		<div id="main" class="layout-978">
        	<div id="content" class="col8">
            	<div class="post error404" style="min-height: 100%">
		            <div style="font-size: 70px; position: absolute; top: 50%; left: 50%;height: 200px; width: 500px; text-align: center; margin-left: -250px; margin-top: -100px;  ">
			            404<br>
			            <div>Такой страницы нет, но есть другие :-)</div>
			            <div class="clear"></div>

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
			            <div style="margin: 10px 0px 0px 81px; ">
				            <div>
					            <div style="float: left; margin: 0px 3px;">
						            <a href="<?=HTTP_HOST?>" style="text-decoration: underline;">Главная</a>
					            </div>
				            </div>
				            <div>
					            <div style="float: left; margin: 0px 3px;">
						            <a href="<?=HTTP_HOST?>/<?=$map['Статьи']?>"  style="text-decoration: underline;">Статьи</a>
					            </div>
				            </div>
				            <div>
					            <div style="float: left; margin: 0px 3px;">
						            <a href="<?=HTTP_HOST?>/<?=$map['Кейсы']?>"  style="text-decoration: underline;">Кейсы</a>
					            </div>
				            </div>
				            <div>
					            <div style="float: left; margin: 0px 3px;">
						            <a href="<?=HTTP_HOST?>/<?=$map['Ивенты']?>"  style="text-decoration: underline;">Ивенты</a>
					            </div>
				            </div>
				            <div>
					            <div style="float: left; margin: 0px 3px;">
						            <a href="<?=HTTP_HOST?>/<?=$map['about']?>"  style="text-decoration: underline;">О нас</a>
					            </div>
				            </div>
				            <div>
					            <div style="float: left; margin: 0px 3px;">
						            <a href="<?=HTTP_HOST?>/<?=$map['Контакты']?>"  style="text-decoration: underline;">Контакты</a>
					            </div>
				            </div>
				            <div class="clear"></div>

			            </div>
			            <div class="clear"></div>
		            </div>
              	</div>
       		</div><!-- #content-->
        </div><!--#main-->
<?php get_footer(); ?>