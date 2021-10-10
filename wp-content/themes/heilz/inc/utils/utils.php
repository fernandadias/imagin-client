<?php

use \UtillzTheme\Inc\Utils;

/*
 * register utilities
 *
 */
if( ! function_exists('utillz_theme') ) {
    function utillz_theme() {
        return Utils\Register::instance();
    }
}

if( ! function_exists('Utheme') ) {
    function Utheme() {
    	return utillz_theme()->helpers();
    }
    utillz_theme()->register( 'helpers', Utils\Helpers::instance() );
    utillz_theme()->register( 'breadcrumbs', Utils\Breadcrumbs\Breadcrumbs::instance() );
}
