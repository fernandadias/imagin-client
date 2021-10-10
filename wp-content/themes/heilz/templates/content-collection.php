<main class="ulz-main">
    <div class="ulz-content">
        <article <?php post_class(); ?>>

            <div class="ulz-page-content">
                <?php if( ! post_password_required() ): ?>
                    <?php Ucore()->the_template('explore/explore'); ?>
                <?php else: ?>
                    <div class="ulz-row">
                        <?php echo get_the_password_form(); ?>
                    </div>
                <?php endif; ?>
            </div>

        </article>
    </div>
</main>
