<?php

function ttbase_framework_counter_shortcode( $atts ) {
		extract(shortcode_atts(array(
			'number' => '197',
			'title'  => '',
			'color'  => '#3cb087',
			'title_color' => '#1e2221',
			'background_color' => '#ffffff',
			'border_color' => ''
		), $atts));
		
	// Enque scripts
	wp_enqueue_script( 'ttbase-counter' );
	
	return '<div class="ttbase-counter card clearfix wpb_content_element" style="border-color:' . esc_attr($border_color) . '; background-color: ' . esc_attr($background_color) . ';"><div class="ttbase-counter-number" style="color: '.esc_attr($color).';">' .esc_html($number). '</div><div class="separator" style="border-color:' . esc_attr($color) . ';"></div><div class="ttbase-counter-title" style="color: ' . esc_attr($title_color) . ';">' .esc_html($title). '</div></div>';
}
	
add_shortcode('ttbase_counter', 'ttbase_framework_counter_shortcode');

?>