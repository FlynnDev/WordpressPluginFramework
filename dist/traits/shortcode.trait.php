<?php
	namespace PluginFramework\V_1_2\ShortCodes;
	use PluginFramework\V_1_2\ShortCodes\Container as ShortCodes;
	use PluginFramework\V_1_2\Options\Container    as Options;
	use PluginFramework\V_1_2\Options\Single       as Option;
	use PluginFramework\V_1_2\Attributes\Container as Attributes;
	use PluginFramework\V_1_2\Attributes\Single    as Attribute;

	trait Core {

		public $shortcode_prefix = false;

		/**
		 * @var ShortCodes
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
			$defaults = [];
			foreach($this->sc()->get($shortcode)->attributes as $att){
				$defaults[$att->name] = $att->default;
			}

			$new_a = shortcode_atts( $defaults ?: [], $a, $this->pre($shortcode));

			return $this->sc()->get($shortcode)->attributes->import($new_a);
		}

		public function sc() {
			if(empty($this->shortcodes)) $this->shortcodes = new ShortCodes();
			return $this->shortcodes;
		}

		/**
		 * Initializes Shortcodes
		 */
		protected function init_shortcodes(){

			$shortcode_methods = preg_grep('/^shortcode_/', get_class_methods($this));

			// Method method
			foreach($shortcode_methods as $method) {
				$this   ->sc()->get(Single::_slug($method))
				        ->init_method($this->_t, $method)
				        ->metadata();
			}

		}

		public function newOption($option, $name) { return new Option($option, $name); }
		public function newOptions($data = [])    { return new Options($data); }
		public function newAttributes($data = []) { return new Attributes($data); }
		public function newAttribute($slug, $default = false, $name = false, $tip = false, $type = 'text', $options = []) { return new Attribute($slug, $default, $name, $tip, $type, $options); }

	}