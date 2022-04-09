<?php

// Progressbar -------------------------------------------------------------------------- >	
function ttbase_framework_progressbar_shortcode( $atts ) {

	// Parse and extract shortcode attributes
	extract( shortcode_atts( array(
		'title'        => '',
		'percentage'   => '100',
		'color'        => '',
		'class'        => '',
		'show_percent' => 'true'
	), $atts ) );
	
	$title = esc_attr($title);
	
	// Define output var
	$output = '';
	
	// Enque scripts
	wp_enqueue_script( 'ttbase-skillbar' );

	
	// Open skillbar main wrapper
	$output .= '<div class="ttbase-skillbar-wrapper clearfix">';
	
	// Display title
	if ( $title ) {
		$output .= '<div class="ttbase-skillbar-title"><span>'. $title .'</span></div>';
	}
	// Display percentage
	if ( $show_percent == 'true' ) {
		$output .= '<div class="ttbase-skill-bar-percent">'.$percentage.'%</div>';
	}
		
	$output .= '<div class="ttbase-skillbar '. $class .'" data-percent="'. $percentage .'%">';


		// Display bar
		$output .= '<div class="ttbase-skillbar-bar" style="background: '. $color .';"></div>';

	// Close main wrapper
	$output .= '</div></div>';
	
	// Return output
	return $output;
}

add_shortcode( 'ttbase_progressbar', 'ttbase_framework_progressbar_shortcode' );

?>