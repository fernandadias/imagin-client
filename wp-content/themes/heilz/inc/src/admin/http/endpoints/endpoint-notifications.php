<?php

namespace UtillzTheme\Inc\Src\Admin\Http\Endpoints;

use \UtillzCore\Inc\Src\Request\Request;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Endpoint_Notifications extends Endpoint {

	public $action = 'utillz-notifications';

	public function load() {

		global $ulz_site;

		$request = Request::instance();
		$page = max( (int) $request->get('page'), 1 );
		$site_notifications = utillz_core()->notify->get_latest_site( $page );
		$more = ( $page * 10 ) < $site_notifications->found;

		ob_start();

		if( ! $site_notifications->site && $page == 1 ) {
			echo '<p>' . esc_html__('You don\'t have any notifications', 'heilz') . '</p>';
		}else{
			foreach( $site_notifications->site as $site ) {
				$ulz_site = $site;
				Utheme()->the_template('globals/notifications/row');
			}
			if( ! $more ) {
				echo '<p>' . esc_html__('No more notifications', 'heilz') . '</p>';
			}
		}

		wp_send_json([
			'success' => true,
			'html' => ob_get_clean(),
			'found' => $site_notifications->found,
			'more' => $more,
		]);

	}

	public function mark_read() {

		if( apply_filters( 'utillz/notifications/mark-as-read', true ) ) {
			utillz_core()->notify->mark_site_as_read();
		}

		wp_send_json([
			'success' => true,
		]);

	}

}
