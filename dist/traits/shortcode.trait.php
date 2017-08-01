<?php
	namespace PluginFramework\V_1_1;
	trait Shortcodes {

		public $shortcode_prefix = false;
		protected $shortcodes = [];

		/**
		 * Set Shortcode Prefix
		 *
		 * Set the prefix that comes before all shortcode names.
		 *
		 * Set to blank to remove the prefix
		 *
		 * Note: Don't add the underscore, we do that for you
		 *
		 * Note: We will clean the string for you: Lowercase it and replace spaces with underscores
		 *
		 * @param string $prefix Prefix
		 */
		public function setShortcodePrefix($prefix, $force = false) {
			if($this->shortcode_prefix === false || $force) $this->shortcode_prefix = $this->sterilize($prefix);
		}

		public function getShortcodePrefix() {
			return $this->shortcode_prefix == "" ? "" : $this->sterilize($this->shortcode_prefix) . '_';
		}

		protected function atts($shortcode, $a = []) {
			return shortcode_atts( $this->shortcodes[$shortcode]['attributes'] ?: [], $a, $this->shortcode_pre($shortcode));
		}

		public function sc($slug) {
			if(!isset($this->shortcodes[$slug])) $this->shortcodes[$slug] = new ShortCode($slug);
			return $this->shortcodes[$slug];
		}

		/**
		 * Initializes Shortcodes
		 */
		protected function init_shortcodes(){

			$shortcode_methods = preg_grep('/^shortcode_/', get_class_methods($this));

			// Method method
			foreach($shortcode_methods as $method) {
				$this   ->sc(ShortCode::_slug($method))
				        ->init_method($this->_t, $method)
				        ->metadata();
			}

		}

		public function &newOption($option, $name){
			$o = new Option($option, $name);
			return $o;
		}
		public function &newOptions($data = []){
			$o = new Options($data);
			return $o;
		}
		public function &newAttributes($data = []){
			$a = new Attributes($data);
			return $a;
		}

	}