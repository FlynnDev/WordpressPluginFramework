<?php 
/**
 * Package:  WordPress Plugin Framework
 * Version:  1.0.20
 * Date:     25-06-2017
 * Copyright 2017 Mike Flynn - mflynn@flynndev.us
 */ 
 ?>
<?php
	namespace PluginFramework;
	trait Security {
		private $security_level = 'manage_options';

		/**
		 * Can user access page?
		 *
		 * Checks if user is at or above the security_level
		 *
		 * Dies on failure
		 */
		public function can() {
			if ( !current_user_can( $this->security_level ) )  $this->error('forbidden');
		}

		/**
		 * Set Security Level
		 *
		 * @param string $level
		 */
		public function setSecurityLevel($level = 'manage_options'){
			$this->security_level = $level;
		}

		/**
		 * Get Security Level
		 *
		 * @return string
		 */
		public function getSecurityLevel() {
			return $this->security_level;
		}

	}