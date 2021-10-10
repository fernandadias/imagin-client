<?php

defined('ABSPATH') || exit;

global $ulz_site;

?>

<?php $tag = isset( $ulz_site->url ) ? 'a' : 'em'; ?>
<?php $href = isset( $ulz_site->url ) ? sprintf( ' href="%s"',  esc_url( $ulz_site->url ) ) : ''; ?>
<div class="ulz--site<?php if( $ulz_site->active ) { echo ' ulz--active'; } ?>">
    <<?php echo esc_html( $tag ) . $href; ?>>
        <div class="ulz--icon">
            <?php echo utillz_core()->icon->get( $ulz_site->icon['icon'], $ulz_site->icon['set'] ); ?>
        </div>
        <div class="ulz--text">
            <?php if( isset( $ulz_site->text ) ): ?>
                <?php echo esc_html( $ulz_site->text ); ?>
            <?php endif; ?>
            <span class="ulz--date">
                <?php $offset = get_option('gmt_offset') * HOUR_IN_SECONDS; ?>
                <?php echo date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $ulz_site->created_utc ) + $offset ); ?>
            </span>
        </div>
        <?php if( $ulz_site->active ): ?>
            <div class="ulz--status">
                <span></span>
            </div>
        <?php endif; ?>
    </<?php echo esc_html( $tag ); ?>>
</div>
