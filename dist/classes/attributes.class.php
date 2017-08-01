<?php
namespace PluginFramework\V_1_2\Attributes;
use PluginFramework\V_1_2\DataIterator as AttributesIterator;
use Iterator;

require_once('attribute.class.php');

class Container implements Iterator {
	use AttributesIterator;

	/**
	 * @var Single[]
	 */
	protected $data = [];

	/**
	 * Container constructor.
	 *
	 * @param array $data
	 */
	public function __construct($data = []) {
		$this->start();
		$this->import($data);
	}

	/**
	 * @param Container|array $data
	 *
	 * @return $this
	 */
	public function import($data) {
		if(! $data instanceof Container){
			// Old syntax
			foreach($data as $slug => $value) $this->set($slug, $value);
		}
		else{
			foreach($data as $att) {
				if(!isset($this->data[$att->slug])) $this->data[$att->slug] = $att;
				else $this->set($att->slug, $att->get());
			}
		}
		return $this;
	}

	/**
	 *
	 */
	public function save() {
		// Saves current state
	}

	/**
	 * @param $slug
	 *
	 * @return Single
	 */
	public function get($slug) {
		if(!isset($this->data[$slug])) $this->data[$slug] = new Single($slug);
		return $this->data[$slug];
	}

	/**
	 * @param $slug
	 * @param $value
	 *
	 * @return $this
	 */
	public function set($slug, $value){
		if(!isset($this->data[$slug])) $this->data[$slug] = new Single($slug);
		$this->data[$slug]->set($value);
		return $this;
	}

	/**
	 * @param $slug
	 * @param bool $default
	 * @param bool $name
	 * @param bool $tip
	 * @param string $type
	 * @param array $options
	 *
	 * @return $this
	 */
	public function add($slug, $default = false, $name = false, $tip = false, $type = 'text', $options = [] ){
		$this->data[$slug] = new Single( $slug, $default, $name, $tip, $type, $options);
		return $this;
	}

	public function view() {
		$view = [];
		foreach($this->data as $a) $view[] = $a->view();
		return $view;
	}
}