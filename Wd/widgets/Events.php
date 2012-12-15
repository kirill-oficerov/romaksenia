<?php
class Wd_Widgets_Events extends WP_Widget {
	function Wd_Widgets_Events() {
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
						<?
						$wordsAmount = Wd::get('settings')->getValue(Settings::MAX_EVENT_LENGTH_WORDS);
						$words_array = preg_split( "/[\n\r\t ]+/", $post->post_content, $wordsAmount, PREG_SPLIT_NO_EMPTY );
						$textRest = array_pop( $words_array );
						$dotPos = strpos($textRest, '.');
						$sentenceRest = $textRest;
						if($dotPos) {
							$sentenceRest = substr($textRest, 0, $dotPos);
						}
						$text = implode( ' ', $words_array );
						$more = '<a class="readmore" href="http://wedigital.dev/' . $post->post_name . '/">Далее</a>';
						$text = $text . $sentenceRest . '...<br />' . $more;
						echo $text;
						?>
					</div>
				</div>
			<? }

			?>
	</div>
	</div>
		<?
	}
}