<?php

defined('ABSPATH') || exit;

global $ulz_listing;

$action_type = $ulz_listing->type->get_action_type('download');

?>

<div class="ulz-cover-top">
    <div class="ulz-relative<?php if( is_single() ) { echo ' ulz-row'; } ?>">
        <div class="ulz--inner">
            <div class="ulz--cell-author">
                <div class="ulz--author" data-replace="author">
                    <?php if( $ulz_listing->post ): ?>
                        <?php
                            $user = new \UtillzCore\Inc\Src\User( $ulz_listing->post->post_author );
                            if( ! $user->id ) {
                                return;
                            }
                            $userdata = get_userdata( $user->id );
                        ?>
                        <div class="ulz--image">
                            <a href="<?php echo get_author_posts_url( $user->id ); ?>" target="_blank">
                                <?php $user->the_avatar(); ?>
                            </a>
                        </div>
                        <div class="ulz--heading">
                            <a href="<?php the_permalink(); ?>" class="ulz--title ulz-ellipsis ulz--hide-lt-xs" target="_blank" data-replace="url">
                                <span data-replace="title"><?php the_title(); ?></span>
                            </a>
                            <a href="<?php echo get_author_posts_url( $user->id ); ?>" class="ulz--author-name ulz-ellipsis" target="_blank">
                                <span><?php echo sprintf( esc_html__( 'By %s', 'heilz' ), $userdata->display_name ); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="ulz--cell-action">

                <div class="ulz--hide-lt-sm">
                    <a href="<?php the_permalink(); ?>" target="_blank" data-replace="url">
                        <span><i class="material-icons">article</i></span>
                    </a>
                </div>

                <?php if( get_option('ulz_enable_share') ): ?>
                    <div>
                        <a href="#" class="" data-action="share">
                            <span class="ulz--hide-gt-sm"><i class="material-icons">ios_share</i></span>
                            <span class="ulz--hide-lt-sm"><?php esc_html_e( 'Share', 'heilz' ); ?></span>
                        </a>
                    </div>
                <?php endif; ?>

                <?php if( $has_favorite = $ulz_listing->type->get( 'ulz_display_listing_favorite' ) ): ?>
                    <?php

                        $user_favorites = get_user_meta( get_current_user_id(), 'ulz_favorites', true );
                        if( ! is_array( $user_favorites ) ) {
                            $user_favorites = [];
                        }

                        $is_favorite = in_array( get_the_ID(), $user_favorites );

                    ?>
                    <div>
                        <a class="<?php if( is_user_logged_in() && $is_favorite ) { echo 'ulz--active'; } ?>" href="#" <?php if( is_user_logged_in() ) { echo 'data-action="add-favorite"'; }else{ echo 'data-modal="signin"'; } ?> data-id="<?php the_ID(); ?>" data-replace="favorite-id">
                            <span><i class="material-icons">bookmark</i></span>
                        </a>
                    </div>
                <?php endif; ?>

                <?php if( $action_type ): ?>
                    <div>
                        <a href="#" class="ulz--active" data-action="download-toggle">
                            <span class="ulz--hide-lt-sm"><?php esc_html_e('Download', 'heilz'); ?></span>
                            <i class="material-icons">downloading</i>
                        </a>
                    </div>
                <?php endif; ?>

                <?php if( ! is_single() ): ?>
                    <div>
                        <a href="#" data-action="preview-close">
                            <span><i class="material-icons">close</i></span>
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <?php

        /*
         * the gallery cover type will adopt any download action type
         *
         */
        if( $action_type ): ?>
            <div class="ulz-npanel ulz-dpanel">
                <div class="ulz--header">
                    <span class="ulz--title">
                        <?php esc_html_e( 'Download', 'heilz' ); ?>
                    </span>
                    <a href="#" class="ulz-close" data-action="panel-close">
                        <span><?php esc_html_e('Close', 'heilz'); ?></span>
                    </a>
                </div>
                <div class="ulz--list ulz-scrollbar">
                    <?php Ucore()->the_template('modals/skeleton'); ?>
                    <div data-action="append">
                        <!-- append -->
                    </div>
                </div>
                <div class="ulz--footer">
                    <a href="#" class="ulz-button ulz--large" data-action="download-process">
                        <span><?php esc_html_e( 'Download', 'heilz' ); ?></span>
                        <?php Ucore()->preloader(); ?>
                    </a>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>
