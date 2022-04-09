<?php

// Tabs -------------------------------------------------------------------- >	
function ttbase_framework_tabs_shortcode($atts, $content = NULL) {

	extract(shortcode_atts(array(
	   	'type'          => 'icons-tabs',
	   	'text_align'	=> 'text-center'
	), $atts));
	
	wp_enqueue_script( 'ttbase-tabs' );
	
    $output = '
		<div class="tabbed-content '. esc_attr($type) .' '. esc_attr($text_align) .'">
		    <ul class="tabs">
		        '. do_shortcode($content) .'
		    </ul>
		</div>
	';
	
	return $output;	
}

add_shortcode('ttbase_tabs', 'ttbase_framework_tabs_shortcode');

// Tabs Content -------------------------------------------------------------- >
function ttbase_framework_tabs_content_shortcode($atts, $content = NULL) {
	extract(shortcode_atts(array(
        'title'         => '',
        'icon_font'     => '',
        'icon_fa'       => '',
        'icon_im'       => '',
        'icon_sl'       => '',
    ), $atts));
    
   $output	= '<li>';
   $output .= '<div class="tab-title">';
   if ($icon_font == 'fontawesome') {
   	$output .= '<i class="fa fa-'. $icon_fa .'"></i>';	
   }elseif ($icon_font == 'iconsmind') {
   	$output .= '<i class="im im-'. $icon_im .'"></i>';	
   }else {
   	$output .= '<i class="sl sl-'. $icon_sl .'"></i>';
   }
   $output .= '<span>'. htmlspecialchars_decode($title) .'</span>';    
   $output .= '</div>';
   $output .= '<div class="tab-content">';
   $output .= wpautop(do_shortcode(htmlspecialchars_decode($content)));
   $output .= '</div>';
   $output .= '</li>';

    return $output;
}

add_shortcode('ttbase_tabs_content', 'ttbase_framework_tabs_content_shortcode');
?>