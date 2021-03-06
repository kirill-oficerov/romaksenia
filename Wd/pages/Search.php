<?php
class Wd_Pages_Search {

	public static function getExcerpt($searchString) {
		global $post;
		$searchString = htmlspecialchars_decode($searchString);
		$searchString = trim($searchString);
		$content = strip_tags($post->post_content);
		$contentWords = preg_split( "/[\n\r\t ]+/", $content, null, PREG_SPLIT_NO_EMPTY );
		$searchWords = explode(' ', $searchString);
		if(($firstSearchResultIndex = self::findArrayInArray($searchWords, $contentWords)) !== false) { // found in content
			$wordsAmount = Wd::get('settings')->getValue(Settings::MAX_EXCERPT_LENGTH_WORDS);
			$excerpt = get_the_excerpt();
			$excerptsWords = preg_split( "/[\n\r\t ]+/", $excerpt, null, PREG_SPLIT_NO_EMPTY );
			array_pop( $excerptsWords );
			if(self::findArrayInArray($searchWords, $excerptsWords) !== false) {
				$toReturn = apply_filters('get_the_excerpt', '');
				$toReturn = '<div class="post-excerpt">' . $toReturn;
				$matches = array();
				preg_match('~<br />.{0,2}<a[^>]+readmore[^>]*>Далее</a>~', $toReturn, $matches);
				$toReturn = Wd::mb_str_replace($matches[0], '</div>' . $matches[0], $toReturn);
			} else {
				$firstSearchResultIndex = self::findArrayInArray($searchWords, $contentWords);
				$endEllipsis = count($contentWords) < $firstSearchResultIndex + $wordsAmount ? '' : '...';
				$contentWords = array_slice($contentWords, $firstSearchResultIndex - $wordsAmount / 2, $wordsAmount);
				$output = '<div class="post-excerpt">';
				$output .= '...' . implode(' ', $contentWords) . $endEllipsis;
				$excerpt_length = apply_filters('excerpt_length', 55);
				$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
				$output .= '</div><br />' . substr($excerpt_more, 10);
				$toReturn = apply_filters('get_the_excerpt', $output);
			}
		} else {
//			$toReturn = apply_filters('get_the_excerpt', '');
//			$toReturn = '<div class="post-excerpt">' . $toReturn . '</div>';
		}
		if ( post_password_required($post) ) {
			$output = __('There is no excerpt because this is a protected post.');
			return $output;
		}

//		$toReturn = wp_trim_excerpt($toReturn);
		return $toReturn;
	}

	public static function findArrayInArray($needle, $haystack) {
		$haystackLength = count($haystack);
		$needleLength = count($needle);
		$firstSearchResultIndex = false;
		for($i = 0; $i < $haystackLength; $i++) {
			$firstSearchResultIndex = false;
			$iAdditional = 0;
			for($j = 0; $j < $needleLength; $j++) {
				if(mb_strpos(mb_strtolower($haystack[$i + $iAdditional]), mb_strtolower($needle[$j]), null, 'UTF-8') !== false) {
					if($j + 1 == $needleLength) {
						$firstSearchResultIndex = $i;
						break;
					}
					$iAdditional++;
				} else {
					break;
				}
			}
			if($firstSearchResultIndex !== false) {
				break;
			}

		}
		return $firstSearchResultIndex;
	}
	public static function highlightString($needle, $haystack) {
		$ind = mb_stripos($haystack, $needle, null, 'UTF-8');
		$len = mb_strlen($needle, 'UTF-8');
		if($ind !== false){
			return mb_substr($haystack, 0, $ind, 'UTF-8') . '<span class="select-search-result">' . mb_substr($haystack, $ind, $len, 'UTF-8') . '</span>' .
				self::highlightString($needle, mb_substr($haystack, $ind + $len));
		} else {
			return $haystack;
		}
	}
}