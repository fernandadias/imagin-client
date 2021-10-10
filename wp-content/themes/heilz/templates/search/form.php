<?php

defined('ABSPATH') || exit;

global $ulz_explore, $ulz_atts, $ulz_search_form_id;

if( ! $ulz_explore ) {
    $ulz_explore = \UtillzCore\Inc\Src\Explore\Explore::instance();
}

extract( shortcode_atts([
    'id' => 0
], $ulz_atts ) );

$ulz_search_form_id = $id;

$listing_type = Ucore()->get( 'ulz_listing_type', $ulz_search_form_id );

?>

<div class="ulz-search-form" data-form-id="<?php echo (int) $ulz_search_form_id ?>">
    <form class="ulz--form" action="<?php echo Ucore()->get_explore_page_url(); ?>" method="get" autocomplete="off">

        <?php if( $listing_type ): ?>
            <input type="hidden" name="type" value="<?php echo esc_html( $listing_type ); ?>">
        <?php endif; ?>

        <div class="ulz-search-mods">
            <?php

                $filters = Ucore()->jsoning( 'ulz_search_fields', $id );
                if( ! empty( $filters ) ) {
                    $ulz_explore->component->tabs( $filters );
                }

            ?>
        </div>

        <div class="ulz-search-submit">
            <button type="submit" class="ulz-button">
                <span>
                    <?php esc_html_e('Search', 'heilz'); ?>
                </span>
                <?php Ucore()->preloader(); ?>
            </button>
        </div>

    </form>
</div>
