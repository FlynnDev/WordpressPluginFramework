<?php
/**
 * Package:  WordPress Plugin Framework
 * Version:  1.1.112
 * Date:     29-07-2017
 * Copyright 2017 Mike Flynn - mflynn@flynndev.us
 */ 
 


namespace PluginFramework\V_1_1;

// Attempt to tell server to allow url fopen
ini_set("allow_url_fopen", 1);

if(! function_exists("plugin_core_error_admin_notice")) {

	function plugin_core_error_admin_notice() {
		$class   = 'notice notice-error';
		$message = __( 'The plugins ' . implode(', ', $GLOBALS['plugin_framework_plugins']) . ' require PHP 5.4.0', 'plugin-core' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}

}

if(! function_exists("plugin_framework_register")) {
	function plugin_framework_register($name, $file){
		if(empty($GLOBALS['plugin_framework_plugins'])) $GLOBALS['plugin_framework_plugins'] = [];
		$GLOBALS['plugin_framework_plugins'][$name] = $file;
	}
}

if( plugin_framework_check_version() == false ) {
	add_action( 'admin_notices', 'plugin_core_error_admin_notice' );
}
else {
	if ( ! class_exists( "PluginFramework\V_1_1\Core" ) ) {
		require_once( 'mustache.php' );

		$folder = dirname( __FILE__ ) . '/' . 'traits';
		foreach ( scandir( $folder ) as $filename ) {
			$path = $folder . '/' . $filename;
			if ( is_file( $path ) ) {
				require_once( $path );
			}
		}

		require_once( 'core.class.php' );
	}
}