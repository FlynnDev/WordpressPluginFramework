<?php
namespace PluginFramework\V_1_1\Attributes;
use PluginFramework\V_1_1\DataIterator as AttributesIterator;
use Iterator;

require_once('attribute.class.php');

class Attributes implements Iterator {
	use AttributesIterator;

	/**
	 * @var Attribute[]
	 */
	protected $data = [];

	public function __construct($data = []) {
		$this->start();
		$this->import($data);
	}

	/**
	 * @param Attributes|array $data
	 *
	 * @return $this
	 */
	public function import($data) {
		if(!$data instanceof Attributes){
			// Old syntax
			foreach($data as $slug => $value) $this->set($slug, $value);
		}
		else{
			foreach($data as $att) {
				if(!isset($this->data[$att->slug])) $this->data[$att->slug] = $att;
				else $this->set($att->slug, $att->get());
			}
		}
		return $this;
	}

	public function save() {
		// Saves current state
	}

	public function get($slug) {
		if(!isset($this->data[$slug])) $this->data[$slug] = new Attribute($slug);
		return $this->data[$slug];
	}

	public function set($slug, $value){
		if(!isset($this->data[$slug])) $this->data[$slug] = new Attribute($slug);
		$this->data[$slug]->set($value);
		return $this;
	}

	public function add($slug, $default = false, $name = false, $tip = false, $type = 'text', $options = [] ){
		$this->data[$slug] = new Attribute($slug, $default, $name, $tip, $type, $options);
		return $this;
	}
}