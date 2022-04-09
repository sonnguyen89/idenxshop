<?php
/**
 * Header Small Logo Part
 */

$logo = ( get_post_meta( $id, 'gymx_post_logo_mobile', true ) !='' ) ? wp_get_attachment_url( get_post_meta( $id, 'gymx_post_logo_mobile', true ) ) : get_theme_mod( 'gymx_logo_mobile', get_template_directory_uri() . '/img/logo_small.png' );
$logo2x = ( get_post_meta( $id, 'gymx_post_logo2x_mobile', true ) !='' ) ? wp_get_attachment_url( get_post_meta( $id, 'gymx_post_logo2x_mobile', true ) ) : get_theme_mod( 'gymx_logo2x_mobile', get_template_directory_uri() . '/img/logo_small2x.png' );
$logo_width_height = get_theme_mod( 'gymx_logo_width_height', '' );
if( is_ssl() ) {
    $logo = str_replace( 'http://', 'https://', $logo );
    $logo2x = str_replace( 'http://', 'https://', $logo2x );
};
?>

<!-- small size logo, only used in shrink mode -->
<?php if ( ! empty( $logo ) ) : ?>
    <div class="small-logo-wrapper">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="site-logo-small" title="<?php echo esc_attr( get_bloginfo( 'name','display' ) ); ?>" rel="home">
            <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" srcset="<?php echo esc_url($logo); ?><?php echo empty ( $logo2x ) ? '' : ', ' . esc_url($logo2x) . ' 2x'; ?>" class="img-responsive" <?php echo wp_kses_post($logo_width_height); ?> />
        </a>
    </div>
<?php endif; ?>