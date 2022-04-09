<?php

// VC Testimonial Carousel ------------------------------------------------------------------------ >
function ttbase_framework_vc_testimonial_carousel_shortcode() {
	vc_map( array(
		"name"					=> esc_html__( "TTBase Testimonial Carousel", 'ttbase-framework' ),
		"base"					=> "ttbase_testimonial_carousel",
		'category'				=> esc_html__( 'TTBase', 'ttbase-framework' ),
		"icon"					=> "ttbase_vc_icon",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Number of Testimonials", 'ttbase-framework' ),
				"param_name"	=> "posts",
				"value"			=> "6",
				"description"	=> esc_html__( "Number of Testimonials.", 'ttbase-framework' )
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
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Show Image Border?', 'ttbase-framework' ),
				'param_name'	=> 'img_border',
				'value'			=> array(
					esc_html__( 'No', 'ttbase-framework' ) => 'false',
					 esc_html__( 'Yes', 'ttbase-framework' )  => 'true'
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Image Border Color', 'ttbase-framework' ),
				'param_name' => 'border_color',
				'dependency'    => array(
                    'element'   => 'img_border',
                    'value'     => array( 'true' )
                )
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Image Border Width', 'ttbase-framework' ),
				'param_name'	=> 'border_width',
				'description'	=> esc_html__( 'Enter a width in pixels.', 'ttbase-framework' ),
					'dependency'    => array(
                        'element'   => 'img_border',
                        'value'     => array( 'true' )
                    )
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Content Font Size', 'ttbase-framework' ),
				'param_name'	=> 'font_size',
				'description'	=> esc_html__( 'Enter a font size in pixels or em.', 'ttbase-framework' )
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Text Color', 'ttbase-framework' ),
				'param_name' => 'color'
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Author Name Color', 'ttbase-framework' ),
				'param_name' => 'author_color'
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Company Name Color', 'ttbase-framework' ),
				'param_name' => 'company_color'
			)
		)
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_testimonial_carousel_shortcode' );

?>