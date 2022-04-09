<?php

// VC Half Carousel ------------------------------------------------------------------------ >
function ttbase_framework_vc_image_carousel_shortcode() {
	vc_map( 
		array(
			"icon" => 'ttbase_vc_icon',
		    'name'                    => esc_html__( 'TTBase Image Carousel' , 'ttbase-framework' ),
		    'base'                    => 'ttbase_image_carousel',
		    'description'             => esc_html__( 'Create Image Carousel with Text', 'ttbase-framework' ),
		    'as_parent'               => array('only' => 'ttbase_image_carousel_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('TTBase', 'ttbase-framework'),
		    'params' => array(
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Desktop # of Items", 'ttbase-framework'),
		    		'description' => esc_html__('3, 5 or 7 only!', 'ttbase-framework'),
		    		"param_name" => "desktop",
		    		'value' => '3'
		    	),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Small Desktop # of Items", 'ttbase-framework'),
		    		'description' => esc_html__('3, 5 or 7 only!', 'ttbase-framework'),
		    		"param_name" => "desktop1199",
		    		'value' => '3'
		    	),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Large Tablet # of Items", 'ttbase-framework'),
		    		'description' => esc_html__('3, 5 or 7 only!', 'ttbase-framework'),
		    		"param_name" => "desktop980",
		    		'value' => '3'
		    	),
		    )
		) 
	);
}
add_action( 'vc_before_init', 'ttbase_framework_vc_image_carousel_shortcode' );


// VC Half Carousel Content ------------------------------------------------------------------------ >
function ttbase_framework_vc_image_carousel_content_shortcode() {
	vc_map( 
		array(
			"icon" => 'ttbase_vc_icon',
		    'name'            => esc_html__('TTBase Image Carousel Content', 'ttbase-framework'),
		    'base'            => 'ttbase_image_carousel_content',
		    'description'     => esc_html__( 'Image Carousel Content Element', 'ttbase-framework' ),
		    "category" => esc_html__('TTBase', 'ttbase-framework'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'ttbase_image_carousel'), // Use only|except attributes to limit parent (separate multiple values with comma)
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
		    	)
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'ttbase_framework_vc_image_carousel_content_shortcode' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_ttbase_image_carousel extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_ttbase_image_carousel_content extends WPBakeryShortCode {

    }
}

?>