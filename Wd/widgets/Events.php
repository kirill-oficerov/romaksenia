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
		global $wpdb;

		$query = "SELECT * FROM wp_terms
LEFT JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id = wp_terms.term_id
LEFT JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
LEFT JOIN wp_posts ON wp_posts.ID = wp_term_relationships.object_id
WHERE wp_terms.name = 'Ивенты'";

		$terms = $wpdb->get_results($query);


//		foreach($terms as $key => $category) {
//			if($category->name == 'Ивенты') {
//				$eventCategoryId = $category->term_id;
//				break;
//			}
//		}
		if(!count($terms)) {
			echo 'id of Ивенты not found';
			return;
		}
//		$eventsPosts = array();
//		foreach($cache['category_relationships'] as $postId => $categories) {
//			if(array_key_exists($eventCategoryId, $categories)) {
//				array_push($eventsPosts, $cache['posts'][$postId]);
//			}
//		}
//		if(empty($eventsPosts)) {
//			return;
//		}
		?>

	<div class="widget"><h3>Ивенты</h3><hr>
		<div>
			<?
			foreach($terms as $key => $post) { ?>
				<div class="page_item page-item-<?=$post->term_id?>"><a href="http://wedigital.dev/<?=$post->post_name ?>/" class="event-title"><?=$post->post_title?></a>
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