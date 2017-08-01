<?php
namespace PluginFramework;

class Option {
	public $option;
	public $name;

	public function __construct($option, $name) {
		$this->option = $option;
		$this->name = $name;
	}

	public function view($selected){
		$v = ['selected' => false, 'option' => $o->option, 'name' => $o->name];
		if($selected == $o->option) $v['selected'] = true;
		return $v;
	}

}
