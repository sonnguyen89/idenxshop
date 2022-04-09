<?php
$id = gymx_get_the_post_id();
$page_title_pos = get_post_meta( $id, 'gymx_post_pagetitle_pos', true );
if ( $page_title_pos == '' ) {
	$page_title_pos = get_theme_mod( 'gymx_pagetitle_pos', 'text-left' );
}
$page_title = gymx_get_page_title($id);

$bg_color = get_post_meta( $id, 'gymx_post_header_color', true );
$bg_style = ($bg_color != '') ? ' style="background-color:'.esc_attr($bg_color).';"' : '';

$pagetitle_color = get_post_meta( $id, 'gymx_post_pagetitle_color', true );
$pagetitle_style = ($pagetitle_color != '') ? ' style="color:'. esc_attr($pagetitle_color) .';"' : '';

$breadcrumbs = (get_post_meta( $id, 'gymx_post_breadcrumbs_hide', true) != true) ? '' : 'no-breadcrumbs';

$shortcodeColor = '<div class="background x-small color ' . esc_attr( $page_title_pos ) . ' ' . esc_attr($breadcrumbs) . '"' . $bg_style . '><div class="container">';
$shortcodeColor .= '<div class="row header_text_wrapper v-align">';
if ($page_title_pos != 'text-right') {
	$shortcodeColor .= '<div class="col-xs-12 col-sm-12 col-md-6"><h1' . $pagetitle_style . '>' . esc_attr( $page_title ) . '</h1></div>';
	$shortcodeColor .= '<div class="col-xs-12 col-sm-12 col-md-6">' . gymx_breadcrumbs() . '</div>';
}else {
	$shortcodeColor .= '<div class="col-xs-12 col-sm-12 col-md-6">' . gymx_breadcrumbs() . '</div>';
	$shortcodeColor .= '<div class="col-xs-12 col-sm-12 col-md-6"><h1' . $pagetitle_style . '>' . esc_attr( $page_title ) . '</h1></div>';
}

$shortcodeColor .= '</div></div></div>';
  
echo do_shortcode($shortcodeColor);