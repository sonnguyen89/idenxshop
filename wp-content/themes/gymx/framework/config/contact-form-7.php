<?php
//add html5 support
add_filter( 'wpcf7_support_html5', '__return_true' );

//add Html5 fallback for datepicker and number selector for contact form
add_filter( 'wpcf7_support_html5_fallback', '__return_true' );

//add correct button style from customizer to contact form 7
add_filter('wpcf7_form_elements','gymx_wpcf7_form_elements');
function gymx_wpcf7_form_elements( $content ) {
	
	$rl_pfind = '/wpcf7-submit/';
	if ('style-1' == get_theme_mod('gymx_button_style', 'style-2')) {
		$rl_preplace = 'btn btn-primary';
	}
	else {
		$rl_preplace = 'btn btn-primary style-2';
	}
	$content = preg_replace( $rl_pfind, $rl_preplace, $content);

	return $content;	
}