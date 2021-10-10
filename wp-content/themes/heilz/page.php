<?php get_header(); ?>

<?php

$enable_page_modules = Utheme()->get('ulz_enable_page_modules');

$is_explore = false;
if( function_exists('Ucore') ) {
	$is_explore = Ucore()->is_explore();
}

$is_account = ( function_exists('is_account_page') && is_account_page() );
$is_in_row = ( ! $enable_page_modules && ! $is_explore );

$show_title = true;
if( $is_explore ) {
	$show_title = false;
}

if( $is_account && is_user_logged_in() ) {
	$show_title = false;
}

if( function_exists('is_checkout') && is_checkout() && ! empty( is_wc_endpoint_url('order-received') ) ) {
    $show_title = false;
}

if( Utheme()->is_elementor() ) {
	$is_in_row = false;
}

?>

<div class="ulz-container">
	<?php if( $show_title ): ?>
		<?php get_template_part('templates/title'); ?>
	<?php endif; ?>
	<?php if( $is_in_row ): ?><div class="ulz-row"><?php endif; ?>
		<?php
			while ( have_posts() ) : the_post();
				get_template_part( 'templates/content', 'page' );
			endwhile;
		?>
	<?php if( $is_in_row ): ?></div><?php endif; ?>
</div>

<?php if( $is_account ): ?>
	<?php Utheme()->the_template('account/footer'); ?>
<?php endif; ?>

<?php get_footer();
