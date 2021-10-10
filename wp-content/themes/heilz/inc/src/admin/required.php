<?php

namespace UtillzTheme\Inc\Src\Admin;

class Required {

    use \UtillzTheme\Inc\Src\Traits\Singleton;

    function __construct() {

        $this->include_tgm();
        $this->register();

    }

    protected function include_tgm() {

        include UTILLZ_THEME_PATH . 'inc/lib/tgm-plugin-activation/class-tgm-plugin-activation.php';

    }

    protected function register() {

        add_action( 'tgmpa_register', [ $this, 'register_required_plugins' ] );

    }

    public function register_required_plugins() {

    	/*
    	 * array of plugin arrays, required keys are name and slug
    	 * if the source is NOT from the .org repo, then source is also required
         *
    	 */
    	$plugins = [

    		[
                'name' => 'Utillz Core',
    			'slug' => 'utillz-core',
    			'source' => UTILLZ_THEME_PATH . 'inc/plugins/utillz-core.zip',
    			'required' => true,
    			'version' => '1.0.0.2',
    			'force_activation' => false,
    			'force_deactivation' => false,
    			'external_url' => '',
    			'is_callable' => '',
            ],

    		[
                'name' => 'Utillz Enhance',
    			'slug' => sprintf( 'utillz-enhance-heilz' ),
    			'source' => UTILLZ_THEME_PATH . 'inc/plugins/utillz-enhance-heilz.zip',
    			'required' => true,
    			'version' => '1.0.0.1',
    			'force_activation' => false,
    			'force_deactivation' => false,
    			'external_url' => '',
    			'is_callable' => '',
            ],

            [
                'name' => 'Envato Market',
    			'slug' => 'envato-market',
    			'source' => 'https://github.com/envato/wp-envato-market/archive/master.zip',
                'external_url' => 'https://envato.com/market-plugin/',
            ],

            [
                'name' => 'Elementor',
    			'slug' => 'elementor',
    			'required' => true,
            ],
    		[
                'name' => 'WooCommerce',
    			'slug' => 'woocommerce',
    			'required' => false,
            ],
    		[
                'name' => 'Contact Form 7',
    			'slug' => 'contact-form-7',
    			'required' => false,
            ],
    		[
                'name' => 'MC4WP: Mailchimp for WordPress',
    			'slug' => 'mailchimp-for-wp',
    			'required' => false,
            ],

    	];

    	/*
    	 * array of configuration settings
         *
    	 */
    	$config = [
    		'id' => 'utillz',
    		'default_path' => '',
    		'menu' => 'tgmpa-install-plugins',
    		'has_notices' => true,
    		'dismissable' => true,
    		'dismiss_msg' => '',
    		'is_automatic' => false,
    		'message' => '',
    	];

    	tgmpa( $plugins, $config );

    }

}
