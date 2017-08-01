<?php
	namespace PluginFramework\V_1_1;
	use PluginFramework\V_1_1\ShortCodes\ShortCodes as ShortCodesObj;
	trait Shortcodes {

		public $shortcode_prefix = false;

		/**
		 * @var \PluginFramework\V_1_1\ShortCodes\ShortCodes
		 */
		public $shortcodes;

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
			return shortcode_atts( $this->shortcodes[$shortcode]['attributes'] ?: [], $a, $this->pre($shortcode));
		}

		public function sc($slug) {
			if(empty($this->shortcodes)) $this->shortcodes = new ShortCodesObj();
			return $this->shortcodes->get($slug);
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

		public function newOption($option, $name) { return new Option($option, $name); }
		public function newOptions($data = [])    { return new Options($data); }
		public function newAttributes($data = []) { return new Attributes($data); }

	}