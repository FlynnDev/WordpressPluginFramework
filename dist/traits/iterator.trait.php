<?php
namespace PluginFramework\V_1_1;

trait Iterator {
	private $position = 0;
	private $data = [];

	public function rewind() {
		$this->position = 0;
	}

	public function current() {
		return $this->array[$this->position];
	}

	public function key() {
		return $this->position;
	}

	public function next() {
		++$this->position;
	}

	public function valid() {
		return isset($this->data[$this->position]);
	}
}