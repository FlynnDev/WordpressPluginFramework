<?php

namespace PluginFramework;

$root = dirname(dirname(__FILE__)) . '/src/';

require_once( $root . 'mustache.php' );

$folder = $root . 'traits';
foreach ( scandir( $folder ) as $filename ) {
	$path = $folder . '/' . $filename;
	if ( is_file( $path ) ) {
		require_once( $path );
	}
}

$folder = $root . '/classes';
foreach ( scandir( $folder ) as $filename ) {
	$path = $folder . '/' . $filename;
	if ( is_file( $path ) ) {
		require_once( $path );
	}
}

require_once( $root . 'core.class.php' );
