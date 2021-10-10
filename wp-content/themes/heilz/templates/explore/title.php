<?php

    defined('ABSPATH') || exit;

    global $ulz_explore;

    $post_type = get_post_type();

    // custom taxonomies
    $is_custom_term = false;
    $custom_taxonomies = Ucore()->get_custom_taxonomies();
    if( is_array( $custom_taxonomies ) ) {
        foreach( $custom_taxonomies as $custom_taxonomy ) {
            if( is_tax( Ucore()->prefix( $custom_taxonomy->slug ) ) ) {
                $is_custom_term = true;
            }
        }
    }

    if(
        $is_custom_term or
        is_tax('ulz_listing_tag') or
        is_tax('ulz_listing_region') or
        is_tax('ulz_listing_category')
    ) {
        $title = single_term_title( '', false );
    }elseif( $post_type == 'ulz_collection' ) {
        $title = get_the_title();
    }else{

        $term = null;
        $has_more = null;
        $title = apply_filters('utillz/explore/global/title', esc_html__( 'Explore', 'heilz') );

        if( $ulz_explore->type && $ulz_explore->type->id ) {

            $title = $ulz_explore->type->get('ulz_name_plural');

            $fields = Ucore()->json_decode( $ulz_explore->type->get('ulz_fields') );
            foreach( $fields as $field ) {
                if( $field->template->id == 'taxonomy' ) {
                    if( ! $ulz_explore->request->is_empty( Ucore()->unprefix( $field->fields->key ) ) ) {

                        $term_value = $ulz_explore->request->get( Ucore()->unprefix( $field->fields->key ) );
                        $term_name = Ucore()->prefix( $field->fields->key );

                        if( is_array( $term_value ) ) {
                            $has_more = true;
                            $term_value = reset( $term_value );
                        }

                        $term = get_term_by( 'slug', $term_value, $term_name );

                        if( $term ) {
                            $title = $term->name;
                        }

                    }
                }
            }
        }
    }

    if( $custom_title = Ucore()->get('ulz_heading_custom_title') ) {
        $title = esc_html( $custom_title );
    }

    $style = '';
    if( $background_color = Ucore()->get('ulz_heading_background_color') ) {
        $style .= sprintf( 'background-color: %s;', $background_color );
        $style .= 'margin-bottom: 3rem;';
    }

    if( $text_color = Ucore()->get('ulz_heading_text_color') ) {
        $style .= sprintf( 'color: %s;', $text_color );
    }

    if( $background_image = Ucore()->get_first_from_gallery('ulz_heading_background_image', 'original') ) {
        $style .= sprintf( "background-image: url('%s');", $background_image );
        $style .= 'margin-bottom: 3rem;';
    }

    $summary = Ucore()->get('ulz_heading_summary');
    if( is_tax() ) {
        $summary = term_description();
    }

?>

<?php if( $title ): ?>
    <div class="ulz-dynamic" data-dynamic="title">
        <header class="ulz-page-title ulz-explore-title<?php if( $background_image ) { echo ' ulz--has-image'; } ?>" style="<?php echo esc_attr( $style ); ?>">
            <div class="ulz-row">

                <h1 class="ulz--title">
                    <?php echo esc_html( $title ); ?>
                </h1>

                <?php if( $summary ): ?>
                    <div class="ulz--summary"><?php echo wp_kses_post( wpautop( $summary ) ); ?></div>
                <?php endif; ?>

                <?php if( $tags = Ucore()->get('ulz_listing_tag', get_the_ID(), false ) ): ?>
                    <div class="ulz-listing-tags">
                        <ul>
                            <?php foreach( $tags as $tag_id ): ?>
                                <?php $term = get_term( $tag_id, 'ulz_listing_tag' ); ?>
                                <?php if( $term ): ?>
                                    <li><a href="<?php echo get_term_link( $term ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php get_template_part('templates/breadcrumb'); ?>

            </div>
        </header>
    </div>
<?php endif; ?>
