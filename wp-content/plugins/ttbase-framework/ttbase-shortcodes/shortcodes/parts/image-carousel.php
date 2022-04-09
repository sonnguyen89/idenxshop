<?php

// Image Carousel -------------------------------------------------------------------- >	
function ttbase_framework_image_carousel_shortcode($atts, $content = NULL) {
    extract( 
		shortcode_atts( 
			array(
				'desktop' => '3',
				'desktop1199' => '3',
				'desktop980' => '3'
			), $atts 
		) 
	);
	
	wp_enqueue_script('ttbase-carousel');
	
    $output = '
		<div class="image-carousel owl-carousel owl-theme">'. do_shortcode($content) .'</div>
		
	';
	return $output;
}

add_shortcode('ttbase_image_carousel', 'ttbase_framework_image_carousel_shortcode');

// Image Carousel Content -------------------------------------------------------------- >
function ttbase_framework_image_carousel_content_shortcode($atts, $content = NULL) {
	extract(shortcode_atts(array(
       'image' => ''
    ), $atts));
    
   $output = '
		<div class="image-carousel-item overflow-hidden mb50">
			<div class="row">
				<div class="col-sm-12">
					'. wp_get_attachment_image( $image, 'full' ) .'
				</div>
			</div>
			<hr class="mb50">
			
			<div class="text-holder text-center">
				'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'
			</div>
			
		</div>
	';
	
	return $output;
}

add_shortcode('ttbase_image_carousel_content', 'ttbase_framework_image_carousel_content_shortcode');
?>