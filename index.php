<?php
/*
Plugin Name: Safely Deactivate BetterAMP
Plugin URI: https://betterstudio.com/wp-plugins/better-amp/
Description: Leave Better AMP Plugin Without losing indexed URLs in Google.
Version: 1.0.0
Author: BetterStudio
Author URI: http://betterstudio.com
License: GPL2
Requires at least: 4.0.0
*/


function better_amp_safe_leave() {

	$path   = trim( dirname( $_SERVER['PHP_SELF'] ), '/' );
	$amp_qv = defined( 'AMP_QUERY_VAR' ) ? AMP_QUERY_VAR : 'amp';

	if ( preg_match( "#^$path/*$amp_qv/*(.+)/*#", $_SERVER['REQUEST_URI'], $match ) ) {

		$path = trailingslashit( $match[1] );

		if ( defined( 'AMP__VERSION' ) && AMP__VERSION ) {
			$path .= "$amp_qv/";
		}

		wp_redirect( home_url( $path ), 301 );
		exit;
	}
}

add_action( 'init', 'better_amp_safe_leave' );
