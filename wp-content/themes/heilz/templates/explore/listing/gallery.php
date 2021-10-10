<?php

use \UtillzCore\Inc\Src\User;

defined('ABSPATH') || exit;

global $ulz_explore, $ulz_listing, $ulz_listing_style;

$cover_type = $ulz_listing->type->get('ulz_listing_cover_type');
$cover_style = ! empty( $ulz_listing_style ) ? $ulz_listing_style : $ulz_explore->get_listing_cover_style();
$gallery_size = 'heilz_listing';
$gallery = $ulz_listing->get_gallery( $gallery_size );
$video = Ucore()->get('ulz_video');

$style = '';


?>

<div class="ulz-listing-image">

    <?php

        /*
         * video
         *
         */
        if( $video ):

    ?>

        <?php

            $video = Ucore()->get_first_array_upload( Ucore()->jsoning('ulz_video') );
            $video_metadata = wp_get_attachment_metadata( $video );

            if( $cover_style == 'auto' ) {
                $ratio = 0;
                if( isset( $video_metadata['width'] ) && isset( $video_metadata['height'] ) ) {
                    $ratio = ( $video_metadata['height'] / $video_metadata['width'] ) * 100;
                }

                if( $ratio ) {
                    $style .= sprintf('padding-top: %s%%;', $ratio);
                }
            }

        ?>

        <a href="<?php echo get_permalink(); ?>" class="ulz-image ulz--is-video" style="<?php echo esc_attr( $style ); ?>" <?php Utheme()->set_explore_open(); ?>>
            <video class="ulz--video" loop muted autoplay data-observed="true" poster="<?php if( isset( $gallery[0] ) ) { echo esc_url( $gallery[0] ); } ?>">
                <source src="<?php echo esc_url( wp_get_attachment_url( $video ) ); ?>" type="video/mp4">
            </video>
            <span class="ulz-listing-overlay"></span>
            <i class="fas fa-play"></i>
        </a>

    <?php

        /*
         * gallery
         *
         */

        else:

    ?>

        <?php if( isset( $gallery[0] ) ): ?>

            <?php

                $image_id = Ucore()->get_first_array_upload( Ucore()->jsoning( 'ulz_gallery' ) );
                $image_source = wp_get_attachment_image_src( $image_id, $gallery_size );

                if( $cover_style == 'auto' ) {
                    $ratio = 0;
                    if( isset( $image_source[1] ) && isset( $image_source[2] ) ) {
                        $ratio = ( $image_source[2] / $image_source[1] ) * 100;
                    }

                    if( $ratio ) {
                        $style .= sprintf('padding-top: %s%%;', $ratio);
                    }
                }

                if( $image_dominant_color = Ucore()->get('dominant_color_hex', $image_id, true) ) {
                    $style .= sprintf("background-color: %s;", esc_attr( $image_dominant_color ));
                }

            ?>

            <a href="<?php echo get_permalink(); ?>" class="ulz-image" style="<?php echo esc_attr( $style ); ?>" <?php Utheme()->set_explore_open(); ?>>
                <span class="ulz--img" data-image="<?php echo esc_url( $gallery[0] ); ?>"></span>
                <span class="ulz-listing-overlay"></span>
            </a>

            <?php if( count( $gallery ) > 1 && $cover_type == 'slider' ): ?>
                <div class="ulz-listing-gallery">
                    <?php foreach( $gallery as $key => $image ): ?>
                        <?php
                            $style = $attr = '';
                            if( $key == 0 ) {
                                $style = 'opacity:1;background-image:url(\'' . esc_url( $image ) . '\');';
                            }else{
                                $attr = 'data-image="' . esc_url( $image ) . '"';
                            }
                        ?>
                        <a href="<?php echo get_permalink(); ?>" class="ulz-listing-gallery-item" style="<?php echo esc_attr( $style ); ?>" <?php echo esc_attr( $attr ); ?> <?php Ucore()->set_explore_open(); ?>></a>
                    <?php endforeach; ?>
                </div>
                <a href="#" class="ulz-slider-nav ulz-nav-prev"><span><i class="material-icons">arrow_back</i></span></a>
                <a href="#" class="ulz-slider-nav ulz-nav-next"><span><i class="material-icons">arrow_forward</i></span></a>
            <?php endif; ?>

        <?php else: ?>

            <a href="<?php echo get_permalink(); ?>" <?php Utheme()->set_explore_open(); ?>>
                <?php echo Ucore()->dummy('far fa-image', 'font-awesome'); ?>
            </a>

        <?php endif; ?>
    <?php endif; ?>

</div>

<div class="ulz--action">
    <div class="ulz--author">
        <?php if( $ulz_listing->post ): ?>
            <div class="ulz-cover-author">

                <?php if( $ulz_listing->post ): ?>
                    <?php
                        $user = new \UtillzCore\Inc\Src\User( $ulz_listing->post->post_author );
                        $userdata = get_userdata( $user->id );
                    ?>
                    <div class="ulz--image">
                        <a href="<?php echo get_author_posts_url( $user->id ); ?>" target="_blank">
                            <?php $user->the_avatar(); ?>
                        </a>
                    </div>
                    <div class="ulz--heading">
                        <a href="#" class="ulz--title ulz-ellipsis" target="_blank" data-replace="url">
                            <span data-replace="title"></span>
                        </a>
                        <a href="<?php echo get_author_posts_url( $user->id ); ?>" class="ulz--author-name ulz-ellipsis" target="_blank">
                            <span><?php echo sprintf( esc_html__( 'By %s', 'heilz' ), $userdata->display_name ); ?></span>
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>
    </div>
    <div class="ulz--download">
        <a href="<?php echo get_permalink(); ?>" <?php Utheme()->set_explore_open(); ?>>
            <i class="material-icons">arrow_downward</i>
        </a>
    </div>
</div>
