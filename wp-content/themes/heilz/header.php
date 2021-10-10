<!doctype html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div id="page" class="site">

	<?php if( ! ( function_exists('Ucore') && Ucore()->is_submission() ) ): ?>
		<?php get_template_part('templates/mobile/header'); ?>
		<?php get_template_part('templates/header/header'); ?>
	<?php endif; ?>
