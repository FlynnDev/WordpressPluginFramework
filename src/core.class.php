<?php
//banner

namespace PluginFramework;
use PluginFramework\ShortCodes\Core as Shortcodes;

abstract class Core {

	use PluginInfo, Helpers, Hooks, Errors, View, Data, Shortcodes, Security, Styles, Scripts, Pages, Filters; //, MetaBox;

	public $_t;
	/**
	 * @param $name Plugin Slug
	 * @param $ver Plugin Version
	 * @param $file __FILE__ from parent context
	 * @param $t $this from parent context
	 */

	function init($name, $ver, $file, $t) {
		$this->_t = $t;
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