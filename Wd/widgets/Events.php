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
//		$cache = $wp_object_cache->cache;
		global $wpdb;

		$query = "SELECT * FROM wp_terms
INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id = wp_terms.term_id
INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
INNER JOIN wp_posts ON wp_posts.ID = wp_term_relationships.object_id
WHERE wp_terms.name = 'Ивенты' AND wp_posts.post_status = 'publish'";

		$terms = $wpdb->get_results($query);


//		if(!count($terms)) {
//			echo 'id of Ивенты not found';
//			return;
//		}
		?>

	<div class="widget"><h3>Ивенты</h3><hr>
		<div>
			<?
			foreach($terms as $key => $post) { ?>
				<div class="page_item page-item-<?=$post->term_id?>"><a href="<?=HTTP_HOST?>/events/<?=$post->post_name ?>/" class="event-title"><?=$post->post_title?></a>
					<div class="event-content">
						<?
						$wordsAmount = Wd::get('settings')->getValue(Settings::MAX_EVENT_LENGTH_WORDS);
						$postContent = $post->post_content;
						$matches = 0;
						if ( preg_match('/<!--more(.*?)?-->/', $postContent, $matches) ) {
							// exist
							list($text, $extended) = explode($matches[0], $postContent, 2);
							$text = strip_tags($text) . '<br /><a class="readmore" href="' . HTTP_HOST . '/events/' . $post->post_name . '/#more-' . $post->ID . '">Далее</a>';
						} else {
							$postContent = strip_tags($post->post_content);
							$words_array = preg_split( "/[\n\r\t ]+/", $postContent, $wordsAmount, PREG_SPLIT_NO_EMPTY );
							$textRest = array_pop( $words_array );
							$dotPos = strpos($textRest, '.');
							$sentenceRest = $textRest;
							if($dotPos) {
								$sentenceRest = substr($textRest, 0, $dotPos);
							}
							$text = implode( ' ', $words_array );
							$more = '.<br />' . '<a class="readmore" href="' . HTTP_HOST . '/events/' . $post->post_name . '/">Далее</a>';
							$text = $text . $sentenceRest . $more;
						}

						echo $text;
						?>
					</div>
				</div>
			<? }

			?>
	</div>
	</div>
	<script type="text/javascript">
		(function($) {
			$(function() {
//				var contentHeight = $('.rubber-layout-keep-content');
				var sidebarHeight = $('#sidebar').height();
//				if(contentHeight < sidebarHeight) {
					$('.rubber-layout-keep-content').css({'min-height':sidebarHeight + 'px'});

//				}
			});
		})(jQuery);
	</script>
		<?
	}
}