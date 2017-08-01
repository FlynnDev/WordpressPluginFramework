<?php
namespace PluginFramework\V_1_1;

trait DataIterator {
	private $position = 0;
	protected $data = [];
	public function start()   { $this->position = 0; }
	public function rewind()  { $this->position = 0; }
	public function current() { return $this->data[$this->position]; }
	public function key()     { return $this->position; }
	public function next()    { ++$this->position; }
	public function valid()   { return isset($this->data[$this->position]); }
	public function count()   { return count($this->data); }
}