<?php

defined('ABSPATH') || exit;

global $ulz_explore;

$ulz_search_form_id = $ulz_explore->type ? $ulz_explore->type->get('ulz_search_form') : get_option('ulz_global_search_form');

?>

<?php Ucore()->the_template('explore/title'); ?>

<div class="ulz-row">
    <div class="ulz-explore" id="ulz-explore">
        <?php if( $ulz_search_form_id ): ?>
            <div class="ulz-explore-sidebar">
                <?php Ucore()->the_template('explore/filters'); ?>
            </div>
        <?php endif; ?>
        <div class="ulz-explore-content ulz-no-select">
            <?php Ucore()->the_template('explore/listings'); ?>
        </div>
    </div>
</div>
