<?php
namespace PluginFramework\V_1_1;


class ShortCode {
	public $prefix = "";
	public $atts = [];
	public $attributes = [];
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
	}

	public function &setAttributes($atts = [], $overwrite = true){
		if(!empty($this->atts) && !$overwrite) return $this;
		$this->atts = $atts;
		$this->attributes = $this->plugin->pull( $this->plugin->concat($this->slug, 'atts'), $this->atts );
	}

	public function &setTitle($title, $overwrite = true) {
		if(!empty($this->title) && !$overwrite) return $this;
		$this->title = $title;
	}

	public function &setDescription($description, $overwrite = true) {
		if(!empty($this->description) && !$overwrite) return $this;
		$this->description = $description;
	}

	public function &setCategory($category, $overwrite = true) {
		if(!empty($this->category) && !$overwrite) return $this;
		$this->category = $category;
	}

	public function &metadata($title = false, $attributes = false, $description = '', $category = 'Content'){
		$this   ->setAttributes($attributes ?: $this->load('attributes', []), false )
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