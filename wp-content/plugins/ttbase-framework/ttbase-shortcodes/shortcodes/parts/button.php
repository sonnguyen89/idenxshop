<?php

function ttbase_framework_button_shortcode( $atts, $content = null ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
		'style'         => 'style-1',
		'color_style'	=> 'color-1',
		'gradient_start_color'	=> '',
		'gradient_end_color'	=> '',
		'gradient_dir'	=> '90deg',
		'url'           => '#',
		'title'         => esc_html__( 'Button', 'ttbase-framework' ),
		'target'        => 'self',
		'size'          => '',
		'border_radius' => '',
		'width_100'		=> 'false',			
		'rel'           => '',
		'class'         => '',
		'icon_font'		=> 'streamline',
		'icon_left_im'     => '',
		'icon_right_im'    => '',
		'icon_left_sl'     => '',
		'icon_right_sl'    => '',
		'icon_left_fa'     => '',
		'icon_right_fa'    => '',
		'css_animation'    => '',
        'css_delay'        => '',
		'align'         => '',
	), $atts ) );

	//Set Vars
	$css_animation_classes = '';
	$data_delay ='';
    if ( $css_animation ) {
        $css_animation_classes .= ' '. $css_animation;
        $data_delay = ($css_delay != '') ? ' data-delay="' . intval($css_delay) . '"' : '';
    }

	// Sanitize
	$url 		= esc_url($url);
	$title      = $title ? esc_attr( $title ) : '';
	$rel        = ( $rel !== 'none' ) ? ' rel="'.$rel.'"' : null;
	if ($icon_font == 'streamline') {
		$icon_left  = ttbase_framework_shortcodes_streamline_font_icon_class( $icon_left_sl );
		$icon_right = ttbase_framework_shortcodes_streamline_font_icon_class( $icon_right_sl );
	}
	elseif ($icon_font == 'iconsmind') {
		$icon_left  = ttbase_framework_shortcodes_iconsmind_font_icon_class( $icon_left_im );
		$icon_right = ttbase_framework_shortcodes_iconsmind_font_icon_class( $icon_right_im );
	}else {
		$icon_left  = ttbase_framework_shortcodes_font_icon_class( $icon_left_fa );
		$icon_right = ttbase_framework_shortcodes_font_icon_class( $icon_right_fa );
	}
	

	// Display Button
	if ( $url && $title ) {

		$output= null;
		$inline_style = '';
		$border_style = ($border_radius != '') ? 'border-radius:' . ttbase_framework_sanitize_data( $border_radius, 'px' ) . ';"' : '';
		$inline_style .= $border_style;
		
		//Gradient Style
		if ($style == 'style-3' && $gradient_start_color !='' && $gradient_end_color != '') {
			$gradient_style = 'background:linear-gradient(' . $gradient_dir . ',' . $gradient_start_color . ',' . $gradient_end_color . ' 80%,' . $gradient_end_color . ');';
			$inline_style .= $gradient_style;
		}
		
		$inline_style = ($inline_style != '') ? 'style="' . $inline_style . '"' : '';
		
		$align_class = ($align != 'aligncenter') ? ' ' . $align : '';
		$class = ($class != '') ? ' ' . $class : '';
		$style = ($style != 'style-1') ? ' ' . $style : '';
		$size = ($size != '') ? ' ' . $size : '';
	
		$width_100 = ($width_100 == 'true') ? ' btn-width-100' : '';
		$color_style = ($color_style != 'color-1') ? ' ' . $color_style : '';
		if ($align == 'aligncenter') {
			$output .= '<div class="button-center-wrapper text-center">';
		}
		$output .= '<a href="' . $url . '" class="btn btn-primary'. $size . $style . $class . $css_animation_classes . $align_class . $width_100 . $color_style . '"' . $inline_style . ' target="_'.$target.'" title="'. $title .'"'. $rel . $data_delay . '>';
			$output .= '<span class="ttbase-button-inner">';
				if ( $icon_left ) {
					$output .= '<i class="ttbase-button-icon-left '. $icon_left .'"></i>';
				}
				$output .= $title;
				if ( $icon_right ) {
					$output .= '<i class="ttbase-button-icon-right '. $icon_right .'"></i>';
				}
			$output .= '</span>';
		$output .= '</a>';
		if ($align == 'aligncenter') {
			$output .= '</div>';
		}
		return $output;
		

	} else {

		return '<p>'. esc_html__( 'Please enter a valid URL and title for your button.', 'ttbase-framework' ) .'</p>';

	}

}
add_shortcode( 'ttbase_button', 'ttbase_framework_button_shortcode' );

?>