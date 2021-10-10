<?php

defined('ABSPATH') || exit;

?>

<div class="ulz-modal ulz-modal-listing-preview" data-id="listing-preview">
    <div class="ulz-listing-preview">
        <?php Utheme()->the_template('modals/listing-preview/skeleton'); ?>
        <div class="ulz-modal-append">
            <!-- // -->
        </div>
        <ul class="ulz-preview-gallery">
            <!-- // -->
        </ul>
    </div>
    <div class="ulz-preview-nav ulz-no-select" data-action="preview-prev">
        <i class="material-icons">arrow_left</i>
    </div>

    <div class="ulz-preview-nav ulz-no-select" data-action="preview-next">
        <i class="material-icons">arrow_right</i>
    </div>
</div>
