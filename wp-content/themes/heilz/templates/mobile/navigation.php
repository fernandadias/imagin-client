<?php

use \UtillzCore\Inc\Src\User;

?>

<div class="ulz-mobile-nav">
    <div class="ulz--header">
        <div class="ulz-site-logo">
            <a href="<?php echo get_home_url(); ?>">
                <?php if( $logo = Utheme()->get_logo() ): ?>
                    <img src="<?php echo esc_url( $logo ); ?>">
                <?php else: ?>
                    <span class="ulz-site-title ulz-font-heading">
                        <?php echo esc_html( Utheme()->get_name() ); ?>
                    </span>
                <?php endif; ?>
            </a>
        </div>
    </div>
    <div class="ulz--nav">
        <?php if( has_nav_menu('mobile') ): ?>
            <nav class="ulz-nav-mobile">
                <?php
                    wp_nav_menu([
                        'theme_location' => 'mobile',
                        'container' => false
                    ]);
                ?>
            </nav>
        <?php else: ?>
            <p class="ulz-no-nav"><strong><?php esc_html_e( 'Select menu by going to Admin > Appearance > Menus', 'heilz' ); ?></strong></p>
        <?php endif; ?>
    </div>
    <div class="ulz--footer">
        <?php if( function_exists('Ucore') && is_user_logged_in() ): ?>
            <?php $user = new User( get_current_user_id() ); ?>
            <?php $userdata = get_userdata( $user->id ); ?>
            <div class="ulz--avatar">
                <a href="<?php echo class_exists( 'WooCommerce' ) ? esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) : '#'; ?>">
                    <?php $user->avatar(); ?>
                </a>
            </div>
            <div class="ulz--meta">
                <span class="ulz-ellipsis">
                    <a href="<?php echo class_exists( 'WooCommerce' ) ? esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) : '#'; ?>">
                        <?php echo esc_html( $userdata->display_name ); ?>
                    </a>
                </span>
                <a class="ulz-ellipsis" href="<?php echo class_exists( 'WooCommerce' ) ? esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) : '#'; ?>">
                    <?php esc_html_e( 'Show profile', 'heilz' ); ?>
                </a>
            </div>
        <?php endif; ?>
        <div class="ulz--actions">
            <?php if( is_user_logged_in() ): ?>
                <a href="<?php echo esc_url( wp_logout_url( get_home_url() ) ); ?>" class="ulz--sign-out">
                    <i class="material-icons">logout</i>
                </a>
            <?php endif; ?>
            <a href="#" class="ulz--close" data-action="toggle-mobile-nav">
                <?php esc_html_e( 'Close', 'heilz' ); ?>
            </a>
        </div>
    </div>
</div>
