<?php

// VC Post Carousel ------------------------------------------------------------------------ >
function ttbase_framework_vc_post_carousel_shortcode() {
	vc_map( array(
		"name"					=> esc_html__( "TTBase Recent Posts Carousel", 'ttbase-framework' ),
		"base"					=> "ttbase_post_carousel",
		'category'				=> esc_html__( 'TTBase', 'ttbase-framework' ),
		"icon"					=> "ttbase_vc_icon",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Number of Posts", 'ttbase-framework' ),
				"param_name"	=> "posts",
				"value"			=> "6",
				"description"	=> esc_html__( "Number of Posts.", 'ttbase-framework' )
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> esc_html__( "Categories", 'ttbase-framework' ),
				"param_name"	=> "categories",
				"value"			=> "all",
				"description"	=> esc_html__( "Category Slugs - For example: sports, business, all", 'ttbase-framework' )
			),
			array(
				'type'			=> 'colorpicker',
				'heading'		=> esc_html__( 'Background', 'ttbase-framework' ),
				'param_name'	=> 'background',
				'value'			=> '#ffffff',
				'description'	=> esc_html__( 'Choose your custom background color (Hex value).', 'ttbase-framework' ),
			),
			array(
				'type'			=> 'colorpicker',
				'heading'		=> esc_html__( 'Border Color', 'ttbase-framework' ),
				'param_name'	=> 'border',
				'value'			=> '#232a35',
				'description'	=> esc_html__( 'Choose your custom border color (Hex value).', 'ttbase-framework' ),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Show Thumbnail Image?', 'ttbase-framework' ),
				'param_name'	=> 'featured_image',
				'description'	=> esc_html__( 'Show the thumbnail image.', 'ttbase-framework' ),
				'value'			=> array(
					 esc_html__( 'Yes', 'ttbase-framework' )  => 'true',
					 esc_html__( 'No', 'ttbase-framework' ) => 'false',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Thumbnail Crop', 'ttbase-framework' ),
				'param_name'	=> 'img_crop',
				'value'			=> array(
					 esc_html__( 'Yes', 'ttbase-framework' )  => 'true',
					 esc_html__( 'No', 'ttbase-framework' ) => 'false',
				),
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Thumbnail Width', 'ttbase-framework' ),
				'param_name'	=> 'img_width',
				'description'	=> esc_html__( 'Enter a width in pixels.', 'ttbase-framework' ),
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Thumbnail Height', 'ttbase-framework' ),
				'param_name'	=> 'img_height',
				'description'	=> esc_html__( 'Enter a height in pixels. Set to "9999" to disable vertical cropping and keep image proportions.', 'ttbase-framework' ),
			),
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => esc_html__("Image Style", 'ttbase-framework'),
				"param_name"  => "image_style",
				"value"       => array(
					esc_html__("Colored Thumbnails", 'ttbase-framework')   => 'color',
					esc_html__("Grayscale Thumbnails", 'ttbase-framework') => 'grayscale'
				),
				'dependency'    => array(
                    'element'   => 'featured_image',
                    'value'     => array( 'true' ),
                ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_post_carousel_shortcode' );

?>