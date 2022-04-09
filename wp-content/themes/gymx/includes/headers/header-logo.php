<?php
/**
 * Header Normal Logo Part
 */
$header = get_theme_mod( 'gymx_header_style', 'header-top-full');
$page_header_style = get_post_meta( $id, 'gymx_post_header_style', true );
if ( $page_header_style != '' ) {
    $header = $page_header_style;
}
   
if ($header == 'header-transparent-full' || $header == 'header-transparent-boxed') {
    $logo = ( get_post_meta( $id, 'gymx_post_logo_img_transparent', true ) !='' ) ? wp_get_attachment_url( get_post_meta( $id, 'gymx_post_logo_img_transparent', true ) ) : get_theme_mod( 'gymx_logo_img_transparent', get_template_directory_uri() . '/img/logo_transparent.png' );
    $logo2x = ( get_post_meta( $id, 'gymx_post_logo2x_img_transparent', true ) !='' ) ? wp_get_attachment_url( get_post_meta( $id, 'gymx_post_logo2x_img_transparent', true ) ) : get_theme_mod( 'gymx_logo2x_img_transparent', get_template_directory_uri() . '/img/logo_transparent2x.png' );
}
else {
    $logo = ( get_post_meta( $id, 'gymx_post_logo_img', true ) !='' ) ? wp_get_attachment_url( get_post_meta( $id, 'gymx_post_logo_img', true ) ) : get_theme_mod( 'gymx_logo_img', get_template_directory_uri() . '/img/logo.png' );
    $logo2x = ( get_post_meta( $id, 'gymx_post_logo2x_img', true ) !='' ) ? wp_get_attachment_url( get_post_meta( $id, 'gymx_post_logo2x_img', true ) ) : get_theme_mod( 'gymx_logo2x_img', get_template_directory_uri() . '/img/logo2x.png' );
}
$logo_width_height = get_theme_mod( 'gymx_logo_width_height', '' );
if( is_ssl() ) {
    $logo = str_replace( 'http://', 'https://', $logo );
    $logo2x = str_replace( 'http://', 'https://', $logo2x );
};
?>

<!-- normal size logo -->
<?php if ( ! empty( $logo ) ) : ?>
    <div class="logo-wrapper">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="site-logo" title="<?php echo esc_attr( get_bloginfo( 'name','display' ) ); ?>" rel="home">
            <?php if (!empty($logo) || !empty($logo2x)) { ?>
                <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" srcset="<?php echo esc_url($logo); ?><?php echo empty ( $logo2x ) ? '' : ', ' . esc_url($logo2x) . ' 2x'; ?>" class="img-responsive" <?php echo wp_kses_post( $logo_width_height ); ?> />
            <?php }else {
                echo esc_attr( get_bloginfo( 'name','display' ) );
            } ?>
        </a>
    </div>
<?php endif; ?>