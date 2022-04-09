<?php

// Tabs -------------------------------------------------------------------- >	
function ttbase_framework_half_carousel_shortcode($atts, $content = NULL) {
    
wp_enqueue_script('ttbase-carousel');

$output = '<div class="half-carousel owl-carousel owl-theme">'. do_shortcode($content) .'</div>';
	
	if( substr_count( $content, '[ttbase_half_carousel_content' ) > 1 ){
		
		wp_enqueue_script('ttbase-carousel');
	}
	
	return $output;
}

add_shortcode('ttbase_half_carousel', 'ttbase_framework_half_carousel_shortcode');

// Tabs Content -------------------------------------------------------------- >
function ttbase_framework_half_carousel_content_shortcode($atts, $content = NULL) {
	extract(shortcode_atts(array(
       'image' => '',
		'layout' => 'left'
    ), $atts));
    
   if( 'left' == $layout ){
		
		$output = '
			<section class="image-square right">
			    <div class="col-md-6 image">
			        <div class="background-image-holder">
			            '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') ) .'
			        </div>
			    </div>
			    <div class="col-md-6 content">
			        '. do_shortcode($content) .'
			    </div>
			</section>
		';
	
	} else {
		
		$output = '
			<section class="image-square left">
				<div class="col-md-6 content">
				    '. do_shortcode($content) .'
				</div>
			    <div class="col-md-6 image">
			        <div class="background-image-holder">
			            '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') ) .'
			        </div>
			    </div>
			</section>
		';
		
	}
	
	return $output;
}

add_shortcode('ttbase_half_carousel_content', 'ttbase_framework_half_carousel_content_shortcode');
?>