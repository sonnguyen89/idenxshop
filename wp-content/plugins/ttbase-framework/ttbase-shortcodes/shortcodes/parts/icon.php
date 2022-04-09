<?php

// Font Awesome & Streamline Icons -------------------------------------------------------------------------- >
function ttbase_framework_icon_shortcode( $atts, $content = null ) {
	
	// Extract and parse attributes
	extract( shortcode_atts( array(
			'icon_font'		=> 'streamline',
			'icon_fa'       => 'none',
			'icon_sl'		=> 'none',
			'icon_im'		=> 'none',
			'style'         => '',
			'float'         => 'center',
			'size'          => 'normal',
			'custom_size'	=> '',
			'color'         => '',
			'background'    => '',
			'border_radius' => '',
			'url'           => '',
			'url_title'     => '',
			'css_animation' => '',
            'css_delay'     => '',
	), $atts ) );
	
	$output = '';
	$animation_class='';
	$data_delay ='';
    if ( $css_animation ) {
        $animation_class .= ' ' . $css_animation;
        $data_delay = ($css_delay != '') ? ' data-delay="' . intval($css_delay) . '"' : '';
    }
	
	// Sanitize icon
	$url       = esc_url( $url );
	$url_title = esc_attr( $url_title );
	
	// Inline style
	$style_attr = '';

	if ( $color ) {
		$style_attr .= 'color:'. $color .';';
	}
	if ( $background ) {
		$style_attr .= 'background-color:'. $background .';';
	}
	if ( $border_radius ) {
		$style_attr .= 'border-radius:'. ttbase_framework_sanitize_data( $border_radius, 'px' ) .';';
	}
	if ( $custom_size ) {
		$style_attr .= 'font-size:'. ttbase_framework_sanitize_data( $custom_size, 'font_size' ) .';';
	}
	if ( $style_attr ) {
		$style_attr = ' style="'. $style_attr .'"';
	}
	
	if ($icon_font == 'streamline') {
		$icon = ttbase_framework_shortcodes_streamline_font_icon_class( $icon_sl );
	}elseif ($icon_font == 'iconsmind') {
		$icon = ttbase_framework_shortcodes_iconsmind_font_icon_class( $icon_im );
	}else {
		$icon = ttbase_framework_shortcodes_font_icon_class( $icon_fa );
	}
	$icon = $icon == 'none' ? 'remove' : $icon;
	
	if ( $url ) {
		$output .= '<a href="'. $url .'" title="'. $url_title .'" class="ttbase-icon ttbase-icon-'. $style.' ttbase-icon-'. $size .' ttbase-icon-float-'. $float . $animation_class .'" ' . $style_attr . $data_delay . '>';
		$output .= '<span class="'. $icon .'"></span>';
		$output .= '</a>';
	} else {
		$output .= '<span class="ttbase-icon ttbase-icon-'. $style.' ttbase-icon-'. $size .' ttbase-icon-float-'. $float .' '. $icon . $animation_class .'"' . $style_attr . $data_delay . '></span>';
	}
	
	// Return output
	return $output;

}
add_shortcode( 'ttbase_icon', 'ttbase_framework_icon_shortcode' );

?>