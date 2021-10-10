<?php

$has_footer = true;
if( function_exists('is_account_page') && is_account_page() ) {
    $has_footer = false;
}

if( function_exists('Ucore') && Ucore()->is_submission() ) {
    $has_footer = false;
}

if( function_exists('Ucore') && Ucore()->get('ulz_hide_footer') ) {
    $has_footer = false;
}

$footer_columns = max( 3, min( 6, (int) get_option('ulz_footer_columns') ) );

?>

<?php if( $has_footer ): ?>
    <div class="ulz-footer<?php if( get_option('ulz_enable_dark_footer') ) { echo ' ulz--dark'; } ?>">

        <?php if( is_active_sidebar('footer-top') ): ?>
            <div class="ulz--top">
                <div class="ulz-row">
                    <div class="ulz--widgets">
                        <?php dynamic_sidebar('footer-top'); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php

            if( ! $footer_columns = (int) get_option('ulz_footer_columns') ) {
                $footer_columns = 4;
            }

            $is_active = false;
            for( $i = 1; $i <= $footer_columns; $i++ ) {
                if( is_active_sidebar( sprintf( 'footer-%s', $i ) ) ) {
                    $is_active = true;
                    break;
                }
            }

        ?>

        <?php if( $is_active ): ?>
            <div class="ulz--content" data-cols="<?php echo (int) $footer_columns; ?>">
                <div class="ulz-row<?php if( Utheme()->is_wide_page() ) { echo ' ulz--xl'; } ?>">
                    <div class="ulz--columns">

                        <?php for( $i = 1; $i <= $footer_columns; $i++ ): ?>
                            <div class="ulz--cell">
                                <?php dynamic_sidebar( sprintf( 'footer-%s', $i ) ); ?>
                            </div>
                        <?php endfor; ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php $footer_copy = get_option( 'ulz_footer_copy' ); ?>
        <?php if( empty( $footer_copy ) ) { $footer_copy = esc_html( get_bloginfo('description') ); } ?>
        <?php if( ! empty( $footer_copy ) ): ?>
            <div class="ulz--bottom">
                <div class="ulz-row<?php if( Utheme()->is_wide_page() ) { echo ' ulz--xl'; } ?>">
                    <div class="ulz--bottom-inner">
                        <div class="ulz--cell-copy">
                            <p><?php echo do_shortcode( stripslashes( $footer_copy ) ); ?></p>
                        </div>
                        <?php if( has_nav_menu('bottom') ): ?>
                            <div class="ulz-site-nav">
                                <nav class="ulz-nav-bottom">
                                    <?php
                                        wp_nav_menu([
                                            'theme_location' => 'bottom',
                                            'container' => false,
                                            'depth' => 1
                                        ]);
                                    ?>
                                </nav>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
<?php endif; ?>

</div> <!-- end .site -->

<?php if( function_exists('Ucore') ): ?>
    <?php Utheme()->the_template('modals/gallery/content'); ?>
<?php endif; ?>

<?php if( ! ( function_exists('Ucore') && Ucore()->is_submission() ) ): ?>
    <?php Utheme()->the_template('mobile/bar'); ?>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
