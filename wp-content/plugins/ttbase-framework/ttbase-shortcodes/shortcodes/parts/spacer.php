<?php

// Spacer-------------------------------------------------------------------------- >	
function ttbase_framework_spacer_shortcode( $atts, $content = null ) {

	// Extract and parse attributes
	extract( shortcode_atts( array(
		'height'	=> '10'
	  ),
	  $atts ) );

	if($height == '') {
			$style = '';
		} else{
			$style = 'style="height: '. ttbase_framework_sanitize_data( $height, 'px' ). ';"';
		}

		return '<div class="ttbase-spacer" ' . $style . '></div>';

}
add_shortcode( 'ttbase_spacer', 'ttbase_framework_spacer_shortcode' );

?>