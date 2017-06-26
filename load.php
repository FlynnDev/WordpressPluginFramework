<?php 
/**
 * Package:  WordPress Plugin Framework
 * Version:  1.1.28
 * Date:     25-06-2017
 * Copyright 2017 Mike Flynn - mflynn@flynndev.us
 */ 
 ?>
<?php

if(!class_exists("PluginFramework\V_1_1\Core")) {
	require_once( 'vendor/autoload.php' );

	require_once( 'build/helpers.trait.php' );
	require_once( 'build/errors.trait.php' );
	require_once( 'build/view.trait.php' );
	require_once( 'build/data.trait.php' );
	require_once( 'build/shortcode.trait.php' );
	require_once( 'build/scripts.trait.php' );
	require_once( 'build/styles.trait.php' );
	require_once( 'build/resources.trait.php' );
	require_once( 'build/pages.trait.php' );
	require_once( 'build/plugininfo.trait.php' );
	require_once( 'build/hooks.trait.php');
	require_once( 'build/security.trait.php');

	require_once( 'build/core.class.php' );
}