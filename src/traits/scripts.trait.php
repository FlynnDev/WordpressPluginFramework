<?php
	namespace PluginFramework;
	trait Scripts {
		protected $scripts_dir    = 'scripts/';
		protected $scripts        = [];
		protected $admin_scripts  = [];


		/**
		 * Set Script Directory
		 *
		 * Set the root directory for the css files
		 *
		 * @param string $dir Directory (Examples: "styles", "inc/css")
		 */
		public function setScriptDir($dir) {
			$this->scripts_dir = $dir . '/';
		}


		/**
		 * Add Script
		 *
		 * @param string $name Script Name
		 * @param string $file File Name
		 * @param string[] $deps Dependancies
		 * @param string[]|array[] $localize Localization A list containing strings ( or [string, context]) to be run through the translation engine
		 */
		public function addScript($name, $file, $deps = []){
			$this->scripts[] = [$name, $file, $deps];
		}

		/**
		 * Build Script Url
		 *
		 * @param string $file File relative to project root
		 *
		 * @return string Complete URL
		 */
		protected function scriptUrl($file) {
			return plugins_url( $this->scripts_dir . $file, $this->getFile() );
		}

		/**
		 * Add Admin Script
		 *
		 * @param string $name Script Name
		 * @param string $file File Name
		 * @param array $deps Dependancies
		 * @param string[]|array[] $localize Localization A list containing strings ( or [string, context]) to be run through the translation engine
		 */
		public function addAdminScript($name, $file, $deps = [], $localize = [] ){
			$this->admin_scripts[] = [$name, $file, $deps, $localize];
		}

		public function scripts_hook_init() {
			foreach($this->scripts as list($name, $file, $deps, $localize)) {
				wp_register_script( $this->pre($name), $this->scriptUrl($file), $deps, $this->getVersion(), true );
			}
		}

		public function scripts_hook_admin_init(){
			foreach($this->admin_scripts as list($name, $file, $deps, $localize)) {
				wp_register_script( $this->pre('admin', $name), $this->scriptUrl($file), $deps, $this->getVersion(), true );
			}
		}


		public function scripts_hook_wp_enqueue_scripts() {
			foreach ( $this->scripts as list( $name, $file, $deps, $localize ) ) {
				wp_enqueue_script( $this->pre( $name ) );
				wp_localize_script( $this->pre($name), 'pf_context', $this->build_script_context($localize) );
			}
		}

		public function scripts_hook_admin_enqueue_scripts() {
			foreach ( $this->admin_scripts as list( $name, $file, $deps, $localize ) ) {
				wp_enqueue_script( $this->pre( 'admin', $name ) );
				wp_localize_script( $this->pre( 'admin', $name), 'pf_context', $this->build_script_context($localize) );
			}
		}
	}