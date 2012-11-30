<?php
class Settings {
	const MAX_EXCERPT_LENGTH_WORDS = 'max_excerpt_length_words';

	protected $_settings = array(
		self::MAX_EXCERPT_LENGTH_WORDS => 20 // use with wp_trim_words(text, words_num, more)
	);


	public function getValue($key) {
		return isset($this->_settings[$key]) ? $this->_settings[$key] : false;
	}
}