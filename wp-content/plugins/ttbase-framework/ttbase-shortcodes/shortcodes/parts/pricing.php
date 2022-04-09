<?php

// Pricing Table -------------------------------------------------------------------------- >

function ttbase_framework_pricing_table_shortcode( $atts, $content = null ) {
	extract( 
		shortcode_atts( 
			array(
				'title' 		=> '',
				'title_color'	=> '',
				'small' 		=> '',
				'small_color'	=> '',
				'amount'		=> '$3',
				'amount_color'	=> '',
				'button_text'	=> 'Select Plan',
				'button_url'	=> '',
				'button_style'	=> '',
				'layout'		=> 'basic'
			), $atts 
		) 
	);
	
	$button_url        = esc_url( $button_url );
	$title_style = ($title_color != '') ? ' style="color:' . esc_attr($title_color) . ';"' : '';
	$price_style = ($amount_color != '') ? ' style="color:' . esc_attr($amount_color) . ';"' : '';
	$small_style = ($small_color != '') ? ' style="color:' . esc_attr($small_color) . ';"' : '';
	
	if( 'basic' == $layout ){
		$output = '
			<div class="ttbase-pricing-table card text-center basic">
		        <h4' . $title_style . '>'. htmlspecialchars_decode($title) .'</h4>
		        <span class="price"' . $price_style . '>'. htmlspecialchars_decode($amount) .'</span>
		        <p class="lead"' . $small_style . '>'. htmlspecialchars_decode($small) .'</p>
		        <a class="btn btn-primary ' . $button_style . '" href="'. $button_url  .'"><span class="ttbase-button-inner">'. htmlspecialchars_decode($button_text) .'</span></a>
		        '. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
		    </div>
	    ';
	} elseif( 'boxed' == $layout ) {
		$output = '
		    <div class="ttbase-pricing-table card text-center boxed">
		        <h4' . $title_style . '>'. htmlspecialchars_decode($title) .'</h4>
		        <span class="price"' . $price_style . '>'. htmlspecialchars_decode($amount) .'</span>
		        <p class="lead"' . $small_style . '>'. htmlspecialchars_decode($small) .'</p>
		        <a class="btn btn-primary ' . $button_style . '" href="'. $button_url  .'"><span class="ttbase-button-inner">'. htmlspecialchars_decode($button_text) .'</span></a>
		        '. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
		    </div>
	    ';
	} else {
		$output = '
			<div class="ttbase-pricing-table card text-center emphasis">
			    <h4' . $title_style . '>'. htmlspecialchars_decode($title) .'</h4>
			    <span class="price"' . $price_style . '>'. htmlspecialchars_decode($amount) .'</span>
			    <p class="lead"' . $small_style . '>'. htmlspecialchars_decode($small) .'</p>
			    <a class="btn btn-primary ' . $button_style . '" href="'. $button_url  .'"><span class="ttbase-button-inner">'. htmlspecialchars_decode($button_text) .'</span></a>
			    '. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
			</div>
		';
	}
	
	return $output;
}
add_shortcode( 'ttbase_pricing_table', 'ttbase_framework_pricing_table_shortcode' );

?>