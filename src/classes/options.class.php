<?php
namespace PluginFramework;

require_once('option.class.php');

class Options implements \Iterator {
	use Iterator;

	//private $data = [];

	public function __construct($data = []) {
		$this->start();
		$this->import($data);
	}

	public function import($data){
		if($data instanceof Options){
			//$this->data = $data->data;
			foreach($data->export() as $o){
				$this->data[$o->value] = $o;
			}
		}
		else if($data instanceof Option){
			$this->data[$data->value] = $data;
		}
		else if(!empty($data) && is_array($data)){
			foreach($data as $value => $label){
				$this->add($value, $label);
			}
		}
		return $this;
	}

	public function export(){
		return $this->data;
	}

	public function get($value) {
		return $this->data[$value] ?: false;
	}

	public function add($value, $label){
		$this->data[$value] = new Option($value, $label);
		return $this;
	}

	public function view($selected){
		$v = [];
		foreach($this->data as $k => $o){
			$v[$k] = $o->view($selected);
		}
		return $v;
	}
}
