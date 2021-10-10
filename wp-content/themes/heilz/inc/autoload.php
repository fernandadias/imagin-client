<?php

if ( ! defined('ABSPATH') ) {
	exit;
}

/*
 * human readable dump
 *
 */
if( ! function_exists('dd') ) {
    function dd( $what = '' ) {
        print '<pre class="ulz-dump">';
        print_r( $what );
        print '</pre>';
    }
}

/*
 * shim for wp_body_open,
 * ensuring backward compatibility with versions of WordPress older than 5.2.
 *
 */
if( ! function_exists( 'wp_body_open' ) ) {
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/*
 * define contstants
 *
 */
define( 'UTILLZ_THEME_VERSION', '1.0.0.2' );
define( 'UTILLZ_THEME_PATH', wp_normalize_path( get_template_directory() . DIRECTORY_SEPARATOR ) );
define( 'UTILLZ_THEME_URI', get_template_directory_uri() . '/' );

/*
 * autoload
 *
 */
spl_autoload_register( function( $class_name ) {
    if ( strpos( $class_name, 'UtillzTheme' ) === false ) { return; }

    $file_parts = explode( '\\', $class_name );

    $namespace = '';
    for( $i = count( $file_parts ) - 1; $i > 0; $i-- ) {

        $current = strtolower( $file_parts[ $i ] );
        $current = str_ireplace( '_', '-', $current );

        if( count( $file_parts ) - 1 === $i ) {
            $file_name = "{$current}.php";
        }else{
            $namespace = '/' . $current . $namespace;
        }
    }

    $filepath  = trailingslashit( dirname( dirname( __FILE__ ) ) . $namespace );
    $filepath .= $file_name;

    if( file_exists( $filepath ) ) {
        include_once( $filepath );
    }else{
        wp_die( esc_html("The file attempting to be loaded at {$filepath} does not exist.") );
    }

});

// register utilities
include UTILLZ_THEME_PATH . 'inc/utils/utils.php';

// init
UtillzTheme\Inc\Init::instance();
