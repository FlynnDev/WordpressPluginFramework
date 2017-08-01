<?php
namespace PluginFramework\V_1_1\Attributes;
use PluginFramework\V_1_1\Options\Container;

require_once( 'options.class.php' );

class Single {
	public $slug;
	public $name;
	public $default;
	public $tip;
	public $current;
	public $type;
	public $options;

	public function __construct($slug, $default = false, $name = false, $tip = false, $type = 'text', $options = [] ) {
		$this->slug  = $slug;
		$this->default = $default ?: "";
		$this->name = $name ?: ucwords(str_replace('_', ' ',$slug));
		$this->tip = $tip ?: "";
		$this->options = new Container($options);
		$this->type = $type;
	}

	public function set($value){
		$this->current = $value;
		return $this;
	}

	public function get(){
		return $this->current ?: $this->default;
	}
}