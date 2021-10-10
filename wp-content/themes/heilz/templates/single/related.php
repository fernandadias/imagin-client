<?php

global $ulz_listing, $ulz_nearby_post_ids, $ulz_show_tags;
$ulz_listing = new \UtillzCore\Inc\Src\Listing\Listing( get_the_ID() );
$ulz_show_tags = true;

if( ! $ulz_listing->type ) {
    return;
}

if( $ulz_listing->type->get('ulz_enable_related') ):

    global $post, $ulz_listing_style;

    $related = new UtillzCore\Inc\Src\Listing\Related( $ulz_listing->id );
    $related->set_posts_per_page( $ulz_listing->type->get('ulz_related_posts_per_page') );
    $listings = $related->query();

    $ulz_listing_style = 'auto';

    ?>

    <div class="ulz-mod-listing">
        <div class="ulz-mod-content">
            <h4><?php esc_html_e( 'Related', 'heilz' ); ?></h4>
            <?php if( $listings->have_posts() ): ?>
                <div class="ulz-explore-listings">
                    <div class="ulz-listings-columns" data-chunks="3">
                        <?php foreach( Ucore()->listing_chunks( $listings->posts, 3 ) as $chunk ): ?>
                            <div class="ulz-listings-column">
                                <ul class="ulz-listings">
                                    <?php foreach( $chunk as $item ): $post = $item->post; setup_postdata( $post ); ?>
                                        <li class="ulz-listing-item <?php Ucore()->listing_class(); ?>"
                                            data-index="<?php echo (int) $item->index; ?>"
                                            <?php if( function_exists('Uhance') ): ?>
                                                data-preview-params='<?php echo Uhance()->get_listing_preview_params( get_the_ID() ); ?>'
                                            <?php endif; ?>
                                            >
                                            <?php Ucore()->the_template('explore/listing/listing'); ?>
                                        </li>
                                    <?php endforeach; wp_reset_postdata(); ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <p class="ulz-mb-0"><?php esc_html_e( 'No related items were found', 'heilz' ); ?></p>
            <?php endif; ?>
        </div>
    </div>

<?php endif;

if( function_exists('Uhance') && $ulz_listing->type->get('ulz_enable_related_collections') ):

    $related_id = null;
    $queried_object = get_queried_object();
    if( $queried_object ) {
        $related_id = $queried_object->ID;
    }
    $related_collections = new UtillzEnhance\Inc\Src\Listing\Related_Collections( $related_id );
    $related_collections->set_posts_per_page( max( 1, (int) $ulz_listing->type->get('ulz_related_collections_posts_per_page') ) );
    $collections = $related_collections->query();

    ?>

    <div class="ulz-mod-listing">
        <div class="ulz-mod-content">
            <h4><?php esc_html_e( 'Collections', 'heilz' ); ?></h4>
            <?php if( $collections->have_posts() ): ?>
                <div class="ulz-collections ulz-collections--stack">
                    <div class="ulz--inner">
                        <?php while ( $collections->have_posts() ): $collections->the_post(); ?>
                            <?php get_template_part( 'templates/collection', 'stack' ); ?>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>
            <?php else: ?>
                <p><?php esc_html_e( 'No collections were found', 'heilz' ); ?></p>
            <?php endif; ?>

        </div>
    </div>

<?php endif;
