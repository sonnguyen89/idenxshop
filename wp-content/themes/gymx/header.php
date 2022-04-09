<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
</head>

<?php
$id = gymx_get_the_post_id();
$site_bg_color = get_post_meta($id, 'gymx_post_site_bg_color', true);
?>
<body <?php body_class(); ?> <?php if($site_bg_color != '') { echo 'style="background-color:' . esc_attr($site_bg_color) . ';"'; } ?>>

<?php
	$sticky_style = get_theme_mod( 'gymx_header_sticky', 'static' );
	$header_style = get_theme_mod( 'gymx_header_style', 'header-top-full');
	$page_header_style = get_post_meta( $id, 'gymx_post_header_style', true );
	
	if ( $page_header_style != '' ) {
            $header_style = $page_header_style;
       }
?>
<div id="page" class="site-wrapper <?php echo get_theme_mod( 'gymx_site_layout', 'full-width' ) . ' ' . $header_style ?>">

    <?php
        get_template_part( 'includes/headers/'. $header_style );
        
        if ($sticky_style == 'sticky' && $header_style != 'header-none') {
        	get_template_part( 'includes/headers/header-sticky' );
        }
        
        if ($header_style != 'header-none') {
        	get_template_part( 'includes/headers/header-mobile' );
        }
		
        //only load page title templates when it is not hide for the page or post
        if ( get_post_meta( $id, 'gymx_post_header', true ) != 'hide' ) {
        	//get page title style from page settings, global default is color
			$header_bg = get_post_meta( $id, 'gymx_post_header_background', true );
			if ( empty( $header_bg ) ) {
	            $header_bg = 'color';
	        }
	        
			if($header_bg == 'slider') {
	        	$slider = get_post_meta( $id, 'gymx_post_header_slider', true );
				echo do_shortcode($slider); 
			}
			else {
				//Set header height. Get from page settings or global customizer
				$header_height = get_post_meta( $id, 'gymx_post_header_height', true );
				if ( empty( $header_height ) ) {
		            $header_height = get_theme_mod('gymx_pagetitle_height', 'x-small');
		        }
				//header height extra small is only for color
				if ( $header_height != 'x-small' ) {
		            get_template_part( 'includes/page-title/'. $header_bg .'-' . $header_height );
		        }
		        else {
		        	get_template_part( 'includes/page-title/color-x-small' );
		        }
			}
        }