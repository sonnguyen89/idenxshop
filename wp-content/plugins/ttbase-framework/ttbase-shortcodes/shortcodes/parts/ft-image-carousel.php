<?php

// Tabs -------------------------------------------------------------------- >	
function ttbase_framework_ft_carousel_shortcode($atts, $content = NULL) {
	
	wp_enqueue_script('ttbase-ft-carousel');
	
    $output = '
		<div class="ttbase-ft-carousel">'. do_shortcode($content) .'</div>
		
	';
	return $output;
}

add_shortcode('ttbase_ft_carousel', 'ttbase_framework_ft_carousel_shortcode');

// Tabs Content -------------------------------------------------------------- >
function ttbase_framework_ft_carousel_content_shortcode($atts, $content = NULL) {
	extract(shortcode_atts(array(
       'image' => '',
       'url' => ''
    ), $atts));
    
	$output = '<div class="ttbase-ft-carousel-item carousel-cell">';
	$output .= wp_get_attachment_image( $image, 'full' );
	
	if ($url != '') {
		$output .= '<a class="carousel-cell-link" href="'. esc_url($url) . '" target="_blank"></a>';
	}
	$output .= '</div>';
   
	return $output;
}

add_shortcode('ttbase_ft_carousel_content', 'ttbase_framework_ft_carousel_content_shortcode');
?>