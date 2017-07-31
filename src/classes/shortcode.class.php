<?php
namespace PluginFramework;

class Attributes {
	public $atts = [];

	public function __construct($data = []) {
		$this->import($data);
	}

	public function &import($data) {
		if(!$data instanceof Attributes){
			// Old syntax
			foreach($data as $slug => $value) $this->set($slug, $value);

		}
		else{
			foreach($this->atts as $att) {
				if(!isset($this->atts[$att->slug])) $this->atts[$att->slug] = $att;
				else $this->set($att->slug, $att->get());
			}
		}
		return $this;
	}

	public function &get($slug) {
		if(!isset($this->atts[$slug])) $this->atts[$slug] = new Attribute($slug);
		return $this->atts[$slug];
	}
	public function &set($slug, $value){
		if(!isset($this->atts[$slug])) $this->atts[$slug] = new Attribute($slug);
		$this->atts[$slug]->set($value);
		return $this;
	}
	public function &add($slug, $default = false, $name = false, $tip = false){
		return $this->atts[$slug] = new Attribute($slug, $default, $name, $tip);
	}
}

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
		else if(is_array($data[0])){
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

class Attribute {
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
		$this->options = new Options($options);
		$this->type = $type;
	}

	public function &set($value){
		$this->current = $value;
		return $this;
	}

	public function get(){
		return $this->current ?: $this->default;
	}
}

class ShortCode {
	public $prefix = "";
	public $atts = [];
	public $attributes;
	public $title = "";
	public $description = "";
	public $name = "";
	public $slug = "";
	public $method = "";
	public $category = "";
	public $callable;
	/**
	 * @var Core
	 */
	private $plugin;
	/**
	 * @var callable function
	 */
	private $function;

	public static function _slug($method){
		return str_replace( 'shortcode_', '', $method );
	}

	public function load($var, $default = []) {
		$v = "shortcode_{$var}_{$this->slug}";
		return isset($this->plugin->$v) ? $this->plugin->$v : $default;
	}
	/**
	 * Generate Shortcode Name
	 *
	 * @param string ...$param Name Chunks
	 * @return string
	 */
	public function pre($param){
		$args = func_get_args();
		$pieces = [$this->prefix];

		foreach($args as $arg) if(!empty($arg)) $pieces[] = $this->plugin->sterilize($arg);

		return implode('_', $pieces);
	}

	public function __construct($slug) {
		$this->slug = $slug;
		$this->atts = new Attributes();
		$this->attributes = new Attributes();
	}

	public function &setAttributes($atts){
		$this->attributes
			->import($atts)
			->import($this->atts);
		return $this;
	}

	public function &setTitle($title, $overwrite = true) {
		if(!empty($this->title) && !$overwrite) return $this;
		$this->title = $title;
		return $this;
	}

	public function &setDescription($description, $overwrite = true) {
		if(!empty($this->description) && !$overwrite) return $this;
		$this->description = $description;
		return $this;
	}

	public function &setCategory($category, $overwrite = true) {
		if(!empty($this->category) && !$overwrite) return $this;
		$this->category = $category;
		return $this;
	}

	public function &metadata($title = false, $attributes = false, $description = '', $category = 'Content'){
		$this   ->setAttributes($attributes ?: $this->load('attributes', [] ))
				->setTitle($title ?: $this->load('title', $this->plugin->getName() . ': ' . ucwords(str_replace('_', ' ', $this->slug)) ))
				->setDescription($description != "" ? $description: $this->load('description', $description))
				->setCategory( $category != 'Content' ? $category : $this->load('category', $category));
		return $this;
	}
	/**
	 * Initalize ShortCode using Callable Function
	 *
	 * @param $plugin Core
	 * @param $closure callable
	 * @return Shortcode Chainable
	 */
	public function &init_closure(&$plugin, &$closure) {
		$this->plugin   = $plugin;
		$this->prefix   = $this->plugin->shortcode_prefix;
		$this->function = $closure;
		$this->name     = $this->pre($this->slug);
		$this->atts->import($this->plugin->pull( $this->plugin->concat($this->slug, 'atts'), [] ));

		$this->callable = $this->function;

		return $this;
	}

	/**
	 * Initalize ShortCode using Method
	 *
	 * @param $plugin Core
	 * @param $method string|boolean
	 * @return Shortcode Chainable
	 */
	public function &init_method(&$plugin, $method = false) {

		if(!$method) $method = "shortcode_{$this->slug}";

		$this->plugin   = $plugin;
		$this->prefix   = $this->plugin->shortcode_prefix;
		$this->method   = $method;
		$this->name     = $this->pre($this->slug);
		$this->atts->import($this->plugin->pull( $this->plugin->concat($this->slug, 'atts'), [] ));

		$this->callable = [&$this->plugin, $this->method];

		return $this;
	}

	public function &launch(){
		add_shortcode($this->name, $this->callable);

		if(function_exists('vc_map')) {
			vc_map( [
				"name"     => $this->title,
				"base"     => $this->name,
				"category" => $this->category,
				"params"   => [

				]
			] );
		}


		return $this;
	}

}