<?php

use \UtillzCore\Inc\Src\Listing_Type\Action;

get_header();

global $ulz_submission, $ulz_explore;

$action_fields = Action::get_action_fields( $ulz_submission->listing_type );
$actions = $ulz_submission->listing_type->get_action();

?>

<div class="ulz-submission<?php if( $ulz_submission->id ) { echo ' ulz--is-sidebar'; } ?>">

	<?php if( $ulz_submission->id ): ?>
		<div class="ulz--sidebar">

			<div class="ulz-wizard">
			    <ul>

			        <?php if( $ulz_submission->listing_type->has_plans() ): ?>
						<li>
							<i class="material-icons">inventory_2</i>
							<span><?php esc_html_e( 'Select a Plan', 'heilz' ); ?></span>
						</li>
			        <?php endif; ?>

			        <?php foreach( $ulz_submission->tabs as $tab ): ?>
			            <li>
							<?php if( isset( $tab['icon'] ) && isset( $tab['icon'][0] ) ): ?>
								<?php echo utillz_core()->icon->get( $tab['icon'][0]->icon, $tab['icon'][0]->set ); ?>
							<?php endif; ?>
							<span>
								<?php echo esc_attr( $tab['title'] ); ?>
							</span>
						</li>
			        <?php endforeach; ?>

					<?php if( $action_fields->allow_pricing ): ?>
			            <li>
							<i class="material-icons">payment</i>
							<span><?php esc_html_e( 'Pricing', 'heilz' ); ?></span>
						</li>
			        <?php endif; ?>

			        <li>
						<i class="material-icons">thumb_up_off_alt</i>
						<span><?php esc_html_e( 'Finish', 'heilz' ); ?></span>
					</li>
			        <li>
						<i class="material-icons">done</i>
						<span><?php esc_html_e( 'Publish', 'heilz' ); ?></span>
					</li>

			    </ul>
			</div>

		</div>
	<?php endif; ?>

	<div class="ulz--content">
		<?php if( $ulz_explore->total_types ): ?>
			<div class="ulz--top">
				<?php if( $ulz_submission->id ): ?>
					<span class="ulz--image">
						<?php if( has_post_thumbnail( $ulz_submission->listing_type->id ) ): ?>
							<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $ulz_submission->listing_type->id ) ); ?>
							<span class="ulz--img" style="background-image: url(<?php echo esc_url( $image[0] ); ?>);"></span>
						<?php else: ?>
							<?php $icon = Ucore()->get( 'ulz_icon', $ulz_submission->listing_type->id ); ?>
							<?php echo Ucore()->dummy( Ucore()->get('ulz_icon__icon', $ulz_submission->listing_type->id), Ucore()->get('ulz_icon__set', $ulz_submission->listing_type->id), 100 ); ?>
						<?php endif; ?>
					</span>
					<h3 class="ulz--name ulz-ellipsis">
						<?php echo sprintf( esc_html__('Submit new %s', 'heilz'), $ulz_submission->listing_type->get('ulz_name') ); ?>
					</h3>
					<a href="<?php echo esc_url( $ulz_explore->total_types > 1 ? Ucore()->get_submission_page_url() : get_home_url() ); ?>" class="ulz-button">
						<?php esc_html_e('Exit', 'heilz'); ?>
					</a>
				<?php else: ?>
					<div class="ulz-site-logo ulz-text-center">
			            <a href="<?php echo get_home_url(); ?>">
			                <?php if( $logo = Utheme()->get_logo() ): ?>
			                    <img src="<?php echo esc_url( $logo ); ?>">
			                <?php else: ?>
			                    <span class="ulz-site-title ulz-font-heading">
			                        <?php echo esc_html( Utheme()->get_name() ); ?>
			                    </span>
			                <?php endif; ?>
			            </a>
			        </div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<div class="ulz--middle">
			<div class="ulz--row">

				<?php if( $ulz_explore->total_types ): ?>
					<?php if( $ulz_submission->get_listing_types()->found_posts ): ?>
					    <?php if( $ulz_submission->is_missing_type() ): ?>

							<?php Ucore()->the_template('submission/listing-type'); ?>

					    <?php else: ?>

						    <div class="ulz-submission-content">
						        <?php Ucore()->the_template('submission/steps'); ?>
						    </div>

					    <?php endif; ?>
					<?php else: ?>
					    <div class="ulz-submission-error ulz-block">
					        <div class="ulz--error">
					            <div class="ulz--content">
					                <?php esc_html_e( 'No listing types were found', 'heilz' ); ?>
					            </div>
					        </div>
					    </div>
					<?php endif; ?>
				<?php else: ?>
					<div class="ulz-submission-error ulz-block">
						<div class="ulz--error">
							<div class="ulz--content">
								<?php esc_html_e( 'No listing types were found', 'heilz' ); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</div>
		<?php if( $ulz_explore->total_types ): ?>
			<div class="ulz--bottom">
				<?php if( $ulz_submission->get_listing_types()->found_posts ): ?>
					<span class="ulz--progress"></span>
					<div class="ulz--cell ulz--cell-back">
						<?php if( $ulz_submission->id ): ?>
							<a href="#" class="ulz-button ulz--mutted" data-action="submission-back">
								<span class="fas fa-arrow-left ulz-mr-1"></span>
								<span><?php esc_html_e('Back', 'heilz'); ?></span>
								<?php Ucore()->preloader(); ?>
							</a>
						<?php endif; ?>
					</div>
					<?php if( $ulz_submission->id ): ?>
						<div class="ulz--cell ulz--cell-steps">
							<div class="ulz--steps">
								<span class="ulz--steps-current">1</span>
								&nbsp;/&nbsp;
								<span class="ulz--steps-total"></span>
							</div>
						</div>
					<?php endif; ?>
					<div class="ulz--cell ulz--cell-next">
						<a href="#" class="ulz-button ulz-button-accent" <?php echo is_user_logged_in() ? 'data-action="submission-continue"' : 'data-modal="signin"'; ?>>
							<span class="ulz--text"><?php esc_html_e( 'Continue', 'heilz' ); ?></span>
		                    <span class="fas fa-arrow-right ulz-ml-1"></span>
		                    <?php Ucore()->preloader(); ?>
						</a>
					</div>
					<?php if( ! $ulz_submission->id ): ?>
						<div class="ulz--cell"></div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php get_footer();
