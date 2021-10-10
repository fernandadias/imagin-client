<?php

get_header();

?>

<div class="ulz-container">

	<?php if( post_password_required() ): ?>
	    <?php get_template_part('templates/title'); ?>
	<?php endif; ?>
	
	<?php
		while( have_posts() ) : the_post();
			get_template_part( 'templates/content', 'collection' );
		endwhile;
	?>
</div>

<?php get_footer();
