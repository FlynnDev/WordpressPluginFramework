<?php
namespace PluginFramework;
if(!function_exists(__NAMESPACE__ . '\phpver')){
	function phpver($ver = false) {
		if($ver) {
			if(version_compare($ver, $GLOBALS['plugin_framework_phpver'], '>')) $GLOBALS['plugin_framework_phpver'] = $ver;
		}
		return $GLOBALS['plugin_framework_phpver'];
	}
}