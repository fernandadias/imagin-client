<?php

namespace UtillzTheme\Inc\Utils;

class Helpers {

    use \UtillzTheme\Inc\Src\Traits\Singleton;

    function __construct() {}

    public function sanitize( $data ) {

        if( is_array( $data ) ) {
            foreach( $data as $k => $v ) {
                $data[ $k ] = is_array( $v ) ? $this->sanitize( $v ) : sanitize_text_field( $v );
            }
        }else{
            $data = sanitize_text_field( $data );
        }
        return $data;

    }

    public function get_option( $key, $default = '' ) {

        return get_option( $option_id, $default );

    }

    public function get_theme_option( $key, $default = '' ) {

        if( function_exists('get_field') ) {
            $option = get_field( $key, 'option' );
            return empty( $option ) ? $default : $option;
        }

    }

    public function get( $key, $post_id = 0, $single = true ) {

        return get_post_meta( ( ( (int) $post_id > 0 ) ? $post_id : get_the_ID() ), $key, $single );

    }

    public function child_template_path( $name ) {

        $template_path = sprintf( '%s/templates/%s.php', get_stylesheet_directory(), $name );

        if( file_exists( $template_path ) ) {
            return $template_path;
        }

        return null;

    }

    public function theme_template_path( $name ) {

        $template_path = sprintf( '%s/templates/%s.php', get_template_directory(), $name );

        if( file_exists( $template_path ) ) {
            return $template_path;
        }

        return null;

    }

    public function the_template( $name ) {

        echo ! empty( $name ) ? $this->get_template( $name ) : '';

    }

    public function get_template_path( $name ) {

        // child theme
        if( is_child_theme() && $child_template_path = $this->child_template_path( $name ) ) {
            return $child_template_path;
        }
        // theme
        elseif( $theme_template_path = $this->theme_template_path( $name ) ) {
            return $theme_template_path;
        }

        return null;

    }

    public function get_template( $name ) {

        if( ! $template_path = $this->get_template_path( $name ) ) {
            return;
        }

        if( file_exists( $template_path ) ) {
            ob_start();
            include $template_path;
            return ob_get_clean();
        }

    }

    public function current_page() {

        if ( get_query_var('paged') ) {
	        return get_query_var('paged');
	    }elseif( get_query_var('page') ) {
	        return get_query_var('page');
	    }else{
	        return 1;
	    }

    }

    public function preloader() {
        return '<div class="ulz-preloader ulz-transition"><i></i><i></i></div>';
    }

    public function get_title_tag() {
        return is_front_page() ? 'h1' : 'p';
    }

    public function get_image( $attachment_id, $size = 'ulz_listing' ) {

        $image_attrs = wp_get_attachment_image_src( $attachment_id, $size );

        if( isset( $image_attrs[0] ) ) {
            return $image_attrs[0];
        }

    }

    public function get_logo_image( $logo, $size = 'original' ) {

        $logo = str_replace( '\r\n', "<br>", $logo );
        $logo = json_decode( stripslashes( $logo ), false );

        if( isset( $logo[0] ) && isset( $logo[0]->id ) ) {
            return $this->get_image( $logo[0]->id, $size );
        }

        return;

    }

    public function pagination() {

        global $wp_query;

        $big = 999999999;

        echo paginate_links([
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, $this->current_page() ),
            'total' => $wp_query->max_num_pages,
            'type' => 'list',
            'prev_text' => '<i class="fas fa-angle-left"></i>',
            'next_text' => '<i class="fas fa-angle-right"></i>',
        ]);

    }

    public function dummy(
        $icon,
        $set,
        $height_ratio = null,
        $background_color = null,
        $color = null
    ) {

        $style  = '';
        $style .= $height_ratio ? sprintf( 'padding-top:%s%%;', $height_ratio ) : '';
        $style .= $background_color ? sprintf( 'background-color:%s!important;', $background_color ) : '';
        $style .= $color ? sprintf( 'color:%s;', $color ) : '';

        $icon_html = function_exists('utillz_core') ? utillz_core()->icon->get( $icon, $set ) : '<i class="material-icons">image</i>';

        return sprintf( '<div class="ulz-dummy-image" style="%s">%s</div>', $style, $icon_html );

    }

    public function get_time_elapsed_string( $time ) {

        $etime = time() - $time;

        if ( $etime < 1 ) {
            return '0 seconds';
        }

        $a = [ 365 * 24 * 60 * 60       => esc_html__('year', 'heilz'),
                     30 * 24 * 60 * 60  => esc_html__('month', 'heilz'),
                          24 * 60 * 60  => esc_html__('day', 'heilz'),
                               60 * 60  => esc_html__('hour', 'heilz'),
                                    60  => esc_html__('minute', 'heilz'),
                                     1  => esc_html__('second', 'heilz')
        ];

        $a_plural = [
            'year'      => esc_html__('years', 'heilz'),
            'month'     => esc_html__('months', 'heilz'),
            'day'       => esc_html__('days', 'heilz'),
            'hour'      => esc_html__('hours', 'heilz'),
            'minute'    => esc_html__('minutes', 'heilz'),
            'second'    => esc_html__('seconds', 'heilz')
        ];

        foreach( $a as $secs => $str ) {
            $d = $etime / $secs;
            if( $d >= 1 ) {
                $r = round( $d );
                return $r . ' ' . ( $r > 1 ? $a_plural[ $str ] : $str ) . esc_html__(' ago', 'heilz');
            }
        }
    }

    public function get_post_first_category() {
        $category = get_the_category();
        return isset( $category[0] ) ? $category[0]->cat_name : '';
    }

    public function get_post_first_category_url() {
        $category = get_the_category();
        return isset( $category[0] ) ? get_category_link( $category[0] ) : '#';
    }

    /*
     * heading
     *
     */
    public function get_font_family_heading() {
        return apply_filters('utillz/font/default/family/heading', 'Lexend:wght@700;800');
    }

    public function get_font_selector_heading() {
        return apply_filters('utillz/font/default/selector/heading', 'Lexend');
    }

    /*
     * body
     *
     */
    public function get_font_family_body() {
        return apply_filters('utillz/font/default/family/body', 'Noto+Sans+JP:wght@400;700');
    }

    public function get_font_selector_body() {
        return apply_filters('utillz/font/default/selector/body', 'Noto Sans JP');
    }

    public function get_font_family() {

        $families = [];

        $heading = get_option('ulz_font_heading');
        $families['heading'] = $heading ? esc_attr( $heading ) : $this->get_font_family_heading();

        $body = get_option('ulz_font_body');
        $families['body'] = $body ? esc_attr( $body ) : $this->get_font_family_body();

        return '&family=' . implode( '&family=', $families );

    }

    public function get_google_fonts() {
        return add_query_arg( 'display', 'swap', '//fonts.googleapis.com/css2' ) . $this->get_font_family();
    }

    public function get_name() {
        if( $site_name = get_option('ulz_site_name') ) {
            return $site_name;
        }
        return get_bloginfo('name');
    }

    public function is_dark_header() {

        if( ! is_page() || isset( $_GET['ulz-no-dark'] ) ) {
            return;
        }

        $object_id = get_queried_object_id();

        return boolval( isset( $_GET['ulz-dark'] ) || get_option( 'ulz_enable_dark_header' ) || get_post_meta( $object_id, 'ulz_enable_dark_header', true ) );

    }

    public function get_logo() {

        $logo_type = get_option('ulz_logo_type');
        return $logo_type == 'path' ? get_option('ulz_logo_path') : Utheme()->get_logo_image( get_option('ulz_logo') );

    }

    public function get_logo_white() {

        $logo_type = get_option('ulz_logo_type');
        $logo = $logo_type == 'path' ? get_option('ulz_logo_path_white') : Utheme()->get_logo_image( get_option('ulz_logo_white') );
        return $logo ? $logo : $this->get_logo();

    }

    public function is_elementor( $post_id = 0 ) {

        if( ! class_exists('Elementor\Plugin') ) {
            return;
        }

        if( ! $post_id ) {
            $post_id = get_the_ID();
        }

        return \Elementor\Plugin::$instance->db->is_built_with_elementor( $post_id );

    }

    public function is_wide_page() {

        if( function_exists('Ucore') && Ucore()->is_explore() ) {
            return true;
        }

        return;

    }

    public function set_explore_open() {
        if( function_exists('Ucore') ) {
            Ucore()->set_explore_open();
        }
    }

}
