<?php
namespace PluginFramework\V_1_2;

if(! function_exists(__NAMESPACE__ . '\register')) {
	function register($name, $file){
		if(empty($GLOBALS['plugin_framework_v_1_2_plugins'])) $GLOBALS['plugin_framework_v_1_2_plugins'] = array();
		$GLOBALS['plugin_framework_v_1_2_plugins'][$name] = $file;
	}
}
