<?php
    $enable_google_auth = get_option('ulz_enable_google_auth');
    $enable_facebook_auth = get_option('ulz_enable_facebook_auth');
    $enable_standard_role = get_option('ulz_enable_standard_role');
    $enable_signup_phone = get_option('ulz_enable_signup_phone');
    $enable_signup_terms = get_option('ulz_enable_signup_terms');
    $signup_terms_text = get_option('ulz_signup_terms_text');
?>

<div class="ulz-modal-container">

    <?php if( get_option( 'users_can_register' ) ): ?>
        <div class="ulz-signin-tabs">
            <ul>
                <li class="ulz-active" data-for="sign-in" data-label="<?php esc_html_e( 'Sign in', 'heilz' ); ?>"><a href="#"><?php esc_html_e( 'Sign in', 'heilz' ); ?></a></li>
                <li data-for="create-account" data-label="<?php esc_html_e( 'Create account', 'heilz' ); ?>"><a href="#"><?php esc_html_e( 'Create account', 'heilz' ); ?></a></li>
            </ul>
        </div>
    <?php endif; ?>

    <form class="ulz-form ulz-signin-section ulz-active" data-id="sign-in" autocomplete="off">

        <span class="ulz-signin-title"><?php esc_html_e('Welcome back.', 'heilz'); ?></span>

        <?php if( get_option( 'users_can_register' ) ): ?>
            <?php if( $enable_google_auth || $enable_facebook_auth ): ?>

                <div class="ulz-signin-social">
                    <ul>
                        <?php if( $enable_google_auth ): ?>
                            <li>
                                <a href="#" class="ulz-button ulz--gg" data-action="sign-in-google">
                                    <img src="<?php echo UTILLZ_THEME_URI; ?>assets/dist/images/signin/gg.svg" alt="gg">
                                    <span><?php esc_html_e( 'Continue with Google', 'heilz' ); ?></span>
                                    <?php Ucore()->preloader(); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if( $enable_facebook_auth ): ?>
                            <li>
                                <a href="#" class="ulz-button ulz--fb" data-action="sign-in-facebook">
                                    <img src="<?php echo UTILLZ_THEME_URI; ?>assets/dist/images/signin/fb.svg" alt="fb">
                                    <span><?php esc_html_e( 'Continue with Facebook', 'heilz' ); ?></span>
                                    <?php Ucore()->preloader(); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="ulz-signin-or">
                    <span><?php esc_html_e( 'OR', 'heilz' ); ?></span>
                </div>

            <?php endif; ?>
        <?php endif; ?>

        <div class="ulz-grid">
            <!-- fix browser autocomplete -->
            <div style="position:absolute;z-index:-1;opacity:0;">
                <input type="text" name="username">
                <input type="password" name="password">
            </div>
            <!-- // fix browser autocomplete -->
            <div class="ulz-form-group ulz-col-12">
                <input type="text" name="user_email" value="<?php echo esc_html( apply_filters('utillz/login/username', '' ) ); ?>" placeholder="<?php esc_html_e( 'Username or email', 'heilz' ); ?>">
            </div>
            <div class="ulz-form-group ulz-col-12">
                <input type="password" name="user_password" value="<?php echo esc_html( apply_filters('utillz/login/password', '' ) ); ?>" placeholder="<?php esc_html_e( 'Password', 'heilz' ); ?>">
            </div>
            <div class="ulz-form-group ulz-inline-group ulz-col-12">
                <button type="submit" class="ulz-button ulz-button-accent ulz-block ulz-w-100 ulz-modal-button">
                    <span><?php esc_html_e( 'Sign in', 'heilz' ); ?></span>
                    <?php Ucore()->preloader(); ?>
                </button>
            </div>
            <div class="ulz-signin-errors">
                <!-- output -->
            </div>
            <div class="ulz-form-group ulz-col-12 ulz-text-center">
                <p class="ulz-mb-0">
                    <a href="#" data-for="reset-password" class="ulz-lost-pass-link" data-label="<?php esc_html_e( 'Reset password', 'heilz' ); ?>">
                        <i class="material-icons ulz-mr-1">lock</i><?php esc_html_e( 'Lost your password?', 'heilz' ); ?>
                    </a>
                </p>
            </div>
        </div>
    </form>

    <?php if( get_option( 'users_can_register' ) ): ?>
        <form class="ulz-form ulz-signin-section" data-id="create-account">

            <input type="submit" value="" class="ulz-none">

            <?php if( $enable_standard_role ): ?>
                <div class="ulz-standard-role">
                    <span class="ulz-signin-title"><?php esc_html_e('Hey! Let’s get you started.', 'heilz'); ?></span>
                    <input type="hidden" name="role" value="customer">
                    <ul class="ulz-no-select">
                        <li>
                            <a href="#" data-role="business">
                                <span class="ulz--name">
                                    <i class="ulz--icon material-icons ulz-mr-2">camera_alt</i>
                                    <?php esc_html_e( 'Upload photos or sell on market', 'heilz' ); ?>
                                    <i class="ulz--arrow material-icons ulz-ml-auto">arrow_forward</i>
                                </span>
                                <span class="ulz--summary"><?php esc_html_e('Join a network of +8m creatives worldwide. Get hired for shoots and distribute your work.', 'heilz'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="#" data-role="customer">
                                <span class="ulz--name">
                                    <i class="ulz--icon material-icons ulz-mr-2">shopping_basket</i>
                                    <?php esc_html_e( 'Buy images or book photo shoots', 'heilz' ); ?>
                                    <i class="ulz--arrow material-icons ulz-ml-auto">arrow_forward</i>
                                </span>
                                <span class="ulz--summary"><?php esc_html_e('Create a business account to license royalty-free photography and book photo shoots worldwide.', 'heilz'); ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="ulz-signin-container<?php if( $enable_standard_role ) { echo ' ulz-none'; } ?>">

                <span class="ulz-signin-title"><?php esc_html_e('Create your account.', 'heilz'); ?></span>

                <div class="ulz-signin-social">
                    <ul>
                        <?php if( $enable_google_auth ): ?>
                            <li>
                                <a href="#" class="ulz-button ulz--gg" data-action="sign-in-google">
                                    <img src="<?php echo UTILLZ_THEME_URI; ?>assets/dist/images/signin/gg.svg" alt="gg">
                                    <span><?php esc_html_e( 'Continue with Google', 'heilz' ); ?></span>
                                    <?php Ucore()->preloader(); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if( $enable_facebook_auth ): ?>
                            <li>
                                <a href="#" class="ulz-button ulz--fb" data-action="sign-in-facebook">
                                    <img src="<?php echo UTILLZ_THEME_URI; ?>assets/dist/images/signin/fb.svg" alt="fb">
                                    <span><?php esc_html_e( 'Continue with Facebook', 'heilz' ); ?></span>
                                    <?php Ucore()->preloader(); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="ulz-signin-or">
                    <span><?php esc_html_e( 'OR', 'heilz' ); ?></span>
                </div>

                <div class="ulz-grid">

                    <div class="ulz-form-group ulz-col-12">
                        <input type="text" name="username" value="" placeholder="<?php esc_html_e( 'Username', 'heilz' ); ?>">
                    </div>

                    <div class="ulz-form-group <?php echo boolval( $enable_signup_phone ) ? 'ulz-col-6 ulz-col-sm-12' : 'ulz-col-12'; ?>">
                        <input type="text" name="email" value="" placeholder="<?php esc_html_e( 'Email', 'heilz' ); ?>">
                    </div>

                    <?php if( $enable_signup_phone ): ?>
                        <div class="ulz-form-group ulz-col-6 ulz-col-sm-12">
                            <input type="text" name="phone" value="" placeholder="<?php esc_html_e( 'Phone number', 'heilz' ); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="ulz-form-group ulz-col-6 ulz-col-sm-12">
                        <input type="text" name="first_name" value="" placeholder="<?php esc_html_e( 'First name', 'heilz' ); ?>">
                    </div>
                    <div class="ulz-form-group ulz-col-6 ulz-col-sm-12">
                        <input type="text" name="last_name" value="" placeholder="<?php esc_html_e( 'Last name', 'heilz' ); ?>">
                    </div>
                    <?php if( get_option('ulz_enable_standard_pass') ): ?>
                        <div class="ulz-form-group ulz-col-6 ulz-col-sm-12">
                            <input type="password" name="password" value="" placeholder="<?php esc_html_e( 'Password', 'heilz' ); ?>">
                        </div>
                        <div class="ulz-form-group ulz-col-6 ulz-col-sm-12">
                            <input type="password" name="repeat_password" value="" placeholder="<?php esc_html_e( 'Repeat password', 'heilz' ); ?>">
                        </div>
                    <?php endif; ?>

                    <?php if( $enable_signup_terms ): ?>
                        <div class="ulz-form-group ulz-col-12">
                            <label class="ulz-checkbox ulz-no-select ulz-mt-0">
                                <input type="checkbox" value="1" name="terms">
                                <span class="ulz--toggle ulz-transition"></span>
                                <span class="ulz--text ulz--collect"><?php echo wp_kses_post( html_entity_decode( Ucore()->format_url( $signup_terms_text ) ) ); ?></span>
                            </label>
                        </div>
                    <?php endif; ?>

                    <div class="ulz-form-group ulz-inline-group ulz-col-12">
                        <button type="submit" class="ulz-button ulz-button-accent ulz-block ulz-w-100 ulz-modal-button">
                            <span><?php esc_html_e( 'Create account', 'heilz' ); ?></span>
                            <?php Ucore()->preloader(); ?>
                        </button>
                    </div>
                    <div class="ulz-signin-errors">
                        <!-- output -->
                    </div>
                    <div class="ulz-signin-success">
                        <?php esc_html_e( 'Your account has been created. Please check your email for more details.', 'heilz' ); ?>
                    </div>
                    <?php if( ! get_option('ulz_enable_standard_pass') ): ?>
                    <div class="ulz-form-group ulz-col-12 ulz-text-center">
                        <p class="ulz-mb-0"><?php esc_html_e( 'A password will be e-mailed to you', 'heilz' ); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    <?php endif; ?>

    <form class="ulz-form ulz-signin-section" data-id="reset-password">
        <input type="submit" value="" class="ulz-none">
        <div class="ulz-grid">
            <div class="ulz-form-group ulz-col-12">
                <span class="ulz-signin-title"><?php esc_html_e('Request a password reset.', 'heilz'); ?></span>
                <p><?php esc_html_e( 'Please enter your email address. You will receive a link to create a new password via email.', 'heilz' ); ?></p>
                <input type="text" name="email" value="" placeholder="<?php esc_html_e( 'Email', 'heilz' ); ?>">
            </div>
            <div class="ulz-form-group ulz-inline-group ulz-col-12">
                <button type="submit" class="ulz-button ulz-button-accent ulz-block ulz-w-100 ulz-modal-button">
                    <span><?php esc_html_e( 'Reset password', 'heilz' ); ?></span>
                    <?php Ucore()->preloader(); ?>
                </button>
            </div>
            <div class="ulz-signin-errors">
                <!-- output -->
            </div>
            <div class="ulz-signin-success">
                <?php esc_html_e( 'Please check your email for more details.', 'heilz' ); ?>
            </div>
        </div>
    </form>

</div>

<div class="ulz-modal-footer ulz-text-center">
    <a href="#" class="ulz-button ulz-width-100 ulz-button-accent ulz--large ulz-modal-button" data-action="">
        <span><?php esc_html_e( 'Sign in', 'heilz' ); ?></span>
        <?php Ucore()->preloader(); ?>
    </a>
</div>
