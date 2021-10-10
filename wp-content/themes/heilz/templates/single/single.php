<?php

defined('ABSPATH') || exit;

global $ulz_listing;
$ulz_listing = new \UtillzCore\Inc\Src\Listing\Listing();

$cover_type = $ulz_listing->type->get('ulz_single_cover_type')

?>

<section id="primary" class="content-area">
    <div class="site-main">

        <input type="hidden" id="ulz_listing_id" value="<?php the_ID(); ?>">

        <?php if( $cover_type == 'full-cover' ): ?>
            <?php Ucore()->the_template('single/cover/full-cover'); ?>
        <?php endif; ?>

        <div class="ulz-row">
            <div class="ulz-grid">
                <div class="ulz-col">

                    <div class="ulz-single">
                        <?php if( $cover_type !== 'full-cover' ): ?>
                            <?php Ucore()->the_template('single/heading'); ?>
                        <?php endif; ?>
                        <div class="ulz-listing-container">
                            <div class="ulz-content">
                                <?php if( $cover_type !== 'full-cover' ): ?>
                                    <?php Ucore()->the_template('single/cover'); ?>
                                <?php endif; ?>
                                <?php Ucore()->the_template('single/content'); ?>
                            </div>
                            <?php Ucore()->the_template('single/sidebar'); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

<?php Ucore()->the_template('modals/action-report/content'); ?>

<?php if( $ulz_listing->type->get('ulz_enable_related') ): ?>
    <div class="ulz-related">
        <div class="ulz-row">
            <?php Ucore()->the_template('single/related'); ?>
        </div>
    </div>
<?php endif; ?>
