<?php

global $size;

if( has_post_thumbnail() ) {
    $gallery = [
        get_the_post_thumbnail_url( $post->ID, 'ulz_listing' )
    ];
}else{
    $collection = new \UtillzCore\Inc\Src\Collection\Collection();
    $gallery = $collection->get_collection_gallery(1);
}

if( ! $gallery ) {
    $gallery = [ 0 => null ];
}

?>

<div class="ulz--cell">
    <a href="<?php the_permalink(); ?>" class="ulz--item">
        <?php foreach( $gallery as $image ): ?>
            <div class="ulz--image" style="background-image: url('<?php echo esc_url( $image ); ?>');padding-top: <?php echo (int) $size['size']; ?>%;">
                <div class="ulz--content">
                    <span class="ulz--name"><?php the_title(); ?></span>
                </div>
                <?php if( ! $gallery ): ?>
                    <i class="far fa-image"></i>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </a>
</div>
