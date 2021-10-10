<?php

if( has_post_thumbnail() ) {
    $gallery = [
        get_the_post_thumbnail_url( $post->ID, 'ulz_listing' )
    ];
}else{
    $collection = new \UtillzCore\Inc\Src\Collection\Collection();
    $gallery = $collection->get_collection_gallery(1);
}

?>

<div class="ulz--cell">
    <a href="<?php the_permalink(); ?>" class="ulz--item" data-images="<?php echo count( $gallery ); ?>">

        <?php if( $gallery ): ?>
            <?php foreach( $gallery as $image ): ?>
                <div class="ulz--image" style="background-image: url('<?php echo esc_url( $image ); ?>');"></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <span class="ulz--name"><?php the_title(); ?></span>

    </a>
</div>
