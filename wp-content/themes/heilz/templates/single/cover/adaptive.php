<?php

defined('ABSPATH') || exit;

global $ulz_listing;

$gallery_attrs = Ucore()->jsoning( 'ulz_gallery', $ulz_listing->id );
$size = [
    'ulz_gallery_large',
    'brk_cover_small',
    'ulz_gallery_large',
];
$gallery = [];

foreach( $gallery_attrs as $image_attrs ) {
    if( isset( $image_attrs->id ) ) {
        if( is_array( $size ) ) {
            $gallery_items = [];
            foreach( $size as $size_item ) {
                if( $image = Ucore()->get_image( $image_attrs->id, $size_item ) ) {
                    $gallery_items[ $size_item ] = $image;
                }
            }
            $gallery[] = $gallery_items;
        }else{
            if( $image = Ucore()->get_image( $image_attrs->id, $size ) ) {
                $gallery[] = $image;
            }
        }
    }
}

$gallery_num = count( $gallery );

?>

<?php if( $gallery && ! empty( $gallery ) ): ?>

    <div class="ulz-cover ulz-cover-adaptive ulz--gallery-lighbox">

        <div class="ulz--images -x<?php echo min( 3, $gallery_num ); ?>">
            <?php foreach( $gallery as $key => $image ): ?>
                <?php if( isset( $image['ulz_gallery_large'] ) ): ?>
                    <a href="#" class="ulz--image" style="background-image: url('<?php echo esc_url( $image['ulz_gallery_large'] ); ?>');"></a>
                <?php endif; ?>
                <?php if( $key >= 2 ) { break; } ?>
            <?php endforeach; ?>
        </div>

        <ul class="ulz-gallery-stack" style="margin:0;list-style:none;">
            <?php foreach( $gallery as $key => $image ): ?>
                <li class="ulz-gallery" data-image="<?php echo esc_url( $image['ulz_gallery_large'] ); ?>"></li>
            <?php endforeach; ?>
        </ul>
        <?php if( count( $gallery ) > 3 ): ?>
            <ul class="ulz-gallery-actions ulz--bottom">
                <li>
                    <a href="#" data-action="expand-gallery">
                        <i class="material-icons">collections</i>
                        <span><?php echo sprintf( esc_html__( '+%s', 'heilz' ), count( $gallery ) - 3 ); ?></span>
                    </a>
                </li>
            </ul>
        <?php endif; ?>

    </div> <!-- cover -->

<?php endif; ?>
