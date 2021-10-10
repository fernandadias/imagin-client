<?php

namespace UtillzTheme\Inc\Src\Admin\Http;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Xhr {

	use \UtillzTheme\Inc\Src\Traits\Singleton;

	public $actions;

    public function __construct() {

		if( wp_doing_ajax() && isset( $_REQUEST['action'] ) ) {
            $this->init_endpoints();
        }
	}

	function init_endpoints() {

		foreach( glob( UTILLZ_THEME_PATH . 'inc/src/admin/http/endpoints/*.php') as $file ) {
			$endpoint_classname = sprintf( '\UtillzTheme\Inc\Src\Admin\Http\Endpoints\%s', basename( str_replace( '-', '_', $file ), '.php' ) );
			new $endpoint_classname;
		}

	}
}
