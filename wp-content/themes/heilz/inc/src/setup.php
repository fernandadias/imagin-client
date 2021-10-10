<?php

namespace UtillzTheme\Inc\Src;

class Setup {

    use Traits\Singleton;

    function __construct() {

        add_action('init', [ $this, 'support' ]);
        add_action('widgets_init', [ $this, 'widgets_init' ]);

        add_filter('excerpt_length', [ $this, 'excerpt_length' ], 999);
        add_filter('excerpt_more', [ $this, 'excerpt_more' ], 999);

        // render templates
        add_action('wp_footer', [ $this, 'templates' ]);

        // format menu link
        add_filter('nav_menu_link_attributes', [ $this, 'format_menu_link' ], 10, 4);

        // installation
        add_action('after_switch_theme', [ $this, 'activation' ]);

    }

    public function support() {

        // Make theme available for translation.
        load_theme_textdomain( 'heilz', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

        // Let WordPress manage the document title.
        add_theme_support( 'title-tag' );

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );

        // Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		]);

        register_nav_menus([
			'primary' => esc_html__( 'Primary', 'heilz' ),
		]);

        register_nav_menus([
			'mobile' => esc_html__( 'Mobile', 'heilz' ),
		]);

        register_nav_menus([
			'bottom' => esc_html__( 'Footer Bottom', 'heilz' ),
		]);

        $GLOBALS['content_width'] = apply_filters( 'brk_content_width', 640 );

    }

    public function widgets_init() {

        register_sidebar([
            'name'          => 'Sidebar',
            'id'            => 'sidebar',
            'before_widget' => '<div class="ulz-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h6 class="ulz-widget-title">',
            'after_title'   => '</h6>',
        ]);

        if( ! $footer_columns = (int) get_option('ulz_footer_columns') ) {
            $footer_columns = 4;
        }

        for( $i = 1; $i <= $footer_columns; $i++ ) {
            register_sidebar([
                'name'          => sprintf( esc_html__('Footer column %s', 'heilz'), $i ),
                'id'            => sprintf( 'footer-%s', $i ),
                'before_widget' => '<div class="ulz-widget">',
                'after_widget'  => '</div>',
                'before_title'  => '<h6 class="ulz-widget-title">',
                'after_title'   => '</h6>',
            ]);
        }

    }

    public function excerpt_length() {
        return 25;
    }

    public function excerpt_more() {
        return ' ...';
    }

    public function templates() {

        Utheme()->the_template('globals/notifications/panel');

    }

    public function format_menu_link( $atts, $item, $args, $depth ) {

        if( function_exists('Ucore') ) {
            $atts['href'] = Ucore()->format_menu_link( $atts['href'] );
        }

        return $atts;

    }

    public function activation() {

        $theme = wp_get_theme();
        $theme_name = sanitize_title( $theme->get('Name') );
        $option_name = sprintf( 'utillz_theme_%s_activated', $theme_name );

        if( get_option( $option_name ) !== 'yes' ) {
            update_option( $option_name, 'yes' );
        }

    }

}
