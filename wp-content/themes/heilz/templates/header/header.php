<?php

global $current_user;

?>

<header class="ulz-header">
    <div class="ulz-row<?php if( Utheme()->is_wide_page() ) { echo ' ulz--xl'; } ?>">
        <div class="ulz-site-header">
            <div class="ulz-header-container">
                <div class="ulz-site-logo">
                    <a href="<?php echo get_home_url(); ?>">
                        <?php if( $logo = Utheme()->get_logo() ): ?>
                            <img src="<?php echo esc_url( $logo ); ?>">
                            <?php if( $logo_white = Utheme()->get_logo_white() ): ?>
                                <div class="ulz--white">
                                    <img src="<?php echo esc_url( $logo_white ); ?>">
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php $tag = Utheme()->get_title_tag(); ?>
                            <<?php echo esc_html( $tag ); ?> class="ulz-site-title ulz-font-heading">
                                <?php echo esc_html( Utheme()->get_name() ); ?>
                            </<?php echo esc_html( $tag ); ?>>
                        <?php endif; ?>
                    </a>
                </div>

                <?php if( $primary_search_form = get_option('ulz_primary_search_form') ): ?>
                    <div class="ulz-site-search">
                        <div class="ulz-search ulz-primary-search">
                            <?php echo do_shortcode("[ulz-search-form id='{$primary_search_form}']"); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="ulz-site-nav">
                    <div class="ulz--inner">
                        <div class="ulz-navigation ulz--primary">
                            <?php if( has_nav_menu('primary') ): ?>
                                <nav class="ulz-nav">
                                    <?php
                                        wp_nav_menu([
                                            'theme_location' => 'primary',
                                            'container' => false,
                                            'walker' => new \UtillzTheme\Inc\Src\Menu_Walker(),
                                        ]);
                                    ?>
                                </nav>
                            <?php else: ?>
                                <p><?php esc_html_e('Select menu by going to Admin > Appearance > Menus', 'heilz'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="ulz-site-actions">

                    <?php if( function_exists('utillz_core') && is_user_logged_in() ): ?>
                        <?php $active_site = utillz_core()->notify->get_active_site(); ?>
                        <div class="ulz-site-notifications">
                            <a href="#" class="ulz-site-icon<?php if( $active_site ) { echo ' ulz--active'; } ?>" data-action="notifications-toggle">
                                <span class="ulz--icon">
                                    <?php if( $active_site ): ?>
                                        <span><?php echo (int) $active_site; ?></span>
                                    <?php else: ?>
                                        <i class="material-icons">notification_important</i>
                                    <?php endif; ?>
                                </span>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if( class_exists('woocommerce') && (int) WC()->cart->get_cart_contents_count() > 0 ): ?>
                        <?php global $woocommerce; ?>
                        <div class="ulz-site-cart">
                            <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="ulz-site-icon">
                                <span class="ulz--icon">
                                    <i class="material-icons">shopping_basket</i>
                                </span>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if( function_exists('Ucore') ): ?>
                        <div class="ulz-site-user">
                            <?php if( ! is_user_logged_in() ): ?>
                                <a href="#" class="ulz-site-icon" data-modal="signin">
                                    <span class="ulz--icon">
                                        <i class="material-icons">lock</i>
                                    </span>
                                    <span class="ulz--text"><?php esc_html_e( 'Sign in', 'heilz' ); ?></span>
                                </a>
                            <?php else: ?>
                                <a href="#" class="ulz-site-icon" data-action="user-actions">
                                    <?php $user = new \UtillzCore\Inc\Src\User( get_current_user_id() ); ?>
                                    <?php $user_avatar = $user->get_avatar(); ?>
                                    <?php if( $user_avatar ): ?>
                                        <img src="<?php echo esc_url( $user_avatar ); ?>" alt="<?php echo esc_attr( $current_user->display_name ); ?>">
                                    <?php else: ?>
                                        <span class="ulz--icon">
                                            <i class="material-icons">person</i>
                                        </span>
                                    <?php endif; ?>
                                    <span class="ulz--text"><?php echo esc_html( $current_user->display_name ); ?></span>
                                </a>

                                <div class="ulz-upanel">
                                    <ul>
                                        <?php if( class_exists('woocommerce') && get_option('woocommerce_myaccount_page_id') ): ?>
                                            <li>
                                                <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>">
                                                    <i class="material-icons">dashboard</i>
                                                    <span><?php esc_html_e('Dashboard', 'heilz'); ?></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo esc_url( wc_get_account_endpoint_url('messages') ); ?>">
                                                    <i class="material-icons">chat</i>
                                                    <span><?php esc_html_e('Messages', 'heilz'); ?></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo esc_url( wc_get_account_endpoint_url('entries') ); ?>">
                                                    <i class="material-icons">add_circle</i>
                                                    <span><?php esc_html_e('Entries', 'heilz'); ?></span>
                                                </a>
                                            </li>
                                            <?php if( get_option('ulz_enable_dropdown_favorites') ): ?>
                                                <li>
                                                    <a href="#" data-modal="favorites">
                                                        <i class="material-icons">favorite</i>
                                                        <span><?php esc_html_e( 'Favorites', 'heilz' ); ?></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if( get_user_meta( get_current_user_id(), 'ulz_role', true ) == 'business' ): ?>
                                                <li class="ulz--separator"></li>
                                                <li>
                                                    <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'listings' ) ); ?>">
                                                        <i class="material-icons">place</i>
                                                        <span><?php esc_html_e('Listings', 'heilz'); ?></span>
                                                    </a>
                                                </li>
                                                <?php if( get_option('ulz_enable_payouts') ): ?>
                                                    <li>
                                                        <a href="<?php echo esc_url( wc_get_account_endpoint_url('payouts') ); ?>">
                                                            <i class="material-icons">account_balance_wallet</i>
                                                            <span><?php esc_html_e('Payouts', 'heilz'); ?></span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if( class_exists('woocommerce') && get_option('woocommerce_myaccount_page_id') ): ?>
                                            <li class="ulz--separator"></li>
                                            <li>
                                                <a href="<?php echo esc_url( wc_get_account_endpoint_url('edit-account') ); ?>">
                                                    <i class="material-icons">style</i>
                                                    <span><?php esc_html_e('Account details', 'heilz'); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <li>
                                            <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>">
                                                <i class="material-icons">lock</i>
                                                <span><?php esc_html_e('Logout', 'heilz'); ?></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            <?php endif; ?>

                        </div> <!-- site-user -->
                    <?php endif; ?>

                </div> <!-- site-actions -->

                <?php if( function_exists('utillz_core') && get_option('ulz_enable_cta') && $cta_label = get_option('ulz_cta_label') ): ?>
                    <div class="ulz-site-cta">
                        <a href="<?php echo esc_url( Ucore()->format_url( get_option('ulz_cta_target') ) ); ?>" class="ulz-button ulz-small">
                            <span><?php echo esc_html( $cta_label ); ?></span>
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        </div> <!-- row -->
    </div>

</header>
