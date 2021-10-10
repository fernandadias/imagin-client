<?php

namespace UtillzTheme\Inc\Src\Admin;

class Importer {

    use \UtillzTheme\Inc\Src\Traits\Singleton;

    function __construct() {

        $this->init_actions();

    }

    protected function init_actions() {

        add_filter( 'utillz/importer/demos', [ $this, 'add_demos' ] );

    }

    public function add_demos( $demos ) {

        $demos += [
            'digital-downloads' => [
                'name' => esc_html__('Digital Downloads', 'heilz'),
                'path' => UTILLZ_THEME_PATH . 'inc/demos/digital-downloads/',
                'thumbnail' => UTILLZ_THEME_URI . 'inc/demos/digital-downloads/thumbnail.png',
            ],
        ];

        return $demos;

    }

}
