<?php get_header(); ?>

<?php global $wp_query; ?>

<div class="ulz-container">
	<?php get_template_part('templates/title'); ?>
	<div class="ulz-row">
		<main class="ulz-main">
			<div class="ulz-content">

				<?php

					$featured = new \WP_Query([
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => 2,
						'ignore_sticky_posts' => true,
						'meta_query' => [
							[
								'key' => 'ulz_featured',
								'value' => 1,
							]
						]
					]);

				?>

				<?php if( ! is_paged() && $featured->have_posts() ): ?>
					<h2 class="ulz-mb-3"><?php esc_html_e('Featured', 'heilz'); ?></h2>
					<div class="ulz-articles ulz--x2 ulz-no-excerpt ulz-mb-2">
						<div class="ulz-grid">
							<?php while( $featured->have_posts() ): $featured->the_post(); ?>
								<?php get_template_part( 'templates/article' ); ?>
							<?php endwhile; wp_reset_postdata(); ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if( have_posts() ): ?>
					<?php if( ! is_paged() && $featured->have_posts() ): ?>
						<h3 class="ulz-mb-3"><?php esc_html_e('Latest from the team', 'heilz'); ?></h3>
					<?php endif; ?>
					<div class="ulz-articles ulz-no-excerpt">
						<div class="ulz-grid">
							<?php while( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'templates/article' ); ?>
							<?php endwhile; ?>
						</div>
					</div>
					<div class="ulz-paging">
						<?php echo Utheme()->pagination(); ?>
					</div>
				<?php else: ?>
					<?php get_template_part( 'templates/content-none' ); ?>
				<?php endif; ?>
			</div>
		</main>
	</div>
</div>

<?php get_footer();
