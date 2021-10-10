<?php

defined('ABSPATH') || exit;

global $post, $ulz_explore;

?>

<div class="ulz-dynamic" data-dynamic="listings">
    <div class="ulz-explore-listings">

        <?php if( $ulz_explore->total_types ): ?>
            <?php if( $ulz_explore->query()->posts->have_posts() ): ?>
                <?php if( $ulz_explore->get_listing_cover_style() == 'auto' ): ?>

                    <div class="ulz-listings-columns">
                        <?php foreach( Ucore()->listing_chunks( $ulz_explore->query()->posts->posts, $ulz_explore->get_explore_columns() ) as $chunk ): ?>
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

                <?php else: ?>

                    <ul class="ulz-listings">
                        <?php $index = 0; ?>
                        <?php while( $ulz_explore->query()->posts->have_posts() ): $ulz_explore->query()->posts->the_post(); ?>
                            <li class="ulz-listing-item <?php Ucore()->listing_class(); ?>"
                                data-index="<?php echo (int) $index++; ?>"
                                data-preview-params='<?php echo Uhance()->get_listing_preview_params( get_the_ID() ); ?>'
                                >
                                <?php Ucore()->the_template('explore/listing/listing'); ?>
                            </li>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </ul>

                <?php endif; ?>

                <?php Ucore()->the_template('explore/paging'); ?>

            <?php else: ?>
                <p><strong><?php esc_html_e( 'No results were found', 'heilz' ); ?></strong></p>
            <?php endif; ?>

        <?php else: ?>
            <h5><?php esc_html_e( 'No listing types were found', 'heilz' ); ?></h5>
        <?php endif; ?>

    </div>
</div>
