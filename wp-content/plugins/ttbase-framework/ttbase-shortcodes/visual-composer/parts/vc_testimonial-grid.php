<?php

// VC Testimonial Grid ------------------------------------------------------------------------ >
function ttbase_framework_vc_testimonial_grid_shortcode() {
	vc_map( array(
		"name"					=> esc_html__( "TTBase Testimonial Grid", 'ttbase-framework' ),
		"base"					=> "ttbase_testimonial_grid",
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
				"type"			=> "dropdown",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Show Categories Filter?", 'ttbase-framework' ),
				"param_name"	=> "showfilter",
				"value"			=> array(
					esc_html__( 'Hide Filters', 'ttbase-framework') => 'no',
					esc_html__( 'Show Filter', 'ttbase-framework') => 'yes',
				),
				"description"	=> esc_html__( "Show category filter selection.", 'ttbase-framework' ),
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
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'ttbase-framework' ),
				'param_name' => 'background_color',
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Border Color', 'ttbase-framework' ),
				'param_name' => 'border_color',
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
add_action( 'vc_before_init', 'ttbase_framework_vc_testimonial_grid_shortcode' );

?>