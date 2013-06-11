<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: Oficerov Kirill
 * Date: 13.04.13
 */

class Wd_Parts_Event {

	public static function get_content() {
		global $wpdb;

		$query = "SELECT * FROM wp_terms
INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id = wp_terms.term_id
INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
INNER JOIN wp_posts ON wp_posts.ID = wp_term_relationships.object_id
WHERE wp_terms.slug = 'events' AND wp_posts.post_status = 'publish'

ORDER BY post_date DESC
LIMIT 4";
		$terms = $wpdb->get_results($query);

		echo '<ul>';
		foreach($terms as $term) {
			echo '
			<li>
				<div class="flag_wrapper">
					<div class="icons flag"></div>
				</div>
				<a href="' . get_permalink($term->ID) . '">
				<div class="content">
					<div class="event_date">' . Wd::getReadableDate(date('d-m-Y', strtotime($term->post_date))) . '</div>
					<div class="title">' . $term->post_title . '</div>
				</div>
				</a>
			</li>';
		}
		echo '</ul>
		<div class="clear">&nbsp;</div>';
	}
}