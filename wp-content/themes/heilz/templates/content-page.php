<?php

$is_account = ( function_exists('is_account_page') && is_account_page() );

$is_explore = false;
if( function_exists('Ucore') ) {
    $is_explore = Ucore()->is_explore();
}

$is_nav = false;
if( ! $is_explore ) {
    if( $is_account && is_user_logged_in() ) {
        $is_nav = true;
    }
}

?>

<main class="ulz-main">
    <?php if( $is_nav ): ?>
        <?php get_template_part('templates/account/dashboard/mobile/navigation'); ?>
    <?php endif; ?>
    <?php if( $is_nav ): ?>
        <?php get_template_part('templates/account/dashboard/navigation'); ?>
    <?php endif; ?>
    <div class="ulz-content">
        <article <?php post_class(); ?>>

            <?php $page_id = get_the_ID(); ?>

            <div class="ulz-page-content">
                <?php the_content(); ?>
            </div>

            <?php wp_link_pages(); ?>

            <?php if( comments_open( $page_id ) ): ?>
                <?php comments_template(); ?>
            <?php endif; ?>

        </article>
    </div>
</main>
