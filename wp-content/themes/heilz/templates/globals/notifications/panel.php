<?php

defined('ABSPATH') || exit;

if( ! function_exists('utillz_core') ) {
    return;
}

?>

<div class="ulz-npanel ulz-panel-notifications" id="notifications-panel" data-page="1">
    <div class="ulz--header">
        <span class="ulz--title">
            <?php esc_html_e( 'Notifications', 'heilz' ); ?>
        </span>
        <a href="#" class="ulz-button ulz-ml-auto ulz-mr-1" data-action="mark-read">
            <span class="material-icons">visibility</span>
            <?php Ucore()->preloader(); ?>
        </a>
        <a href="#" class="ulz-close" data-action="panel-close">
            <span><?php esc_html_e('Close', 'heilz'); ?></span>
        </a>
    </div>
    <div class="ulz--list ulz-scrollbar">
        <?php Ucore()->the_template('modals/skeleton'); ?>
        <div data-action="append">
            <!-- append -->
        </div>
    </div>
    <div class="ulz--footer">
        <a href="#" class="ulz-button ulz-width-100 ulz-button-accent ulz--large ulz-modal-button" data-action="notifications">
            <span><?php esc_html_e( 'Load more', 'heilz' ); ?></span>
            <?php Ucore()->preloader(); ?>
        </a>
    </div>
</div>
