<?php

$mobile_bar_nav = [];

if( ! $primary = get_option('ulz_color_primary') ) {
    $primary = '#2a6b6b';
}

?>

<div class="ulz-mobile-bar">
    <span class="ulz--background" style="background-color: <?php echo sprintf( '%sdb', esc_attr( $primary ) ); ?>"></span>
    <div class="ulz-mobile-row">
        <ul>

            <?php if( function_exists('Ucore') ): ?>
                <?php $active_site = utillz_core()->notify->get_active_site(); ?>
                <?php $mobile_bar_nav = Ucore()->json_decode( get_option('ulz_mobile_bar_nav') ); ?>
                <?php if( is_array( $mobile_bar_nav ) ): ?>
                    <?php $is_user_logged_in = is_user_logged_in(); ?>
                    <?php foreach( $mobile_bar_nav as $item ): ?>

                        <?php

                            if(
                                ( $is_user_logged_in && $item->fields->hide_in ) or
                                ( ! $is_user_logged_in && $item->fields->hide_out )
                            ) {
                                continue;
                            }

                            $item_url = '#';
                            $item_attr = [];
                            $has_notification = false;

                            if( $item->template->id == 'defined' ) {
                                switch( $item->fields->id ) {
                                    case 'explore':
                                        $item_url = Ucore()->get_explore_page_url();
                                        break;
                                    case 'submission':
                                        $item_url = get_permalink( get_option('ulz_page_submission') );
                                        break;
                                    case 'messages':
                                        if( $is_user_logged_in ) {
                                            if( function_exists('wc_get_account_endpoint_url') ) {
                                                $item_url = wc_get_account_endpoint_url('messages');
                                            }
                                        }else{
                                            $item_attr[] = 'data-modal="signin"';
                                        }
                                        break;
                                    case 'notifications':
                                        if( $is_user_logged_in ) {
                                            $item_attr[] = 'data-action="notifications-toggle"';
                                            $has_notification = true;
                                        }else{
                                            $item_attr[] = 'data-modal="signin"';
                                        }
                                        break;
                                    case 'favorites':
                                        $item_attr[] = $is_user_logged_in ? 'data-modal="favorites"' : 'data-modal="signin"';
                                        break;
                                    case 'signup':
                                        if( $is_user_logged_in ) {
                                            $item_url = wp_logout_url( home_url() );
                                        }else{
                                            $item_attr[] = 'data-modal="signin"';
                                        }
                                        break;
                                }
                            }else{
                                $item_url = $item->fields->url;
                            }

                        ?>

                        <li>
                            <a href="<?php echo esc_url( $item_url ); ?>" data-name="<?php echo esc_attr( $item->fields->name ); ?>" <?php echo implode( ' ', $item_attr ); ?>>

                                <?php if( isset( $item->fields->icon[0] ) ): ?>
                                    <?php echo utillz_core()->icon->get( $item->fields->icon[0]->icon, $item->fields->icon[0]->set ); ?>
                                <?php endif; ?>

                                <span>
                                    <?php if( $has_notification && $active_site ): ?>
                                        <?php echo sprintf( '(%s) ', (int) $active_site ); ?>
                                    <?php endif; ?>
                                    <?php echo esc_html( $item->fields->name ); ?>
                                </span>

                            </a>
                        </li>

                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>

            <li>
                <a href="#" data-action="toggle-mobile-nav">
                    <i class="material-icons">menu</i>
                    <span><?php echo esc_html_e('Menu', 'heilz'); ?></span>
                </a>
            </li>

        </ul>
    </div>
</div>

<?php get_template_part('templates/mobile/navigation'); ?>
