<?php

// Heading -------------------------------------------------------------------------- >
function ttbase_framework_heading_shortcode( $atts ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
		'title'			=> esc_html__( 'Sample Heading', 'ttbase-framework' ),
		'type'			=> 'h2',
		'margin_top'	=> '',
		'margin_bottom'	=> '',
		'text_align'	=> '',
		'font_size'		=> '',
		'color'			=> '',
		'class'			=> '',
		'span_bg'       => '',
		'icon_font'		=> 'streamline',
		'icon_left_sl'     => '',
		'icon_right_sl'    => '',
		'icon_left_im'     => '',
		'icon_right_im'    => '',
		'icon_left_fa'     => '',
		'icon_right_fa'    => '',
		'css_animation'    => '',
        'css_delay'        => '',
	  ),
	  $atts ) );

	// Sanitize icons
	if ($icon_font == 'streamline') {
		$icon_left  = ttbase_framework_shortcodes_streamline_font_icon_class( $icon_left_sl );
		$icon_right = ttbase_framework_shortcodes_streamline_font_icon_class( $icon_right_sl );
	}elseif ($icon_font == 'iconsmind') {
		$icon_left  = ttbase_framework_shortcodes_iconsmind_font_icon_class( $icon_left_im );
		$icon_right = ttbase_framework_shortcodes_iconsmind_font_icon_class( $icon_right_im );
	}else {
		$icon_left  = ttbase_framework_shortcodes_font_icon_class( $icon_left_fa );
		$icon_right = ttbase_framework_shortcodes_font_icon_class( $icon_right_fa );
	}
  	$title = esc_attr($title);
	
	$css_animation_classes = '';
	$data_delay ='';
    if ( $css_animation ) {
        $css_animation_classes .= ' '. $css_animation;
        $data_delay = ($css_delay != '') ? ' data-delay="' . intval($css_delay) . '"' : '';
    }
    
	// Inline styles
	$style_attr = '';
	if ( $font_size ) {
		$style_attr .= 'font-size: '. $font_size .';';
	}
	if ( $color ) {
		$style_attr .= 'color: '. $color .';';
	}
	if ( $margin_bottom ) {
		$style_attr .= 'margin-bottom: '. intval( $margin_bottom ) .'px;';
	}
	if ( $margin_top ) {
		$style_attr .= 'margin-top: '. intval( $margin_top ) .'px;';
	}
	if ( $style_attr ) {
		$style_attr = 'style="'. $style_attr .'"';
	}
	if ( $span_bg ) {
		$span_bg = ' style="background-color:'. $span_bg .';"';
	}

	// Text aligns
	if ( $text_align ) {
		$text_align = 'text-align-'. $text_align;
	} else {
		$text_align = 'text-align-left';
	}
	
	// Output
	$output = '<'.$type.' class="ttbase-heading '. $text_align .' '. $class . $css_animation_classes . '" '. $style_attr . $data_delay . '>';
		$output .= '<span'. $span_bg .'>';
			if ( $icon_left ) {
				$output .= '<i class="ttbase-heading-icon-left '. $icon_left .'"></i>';
			}
				$output .= $title;
			if ( $icon_right ) {
				$output .= '<i class="ttbase-heading-icon-right '. $icon_right .'"></i>';
			}
		$output .= '</span>';
	$output .= '</'.$type.'>';
	
	// Return output
	return $output;

}
add_shortcode( 'ttbase_heading', 'ttbase_framework_heading_shortcode' );

?>