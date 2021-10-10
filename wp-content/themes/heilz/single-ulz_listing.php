<?php

get_header();

?>

<main class="ulz-main">
	<div class="ulz-content">
		<?php
			while( have_posts() ): the_post();
				the_content();
			endwhile;
		?>
	</div>
</main>

<?php get_footer();
