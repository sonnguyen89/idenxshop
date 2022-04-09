<?php

function ttbase_framework_content_image_shortcode( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'image' 				=> '',
				'layout'				=> 'offscreen-left',
				'background_color'		=> '',
				'css_animation_image'   => '',
        		'css_delay_image'       => '',
        		'css_animation_content' => '',
        		'css_delay_content'     => '',
			), $atts
		)
	);
	
	$css_animation_classes_img = '';
	$data_delay_img ='';
    if ( $css_animation_image ) {
        $css_animation_classes_img .= ' '. $css_animation_image;
        $data_delay_img = ($css_delay_image != '') ? ' data-delay="' . intval($css_delay_image) . '"' : '';
    }
    $css_animation_classes_content = '';
	$data_delay_content ='';
    if ( $css_animation_content ) {
        $css_animation_classes_content .= ' '. $css_animation_content;
        $data_delay_content = ($css_delay_content != '') ? ' data-delay="' . intval($css_delay_content) . '"' : '';
    }
	
	if( 'offscreen-left' == $layout ){

		$output = '
			<section class="ttbase-content-image image-edge">
			    <div class="col-md-6 col-sm-4 pd0' . $css_animation_classes_img . '"' . $data_delay_img . '>
			    	'. wp_get_attachment_image( $image, 'full', 0, array('class' => 'mb-xs-24 img-responsive') ) .'
			    </div>
			    <div class="container' . $css_animation_classes_content . '"' . $data_delay_content . '>
			        <div class="col-md-5 col-md-offset-1 col-sm-7 col-sm-offset-1 v-align-transform right">
			            '. do_shortcode($content) .'
			        </div>
			    </div>
			</section>
		';

	} elseif( 'offscreen-right' == $layout ) {

		$output = '
			<section class="ttbase-content-image image-edge">
			    <div class="col-md-6 col-sm-4 pd0 col-md-push-6 col-sm-push-8' . $css_animation_classes_img . '"' . $data_delay_img . '>
			        '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'mb-xs-24') ) .'
			    </div>
			    <div class="container' . $css_animation_classes_content . '"' . $data_delay_content . '>
			        <div class="col-md-5 col-md-pull-0 col-sm-7 col-sm-pull-4 v-align-transform">
			            '. do_shortcode($content) .'
			        </div>
			    </div>
			</section>
		';

	} elseif( 'box-left' == $layout ) {

		$output = '
			<section class="ttbase-content-image image-square left" style="background-color:' . esc_attr( $background_color ) . ';">
			    <div class="col-md-6 image' . $css_animation_classes_img . '"' . $data_delay_img . '>
			        <div class="background-image-holder">
			            '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'img-responsive') ) .'
			        </div>
			    </div>
			    <div class="col-md-6 col-md-offset-1 content' . $css_animation_classes_content . '"' . $data_delay_content . '>
			    	<div class="inner-content">
			    			'. do_shortcode($content) .'
			    	</div>
			    </div>
			</section>
		';

	} elseif( 'box-right' == $layout ) {

		$output = '
			<section class="ttbase-content-image image-square right" style="background-color:' . esc_attr( $background_color ) . ';">
			    <div class="col-md-6 image' . $css_animation_classes_img . '"' . $data_delay_img . '>
			        <div class="background-image-holder">
			            '. wp_get_attachment_image( $image, 'full', 0, array('class' => 'img-responsive') ) .'
			        </div>
			    </div>
			    <div class="col-md-6 content' . $css_animation_classes_content . '"' . $data_delay_content . '>
	        		<div class="inner-content">
		    			'. do_shortcode($content) .'
			    	</div>
			    </div>
			</section>
		';

	}

	return $output;
}
add_shortcode( 'ttbase_content_image', 'ttbase_framework_content_image_shortcode' );

?>