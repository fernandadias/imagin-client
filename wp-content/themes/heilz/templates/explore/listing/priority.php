<?php

defined('ABSPATH') || exit;

global $ulz_listing;
$priority_label = $ulz_listing->get_priority_label();

?>

<?php if( $priority_label ): ?>
    <div class="ulz-listing-priority">
        <span class="ulz--tag">
            <?php esc_html_e('Sponsored', 'heilz'); ?>
        </span>
    </div>
<?php endif; ?>
