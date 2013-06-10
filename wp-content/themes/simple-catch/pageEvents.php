<?php /* Template Name: Events */
/**
 * The main template file.
 *
 * This is the most generic template file in a Simple Catch theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.0
 */



get_header();

// @todo kirill header
?>
	<div class="main">
		<div class="header">
			<div class="top">
				<div class="logo">
					<a href="http://<?=$_SERVER['HTTP_HOST']?>"><img src="/wp-content/themes/simple-catch/images/logo.png" /></a>
				</div>
				<div class="header_info">
					<div class="about">
						<a href="#">О проекте</a>
					</div>
					<div class="contacts">
						<a href="#">Контактная информация</a>
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
						<a href="#" class="make_popup">Прислать новость</a>
					</div>
					<div class="search">
						<div class="background">
							<input type="text" value="Искать тут">
						</div>
						<div class="icons button">

						</div>
					</div>
				</div>

			</div>
		</div>

		<div class="cases">
			<div class="header">
				<div class="label">
					<a href="http://<?=$_SERVER['HTTP_HOST']?>/events/">События</a>
				</div>
				<div class="hr events"></div>
			</div>
			<div class="clear">&nbsp;</div>


			<?




$query = array('category_name' => 'events');
$paged = get_query_var('paged');
if($paged) {
	$query['paged'] = $paged;
}
query_posts($query);

get_template_part('eventsContent'); ?>
</div> <!-- events -->
<div class="clear">&nbsp;</div>
<script type="text/javascript">
	if($ == undefined) {
		var $ = jQuery;
	}
	(function($) {
		$(function() {
			wdPrettyPhoto();
		});
	})(jQuery);
</script>
<?php get_footer(); ?>
</div>



</div><!-- #main -->