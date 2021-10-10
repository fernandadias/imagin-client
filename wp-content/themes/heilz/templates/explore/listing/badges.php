<?php

defined('ABSPATH') || exit;

global $ulz_listing, $ulz_explore;

$has_favorite = $ulz_listing->type->get( 'ulz_display_listing_favorite' );

?>

<ul class="ulz-listing-badges">

    <?php if( $has_favorite ): ?>
        <li>
            <a href="<?php echo esc_url( Ucore()->non_logged_in_account_page() ); ?>" class="ulz-listing-favorite <?php if( $ulz_explore->user->id && $ulz_explore->user->is_favorite( $ulz_listing->id ) ) { echo 'ulz--active'; } ?>" <?php if( is_user_logged_in() ) { echo 'data-action="add-favorite"'; }else{ echo 'data-modal="signin"'; } ?> data-id="<?php echo (int) $ulz_listing->id; ?>">
                <span class="material-icons">bookmark</span>
            </a>
        </li>
    <?php endif; ?>
</ul>
