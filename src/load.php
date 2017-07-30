<?php
//banner

namespace PluginFramework;

// Attempt to tell server to allow url fopen
ini_set("allow_url_fopen", 1);

if(empty($GLOBALS['plugin_framework_phpver'])) $GLOBALS['plugin_framework_phpver'] = '5.4.0';

require_once("funcs/check_version.func.php");
require_once("funcs/register.func.php");
require_once("funcs/phpver.func.php");
require_once("funcs/admin_notice.func.php");

if( ! check_version() ) {
	add_action( 'admin_notices', __NAMESPACE__ . '\admin_notice' );
}
else {
	if ( ! class_exists( __NAMESPACE__ . "\Core" ) ) {
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