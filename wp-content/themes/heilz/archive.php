<?php get_header(); ?>

<div class="ulz-container">
	<?php get_template_part('templates/title'); ?>
	<div class="ulz-row">
		<main class="ulz-main">
			<div class="ulz-content">
				<?php if( have_posts() ): ?>
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
