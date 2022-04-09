<?php

// Callout -------------------------------------------------------------------------- >	
function ttbase_framework_callout_shortcode( $atts, $content = null  ) {
	extract( shortcode_atts( array(
		'caption'				=> '',
		'button_text'			=> '',
		'fade_in'				=> '',
		'button_style'			=> 'style-1',
		'button_size'			=> '',
		'button_url'			=> '#',
		'button_rel'			=> 'nofollow',
		'button_target'			=> 'blank',
		'button_title'			=> esc_html__( 'Callout button', 'ttbase-framework' ),
		'class'					=> '',
		'button_icon_left'		=> '',
		'button_icon_right'		=> '',
	), $atts ) );

	// Sanitize
	$button_icon_left  = ttbase_framework_shortcodes_font_icon_class( $button_icon_left );
	$button_icon_right = ttbase_framework_shortcodes_font_icon_class( $button_icon_right );
	$button_url        = esc_url( $button_url );
	$button_title      = esc_attr( $button_title );
	
	// Fade in
	$fade_in_class = null;
	if ( $fade_in == 'true' ) {
		wp_enqueue_script( 'ttbase-scroll-fade' );
		$fade_in_class = 'ttbase-fadein';
	}
	
	// Display Callout
	$output = '<div class="ttbase-callout clearfix '. $class .' '. $fade_in_class .'">';
	$output .= '<div class="ttbase-callout-caption">';
		$output .= do_shortcode ( $content );
	$output .= '</div>';	
	if ( $button_text && $button_url ) {
		$button_rel    = 'nofollow' == $button_rel ? ' rel="nofollow"' : null;
		$button_target = ( strpos( $button_target, 'blank' ) !== false ) ? ' target="_blank"' : null;
		$output .= '<div class="ttbase-callout-button">';
			$output .= '<a href="' . $button_url .'" class="ttbase-button btn btn-primary '. $button_size .' ' . $button_style . '" title="'. $button_title .'" ' . $button_rel . $button_target .'>';
				$output .= '<span class="ttbase-button-inner">';
					if ( $button_icon_left ) {
						$output .= '<span class="ttbase-button-icon-left '. $button_icon_left .'"></span>';
					}
					$output .= $button_text;
					if ( $button_icon_right ) {
						$output .= '<span class="ttbase-button-icon-right '. $button_icon_right .'"></span>';
					}
				$output .= '</span>';
			$output .= '</a>';
		$output .= '</div>';
	}
	$output .= '</div>';
	
	return $output;
}
add_shortcode( 'ttbase_callout', 'ttbase_framework_callout_shortcode' );

?>