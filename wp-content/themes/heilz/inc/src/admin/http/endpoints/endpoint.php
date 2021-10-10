<?php

namespace UtillzTheme\Inc\Src\Admin\Http\Endpoints;

use \UtillzCore\Inc\Src\Request\Request;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Endpoint {

	public $action;

	public function __construct() {

		add_action( sprintf( 'wp_ajax_%s', $this->action ), [ $this, 'action' ] );
		add_action( sprintf( 'wp_ajax_nopriv_%s', $this->action ), [ $this, 'action' ] );

	}

	// load method by target
    public function action() {

		$request = Request::instance();
		$target = str_replace( '-', '_', $request->get('target') );

		if( ! empty( $target ) && method_exists( $this, $target ) ) {
			$this->{$target}();
		}

	}

	public function error() {
		wp_send_json([
			'success' => false
		]);
	}

}
