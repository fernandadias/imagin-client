<?php

get_header();

?>

<div class="ulz-container">

	<?php get_template_part('templates/title'); ?>

	<div class="ulz-row">

		<?php
			while ( have_posts() ) : the_post();
				get_template_part( 'templates/content', get_post_type() );
			endwhile;
		?>

	</div>
</div>

<?php get_footer();
