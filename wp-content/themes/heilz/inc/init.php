<?php

namespace UtillzTheme\Inc;

class Init {

    use \UtillzTheme\Inc\Src\Traits\Singleton;

    function __construct() {

        Src\Admin::instance();
        Src\Assets::instance();
        Src\Setup::instance();
        Src\Widgets::instance();
        Src\Core::instance();
        Src\WooCommerce::instance();

    }

}
