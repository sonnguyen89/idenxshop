<?php

// VC Image Gallery ------------------------------------------------------------------------ >
function ttbase_framework_vc_gallery_shortcode() {
	vc_map( array(
	    "name" 						=> esc_html__( 'TTBase Gallery', 'ttbase-framework' ),
	    "base" 						=> 'ttbase_gallery',
	    "description" 				=> esc_html__( 'Add Image Gallery Grid', 'ttbase-framework' ),
	    "icon" 						=> "ttbase_vc_icon",
	    "category" 					=> esc_html__( 'TTBase', 'ttbase-framework' ),
	    "as_parent" 				=> array('only' => 'ttbase_gallery_item'),
	    "content_element" 			=> true,
	    "show_settings_on_create" 	=> true,
	    "js_view" 					=> 'VcColumnView',
	    "params" 					=> array(
	    	array(
				"type" 					=> "dropdown",
				"heading" 				=> esc_html__( 'Columns', 'ttbase-framework' ),
				"param_name" 			=> "columns",
				"value" 				=> array(
					esc_html__( '2 Columns', 'ttbase-framework' ) 				=> "cols-2",
					esc_html__( '3 Columns', 'ttbase-framework' ) 				=> "cols-3",
					esc_html__( '4 Columns', 'ttbase-framework' ) 				=> "cols-4",
					esc_html__( '5 Columns', 'ttbase-framework' ) 				=> "cols-5",
					esc_html__( '6 Columns', 'ttbase-framework' ) 				=> "cols-6",
				),
			),
			array(
				"type" 					=> "dropdown",
				"heading" 				=> esc_html__( 'Column gap', 'ttbase-framework' ),
				"param_name" 			=> "spaces",
				"value" 				=> array(
					esc_html__( '0px', 'ttbase-framework' )					=> "gap-0",
					esc_html__( '2px', 'ttbase-framework' ) 					=> "gap-2",
					esc_html__( '5px', 'ttbase-framework' ) 					=> "gap-5",
					esc_html__( '10px', 'ttbase-framework' ) 					=> "gap-10",
					esc_html__( '15px', 'ttbase-framework' ) 					=> "gap-15",
				),
			),
			array(
				"type" 					=> "dropdown",
				"heading" 				=> esc_html__( 'Hover Style', 'ttbase-framework' ),
				"param_name" 			=> "style",
				"value" 				=> array(
					esc_html__( 'Style 1', 'ttbase-framework' ) 					=> "style-1",
					esc_html__( 'Style 2', 'ttbase-framework' ) 					=> "style-2",
				),
			),
		),
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_gallery_shortcode' );


// VC Image Gallery Item ------------------------------------------------------------------------ >
function ttbase_framework_vc_gallery_item_shortcode() {
	vc_map( array(
	    "name" 				=> esc_html__( 'TTBase Gallery Item', 'ttbase-framework' ),
	    "base" 				=> 'ttbase_gallery_item',
	    "description" 		=> esc_html__( 'Add gallery image', 'ttbase-framework' ),
	    "icon" 				=> "ttbase_vc_icon",
	    "content_element" 	=> true,
	    "as_child" 			=> array('only' => 'ttbase_gallery'),
	    "params" 			=> array(
	    	array(
				'type' 				=> 'attach_image',
				'heading' 			=> esc_html__( 'Image', 'ttbase-framework' ),
				'param_name' 		=> 'image',
				'value' 			=> '',
				'description' 		=> esc_html__( 'Select images from media library', 'ttbase-framework' )
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> esc_html__( 'Caption', 'ttbase-framework' ),
				'param_name' 		=> 'caption',
			),
			array(
				'type'			=> 'colorpicker',
				'heading'		=> esc_html__( 'Overlay Color', 'ttbase-framework' ),
				'param_name'	=> 'overlay_color',
				'value'			=> 'rgba(230,73,94,.7)',
				'description'	=> esc_html__( 'Choose your custom overlay color.', 'ttbase-framework' ),
			),
		),
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_gallery_item_shortcode' );

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_TTBase_Gallery_Item extends WPBakeryShortCode {
    }
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_TTBase_Gallery extends WPBakeryShortCodesContainer {
    }
}

?>