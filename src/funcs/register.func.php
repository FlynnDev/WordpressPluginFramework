<?php
namespace PluginFramework;

if(! function_exists(__NAMESPACE__ . "\register")) {
	function register($name, $file){
		if(empty($GLOBALS['plugin_framework_plugins'])) $GLOBALS['plugin_framework_plugins'] = array();
		$GLOBALS['plugin_framework_plugins'][$name] = $file;
	}
}
