<?php
	namespace PluginFramework;
	trait View {

		/**
		 * View
		 *
		 * An instance of the Mustache Engine
		 *
		 * @var \Mustache_Engine
		 */
		public $view;

		/**
		 * View Directory
		 *
		 * The location of the Mustache Tempates root Directory
		 *
		 * @var string
		 */
		private $view_dir = 'views/';

		/**
		 * Initialize View
		 */
		private function init_view() {
			$this->view = new \Mustache_Engine( [ 'loader' => new \Mustache_Loader_FilesystemLoader( plugins_url( $this->view_dir, $this->root ) ) ] );
		}

		/**
		 * Set View Directory
		 *
		 * Set the root directory for the mustache template engine
		 *
		 * @param string $dir Directory
		 */
		public function setViewDir( $dir ) {
			$this->view_dir = $dir;
		}

		public function render($template, $view = []) {

			$defaults = [
				'prefix' => $this->getPrefix(),
				'plugin_name' => $this->getName(),
				'plugin_version' => $this->getVersion(),
				'plugin_root' => dirname($this->getRoot())
			];

			return $this->view->render($template, array_merge($defaults, $view));


		}

	}
