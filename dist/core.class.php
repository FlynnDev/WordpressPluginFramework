<?php
//banner

namespace PluginFramework\V_1_1;

abstract class Core{

	use PluginInfo, Helpers, Hooks, Errors, View, Data, Shortcode, Security, Styles, Scripts, Pages;

	function init($name, $ver, $file) {
		$this->setPrefix($name);
		$this->setShortcodePrefix($this->getPrefix());
		$this->setVersion($ver);
		$this->setRoot($file);

		$this->setMenuTitle($name);
		
		$this->init_view();
		$this->init_hooks();
		$this->init_shortcodes();
	}

}