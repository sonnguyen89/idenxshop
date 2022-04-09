<?php

// Modal -------------------------------------------------------------------- >
function ttbase_framework_modal_shortcode( $atts, $content = null ) {
	
	global $gymx_modal_content;
	
	extract( 
		shortcode_atts( 
			array(
				'image' 		=> '',
				'fullscreen' 	=> 'no',
				'button_text' 	=> '',
				'button_style'	=> 'style-1',
				'button_size'	=> '',
				'bg_color'		=> '',
				'close_color' 	=> '',
				'icon_font' 	=> 'streamline',
				'icon_sl' 		=> '',
				'icon_im' 		=> '',
				'icon_fa' 		=> '',
				'delay' 		=> false,
				'align' 		=> 'text-center',
				'cookie' 		=> false,
				'manual_id' 	=> false
			), $atts 
		) 
	);
	
	// Enque scripts
	wp_enqueue_script( 'ttbase-modal' );
	
	$id = ( $manual_id ) ? $manual_id : rand(0, 10000);
	
	$cookie = ( $cookie ) ? 'data-cookie="'. $cookie .'"' : false;

	$classes = ($image) ? 'image-bg overlay' : false;
	
	if ($icon_font == 'streamline') {
		$icon = ttbase_framework_shortcodes_streamline_font_icon_class( $icon_sl );
	}elseif ($icon_font == 'iconsmind') {
		$icon = ttbase_framework_shortcodes_iconsmind_font_icon_class( $icon_im );
	}else {
		$icon = ttbase_framework_shortcodes_font_icon_class( $icon_fa );
	}
	
	
	if( 'yes' == $fullscreen ){
		$classes .= ' fullscreen';	
	}
	
	if( 'fullwidth' == $fullscreen ){
		$classes .= ' fullscreen fullwidth';	
	}
	
	if( $delay ){
		$delay = 'data-time-delay="'. (int) $delay .'"';	
	}
	
	$bg_color = ( $bg_color != '' ) ? 'style="background-color:'. $bg_color .';"' : '';
	$close_color = ( $close_color ) ? 'style="color:'. $close_color .';"' : '';
	
	$output = '<div class="modal-container '. $align .'"><a class="btn btn-primary btn-modal ' . $button_size . ' ' . $button_style . '" href="#" modal-link="'. esc_attr($id) .'"><i class="'. $icon .'"></i> '. $button_text .'</a>';
	
	$output2 = '<div class="ttbase-modal '. $classes .'" '. $delay .' ' . $bg_color . ' '. esc_attr($cookie) .' modal-link="'. esc_attr($id) .'"><i class="icon-close close-modal" ' . $close_color . '></i>';
	
	if($image != ''){
		$output2 .= '
			<div class="background-image-holder">
				'. wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') ) .'
			</div>
		';	
	}
	
	if( 'fullwidth' == $fullscreen ){
		$output2 .= '<div class="ttbase-modal-content">';
	}
	
	$output2 .= do_shortcode($content);
	
	if( 'fullwidth' == $fullscreen ){
		$output2 .= '</div>';
	}
	
	$output2 .= '</div>';
	
	$output .= '</div>';
	
	$gymx_modal_content .= $output2;
	
	return $output;
}
add_shortcode( 'ttbase_modal', 'ttbase_framework_modal_shortcode' );

?>