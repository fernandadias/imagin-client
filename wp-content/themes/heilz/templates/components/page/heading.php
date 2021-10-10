<?php global $brk_title, $brk_subtitle; ?>

<?php if( $brk_title ): ?>
    <header class="ulz--heading">
        <h3 class="ulz--title">
            <?php echo wp_kses( html_entity_decode( $brk_title ), Ucore()->allowed_html() ); ?>
        </h3>
        <?php if( $brk_subtitle ): ?>
            <p><?php echo wp_kses( html_entity_decode( Ucore()->format_url( $brk_subtitle ) ), Ucore()->allowed_html() ); ?></p>
        <?php endif; ?>
    </header>
<?php endif; ?>
