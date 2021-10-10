<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="ulz-native-search" autocomplete="off">
    <input type="text" class="ulz--input" name="s" placeholder="<?php esc_attr_e( 'Search ...', 'heilz' ); ?>" value="<?php echo esc_html( get_search_query() ); ?>">
    <button type="submit" class="ulz--submit">
        <i class="fas fa-search"></i>
    </button>
</form>
