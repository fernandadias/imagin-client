<?php

defined('ABSPATH') || exit;

global $ulz_listing;

?>

<div class="ulz-single-heading">
    <div class="ulz--cell-author">
        <div class="ulz--author">
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
                    <a href="<?php the_permalink(); ?>" class="ulz--title ulz-ellipsis" target="_blank" data-replace="url">
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

        <?php if( get_option('ulz_enable_share') ): ?>
            <div>
                <a href="#" class="" data-action="share">
                    <?php esc_html_e( 'Share', 'heilz' ); ?>
                </a>
            </div>
        <?php endif; ?>

        <?php if( $ulz_listing->type->get('ulz_display_listing_favorite') ): ?>
            <?php

                $user_favorites = get_user_meta( get_current_user_id(), 'ulz_favorites', true );
                if( ! is_array( $user_favorites ) ) {
                    $user_favorites = [];
                }

                $is_favorite = in_array( get_the_ID(), $user_favorites );

            ?>
            <div>
                <a class="<?php if( is_user_logged_in() && $is_favorite ) { echo 'ulz--active'; } ?>" href="#" <?php if( is_user_logged_in() ) { echo 'data-action="add-favorite"'; }else{ echo 'data-modal="signin"'; } ?> data-id="<?php the_ID(); ?>" data-replace="favorite-id">
                    <i class="material-icons">bookmark</i>
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>
