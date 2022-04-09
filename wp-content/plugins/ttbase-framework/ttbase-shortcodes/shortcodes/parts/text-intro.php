<?php

// Intro Text -------------------------------------------------------------------------- >
function ttbase_framework_intro_text_shortcode( $atts, $content = null ) {
	
	// Parse and extract shortcode attributes
	extract( shortcode_atts( array(
		'color'        => '',
		'text_align'		   => '',
		'css_animation'    => '',
        'css_delay'        => '',
	), $atts ) );
	// Return output
	$css_animation_classes = '';
	$data_delay ='';
    if ( $css_animation ) {
        $css_animation_classes .= ' '. $css_animation;
        $data_delay = ($css_delay != '') ? ' data-delay="' . intval($css_delay) . '"' : '';
    }
	if (!empty($color)) {
		return '<p class="intro ' . esc_attr( $text_align ) . $css_animation_classes . '" style="color:' . esc_attr($color) . ';"' . $data_delay . '>' . do_shortcode( $content ) .'</p>';
	} else {
		return '<p class="intro ' . esc_attr( $text_align ) . $css_animation_classes . '"' . $data_delay . '>' . do_shortcode( $content ) .'</p>';	
	}

}
add_shortcode( 'ttbase_intro_text', 'ttbase_framework_intro_text_shortcode' );

?>