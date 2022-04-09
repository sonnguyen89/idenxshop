<?php

// Items List --------------------------------------------------------------------- >
function ttbase_framework_list_shortcode( $atts, $content = null ) {

	extract(shortcode_atts(array(
			'text_align'	=> ''
		), $atts));
	
	return '<ul class="styled-list fa-ul ' . $text_align . '">'. do_shortcode($content) . '</ul>';

}
add_shortcode( 'ttbase_list', 'ttbase_framework_list_shortcode' );

// Item --------------------------------------------------------------------- >
function ttbase_framework_item_shortcode($atts, $content)
{
	extract(shortcode_atts(array(
			'icon_font' 	=> 'streamline',
			'icon_fa'      	=> '',
			'icon_sl'		=> '',
			'icon_im'		=> '',
			'icon_color'	=> '',
			'width'			=> ''
		), $atts));
		
		if ($icon_font == 'streamline') {
			$icon  = ttbase_framework_shortcodes_streamline_font_icon_class( $icon_sl );
		}elseif ($icon_font == 'iconsmind') {
			$icon  = ttbase_framework_shortcodes_iconsmind_font_icon_class( $icon_im );
		}else {
			$icon  = ttbase_framework_shortcodes_font_icon_class( $icon_fa );
		}
		$icon_class = ($icon != '') ? '' : ' class="none" ';
		$icon_style = ($icon_color !='') ? 'style="color:'.$icon_color.';"' : '';
		$width_style = ($width != '') ? 'style="width:' . $width . ';"' : '';
		return '<li><div' . $icon_class . $width_style . '><i class="'.esc_attr($icon).'" '. $icon_style . '></i>'. do_shortcode($content) . '</div></li>';
}
add_shortcode("ttbase_item", "ttbase_framework_item_shortcode");

?>