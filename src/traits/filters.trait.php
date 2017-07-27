<?php
	namespace PluginFramework;
	/**
	 * Trait Filters
	 * @package PluginFramework
	 *
	 * Add filter:
	 *      Add method: test_filter_{filter_name} ($params...){ ... return $filtered; }
	 *
	 */
	trait Filters {
		/**
		 * Filters
		 * Checks all available hooks and ties related methods to them
		 */
		protected function init_filters(){
			$filter_methods = preg_grep('/^(.+_)?filter_/', get_class_methods($this));

			foreach($filter_methods as $method) add_filter(preg_replace('/^(.+_)?filter_/','', $method), [&$this, $method]);
		}

	}