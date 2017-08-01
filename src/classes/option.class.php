<?php
namespace PluginFramework\Options;

class Option {
	public $value;
	public $label;

	public function __construct($value, $label = false) {
		$this->value = $value;
		$this->label = $label ?: $value;
	}

	public function view($selected){
		return [
			'selected' => $selected == $this->value,
			'value' => $this->value,
			'label' => $this->label
		];
	}

}
