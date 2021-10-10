<?php

global $ulz_show_tags;

$collection = new \UtillzCore\Inc\Src\Collection\Collection();
$gallery = $collection->get_collection_gallery(3);
$num_gallery = count( $gallery );
$terms = Ucore()->get('ulz_listing_tag', get_the_ID(), false);

if( has_post_thumbnail() ) {
    $num_gallery += 1;
    array_unshift( $gallery, get_the_post_thumbnail_url( $post->ID, 'ulz_listing' ) );
}

?>

<div class="ulz--cell">
    <div class="ulz--item" data-images="<?php echo (int) $num_gallery; ?>">

        <a href="<?php the_permalink(); ?>" class="ulz--gallery">
            <?php $i = 0; foreach( $gallery as $image ): $i++; if( $i > 3 ) { break; } ?>
                <div class="ulz--image" style="background-image: url('<?php echo esc_url( $image ); ?>');"></div>
            <?php endforeach; ?>
            <?php if( $num_gallery < 3 ): ?>
                <?php for( $i = 0; 3 - $num_gallery > $i; $i++ ): ?>
                    <div class="ulz--image">
                        <i class="far fa-image"></i>
                    </div>
                <?php endfor; ?>
            <?php endif; ?>
        </a>

        <div class="ulz--content">
            <a href="<?php the_permalink(); ?>" class="ulz--name"><?php the_title(); ?></a>
        </div>

        <?php if( $ulz_show_tags && $terms ): ?>
            <div class="ulz-listing-tags">
                <ul>
                    <?php foreach( $terms as $key => $term ): ?>
                        <?php if( $key > 5 ): ?>
                            <li><span><i class="fas fa-ellipsis-h"></i></span></li>
                            <?php break; ?>
                        <?php endif; ?>
                        <?php $term_obj = get_term( $term ); ?>
                        <?php if( $term_obj ): ?>
                            <li>
                                <?php if( boolval( get_option('ulz_tax_tag_public') ) ): ?>
                                    <a href="<?php echo esc_url( get_term_link( $term_obj->term_id ) ); ?>">
                                        <?php echo esc_html( $term_obj->name ); ?>
                                    </a>
                                <?php else: ?>
                                    <span>
                                        <?php echo esc_html( $term_obj->name ); ?>
                                    </span>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

    </div>
</div>
