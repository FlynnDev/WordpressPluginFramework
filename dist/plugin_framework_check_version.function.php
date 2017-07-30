<?php
	namespace PluginFramework\V_1_1;
	if(!function_exists('plugin_framework_check_version')) {
		/**
		 * Check PHP deps
		 *
		 * @return bool
		 */
		function plugin_framework_check_version() {
			return ! version_compare( PHP_VERSION, '5.4.0', '<' );
		}
	}
