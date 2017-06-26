<?php 
/**
 * Package:  WordPress Plugin Framework
 * Version:  1.1.25
 * Date:     25-06-2017
 * Copyright 2017 Mike Flynn - mflynn@flynndev.us
 */ 
 ?>
<?php
	namespace PluginFramework\V_1_1;
	trait Hooks {
		/**
		 * Hooks
		 * Checks all available hooks and ties related methods to them
		 */
		private function init_hooks(){
			$hook_methods = preg_grep('/^(.+_)?hook_/', get_class_methods($this));

			foreach($hook_methods as $method) add_action(preg_replace('/^(.+_)?hook_/','', $method), [&$this, $method]);
		}

	}