<?php
namespace PluginFramework;

require_once('option.class.php');

class Options {
	public $opts;
	public function __construct($data) {
		$this->import($data);
	}
	public function &import($data){
		if($data instanceof Options){
			$this->opts = $data->opts;
		}
		else if($data instanceof Option){
			$this->opts[$data->option] = $data;
		}
		else if(!empty($data) && is_array($data[0])){
			foreach($this->opts as $k => $o){
				$this->add($o['option'], $o['name']);
			}
		}
		return $this;

	}

	public function add($option, $name){
		$this->opts[$option] = new Option($option, $name);
	}
	public function view($selected){
		$v = [];
		foreach($opts as $k => $o){
			$v[$k] = $o->view($selected);
		}
		return $v;
	}
}
