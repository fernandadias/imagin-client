<?php

namespace UtillzTheme\Inc\Src;

use \UtillzCore\Inc\Src\Form\Component as Form;
use \UtillzCore\Inc\Src\Request\Request;

class Core {

    use Traits\Singleton;

    function __construct() {

        // settings page
        add_filter( 'utillz/settings/page', function() {

            $form = new Form( Form::Storage_Option );

            $form->render([
                'type' => 'select',
                'id' => 'page_collections',
                'name' => esc_html__('Collections page', 'heilz'),
                'options' => [
                    'query' => [
                        'post_type' => 'page',
                        'posts_per_page' => -1,
                    ]
                ]
            ]);

        });

        // explore open types
        add_filter('utillz/listing-type/settings/explore/open', function( $types ) {
            return array_merge( $types, [
                'modal' => esc_html__('Quick-view modal', 'heilz')
            ]);
        });

        // explore open
        add_action('utillz/explore/open/modal', function() {
            global $ulz_listing;
            echo sprintf( 'data-modal="listing-preview" data-params="%s"', $ulz_listing->id );
        });

        add_action('wp_footer', [ $this, 'explore_open_modal_template' ]);

        add_action('utillz/is-explore', function() {
            return is_author();
        });

        add_filter('utillz/display/explore/type', function( $types ) {
            return array_merge( $types, [
                'wide' => esc_html__('Wide', 'heilz'),
            ]);
        });

        // collections page template
        add_filter('utillz/page/collections/template', function() {
            return 'stack';
        });

        // pre-defined fields
        add_filter('utillz/form/field/key/pre-defined', function( $fields ) {
            $fields['ulz_video'] = esc_html__('Video', 'heilz');
            $fields['ulz_download'] = esc_html__('Download file', 'heilz');
            return $fields;
        });

        // single listing cover type
        add_filter('utillz/listing-type/display/cover-type', function( $types ) {
            return array_merge( $types, [
                'default' => esc_html__('Default', 'heilz'),
                'full-cover' => esc_html__('Full-cover', 'heilz'),
                'adaptive' => esc_html__('Adaptive', 'heilz')
            ]);
        });

        add_filter('utillz/explore/layout/cover_style', function() {
            $available = ['landscape', 'square', 'portrait', 'auto'];
            if( isset( $_GET['__style'] ) && in_array( $_GET['__style'], $available ) ) {
                return $_GET['__style'];
            }
            return;
        });

        add_filter('utillz/explore/layout/type', function() {
            $available = ['default', 'wide'];
            if( isset( $_GET['__type'] ) && in_array( $_GET['__type'], $available ) ) {
                return $_GET['__type'];
            }
            return;
        });

        add_filter('utillz/explore/layout/columns', function() {
            $available = [5,4,3,2];
            if( isset( $_GET['__columns'] ) && in_array( $_GET['__columns'], $available ) ) {
                return $_GET['__columns'];
            }
            return;
        });

        add_filter('utillz/single/display-sidebar', function() {
            return ! isset( $_GET['__no_sidebar'] );
        });

        add_action('utillz/explore/filters/before', function( $search_form_id ) {
            Utheme()->the_template('mobile/explore/filters');
        });

        add_action('utillz/import/image-colors', function( $image_colors ) {
            return [
                [
                    'background' => '111',
                    'color' => '333',
                ],
                [
                    'background' => '222',
                    'color' => '444',
                ],
                [
                    'background' => '333',
                    'color' => '555',
                ],
            ];
        });

        // set default style kit for elementor
        // after demo import is ready
        add_action('utillz/importer/finalize', function() {

            $query = new \WP_Query([
                'post_type' => 'elementor_library',
                'post_status' => 'publish',
                'posts_per_page' => 1,
                'orderby' => 'date',
                'order' => 'ASC',
            ]);

            if( $query->found_posts ) {
                update_option( 'elementor_active_kit', (int) $query->posts[0]->ID );
            }

		});

        // fix listings image ids
        add_action('utillz/importer/finalize', [ $this, 'listing_image_ids' ]);

    }

    public function explore_open_modal_template() {
        if( function_exists('Ucore') ) {
            Utheme()->the_template('modals/listing-preview/content');
        }
    }

    public function listing_image_ids() {

		$the_query = new \WP_Query([
		    'post_type' => [
		        'page',
		        'post',
		        'ulz_listing',
		        'ulz_listing_type',
		    ],
		    'posts_per_page' => -1
		]);

		if( $the_query->have_posts() ) {

		    while( $the_query->have_posts() ) { $the_query->the_post();

		        $post_id = get_the_ID();
		        $post_metas = get_post_meta( $post_id, '', true );

		        if( is_array( $post_metas ) ) {
		            foreach( $post_metas as $key => $post_meta ) {

		                $meta_single_value = $post_meta[0];

		                if( ! empty( $meta_single_value ) && Ucore()->is_prefixed( $key ) ) {
		                    if( substr( $meta_single_value, 0, 3 ) === '[{"' ) {

							    $generated_image = \UtillzCore\Inc\Src\Admin\Import::generate_image();
		                        $new_meta_value = preg_replace( '/{"id":"?([0-9]+)"?}/i', '{"id":"' . $generated_image->id . '"}', $meta_single_value );
		                        update_post_meta( $post_id, $key, $new_meta_value );

		                    }
		                }
		            }
		        }
		    }
		}

		wp_reset_postdata();

	}

}
