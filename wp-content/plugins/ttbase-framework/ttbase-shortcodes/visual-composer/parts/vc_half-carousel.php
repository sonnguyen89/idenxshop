<?php

// VC Half Carousel ------------------------------------------------------------------------ >
function ttbase_framework_vc_half_carousel_shortcode() {
	vc_map( 
		array(
			"icon" => 'ttbase_vc_icon',
		    'name'                    => esc_html__( 'TTBase Half Text, Half Image Carousel' , 'ttbase-framework' ),
		    'base'                    => 'ttbase_half_carousel',
		    'description'             => esc_html__( 'Create Image Content Carousel', 'ttbase-framework' ),
		    'as_parent'               => array('only' => 'ttbase_half_carousel_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('TTBase', 'ttbase-framework'),
		    'params' => array()
		) 
	);
}
add_action( 'vc_before_init', 'ttbase_framework_vc_half_carousel_shortcode' );


// VC Half Carousel Content ------------------------------------------------------------------------ >
function ttbase_framework_vc_half_carousel_content_shortcode() {
	vc_map( 
		array(
			"icon" => 'ttbase_vc_icon',
		    'name'            => esc_html__('TTBase Half Text, Half Image Carousel Content', 'ttbase-framework'),
		    'base'            => 'ttbase_half_carousel_content',
		    'description'     => esc_html__( 'Half Carousel Content Element', 'ttbase-framework' ),
		    "category" => esc_html__('TTBase', 'ttbase-framework'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'ttbase_half_carousel'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
		    	array(
		    		"type" => "attach_image",
		    		"heading" => esc_html__("Image", 'ttbase-framework'),
		    		"param_name" => "image"
		    	),
		    	array(
		    		"type" => "textarea_html",
		    		"heading" => __("Content", 'ttbase-framework'),
		    		"param_name" => "content",
		    		'holder' => 'div'
		    	),
		    	array(
		    		"type" => "dropdown",
		    		"heading" => __("Image & Text Display Type", 'ttbase-framework'),
		    		"param_name" => "layout",
		    		"value" => array(
		    			esc_html__('Image Right, Content Left', 'ttbase-framework') => 'left',
		    			esc_html__('Image Left, Content Right', 'ttbase-framework') => 'right'
		    		)
		    	),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'ttbase_framework_vc_half_carousel_content_shortcode' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_ttbase_half_carousel extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_ttbase_half_carousel_content extends WPBakeryShortCode {

    }
}

?>