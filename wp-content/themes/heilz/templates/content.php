<main class="ulz-main">
    <div class="ulz-content">
        <article <?php post_class(); ?>>
            <?php the_content(); ?>
            <?php wp_link_pages(); ?>
        </article>
    </div>
    <?php if( is_active_sidebar('sidebar') ): ?>
        <div class="ulz-sidebar">
            <div class="">
                <?php dynamic_sidebar('sidebar'); ?>
            </div>
        </div>
    <?php endif; ?>
</main>