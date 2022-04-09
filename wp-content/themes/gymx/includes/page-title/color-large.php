<?php

$id = gymx_get_the_post_id();

$page_title_pos = rwmb_meta('gymx_post_pagetitle_pos', $id );
if ( $page_title_pos == '' ) {
	$page_title_pos = get_theme_mod( 'gymx_pagetitle_pos', 'text-left' );
}
$page_title = gymx_get_page_title($id);

$bg_color = get_post_meta( $id, 'gymx_post_header_color', true );
$bg_style = ($bg_color != '') ? ' style="background-color:'. esc_attr($bg_color) .';"' : '';

$pagetitle_color = get_post_meta( $id, 'gymx_post_pagetitle_color', true );
$pagetitle_style = ($pagetitle_color != '') ? ' style="color:'. esc_attr($pagetitle_color) .';"' : '';

$pagetitle_underline_color = get_post_meta($id, 'gymx_post_pagetitle_underline_color', true );
$pagetitle_underline_style = ($pagetitle_underline_color != '') ? ' style="border-color:'. esc_attr($pagetitle_underline_color) .';"' : '';

$breadcrumbs = (get_post_meta($id, 'gymx_post_breadcrumbs_hide', true) != true) ? '' : 'no-breadcrumbs';

$shortcodeColor = '<div class="background large color ' . sanitize_html_class($page_title_pos) . ' ' . sanitize_html_class($breadcrumbs) . '"' . $bg_style . '>';
$shortcodeColor .= '<div class="container"><div class="row header_text_wrapper v-align"><div class="col-xs-12">';
$show_separator = get_theme_mod('gymx_show_pagetitle_separator', 'yes');
$separator_class = ($show_separator == 'yes') ? ' class="title-separator"' : '';
$shortcodeColor .= '<h1' . $separator_class . $pagetitle_style . '>' . esc_attr( $page_title ) . '</h1>';
$shortcodeColor .= '</div></div><div class="row"><div class="col-xs-12">' . gymx_breadcrumbs() . '</div></div></div></div>';
echo do_shortcode($shortcodeColor);