<div class="ulz-modal ulz-modal-signin" data-id="signin" data-signup="<?php echo get_option('ulz_enable_standard_pass') ? 'pass' : 'email'; ?>">
    <div class="ulz-signin-image"></div>
    <div class="ulz-signin-content">
        <?php Ucore()->the_template('modals/close'); ?>
        <div class="ulz-modal-content">
            <div class="ulz-modal-append">
                <?php Ucore()->the_template('modals/account/append'); ?>
            </div>
            <?php Ucore()->preloader(); ?>
        </div>
    </div>
</div>
