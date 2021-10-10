<?php get_header(); ?>

<?php

$is_explore = false;
if( function_exists('Ucore') ) {
	$is_explore = Ucore()->is_explore();
}

?>

<div class="ulz-container">

	<?php if( is_shop() ): ?>
		<?php get_template_part('templates/title'); ?>
	<?php endif; ?>

	<div class="ulz-row">
		<?php woocommerce_content(); ?>
	</div>

</div>

<?php if( function_exists('is_account_page') && is_account_page() ): ?>
	<?php Utheme()->the_template('account/footer'); ?>
<?php endif; ?>

<?php get_footer();
