<?php

defined('ABSPATH') || exit;

global $ulz_listing;

if( $cover_type = $ulz_listing->type->get('ulz_single_cover_type') ) {
    Ucore()->the_template( sprintf( 'single/cover/%s', $cover_type ) );
}
