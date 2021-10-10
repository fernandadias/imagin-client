<?php

use \UtillzCore\Inc\Src\Request\Request;
use \UtillzCore\Inc\Src\Wallet;

defined('ABSPATH') || exit;

$wallet = new Wallet();
$payouts = $wallet->get_payouts();
$request = Request::instance();
$page = $request->has('onpage') ? $request->get('onpage') : 1;
$min_payout = (float) get_option( 'ulz_min_payout', 0 );

?>

<div class="ulz-payouts">
    <div class="ulz--inner">
        <div class="ulz--details">
            <span class="ulz--balance-label">
                <?php esc_html_e( 'Your current balance', 'heilz' ); ?>
            </span>
            <span class="ulz--balance-num">
                <?php echo Ucore()->format_price( floor( $wallet->get_balance() * 100 ) / 100 ); ?>
            </span>
            <?php if( $min_payout ): ?>
                <span class="ulz--balance-info">
                    <?php
                        echo sprintf(
                            esc_html__( 'Minimum payout amount: %s', 'heilz' ),
                            Ucore()->format_price( $min_payout )
                        );
                    ?>
                </span>
            <?php endif; ?>
        </div>
        <div class="ulz--actions">
            <a href="#" class="ulz-button ulz--white" data-modal="payout">
                <span><?php esc_html_e( 'Request a payout', 'heilz' ); ?></span>
            </a>
        </div>
    </div>
</div>

<?php if( $payouts->results ): ?>
    <div class="ulz-boxes">
        <?php foreach( $payouts->results as $payout ): ?>
            <div class="ulz--cell">
                <div class="ulz-box">
                    <div class="ulz--heading">
                        <div class="ulz--title">
                            <h4><?php echo Ucore()->format_price( $payout->amount ); ?></h4>
                        </div>
                    </div>
                    <div class="ulz--status">
                        <div class="ulz-post-status ulz-status-<?php echo esc_attr( $payout->status ); ?>">
                            <span>
                                <?php
                                    switch( $payout->status ) {
                                        case 'pending': esc_html_e( 'Pending', 'heilz' ); break;
                                        case 'approved': esc_html_e( 'Approved', 'heilz' ); break;
                                        case 'declined': esc_html_e( 'Declined', 'heilz' ); break;
                                    }
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="ulz--content">
                        <table>
                            <tbody>
                                <tr>
                                    <td><?php esc_html_e( 'Type', 'heilz' ); ?></td>
                                    <td>
                                        <?php
                                            switch( $payout->payment_method ) {
                                                case 'paypal': esc_html_e( 'PayPal', 'heilz' ); break;
                                                case 'bank_transfer': esc_html_e( 'Direct Bank Transfer', 'heilz' ); break;
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e( 'Request date', 'heilz' ); ?></td>
                                    <td><?php echo date_i18n( get_option('date_format'), strtotime( $payout->created_at ) ); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php if( $payout->status == 'pending' ): ?>
                        <div class="ulz--actions">
                            <div class="ulz--primary-actions">
                                <ul>
                                    <li>
                                        <?php
                                            $action_url = add_query_arg([
                                                'action' => 'cancel_payout',
                                                'id' => $payout->id
                                            ]);
                                            $action_url = wp_nonce_url( $action_url, 'utillz_account_cancel_payout' );
                                        ?>
                                        <a href="<?php echo esc_url( $action_url ); ?>" data-action="payout-cancel"><i class="fas fa-trash-alt"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="ulz-weight-700"><?php esc_html_e( 'No payouts were found', 'heilz' ); ?></p>
<?php endif; ?>

<div class="ulz-paging">
    <?php

        echo Ucore()->pagination([
            'base' => add_query_arg( [ 'onpage' => '%#%' ], wc_get_account_endpoint_url( 'payouts' ) ),
            'format' => '?onpage=%#%',
            'current' => $page,
            'total' => $payouts->max_num_pages,
        ]);

    ?>
</div>

<?php Ucore()->the_template('modals/payouts/content'); ?>
