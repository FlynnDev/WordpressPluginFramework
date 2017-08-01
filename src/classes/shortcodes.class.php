<?php
namespace PluginFramework\ShortCodes;
use PluginFramework\DataIterator as ShortCodeIterator;
use Iterator;

require_once('attribute.class.php');

class Container implements Iterator {
	use ShortCodeIterator;

	public function __construct($data = []) {
		$this->start();
	}

	public function get($slug) {
		if(!isset($this->data[$slug])) $this->data[$slug] = new Single($slug);
		return $this->data[$slug];
	}
}