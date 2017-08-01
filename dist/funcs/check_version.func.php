<?php
	namespace PluginFramework\V_1_2;
	if(!function_exists(__NAMESPACE__ . '\check_version')) {
		/**
		 * Check PHP deps
		 *
		 * @return bool
		 */
		function check_version() {
			return ! version_compare( PHP_VERSION, phpver(), '<' );
		}
	}
