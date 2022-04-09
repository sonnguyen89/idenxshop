<?php

// VC Post Grid ------------------------------------------------------------------------ >
function ttbase_framework_vc_post_grid_shortcode() {
	vc_map( array(
		'name'        => esc_html__( 'TTBase Post Grid', 'ttbase-framework' ),
		'base'        => 'ttbase_posts_grid',
		'description' => esc_html__( 'Custom post type grid', 'ttbase-framework' ),
		'category'    => esc_html__( 'TTBase', 'ttbase-framework' ),
		'icon'        => 'ttbase_vc_icon',
		'params'      => array(
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Show Thumbnail Image?', 'ttbase-framework' ),
				'param_name'	=> 'thumbnail',
				'description'	=> esc_html__( 'Show the thumbnail image.', 'ttbase-framework' ),
				'value'			=> array(
					 esc_html__( 'Yes', 'ttbase-framework' )  => 'true',
					 esc_html__( 'No', 'ttbase-framework' ) => 'false',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Style', 'ttbase-framework' ),
				'param_name'	=> 'style',
				'std'           => 'default',
				'value'			=> array(
					 esc_html__( 'Colored Thumbnails', 'ttbase-framework' )	=> 'default',
					 esc_html__( 'Grayscale Thumbnails', 'ttbase-framework' )	=> 'grayscale'
				),
				'dependency'    => array(
                        'element'   => 'thumbnail',
                        'value'     => array( 'true' ),
                    ),
			),
			array(
				'type'			=> 'colorpicker',
				'heading'		=> esc_html__( 'Background', 'ttbase-framework' ),
				'param_name'	=> 'background',
				'value'			=> '',
				'description'	=> esc_html__( 'Choose your custom background color (Hex value).', 'ttbase-framework' ),
			),
			array(
				'type'			=> 'colorpicker',
				'heading'		=> esc_html__( 'Border', 'ttbase-framework' ),
				'param_name'	=> 'border',
				'value'			=> '',
				'description'	=> esc_html__( 'Choose your custom border color (Hex value).', 'ttbase-framework' ),
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
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Post Count', 'ttbase-framework' ),
				'param_name'  => 'count',
				'value'       => '12',
				'description' => esc_html__( 'How many items do you wish to show.', 'ttbase-framework' ),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Pagination', 'ttbase-framework' ),
				'param_name'	=> 'pagination',
				'description'	=> esc_html__( 'Note: Pagination will not work on your homepage.', 'ttbase-framework' ),
				'value'			=> array(
					 esc_html__( 'No', 'ttbase-framework' ) => 'false',
					 esc_html__( 'Yes', 'ttbase-framework' )  => 'true',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Columns', 'ttbase-framework' ),
				'param_name'	=> 'columns',
				'std'           => '3',
				'value'			=> array(
					 esc_html__( '1 Column', 'ttbase-framework' )	=> '1',
					 esc_html__( '2 Columns', 'ttbase-framework' )	=> '2',
					 esc_html__( '3 Columns', 'ttbase-framework' )	=> '3',
					 esc_html__( '4 Columns', 'ttbase-framework' )	=> '4',
					 esc_html__( '5 Columns', 'ttbase-framework' )	=> '5',
					 esc_html__( '6 Columns', 'ttbase-framework' )	=> '6',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Order', 'ttbase-framework' ),
				'param_name'	=> 'order',
				'description'	=> sprintf( wp_kses(__( 'Designates the ascending or descending order. More at %s.', 'ttbase-framework' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
				'value'			=> array(
					 esc_html__( 'DESC', 'ttbase-framework' )	=> 'DESC',
					 esc_html__( 'ASC', 'ttbase-framework' )	=> 'ASC',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Order By', 'ttbase-framework' ),
				'param_name'	=> 'orderby',
				'description'	=> sprintf( wp_kses(__( 'Select how to sort retrieved posts. More at %s.', 'ttbase-framework' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
				'value'			=> ttbase_framework_shortcodes_order_by_array(),
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
				'heading'		=> esc_html__( 'Display Title', 'ttbase-framework' ),
				'param_name'	=> 'title',
				'value'			=> array(
					 esc_html__( 'Yes', 'ttbase-framework' )  => 'true',
					 esc_html__( 'No', 'ttbase-framework' ) => 'false',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Display Excerpt', 'ttbase-framework' ),
				'param_name'	=> 'excerpt',
				'value'			=> array(
					 esc_html__( 'Yes', 'ttbase-framework' )  => 'true',
					 esc_html__( 'No', 'ttbase-framework' ) => 'false',
				),
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Excerpt Length', 'ttbase-framework' ),
				'param_name'	=> 'excerpt_length',
				'value'			=> '30',
				'description'	=> esc_html__( 'How many words do you want to display for your excerpt?', 'ttbase-framework' ),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Read More Link?', 'ttbase-framework' ),
				'param_name'	=> 'read_more',
				'value'			=> array(
					 esc_html__( 'Yes', 'ttbase-framework' )  => 'true',
					 esc_html__( 'No', 'ttbase-framework' ) => 'false',
				),
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Read More Text', 'ttbase-framework' ),
				'param_name'	=> 'read_more_text',
				'description'	=> esc_html__( 'Set the read more text.', 'ttbase-framework' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_post_grid_shortcode' );

?>