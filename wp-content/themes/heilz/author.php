<?php get_header(); ?>

<?php global $ulz_explore; ?>

<div class="ulz-container">

	<div class="ulz-row">
		<main class="ulz-main">
			<div class="ulz-content">

				<?php if( function_exists('Ucore') ): ?>

					<?php

						global $wpdb;

						$author = get_queried_object();
						$user = new \UtillzCore\Inc\Src\User( $author->ID );
						$user_avatar = $user->get_avatar();
						$user_cover = $user->get_cover();

					?>

					<?php if( ! ( isset( $_GET['onpage'] ) && (int) $_GET['onpage'] > 1 ) ): ?>
		                <div class="ulz-author-cover">
		                    <div class="ulz--cover<?php if( $user_cover ) { echo ' ulz--has-cover'; } if( $user_avatar ) { echo ' ulz--has-avatar'; } ?>" style="<?php if( $user_cover ) { echo sprintf( 'background-image: url(\'%s\');', $user_cover ); } ?>">
		                        <div class="ulz--inner">
									<div class="ulz--heading">
			                            <div class="ulz--cover-avatar">
											<?php if( $user_avatar ): ?>
			                                    <img src="<?php echo esc_url( $user_avatar ); ?>">
			                                <?php else: ?>
			                                    <i class="ulz--avatar fas fa-user-alt"></i>
			                                <?php endif; ?>
			                            </div>
										<div class="ulz--action">
											<a href="#" class="ulz-button ulz--white" data-modal="conversation" data-params='{"id":<?php echo (int) $author->ID; ?>}'>
												 <span><?php echo sprintf( esc_html__('Contact %s', 'heilz'), $author->display_name ); ?></span>
											</a>
										</div>
		                            </div>
		                            <h5 class="ulz--name">
										<?php echo esc_html( $author->display_name ); ?>
									</h5>
		                            <p class="ulz--bio"><?php echo wp_trim_words( esc_html( get_the_author_meta( 'description', $author->ID ) ), 50, ' ...' ); ?></p>
		                        </div>
		                    </div>
		                </div>
					<?php endif; ?>

					<div class="">
						<h4 class="ulz-mb-3">
							<?php esc_html_e( 'Author\'s listings', 'heilz' ); ?>
						</h4>
					</div>

					<div class="ulz-explore" id="ulz-explore">
					    <div class="ulz-explore-content">
					        <?php Ucore()->the_template('explore/listings'); ?>
					    </div>
					</div>

				<?php else: ?>

					<?php if( have_posts() ): ?>
						<div class="ulz-articles ulz-no-excerpt">
							<div class="ulz-grid">
								<?php while ( have_posts() ) : the_post(); ?>
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

				<?php endif; ?>

			</div>
		</main>
	</div>
</div>

<?php get_footer();
