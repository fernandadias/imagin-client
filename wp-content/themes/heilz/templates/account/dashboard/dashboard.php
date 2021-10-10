<?php

use \UtillzCore\Inc\Src\Listing\Views;
use \UtillzCore\Inc\Src\Wallet;

defined('ABSPATH') || exit;

// views
$today_views = Views::get_all_today_views();

// earnings
$today_earnings = Wallet::get_earnings();

// waller
$wallet = new Wallet();
$payouts = $wallet->get_payouts();

$user = new \UtillzCore\Inc\Src\User( get_current_user_id() );
$user_data = $user->get_userdata();
$user_role = get_user_meta( get_current_user_id(), 'ulz_role', true );

?>

<?php

$user = new \UtillzCore\Inc\Src\User( get_current_user_id() );
$user_avatar = $user->get_avatar();
$user_cover = $user->get_cover();
$user_metadata = $user->get_userdata();

?>

<div class="ulz-author-cover">
    <div class="ulz--cover<?php if( $user_cover ) { echo ' ulz--has-cover'; } if( $user_avatar ) { echo ' ulz--has-avatar'; } ?>" style="<?php if( $user_cover ) { echo sprintf( 'background-image: url(\'%s\');', $user_cover ); } ?>">
        <div class="ulz--inner">
            <div class="ulz--heading">
                <div class="ulz--cover-avatar">
                    <?php if( $user_avatar ): ?>
                        <img src="<?php echo esc_url( $user_avatar ); ?>">
                    <?php else: ?>
                        <i class="ulz--avatar fas fa-user-alt"></i>
                    <?php endif; ?>
                </div>
                <div class="ulz--action">
                    <a href="<?php echo get_author_posts_url( $user->id ); ?>" class="ulz-button ulz--white" target="_blank">
                         <span><?php esc_html_e('View public profile', 'heilz'); ?></span>
                         <i class="fas fa-caret-right ulz-ml-1"></i>
                    </a>
                </div>
            </div>
            <h5 class="ulz--name">
                <?php echo esc_html( $user_metadata->display_name ); ?>
            </h5>
            <p class="ulz--bio ulz-w-100"><?php echo wp_trim_words( esc_html( get_the_author_meta( 'description', $user->id ) ), 50, ' ...' ); ?></p>
        </div>
    </div>
</div>

<?php if( get_option('ulz_enable_dashboard_role') ): ?>
    <div class="ulz-grid ulz-justify-space ulz-align-center ulz-mb-4">
        <div class="ulz-col-auto ulz-col-sm-12 ulz-weight-600">
            <p><?php echo sprintf( esc_html__( 'You are viewing the dashboard as %s', 'heilz' ), ( empty( $user_role ) || $user_role == 'customer' ) ? esc_html__( 'customer', 'heilz' ) : esc_html__( 'business', 'heilz' ) ); ?></p>
        </div>
        <div class="ulz-col-auto ulz-col-sm-12">
            <a class="ulz-button" href="<?php echo apply_filters( 'utillz/account/dashboard/switch-user-role', esc_url( add_query_arg( 'ulz_switch_user_role', '', wc_get_account_endpoint_url( 'dashboard' ) ) ) ); ?>" data-action="account-switch-user-role">
                <span><?php echo sprintf( esc_html__( 'Switch to %s', 'heilz' ), ( empty( $user_role ) || $user_role == 'customer' ) ? esc_html__( 'business', 'heilz' ) : esc_html__( 'customer', 'heilz' ) ); ?></span>
            </a>
        </div>
    </div>
<?php endif; ?>

<?php

/*
 * customer
 *
 */
if( empty( $user_role ) || $user_role == 'customer' ):
?>

<div class="ulz-dashboard">
    <div class="ulz-grid">
        <div class="ulz-col-6 ulz-col-xl-12 ulz-flex ulz-flex-column">
            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-account' ) ); ?>" class="ulz--box">
                <i class="material-icons">style</i>
                <span class="ulz--title"><?php esc_html_e( 'Account details', 'heilz' ); ?><i class="fas fa-caret-right ulz-ml-1"></i></span>
                <p class="ulz-mt-1 ulz-mb-0"><?php esc_html_e( 'Provide personal details and how we can reach you', 'heilz' ); ?></p>
            </a>
        </div>
        <div class="ulz-col-6 ulz-col-xl-12 ulz-flex ulz-flex-column">
            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'messages' ) ); ?>" class="ulz--box">
                <i class="material-icons">chat</i>
                <span class="ulz--title"><?php esc_html_e( 'Messages', 'heilz' ); ?><i class="fas fa-caret-right ulz-ml-1"></i></span>
                <p class="ulz-mt-1 ulz-mb-0"><?php esc_html_e( 'Track all your important conversations with the world', 'heilz' ); ?></p>
            </a>
        </div>
        <div class="ulz-col-6 ulz-col-xl-12 ulz-flex ulz-flex-column">
            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>" class="ulz--box">
                <i class="material-icons">library_add_check</i>
                <span class="ulz--title"><?php esc_html_e( 'My orders', 'heilz' ); ?><i class="fas fa-caret-right ulz-ml-1"></i></span>
                <p class="ulz-mt-1 ulz-mb-0"><?php esc_html_e( 'Get information about your orders, payments and details', 'heilz' ); ?></p>
            </a>
        </div>
        <div class="ulz-col-6 ulz-col-xl-12 ulz-flex ulz-flex-column">
            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'notification-settings' ) ); ?>" class="ulz--box">
                <i class="material-icons">notifications_active</i>
                <span class="ulz--title"><?php esc_html_e( 'Notification settings', 'heilz' ); ?><i class="fas fa-caret-right ulz-ml-1"></i></span>
                <p class="ulz-mt-1 ulz-mb-0"><?php esc_html_e( 'Enable notifications for important actions and activities', 'heilz' ); ?></p>
            </a>
        </div>
    </div>

</div>

<?php
/*
 * business
 *
 */
else:
?>

<div class="ulz-dashboard">
    <div class="ulz-grid ulz-dashboard-row">
        <div class="ulz-col-4 ulz-col-xl-12 ulz-flex ulz-flex-column">
            <div class="ulz--box ulz--has-icon">
                <i class="material-icons">remove_red_eye</i>
                <span class="ulz--title"><?php esc_html_e( 'Views today', 'heilz' ); ?></span>
                <span class="ulz--num ulz-font-heading"><?php echo Ucore()->short_number( $today_views ); ?></span>
            </div>
        </div>
        <div class="ulz-col-4 ulz-col-xl-12 ulz-flex ulz-flex-column">
            <div class="ulz--box ulz--has-icon">
                <i class="material-icons">timeline</i>
                <span class="ulz--title"><?php esc_html_e( 'Today earnings', 'heilz' ); ?></span>
                <span class="ulz--num ulz-font-heading"><?php echo Ucore()->format_price( $today_earnings ); ?></span>
            </div>
        </div>
        <div class="ulz-col-4 ulz-col-xl-12 ulz-flex ulz-flex-column">
            <div class="ulz--box ulz--highlight ulz--has-icon">
                <i class="material-icons">account_balance_wallet</i>
                <span class="ulz--title"><?php esc_html_e( 'Your balance', 'heilz' ); ?></span>
                <span class="ulz--num ulz-font-heading"><?php echo Ucore()->format_price( $wallet->get_balance() ); ?></span>
            </div>
        </div>
    </div>

    <div class="ulz-grid ulz-dashboard-row">
        <div class="ulz-col-12">
            <div class="ulz--box">
                <div class="ulz-flex">
                    <div class="">
                        <span class="ulz--title ulz-mb-0 ulz-mr-1"><?php esc_html_e( 'Latest views', 'heilz' ); ?></span>
                    </div>
                    <div class="ulz-ml-auto">
                        <!-- .. -->
                    </div>
                </div>
                <div class="ulz-chart" data-id="dashboard">
                    <div id="ulz-chart-render"></div>
                    <?php Ucore()->preloader(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="ulz-grid">
        <div class="ulz-col-4 ulz-col-xl-12 ulz-flex ulz-flex-column">
            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'listings' ) ); ?>" class="ulz--box">
                <i class="material-icons">place</i>
                <span class="ulz--title"><?php esc_html_e( 'Listings', 'heilz' ); ?><i class="fas fa-caret-right ulz-ml-1"></i></span>
                <p class="ulz-mt-1 ulz-mb-0"><?php esc_html_e( 'Manage all your listings and track important information', 'heilz' ); ?></p>
            </a>
        </div>
        <div class="ulz-col-4 ulz-col-xl-12 ulz-flex ulz-flex-column">
            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'entries' ) ); ?>" class="ulz--box">
                <i class="material-icons">add_circle</i>
                <span class="ulz--title"><?php esc_html_e( 'Entries', 'heilz' ); ?><i class="fas fa-caret-right ulz-ml-1"></i></span>
                <p class="ulz-mt-1 ulz-mb-0"><?php esc_html_e( 'Manage your incoming and outgoing entries', 'heilz' ); ?></p>
            </a>
        </div>
        <div class="ulz-col-4 ulz-col-xl-12 ulz-flex ulz-flex-column">
            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'messages' ) ); ?>" class="ulz--box">
                <i class="material-icons">chat</i>
                <span class="ulz--title"><?php esc_html_e( 'Messages', 'heilz' ); ?><i class="fas fa-caret-right ulz-ml-1"></i></span>
                <p class="ulz-mt-1 ulz-mb-0"><?php esc_html_e( 'Track all your important conversations with the world', 'heilz' ); ?></p>
            </a>
        </div>
    </div>

</div>

<?php endif; ?>
