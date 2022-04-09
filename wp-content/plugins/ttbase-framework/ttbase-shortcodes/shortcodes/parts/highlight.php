<?php

// Highlights -------------------------------------------------------------------------- >	
function ttbase_framework_highlight_shortcode( $atts, $content = null ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
		'color'	=> 'blue',
		'class'	=> '',
	  ),
	  $atts ) );

	// Return output
	return '<div class="ttbase-highlight ttbase-highlight-'. $color .' '. $class .'">' . do_shortcode( $content ) . '</div>';

}
add_shortcode( 'ttbase_highlight', 'ttbase_framework_highlight_shortcode' );

?>