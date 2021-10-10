<?php

global $wp_query;

if( ! function_exists('Ucore') ) {
    return;
}

?>

<div class="ulz-account-footer">
    <div class="ulz-row">
        <div class="ulz-grid ulz-justify-space">
            <div class="ulz-col-auto ulz-col-md-12">
                <?php echo wp_kses( html_entity_decode( get_option( 'ulz_footer_copy' ) ), Ucore()->allowed_html() ); ?>
            </div>
            <?php $footer_account = get_option( 'ulz_footer_account' ); ?>
            <?php if( $footer_account ): ?>
                <div class="ulz-col-auto ulz-col-md-12">
                    <?php echo wp_kses( html_entity_decode( $footer_account ), Ucore()->allowed_html() ); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
