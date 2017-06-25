<?php

if(!class_exists("PluginFramework\Core")) {
	require_once( '../vendor/autoload.php' );

	require_once( '../src/helpers.trait.php' );
	require_once( '../src/errors.trait.php' );
	require_once( '../src/view.trait.php' );
	require_once( '../src/data.trait.php' );
	require_once( '../src/shortcode.trait.php' );
	require_once( '../src/scripts.trait.php' );
	require_once( '../src/styles.trait.php' );
	require_once( '../src/resources.trait.php' );
	require_once( '../src/pages.trait.php' );
	require_once( '../src/plugininfo.trait.php' );
	require_once( '../src/hooks.trait.php');
	require_once( '../src/security.trait.php');

	require_once( '../src/core.class.php' );
}