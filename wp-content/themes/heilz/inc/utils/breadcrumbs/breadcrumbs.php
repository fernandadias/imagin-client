<?php

namespace UtillzTheme\Inc\Utils\Breadcrumbs;

class Breadcrumbs {

    use \UtillzTheme\Inc\Src\Traits\Singleton;

    public $post_type;

    function __construct() {
        $this->post_type = get_post_type();
    }

    public function get() {
        echo sprintf( '<ul>%s</ul>', $this->links() );
    }

    public function links() {

        global $post;

        $page_explore = get_option('ulz_page_explore');
        $page_collections = get_option('ulz_page_collections');
        $post_type = get_post_type();

        ob_start();

        echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__('Home', 'heilz') . '</a></li>';

        switch( true ) {
                case wp_doing_ajax():
                if( $page_explore ) {
                    echo sprintf( '<li><span>%s</span></li>', get_the_title( $page_explore ) );
                }
            break;
            case is_category():
                echo sprintf( '<li><span>%s</span></li>', get_the_archive_title() );
                break;
            case $post_type == 'ulz_collection':
                if( $page_explore ) {
                    echo sprintf( '<li><a href="%s">%s</a></li>', get_the_permalink( $page_explore ), get_the_title( $page_explore ) );
                }
                if( $page_collections ) {
                    echo sprintf( '<li><a href="%s">%s</a></li>', get_the_permalink( $page_collections ), get_the_title( $page_collections ) );
                }
                echo sprintf( '<li><span>%s</span></li>', get_the_title() );
                break;
            case is_tax('ulz_listing_tag'):
                if( $page_explore ) {
                    echo sprintf( '<li><a href="%s">%s</a></li>', get_the_permalink( $page_explore ), get_the_title( $page_explore ) );
                }
                echo sprintf( '<li><span>%s</span></li>', single_term_title( '', false ) );
                break;
            case is_tax():
                echo sprintf( '<li><span>%s</span></li>', single_term_title( '', false ) );
                break;
            case is_404():
                echo '<li><span>404</span></li>';
                break;
            case is_home():
                echo sprintf( '<li><span>%s</span></li>', esc_html__( 'Blog', 'heilz' ) );
                break;
            case is_search():
                echo sprintf( '<li><span>%s</span></li>', get_search_query() );
                break;
            case is_author():
                $author = get_queried_object();
                echo sprintf( '<li><span>%s</span></li>', $author->display_name );
                break;
            case is_single():
                if( $post->post_type == 'post' ) {
                    echo '<li>';
                    $categories = wp_get_post_categories( get_the_ID() );
                    foreach( $categories as $k => $category ) {
                        $category_obj = get_category( $category );
                        echo '<a href="' . esc_url( get_category_link( $category_obj ) ) . '">' . esc_html( $category_obj->name ) . '</a>';
                        if( count( $categories ) > $k + 1 ) {
                            echo ', ';
                        }
                    }
                    echo '</li>';
                }
                if( $title = get_the_title() ) {
                    echo sprintf( '<li><span>%s</span></li>', $title );
                }
                break;
            case is_page():
                if( $page_explore && $page_collections == get_the_ID() ) {
                    echo sprintf( '<li><a href="%s">%s</a></li>', get_the_permalink( $page_explore ), get_the_title( $page_explore ) );
                }
                if( $post->post_parent ) {
                    echo sprintf( '<li><a href="%s">%s</a></li>', get_permalink( $post->post_parent ), get_the_title( $post->post_parent ) );
                }
                if( $title = get_the_title() ) {
                    echo sprintf( '<li><span>%s</span></li>', $title );
                }
                break;
            case is_tag():
                echo sprintf( '<li><span>%s</span></li>', single_tag_title( '', false ) );
                break;
            case class_exists( 'WooCommerce' ) && is_shop():
                echo sprintf( '<li><span>%s</span></li>', esc_html__( 'Shop', 'heilz' ) );
                break;

        }

        return ob_get_clean();

    }

}
