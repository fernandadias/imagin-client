<?php

namespace UtillzTheme\Inc\Src\Admin\Http\Endpoints;

use \UtillzCore\Inc\Src\Request\Request;
use \UtillzCore\Inc\Src\Listing\Listing;
use \UtillzCore\Inc\Src\Listing\Views;

use \UtillzEnhance\Inc\Src\Listing\Download;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Endpoint_Listing_Preview extends Endpoint {

	public $action = 'utillz-listing-preview';

    public function open() {

		$request = Request::instance();

		if( $request->is_empty('id') ) {
			$this->error();
		}

		global $post, $ulz_listing, $utilities_download_data;

		$post = get_post( $request->get('id'), OBJECT );
		$ulz_listing = new Listing();
		$utilities_download_data = Download::get_listing_download_data( $ulz_listing );

		// dominant color
		$image_id = Ucore()->get_first_array_upload( Ucore()->jsoning( 'ulz_gallery', $ulz_listing->id ) );
	    $image_dominant_color = Ucore()->get('dominant_color_hex', $image_id, true);

		setup_postdata( $post );

		ob_start();

		$views = new Views( get_the_ID() );
        $views->add();

		Utheme()->the_template('modals/listing-preview/append');

		wp_reset_postdata();

		wp_send_json([
			'success' => true,
			'download_data' => $utilities_download_data,
			'dominant_color' => $image_dominant_color,
			'html' => ob_get_clean()
		]);

	}

	public function get() {

		$request = Request::instance();

		if( $request->is_empty('id') ) {
			$this->error();
		}

		global $post, $ulz_listing;

		$post = get_post( $request->get('id'), OBJECT );
		$ulz_listing = new Listing();

		setup_postdata( $post );

		// summary
		ob_start();
			Ucore()->the_template('modals/listing-preview/summary');
		$summary = ob_get_clean();

		// video
		$video = '';
		$gallery = $ulz_listing->get_gallery('ulz_gallery_large');

        if( ! empty( $video_id = Ucore()->get_first_array_upload( Ucore()->jsoning( 'ulz_video', $ulz_listing->id ) ) ) ) {
            $video = '<video class="ulz--video" loop muted autoplay data-observed="true" poster="' . esc_url( isset( $gallery[0] ) ? $gallery[0] : '' ) . '">
                <source src="' . esc_url( wp_get_attachment_url( $video_id ) ) . '" type="video/mp4">
            </video>';
        }

		wp_reset_postdata();

		wp_send_json([
			'success' => true,
			'summary' => $summary,
			'video' => $video,
		]);

	}

	public function plans() {

		global $ulz_listing, $utilities_download_data;

		$request = Request::instance();

		if( $request->is_empty('id') ) {
			$this->error();
		}

		$ulz_listing = new Listing( $request->get('id') );

		$utilities_download_data = \UtillzEnhance\Inc\Src\Listing\Download::get_listing_download_data( $ulz_listing );

		if( ! $ulz_listing->type ) {
			return;
		}

		$action_type = $ulz_listing->type->get_action_type('download');

		$action = \UtillzCore\Inc\Src\Listing\Action\Component::instance();
		$action->set_position('cover');

		$module = $action->create( array_merge( (array) $action_type->fields, [
			'type' => 'download',
		]));

		wp_send_json([
			'success' => true,
			'html' => $module->get(),
		]);

	}

}
