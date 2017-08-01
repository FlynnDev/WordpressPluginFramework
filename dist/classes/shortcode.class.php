<?php
namespace PluginFramework\V_1_2\ShortCodes;
use PluginFramework\V_1_2\Attributes\Container as Attributes;

require_once('attributes.class.php');

class Single {
	public $prefix = "";
	public $atts = [];
	/**
	 * @var Attributes
	 */
	public $attributes;
	public $title = "";
	public $description = "";
	public $name = "";
	public $slug = "";
	public $method = "";
	public $category = "";
	public $callable;
	/**
	 * @var \PluginFramework\V_1_2\Core
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

	public function setAttributes($atts){
		$this->attributes
			->import($atts)
			->import($this->atts);
		return $this;
	}

	public function setTitle($title, $overwrite = true) {
		if(!empty($this->title) && !$overwrite) return $this;
		$this->title = $title;
		return $this;
	}

	public function setDescription($description, $overwrite = true) {
		if(!empty($this->description) && !$overwrite) return $this;
		$this->description = $description;
		return $this;
	}

	public function setCategory($category, $overwrite = true) {
		if(!empty($this->category) && !$overwrite) return $this;
		$this->category = $category;
		return $this;
	}

	public function metadata($title = false, $attributes = false, $description = '', $category = 'Content'){
		$this   ->setAttributes($attributes ?: $this->load('attributes', [] ))
				->setTitle($title ?: $this->load('title', $this->plugin->getName() . ': ' . ucwords(str_replace('_', ' ', $this->slug)) ))
				->setDescription($description != "" ? $description: $this->load('description', $description))
				->setCategory( $category != 'Content' ? $category : $this->load('category', $category));
		return $this;
	}
	/**
	 * Initalize ShortCode using Callable Function
	 *
	 * @param $plugin \PluginFramework\V_1_2\Core
	 * @param $closure callable
	 *
	 * @return Single Chainable
	 */
	public function init_closure(&$plugin, &$closure) {
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
	 * @param $plugin \PluginFramework\V_1_2\Core
	 * @param $method string|boolean
	 * @return Single Chainable
	 */
	public function init_method(&$plugin, $method = false) {

		if(!$method) $method = "shortcode_{$this->slug}";

		$this->plugin   = $plugin;
		$this->prefix   = $this->plugin->shortcode_prefix;
		$this->method   = $method;
		$this->name     = $this->pre($this->slug);
		$this->atts->import($this->plugin->pull( $this->plugin->concat($this->slug, 'atts'), [] ));

		$this->callable = [&$this->plugin, $this->method];

		return $this;
	}

	public function launch(){
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