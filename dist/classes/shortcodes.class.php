<?php
namespace PluginFramework\V_1_1\ShortCodes;
use PluginFramework\V_1_1\DataIterator as ShortCodeIterator;
use Iterator;

require_once('attribute.class.php');

class ShortCodes implements Iterator {
	use ShortCodeIterator;

	public function __construct($data = []) {
		$this->start();
	}

	public function get($slug) {
		if(!isset($this->data[$slug])) $this->data[$slug] = new ShortCode($slug);
		return $this->data[$slug];
	}
}