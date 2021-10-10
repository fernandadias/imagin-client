<?php

defined('ABSPATH') || exit;

global $ulz_listing;

$gallery = $ulz_listing->get_gallery('ulz_gallery_large');
$video = Ucore()->get('ulz_video');

?>

<?php if( $gallery || $video ): ?>

    <div class="ulz-cover ulz-cover-gallery">

        <?php Utheme()->the_template('single/cover/top'); ?>

        <div class="ulz--asset">

            <?php

            /*
             * video — embed code
             *
             */
            /*if( $video_embed ): ?>

                <div class="ulz--embed x16x9">
                    <?php echo do_shortcode( $video_embed ); ?>
                </div>

            <?php */

            /*
             * video
             *
             */
            if( $video ): ?>

                <?php

                    $video = Ucore()->get_first_array_upload( Ucore()->jsoning('ulz_video') );

                    $video_background = '';
                    if( isset( $gallery[0] ) ) {
                        $video_background .= sprintf( "background-image: url('%s');", esc_url( $gallery[0] ) );
                    }

                ?>

                <?php if( isset( $gallery[0] ) ): ?>
                    <img src="<?php echo esc_url( $gallery[0] ); ?>" alt="<?php echo sanitize_title( $ulz_listing->post->post_title); ?>" data-replace="image">
                <?php endif; ?>
                <video class="ulz--video" loop muted autoplay data-observed="true" poster="<?php echo esc_url( $video_background ); ?>">
                    <source src="<?php echo esc_url( wp_get_attachment_url( $video ) ); ?>" type="video/mp4">
                </video>

            <?php

            /*
             * image
             *
             */
            else: ?>

                <?php foreach( $gallery as $key => $image ): ?>
                    <div class="ulz--image">
                        <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo sanitize_title( $ulz_listing->post->post_title); ?>" data-replace="image">
                    </div>
                    <?php if( $key > 1 ) { break; } ?>
                <?php endforeach; ?>

            <?php endif; ?>

        </div>

    </div> <!-- ulz-cover -->

<?php endif; ?>
