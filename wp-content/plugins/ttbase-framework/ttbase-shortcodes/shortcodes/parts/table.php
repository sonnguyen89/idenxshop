<?php

// Table -------------------------------------------------------------------------- >
function ttbase_framework_table_shortcode( $atts, $content = null ) {

	extract( shortcode_atts( array(
			'style' 	=> '1'
		), $atts ) );

		return '<div class="table-responsive table-style-' . esc_attr($style) . '">'. do_shortcode($content) . '</div>';

}
add_shortcode( 'ttbase_table', 'ttbase_framework_table_shortcode' );

?>