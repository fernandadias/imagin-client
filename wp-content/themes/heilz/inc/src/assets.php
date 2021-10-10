<?php

namespace UtillzTheme\Inc\Src;

class Assets {

    use Traits\Singleton;

    function __construct() {

        add_action( 'after_setup_theme', [ $this, 'thumbnails' ] );
        add_action( 'body_class', [ $this, 'body_class' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'comment_form_before', [ $this, 'enqueue_comments_reply' ] );

        add_filter( 'utillz/chart/colors/main', function() {
            return get_option('ulz_main_color') ? esc_attr( get_option('ulz_main_color') ) : '#5e38ec';
        });

    }

    public function thumbnails() {

        add_image_size( 'heilz_listing', 800 );

    }

    public function body_class( $classes ) {

        $classes[] = 'page';
        $classes[] = 'ulz--loading-icons';

        if( wp_is_mobile() ) {
            $classes[] = 'ulz--is-mobile';
        }

        // single post
        if( is_single() && get_post_type() == 'post' ) {
            if( ! is_active_sidebar('sidebar') ) {
                $classes[] = 'ulz--no-sidebar';
            }
        }

        $is_explore = ( function_exists('Ucore') && Ucore()->is_explore() ) ? Ucore()->is_explore() : false;

        if( function_exists('Ucore') && Utheme()->get('ulz_overlap_header') ) {
            $classes[] = 'ulz--header-overlap';

            if( Utheme()->get('ulz_overlap_header_white') ) {
                $classes[] = 'ulz--header-white';
            }
        }

        // account
        if( ! $is_explore ) {
            $is_account = ( function_exists('is_account_page') && is_account_page() );
            if( $is_account && is_user_logged_in() ) {
                $classes[] = 'ulz-is-account-bar';
            }
        }

        // primary search
        $classes[] = sprintf( 'ulz--%s-primary-search', get_option('ulz_primary_search_form') ? 'has' : 'no' );

        // wide page
        if( Utheme()->get('ulz_enable_wide_page') ) {
            $classes[] = 'ulz-wide-page';
        }

        // dark mode header
        if( Utheme()->is_dark_header() ) {
            $classes[] = 'ulz-dark-header';
        }

        // hide heading
        if( Utheme()->get('ulz_hide_heading') ) {
            $classes[] = 'ulz-hide-heading';
        }

        // invert footer
        if( Utheme()->get('ulz_enable_dark_footer') ) {
            $classes[] = 'ulz-invert-footer';
        }

        return $classes;

    }

    public function get_vars() {

        return [
            'version'           => UTILLZ_THEME_VERSION,
            'admin_ajax'        => admin_url('admin-ajax.php'),
            'nonce'             => wp_create_nonce('ajax-nonce'),
            'site_url'          => site_url('/'),
            'uri_assets'        => UTILLZ_THEME_URI,
            'is_mobile'         => wp_is_mobile(),
            'strings'           => [],
        ];
    }

    public function styles() {

        ob_start();

        if( function_exists('Ucore') && $signin_image = get_option('ulz_signin_image') ) {
            $signin_image_obj = Ucore()->json_decode( $signin_image );
            if( isset( $signin_image_obj[0] ) ) {
                $signin_image_src = wp_get_attachment_image_src( $signin_image_obj[0]->id, 'original' );
                if( isset( $signin_image_src[0] ) ) {
                    echo sprintf( '.ulz-modal-open--signin .ulz-signin-image {background-image:url(\'%s\');}', esc_url( $signin_image_src[0] ) );
                }
            }
        }

        extract( array_merge(
            // defaults
            [
                'primary'           => '#2a6b6b',
                'secondary'         => '#000',

                'system'            => '#2e89ff',
                'system_background' => '#eff6ff',

                'listing_over'      => 'rgba(0,145,176,0.4)',

                'font_heading'      => Utheme()->get_font_selector_heading(),
                'font_body'         => Utheme()->get_font_selector_body(),

                'marker'            => '#fff',
                'marker_text'       => '#111',
            ],
            // values
            array_filter([
                'primary'           => get_option('ulz_color_primary'),
                'secondary'         => get_option('ulz_color_secondary'),

                'system'            => get_option('ulz_color_system'),
                'system_background' => get_option('ulz_color_system_background'),

                'listing_over'      => get_option('ulz_color_listing_over'),

                'font_heading'      => str_replace( '+', ' ', strstr( get_option('ulz_font_heading'), ':', true ) ),
                'font_body'         => str_replace( '+', ' ', strstr( get_option('ulz_font_body'), ':', true ) ),

                'marker'            => get_option('ulz_marker_color'),
                'marker_text'       => get_option('ulz_marker_text_color'),
            ])
        ));

        ?>:root {
            --primary: <?php echo esc_attr( $primary ); ?>;
            --secondary: <?php echo esc_attr( $secondary ); ?>;

            --system: <?php echo esc_attr( $system ); ?>;
            --system-background: <?php echo esc_attr( $system_background ); ?>;

            --listing-over: <?php echo esc_attr( $listing_over ); ?>;

            --font-heading: <?php echo esc_attr( $font_heading ); ?>;
            --font-body: <?php echo esc_attr( $font_body ); ?>;

            --marker: <?php echo esc_attr( $marker ); ?>;
            --marker-text: <?php echo esc_attr( $marker_text ); ?>;
        }<?php

        return ob_get_clean();

    }

    public function enqueue_scripts() {

        // native
     	wp_enqueue_style( 'wp-style', get_stylesheet_uri(), [], UTILLZ_THEME_VERSION );

        // layouts
        wp_register_style( 'utillz-layouts', UTILLZ_THEME_URI . 'assets/dist/css/layouts.css', [], UTILLZ_THEME_VERSION );

        // css
    	wp_enqueue_style( 'utillz-theme-style', UTILLZ_THEME_URI . 'assets/dist/css/theme.css', ['utillz-layouts'], UTILLZ_THEME_VERSION );
        wp_add_inline_style( 'utillz-theme-style', $this->styles() );

        // js
        wp_register_script( 'utillz-theme-script', UTILLZ_THEME_URI . 'assets/dist/js/theme.js', [ 'jquery', 'gsap' ], UTILLZ_THEME_VERSION, true );
        wp_localize_script( 'utillz-theme-script', 'utillz_theme_vars', $this->get_vars() );
        wp_enqueue_script( 'utillz-theme-script' );

        // dark mode
        if( Utheme()->is_dark_header() ) {
            wp_enqueue_style( 'utillz-theme-dark', UTILLZ_THEME_URI . 'assets/dist/css/darkmode.css', [ 'utillz-theme-style' ], UTILLZ_THEME_VERSION );
        }

        // submission
        if( function_exists('Ucore') && Ucore()->is_submission() ) {
            wp_enqueue_style( 'utillz-theme-submission', UTILLZ_THEME_URI . 'assets/dist/css/submission.css', [], UTILLZ_THEME_VERSION );
        }

        // rtl
        if( is_rtl() ) {
            wp_enqueue_style( 'utillz-rtl', UTILLZ_THEME_URI . 'assets/dist/css/rtl.css', [ 'utillz-style' ], UTILLZ_THEME_VERSION );
        }

        // icons
        wp_enqueue_style( 'font-awesome-5', UTILLZ_THEME_URI . 'assets/dist/fonts/font-awesome/css/all.min.css', [], UTILLZ_THEME_VERSION );
        wp_enqueue_style( 'material-icons', UTILLZ_THEME_URI . 'assets/dist/fonts/material-icons/material-icons.css' );

        // google fonts
        wp_enqueue_style( 'utillz-fonts', Utheme()->get_google_fonts(), [], null );

        // gsap
        wp_register_script( 'gsap', UTILLZ_THEME_URI . 'assets/dist/lib/gsap/gsap.min.js', [], UTILLZ_THEME_VERSION, true );
        wp_enqueue_script( 'gsap-scrollto-plugin', UTILLZ_THEME_URI . 'assets/dist/lib/gsap/ScrollToPlugin.min.js', ['gsap'], UTILLZ_THEME_VERSION, true );

    }

    public function enqueue_comments_reply() {
        if( get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }

}
