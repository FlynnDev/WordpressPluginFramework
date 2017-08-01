<?php
namespace PluginFramework\V_1_1\ShortCodes;
use PluginFramework\V_1_1\DataIterator as ShortCodeIterator;
use Iterator;

require_once('attribute.class.php');

class Container implements Iterator {
	use ShortCodeIterator;

	public function __construct($data = []) {
		$this->start();
	}

	/**
	 * Get Shortcode
	 *
	 * @param $slug string
	 *
	 * @return Single
	 */
	public function get($slug) {
		if(!isset($this->data[$slug])) $this->data[$slug] = new Single($slug);
		return $this->data[$slug];
	}
}