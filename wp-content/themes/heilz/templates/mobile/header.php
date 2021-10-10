<div class="ulz-mobile-header">
    <div class="ulz--site-name ulz-font-heading">
        <a href="<?php echo get_home_url(); ?>">
            <?php if( $logo = Utheme()->get_logo() ): ?>
                <div class="ulz--logo">
                    <img src="<?php echo esc_url( $logo ); ?>">
                </div>
            <?php else: ?>
                <span><?php echo esc_html( Utheme()->get_name() ); ?></span>
            <?php endif; ?>
        </a>
    </div>
    <?php if( $primary_search_form = get_option('ulz_primary_search_form') ): ?>
        <div class="ulz--site-search" data-action="mobile-search">
            <a href="#">
                <i class="fas fa-search"></i>
                <span><?php esc_html_e('Search', 'heilz'); ?></span>
            </a>

        </div>
    <?php endif; ?>
</div>

<div class="ulz-search ulz-primary-search ulz-mobile-search">
    <?php echo do_shortcode("[ulz-search-form id='{$primary_search_form}']"); ?>
</div>
