<?php

// WPML -------------------------------------------------------------------------- >
function ttbase_framework_wpml_shortcode( $atts, $content = null ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
		'lang'	=> '',
	), $atts));

	// Translate
	if ( ! defined( 'ICL_LANGUAGE_CODE' ) ) {
		return esc_html__( 'WPML Plugin does not exist. If you want to translate something please first install the WPML plugin.', 'ttbase-framework' );
	}

	// Return string
	if ( $lang == ICL_LANGUAGE_CODE ) {
		return do_shortcode($content);
	}

}
add_shortcode( 'ttbase_wpml', 'ttbase_framework_wpml_shortcode' );

?>