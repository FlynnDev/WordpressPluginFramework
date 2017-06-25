<?php

if(!class_exists("PluginFramework\Core")) {
	require_once( 'vendor/autoload.php' );

	require_once( 'helpers.trait.php' );
	require_once( 'errors.trait.php' );
	require_once( 'view.trait.php' );
	require_once( 'data.trait.php' );
	require_once( 'shortcode.trait.php' );
	require_once( 'scripts.trait.php' );
	require_once( 'styles.trait.php' );
	require_once( 'resources.trait.php' );
	require_once( 'pages.trait.php' );
	require_once( 'plugininfo.trait.php' );
	require_once( 'hooks.trait.php');
	require_once( 'security.trait.php');

	require_once( 'core.class.php' );
}