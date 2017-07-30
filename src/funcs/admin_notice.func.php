<?php
namespace PluginFramework;

if(! function_exists(__NAMESPACE__ . "\admin_notice")) {
	function admin_notice($message) {
		$class   = 'notice notice-error';
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}
}

if(! function_exists(__NAMESPACE__ . "\admin_notice_ver")) {
	function admin_notice_ver(){
		$message = __( 'The plugins ' . implode(', ', array_keys($GLOBALS['plugin_framework_plugins'])) . ' require PHP ', 'plugin-core' );
	}
}

if(! function_exists(__NAMESPACE__ . "\admin_notice_settings")) {
	function admin_notice_ver(){
		$message = __( 'The plugins ' . implode(', ', array_keys($GLOBALS['plugin_framework_plugins'])) . ' require PHP Settings to be enabled: '. implode(', ',$GLOBALS['plugin_framework_php_settings']), 'plugin-core' );
	}
}