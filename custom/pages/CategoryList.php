<?php
class Custom_Pages_CategoryList {

	const MAX_POSTS_SHOW_PER_CATEGORY = 2;

	public static function showPage() {
		get_header();
		global $wp_object_cache;
		$cache = $wp_object_cache->cache;
		$categories = $cache['category'];
		$printedPostIds = array();

		$rawPostCategoryRelations = self::getPostCategoryRelations();
		if(empty($rawPostCategoryRelations)) {
			echo 'no categories found';
			return;
		}
		$postCategoryRelations = array();
		foreach($rawPostCategoryRelations as $post) {
			$postCategoryRelations[$post->term_id][] = $post; // $post->term_id here means 'category id'
		}

		$output = '<div class="article-categories-content">';
		foreach($categories as $catId => $category) {
			$output .= self::getCategoryTitle($category);
			$output .= self::getCategoryDescription($category);
			$amount = count($postCategoryRelations[$catId]);
			for($i = 0; $i < self::MAX_POSTS_SHOW_PER_CATEGORY && $i < $amount; $i++) {
				$output .= self::getPost($postCategoryRelations[$catId][$i]);
			}
			$output .= '<br><br>';
		}
		$output .= '</div>';
		echo $output;
		get_footer();
	}

	protected static function getCategoryTitle($category) {
		$config = unserialize($category->category_settings);
		return '
		<div class="entry-title ' . (isset($config['class']) ? $config['class'] : '') . '">
			<a class="category-link" style="" href="' . HTTP_HOST . '/category/' . $category->slug . '">' . $category->name . '
			</a>
		</div>
		';
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
		return '
		<div style="margin-left: 40px;">
			<div class="header">' . $post->post_title . '</div>
			<div class="content">
				' . mb_substr($post->post_content, 0, 100, 'UTF-8') . '
			</div>
		</div>
		';
	}
}