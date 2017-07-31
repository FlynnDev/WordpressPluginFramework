<?php
namespace PluginFramework\V_1_1;

require_once('attribute.class.php');

class Attributes {
	public $atts = [];

	public function __construct($data = []) {
		$this->import($data);
	}

	public function &import($data) {
		if(!$data instanceof Attributes){
			// Old syntax
			foreach($data as $slug => $value) $this->set($slug, $value);

		}
		else{
			foreach($this->atts as $att) {
				if(!isset($this->atts[$att->slug])) $this->atts[$att->slug] = $att;
				else $this->set($att->slug, $att->get());
			}
		}
		return $this;
	}

	public function &get($slug) {
		if(!isset($this->atts[$slug])) $this->atts[$slug] = new Attribute($slug);
		return $this->atts[$slug];
	}

	public function &set($slug, $value){
		if(!isset($this->atts[$slug])) $this->atts[$slug] = new Attribute($slug);
		$this->atts[$slug]->set($value);
		return $this;
	}

	public function &add($slug, $default = false, $name = false, $tip = false, $type = 'text', $options = [] ){
		$this->atts[$slug] = new Attribute($slug, $default, $name, $tip, $type, $options);
		return $this->atts[$slug];
	}
}