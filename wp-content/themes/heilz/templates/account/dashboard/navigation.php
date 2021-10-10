<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

$dashboard_icons = apply_filters('utillz/account/navigation/icons', [
	'dashboard' 			=> 'dashboard',
	'listings' 				=> 'place',
	'messages' 				=> 'chat',
	'entries' 				=> 'add_circle',
	'payouts' 				=> 'account_balance_wallet',
	'notification-settings' => 'notifications',
	'orders' 				=> 'library_add_check',
	'downloads' 			=> 'download',
	'subscriptions' 		=> 'hourglass_top',
	'payment-methods' 		=> 'payments',
	'edit-address' 			=> 'business',
	'edit-account' 			=> 'style',
	'customer-logout' 		=> 'lock',
]);

?>

<div class="ulz-account-bar">
	<nav class="ulz-account-nav">
		<ul>
			<?php foreach( wc_get_account_menu_items() as $endpoint => $label ) : ?>
				<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
					<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
						<?php
							echo array_key_exists( $endpoint, $dashboard_icons ) ? sprintf( '<i class="material-icons">%s</i>', esc_html( $dashboard_icons[ $endpoint ] ) ) : '<i class="material-icons">fiber_manual_record</i>';
						?>
						<span><?php echo esc_html( $label ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</nav>
</div>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
