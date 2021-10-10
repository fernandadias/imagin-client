<?php

defined('ABSPATH') || exit;

global $ulz_listing;

$modules = \UtillzCore\Inc\Src\Listing\Component::instance();
$action_types = Ucore()->json_decode( $ulz_listing->type->get('ulz_action_types') );
$action_download = $ulz_listing->type->get_action_type('download');

?>

<?php Utheme()->the_template('single/cover/full-cover'); ?>
