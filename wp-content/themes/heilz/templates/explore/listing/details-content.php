<?php

defined('ABSPATH') || exit;

global $ulz_listing;

?>

<?php $details = $ulz_listing->get_details('ulz_display_listing_content'); ?>
<?php if( $details ): ?>
    <div class="ulz-listing-details ulz-listing-details-content ulz-listing-tags">
        <ul>
            <?php foreach( $details as $detail ): ?>
                <li>
                    <span>
                        <?php if( $detail->icon ): ?>
                            <i class="<?php echo esc_html( $detail->icon ); ?>"></i>
                        <?php endif; ?>
                        <?php echo wp_kses( $detail->content, Ucore()->allowed_html() ); ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
