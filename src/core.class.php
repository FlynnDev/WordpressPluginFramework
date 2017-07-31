<?php
//banner

namespace PluginFramework;

abstract class Core{

	use PluginInfo, Helpers, Hooks, Errors, View, Data, Shortcodes, Security, Styles, Scripts, Pages, Filters;

	public $_t;

	function init($name, $ver, $file) {
		$this->_t = $this;
		$this->setPrefix($name);
		$this->setShortcodePrefix($this->getPrefix());
		// $this->setMetaBoxPrefix($this->getPrefix());
		$this->setVersion($ver);
		$this->setRoot($file);

		$this->setMenuTitle($name);

		$this->init_view();
		$this->init_hooks();
		$this->init_shortcodes();
		$this->init_filters();

		// $this->init_metaboxes();
	}

}