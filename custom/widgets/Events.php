<?php
class Widget_Events extends WP_Widget {
	function Widget_Events() {
		parent::WP_Widget(false, 'Events');
	}
	function form($instance) {
		// outputs the options form on admin
		echo "<pre>".print_r('outputs the options form on admin', true)."</pre>\n\n";
	}
	function update($new_instance, $old_instance) {
		// processes widget options to be saved
		return $new_instance;
	}
	function widget($args, $instance) {
		// outputs the content of the widget
		global $wp_object_cache;
		$cache = $wp_object_cache->cache;
		// find categoryId
		$eventCategoryId = 0;
		foreach($cache['category'] as $categoryId => $category) {
			if($category->name == 'Ивенты') {
				$eventCategoryId = $categoryId;
				break;
			}
		}
		if(!$eventCategoryId) {
			return;
		}
		$eventsPosts = array();
		foreach($cache['category_relationships'] as $postId => $categories) {
			if(array_key_exists($eventCategoryId, $categories)) {
				array_push($eventsPosts, $cache['posts'][$postId]);
			}
		}
		if(empty($eventsPosts)) {
			return;
		}
		?>

	<div class="widget"><h3>Ивенты</h3><hr>
		<div>
			<?
			foreach($eventsPosts as $postId => $post) { ?>
				<div class="page_item page-item-<?=$postId?>"><a href="http://wedigital.dev/<?=$post->post_name ?>/" class="event-title"><?=$post->post_title?></a>
					<div class="event-content">
						<?=mb_substr($post->post_content, 0, 200, 'UTF-8')?>
					</div>
				</div>
			<? }

			?>
<!--		<li class="page_item page-item-6"><a href="http://wedigital.dev/about/">About</a></li>-->
<!--		<li class="page_item page-item-14"><a href="http://wedigital.dev/%d0%b2%d0%b0%d0%ba%d0%b0%d0%bd%d1%81%d0%b8%d0%b8/">Вакансии</a></li>-->
<!--		<li class="page_item page-item-31"><a href="http://wedigital.dev/%d0%b8%d0%b2%d0%b5%d0%bd%d1%82%d1%8b/">Ивенты</a>-->
<!--			<ul class="children">-->
<!--				<li class="page_item page-item-46"><a href="http://wedigital.dev/%d0%b8%d0%b2%d0%b5%d0%bd%d1%82%d1%8b/%d0%b8%d0%b2%d0%b5%d0%bd%d1%82-1/">Ивент 1</a></li>-->
<!--			</ul>-->
<!--		</li>-->
	</div>
	</div>
<!--	<li class="page_item page-item-6"><a href="http://wedigital.dev/about/">About</a></li>-->
<!--	<li class="page_item page-item-14"><a href="http://wedigital.dev/%d0%b2%d0%b0%d0%ba%d0%b0%d0%bd%d1%81%d0%b8%d0%b8/">Вакансии</a></li>-->
<!--	<li class="page_item page-item-31"><a href="http://wedigital.dev/%d0%b8%d0%b2%d0%b5%d0%bd%d1%82%d1%8b/">Ивенты</a>-->
<!--		<ul class="children">-->
<!--			<li class="page_item page-item-46"><a href="http://wedigital.dev/%d0%b8%d0%b2%d0%b5%d0%bd%d1%82%d1%8b/%d0%b8%d0%b2%d0%b5%d0%bd%d1%82-1/">Ивент 1</a></li>-->
<!--		</ul>-->
<!--	</li>-->
		<?
	}
}