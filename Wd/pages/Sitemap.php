<?php
class Wd_Pages_Sitemap {

//	const MAX_POSTS_SHOW_PER_CATEGORY = 2;
/**
 * @var full info about categories
 */
	protected static $_categoryList;
	public static function mergePagesPosts($all_options) {
		extract($all_options);
		$pages = '<ul>';
		$pages .= self::listPages(array('sort_column' => $page_sort_column, 'sort_order' => $page_sort_order, 'exclude' => $page_exclude, 'depth' => $page_depth, 'show_date' => $page_show_date, 'title_li' => '', 'echo' => '0'), $all_options);
		$pages .= '</ul></div>';
		return $pages;
	}

	function listPages($args = '', $all_options) {
		extract($all_options);
 
		$defaults = array(
			'depth' => 0, 'show_date' => '',
			'date_format' => get_option('date_format'),
			'child_of' => 0, 'exclude' => '',
			'title_li' => __('Pages'), 'echo' => 1,
			'authors' => '', 'sort_column' => 'menu_order, post_title',
			'link_before' => '', 'link_after' => '', 'walker' => '',
		);
		$r = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );
		$current_page = 0;
		// sanitize, mostly to keep spaces out
		$r['exclude'] = preg_replace('/[^0-9,]/', '', $r['exclude']);
		// Allow plugins to filter an array of excluded pages (but don't put a nullstring into the array)
		$exclude_array = ( $r['exclude'] ) ? explode(',', $r['exclude']) : array();
		$r['exclude'] = implode( ',', apply_filters('wp_list_pages_excludes', $exclude_array) );
		// Query pages.
		$r['hierarchical'] = 0;
		$pages = get_pages($r);

		self::$_categoryList = get_categories(array('type' => 'post', 'orderby' => $category_orderby, 'order' => $category_order, 'hide_empty' => $category_hide_empty, 'exclude' => $category_exclude, 'hierarchical' => '1', 'number' => $category_number, 'taxonomy' => 'category'));

		$output = '<ul>';
		foreach($pages as $page) {
			if(($category = self::pageIsCategory($page)) !== false) {
				$output .= '<li><a href="' . get_category_link($category->term_id) . '" title="' . $category->category_description . '">' . $category->name . '</a><ul>';
				// Set options for post query
				$theposts = get_posts(array(
					'numberposts'	=> $post_numberposts,
					'category'	=> $category->cat_ID,
					'orderby'	=> $post_orderby,
					'order'		=> $post_order,
					'exclude'	=> $post_exclude,
					'post_type'	=> 'post',
				));
				if (count($theposts) > 0) {
					wp_reset_postdata();
					foreach($theposts as $post) {
						setup_postdata($post);
						$extra = '';
						if ($post_show_date == 'Yes')
							$extra = ' <span>' . get_the_date() . '</span>';

						$output .= '<li><a href="' . get_permalink($post) . '" rel="bookmark">' . get_the_title($post) . '</a>' . $extra . '</li>';
					}
					wp_reset_postdata();
				}
				$output .= '</ul></li>';
			} else {
				$output .= '<li><a href="' . HTTP_HOST . '/' . $page->post_name . '">' . $page->post_title . '</a></li>';
			}
		}
		$output .= '</ul>';
		$output = apply_filters('wp_list_pages', $output, $r);
		return $output;
	}

	public static function pageIsCategory($page) {
		foreach(self::$_categoryList as $category) {
			if($page->post_title == $category->name) {
				return $category;
			}
		}
		return false;
	}




























	protected static function getCategoryDescription($category) {
		return '
		<div class="article-category categoty-description">' . $category->description . '</div>
		';
	}

	protected function getPostCategoryRelations() {
		global $wpdb;
		$request = "SELECT wp_posts.*, wp_terms.term_id, wp_terms.name
			FROM wp_posts
			LEFT JOIN wp_term_relationships
			ON wp_term_relationships.object_id = wp_posts.ID
			LEFT JOIN wp_term_taxonomy
			ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
			LEFT JOIN wp_terms
			ON wp_term_taxonomy.term_id = wp_terms.term_id
			WHERE wp_posts.post_type = 'post'
			AND wp_posts.post_status = 'publish'
			AND wp_term_taxonomy.taxonomy = 'category'
			ORDER BY wp_posts.post_date DESC ";

		return $wpdb->get_results($request);
	}

	protected function getPost($post) {
//		setup_postdata($post);
//		$excerpt = the_excerpt(false);

		$thumbnail = get_the_post_thumbnail( $post->ID, 'featured' );
		$excerpt = wp_trim_words( $post->post_content, Wd::get('settings')->getValue(Settings::MAX_EXCERPT_LENGTH_WORDS), '' );
		return '
		<div style="margin-left: 40px;">
			<h2 class="entry-title" style="margin-top: 10px;">
				<a href="' . HTTP_HOST . '/' . $post->post_name . '" title="' . $post->post_title . '" rel="bookmark" >' . $post->post_title . '</a>
			</h2>
			<div class="content">
				<div style="">
                    <a href="' . HTTP_HOST . '/' . $post->post_name . '" title="' . $post->post_title . '">' . $thumbnail . '</a>
                </div>
                ' . $excerpt . '
				<a class="readmore" href="' . HTTP_HOST . '/' . $post->post_name . '">Далее</a>
			</div>
		</div>
		';
	}
}