<div class="ulz--cell">
    <article class="ulz--item<?php echo is_sticky() ? ' ulz--sticky' : ''; ?>">

        <?php if( has_post_thumbnail() ): ?>
            <a href="<?php the_permalink(); ?>" class="ulz--image">
                <?php $image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'ulz_listing' ); ?>
                <div class="ulz--img" style="background-image: url(<?php echo esc_url( $image_src[0] ); ?>);"></div>
            </a>
        <?php endif; ?>

        <div class="ulz--content">

            <div class="ulz--meta">
                <?php $category = Utheme()->get_post_first_category(); ?>
                <?php if( $category ): ?>
                    <div class="ulz--meta-cell">
                        <a href="<?php echo esc_url( Utheme()->get_post_first_category_url() ); ?>" class="ulz--category">
                            <span><?php echo esc_html( $category ); ?></span>
                        </a>
                    </div>
                <?php endif; ?>
                <div class="ulz--meta-cell">
                    <div class="ulz--date">
                        <?php echo esc_html( get_the_date() ); // get_time_elapsed_string ?>
                    </div>
                </div>
            </div>

            <?php if( get_the_title() !== '' ): ?>
                <h5 class="ulz--title">
                    <a class="ulz--name" href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h5>
            <?php endif; ?>

            <div class="ulz--excerpt">
                <p>
                    <?php echo wp_trim_words( get_the_excerpt(), 15 ); ?>
                <p>
            </div>

            <p class="ulz--more">
                <a href="<?php the_permalink(); ?>">
                    <?php esc_html_e( 'Continue reading', 'heilz' ); ?>
                </a>
            </p>

        </div>
    </article>
</div>
