<?php

// VC Flickity Carousel ------------------------------------------------------------------------ >
function ttbase_framework_vc_ft_carousel_shortcode() {
	vc_map( 
		array(
			"icon" => 'ttbase_vc_icon',
		    'name'                    => esc_html__( 'TTBase Flickity Image Carousel' , 'ttbase-framework' ),
		    'base'                    => 'ttbase_ft_carousel',
		    'description'             => esc_html__( 'Create Flickity Image Carousel with Text', 'ttbase-framework' ),
		    'as_parent'               => array('only' => 'ttbase_ft_carousel_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('TTBase', 'ttbase-framework'),
		) 
	);
}
add_action( 'vc_before_init', 'ttbase_framework_vc_ft_carousel_shortcode' );


// VC Flickity Carousel Content ------------------------------------------------------------------------ >
function ttbase_framework_vc_ft_carousel_content_shortcode() {
	vc_map( 
		array(
			"icon" => 'ttbase_vc_icon',
		    'name'            => esc_html__('TTBase Flickity Carousel Content', 'ttbase-framework'),
		    'base'            => 'ttbase_ft_carousel_content',
		    'description'     => esc_html__( 'Flickity Carousel Content Element', 'ttbase-framework' ),
		    "category" => esc_html__('TTBase', 'ttbase-framework'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'ttbase_ft_carousel'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
		    	array(
		    		"type" => "attach_image",
		    		"heading" => esc_html__("Image", 'ttbase-framework'),
		    		"param_name" => "image"
		    	),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Image Link URL", 'ttbase-framework'),
		    		"param_name" => "url"
		    	)
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'ttbase_framework_vc_ft_carousel_content_shortcode' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_ttbase_ft_carousel extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_ttbase_ft_carousel_content extends WPBakeryShortCode {

    }
}

?>