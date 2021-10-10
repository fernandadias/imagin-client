<?php

global $wp_query;

?>

<div class="ulz-account-heading">
    <h1 class="ulz--title">
        <?php

            switch( true ) {
                case isset( $wp_query->query_vars['listings'] ):
                    esc_html_e( 'Listings', 'heilz' );
                    break;
                case isset( $wp_query->query_vars['messages'] ):
                    esc_html_e( 'Messages', 'heilz' );
                    break;
                case isset( $wp_query->query_vars['entries'] ):
                    esc_html_e( 'Entries', 'heilz' );
                    break;
                case isset( $wp_query->query_vars['payouts'] ):
                    esc_html_e( 'Payouts', 'heilz' );
                    break;
                case isset( $wp_query->query_vars['orders'] ):
                    esc_html_e( 'Orders', 'heilz' );
                    break;
                case isset( $wp_query->query_vars['downloads'] ):
                    esc_html_e( 'Downloads', 'heilz' );
                    break;
                case isset( $wp_query->query_vars['edit-address'] ):
                    esc_html_e( 'Address', 'heilz' );
                    break;
                case isset( $wp_query->query_vars['edit-account'] ):
                    esc_html_e( 'Account details', 'heilz' );
                    break;
                case isset( $wp_query->query_vars['notification-settings'] ):
                    esc_html_e( 'Notifications', 'heilz' );
                    break;
                default:
                    esc_html_e( 'Dashboard', 'heilz' );
            }

        ?>
    </h1>
</div>
