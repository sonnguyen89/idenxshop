<?php

// VC Table ------------------------------------------------------------------------ >
function ttbase_framework_vc_table_shortcode() {
	vc_map( array(
		'name'				=> esc_html__( 'TTBase Table', 'ttbase-framework' ),
		'base'				=> 'ttbase_table',
		'description'		=> esc_html__( 'Custom table style.', 'ttbase-framework' ),
		'category'			=> esc_html__( 'TTBase', 'ttbase-framework' ),
		'icon'        => 'ttbase_vc_icon',
		"content_element" 			=> true,
		'params'			=> array(
			array(
				"type" 					=> "dropdown",
				"heading" 				=> esc_html__( 'Table Style', 'ttbase-framework' ),
				"param_name" 			=> "style",
				"value" 				=> array(
					esc_html__( 'Style 1', 'ttbase-framework' ) 				=> "1",
					esc_html__( 'Style 2', 'ttbase-framework' ) 				=> "2",
				),
			),
			array(
				'type'			=> 'textarea_html',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Table Content', 'ttbase-framework' ),
				'param_name'	=> 'content',
				'value'			=> esc_html__( 'Enter your content here.', 'ttbase-framework' ),
				'description'	=> esc_html__( 'Table Content', 'ttbase-framework' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_table_shortcode' );

?>