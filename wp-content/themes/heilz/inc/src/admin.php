<?php

namespace UtillzTheme\Inc\Src;

use Form\Fields;

class Admin {

    use Traits\Singleton;

    function __construct() {

        if( is_admin() ) {

            Admin\Http\Xhr::instance();
            Admin\Required::instance();
            Admin\Importer::instance();

            add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

        }

    }

    function enqueue_scripts() {

        // icons
        wp_enqueue_style( 'font-awesome', UTILLZ_THEME_URI . 'assets/dist/fonts/font-awesome/css/all.min.css', [], UTILLZ_THEME_VERSION );
        wp_enqueue_style( 'material-icons', UTILLZ_THEME_URI . 'assets/dist/fonts/material-icons/material-icons.css' );

        // rtl
        if( is_rtl() ) {
            wp_enqueue_style( 'utillz-rtl', UTILLZ_THEME_URI . 'assets/dist/css/rtl.css', [ 'utillz-theme-admin-style' ], UTILLZ_THEME_VERSION );
        }

        /*
         * main
         *
         */

        // layouts
        wp_register_style( 'utillz-layouts', UTILLZ_THEME_URI . 'assets/dist/css/layouts.css', [], UTILLZ_THEME_VERSION );

        // css
        wp_enqueue_style( 'utillz-theme-admin-style', UTILLZ_THEME_URI . 'assets/dist/css/admin/admin.css', ['utillz-layouts'], UTILLZ_THEME_VERSION );

        // js
        wp_register_script( 'utillz-theme-admin-main', UTILLZ_THEME_URI . 'assets/dist/js/admin/admin.js', ['jquery'], UTILLZ_THEME_VERSION, true );
        $vars = [
            'admin_ajax'        => admin_url('admin-ajax.php'),
            'nonce'             => wp_create_nonce('ajax-nonce'),
            'site_url'          => site_url('/'),
            'uri_assets'        => UTILLZ_THEME_URI,
            'strings'           => []
        ];
        wp_localize_script( 'utillz-theme-admin-main', 'utillz_theme_vars', $vars );
        wp_enqueue_script( 'utillz-theme-admin-main' );

    }

}
