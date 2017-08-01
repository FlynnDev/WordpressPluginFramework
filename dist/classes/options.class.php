<?php
namespace PluginFramework\V_1_1;

require_once('option.class.php');

class Options implements \Iterator {
	use Iterator;

	public function __construct($data) {
		$this->start();
		$this->import($data);
	}

	public function &import($data){
		if($data instanceof Options){
			$this->data = $data->data;
		}
		else if($data instanceof Option){
			$this->data[$data->option] = $data;
		}
		else if(!empty($data) && is_array($data[0])){
			foreach($this->data as $k => $o){
				$this->add($o['option'], $o['name']);
			}
		}
		return $this;
	}

	public function &add($option, $name){
		$this->data[$option] = new Option($option, $name);
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
