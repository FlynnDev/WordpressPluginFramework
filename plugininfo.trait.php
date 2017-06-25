<?php
	namespace PluginFramework;
	trait PluginInfo {

		/**
		 * Plugin Name
		 * @var string
		 */
		private $name = "Plugin Framework";

		/**
		 * Plugin Version
		 * @var string
		 */
		private $version = '1.0.0';

		/**
		 * Plugin Root
		 *
		 * Used for determining file locations
		 *
		 * @var string
		 */
		private $root = '';

		/**
		 * Plugin Prefix
		 *
		 * This string will be applied in a variety of locations to namespace stuff for this plugin
		 *
		 * @var string
		 */
		public $prefix = 'plugin_framework';

		/**
		 * Set Plugin Name
		 *
		 * Set the plugin name
		 * Optionally set the plugin prefix, shortcode prefix, etc...
		 *
		 * @param string $name Plugin Name
		 * @param bool $cascade Update other fields?
		 */
		public function setName($name, $cascade = true){
			$this->name = $name;
			if($cascade) $this->setPrefix($name, true);
		}

		/**
		 * Set Plugin Prefix
		 *
		 * @param string $prefix Prefix
		 * @param bool $cascade Update other fields?
		 */
		public function setPrefix($prefix, $cascade = true){
			$this->prefix = $this->sterilize($prefix);
			if($cascade) $this->setShortcodePrefix($prefix);
		}

		/**
		 * Get Plugin Prefix
		 * @return string Prefix
		 */
		public function getPrefix(){
			return $this->prefix . "_";
		}

		/**
		 * Set Plugin Root
		 *
		 * send in the value of __FILE__ from the plugin root
		 *
		 * @param string $root Root File
		 */
		public function setRoot($root) {
			if(file_exists($root)) $this->root = $root;
			else $this->root = dirname(__FILE__);
		}

		/**
		 * Get Plugin Root
		 *
		 * @return string Root
		 */
		public function getRoot() {
			return $this->root;
		}

		/**
		 * Set Plugin Version
		 *
		 * Set the version number of this plugin.  It is applied to all script and style calls to help them clear the cache
		 *
		 * @param $version
		 */
		public function setVersion($version){
			$this->version = $version;
		}

		/**
		 * Get Plugin Version
		 * @return string Version
		 */
		public function getVersion(){
			return $this->version;
		}
	}