<?php

if( Utheme()->get('ulz_hide_heading') ) {
    return;
}

// $title = get_the_title();
$title = single_post_title( '', false );
$post_type = get_post_type();

if( is_category() || is_tag() || is_date() ) {
    $title = get_the_archive_title();
}

if( is_tax() ) {
    $title = single_term_title( '', false );
}

if( is_404() ) {
    $title = 404;
}

if( is_home() ) {
    $title = esc_html__( 'Blog', 'heilz' );
}

if( is_search() ) {
    $title = sprintf( esc_html__( 'Searching for `%s`', 'heilz' ), get_search_query() );
}

if( is_author() ) {
    $author = get_queried_object();
    $title = $author->display_name;
}

if( class_exists( 'WooCommerce' ) && is_shop() ) {
    $title = esc_html__( 'Shop', 'heilz' );
}

if( $custom_title = Utheme()->get('ulz_heading_custom_title') ) {
    $title = esc_html( $custom_title );
}

$row_wide = false;
if( $post_type == 'ulz_collection' ) {
    $row_wide = true;
}

$style = '';
if( $background_color = Utheme()->get('ulz_heading_background_color') ) {
    $style .= sprintf( 'background-color: %s;', $background_color );
}

if( $text_color = Utheme()->get('ulz_heading_text_color') ) {
    $style .= sprintf( 'color: %s;', $text_color );
}

if( $background_image = function_exists('Ucore') && Ucore()->get_first_from_gallery('ulz_heading_background_image', 'original') ) {
    $style .= sprintf( "background-image: url('%s');", $background_image );
}

?>

<?php if( ! Utheme()->get( 'disable_page_title' ) ): ?>
    <header class="ulz-page-title<?php if( $background_image ) { echo ' ulz--has-image'; } ?>" style="<?php echo esc_attr( $style ); ?>">
        <div class="ulz-row <?php echo boolval( $row_wide ) ? 'ulz--xl' : ''; ?>">

            <?php if( $title ): ?>
    	    	<h1 class="ulz--title">
    				<?php echo do_shortcode( $title ); ?>
    	    	</h1>
            <?php endif; ?>

            <?php if( $summary = Utheme()->get('ulz_heading_summary') ): ?>
                <div class="ulz--summary"><?php echo esc_html( $summary ); ?></div>
            <?php endif; ?>

    		<?php get_template_part('templates/breadcrumb'); ?>

        </div>
    </header>
<?php endif; ?>
