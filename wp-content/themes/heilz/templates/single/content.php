<?php

use \UtillzCore\Inc\Src\Listing\Component;

defined('ABSPATH') || exit;

global $ulz_listing;

$modules = Component::instance();
$module_items = Ucore()->jsoning( 'ulz_display_single_content', $ulz_listing->type->id );

?>

<div class="ulz-single-content">
    <?php

        foreach( $module_items as $module_item ):
            $modules->render( $module_item );
        endforeach;

    ?>
</div>
