<?php
namespace PluginFramework\Attributes;
use PluginFramework\Options\Container;

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

	public function __toString() {
		return $this->get();
	}

	public function view(){
		return [
			'name'          => $this->slug,
			'title'         => $this->name,
			'is_select'     => $this->type == 'select',
			'is_checkbox'   => $this->type == 'check',
			'checked'       => $this->type == 'check' && $this->get(),
			'is_text'       => $this->type == 'text',
			'options'       => $this->options->view($this->get()),
			'value'         => $this->get(),
			'tip'           => $this->tip
		];
	}

}