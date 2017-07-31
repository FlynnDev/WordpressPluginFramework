<?php

	namespace PluginFramework;

	trait Helpers {
		/**
		 * Sterilize String
		 *
		 * Converts string to lower case
		 * Converts all spaces to underscores
		 *
		 * @param string $str
		 *
		 * @return string Sterilized String
		 */
		public function sterilize($str) {
			return strtolower( str_replace(' ', '_', $str ) );
		}

		/**
		 * Concatenate
		 *
		 * Sterilizes all Strings
		 * Glues strings together with _
		 *
		 * @param string|array ...$param Parameter
		 *
		 * @return string
		 */
		public function concat($param){
			$args   = func_get_args();
			$pieces = [];

			foreach($args as $arg) if(!empty($arg)) $pieces[] = $this->sterilize($arg);

			return implode("_", $pieces);
		}

		/**
		 * Generate Prefixed String
		 *
		 * Prefixes with plugin prefix
		 * Sterilizes all Strings
		 * Glues strings together with _
		 *
		 * @param string ...$param Parameters
		 * @return string
		 */
		public function pre($param) {
			$args   = func_get_args();
			$pieces = [$this->prefix];

			foreach($args as $arg) if(!empty($arg)) $pieces[] = $this->sterilize($arg);

			return  implode('_', $pieces);
		}

		/**
		 * Convert pre to title
		 *
		 * Converts a string that has been passed through pre back to a page title
		 *
		 * @param string $s
		 * @return string
		 */
		public function pre_to_title($s) {
			$a = explode('_', $s);
			array_shift($a);
			return ucwords(implode(" ", $a));
		}

		public function check_nonce($name){
			$n = $this->pre($name);
			if ( !isset( $_REQUEST['_'.$n] ) || !wp_verify_nonce( $_REQUEST['_'.$n], $n ) ){
				return false;
			}
			return true;
		}

		public function nonce($name){
			$n = $this->pre($name);
			$nonce = wp_create_nonce($n);
			return "<input type='hidden' id='_{$n}' name='_{$n}' value='{$nonce}' />";
		}

		public $text_domain = "plugin-framework";

		public function setTextDomain($domain) {
			$this->text_domain = $domain;
		}

		public function __($str, $escape = false) {
			return $escape ? esc_html__($str, $this->text_domain) : __($str, $this->text_domain);
		}

		public function _e($str, $escape = false) {
			return $escape ? esc_html_e($str, $this->text_domain) : _e($str, $this->text_domain);
		}

		public function _x($str, $context){
			return _x($str, $context, $this->text_domain);
		}

		public function _ex($str, $context) {
			return _ex($str, $context, $this->text_domain);
		}

		protected function build_script_context($arr) {
			$context = [];

			foreach($arr as $i) {
				if(is_array($i)) $context[$i[0]] = $this->_x($i[0], $i[1]);
				else $context[$i] = $this->__($i);
			}

			return $context;
		}


	}