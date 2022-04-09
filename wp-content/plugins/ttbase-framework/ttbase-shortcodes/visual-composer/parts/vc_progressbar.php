<?php

// VC Progressbar ------------------------------------------------------------------------ >
function ttbase_framework_vc_progressbar_shortcode() {
	vc_map( array(
		'name'				=> esc_html__( 'TTBase Progressbar', 'ttbase-framework' ),
		'base'				=> 'ttbase_progressbar',
		'description'		=> esc_html__( 'Animated percentage bar', 'ttbase-framework' ),
		'category'			=> esc_html__( 'TTBase' , 'ttbase-framework' ),
		'icon'        => 'ttbase_vc_icon',
		'params'			=> array(
			array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Title', 'ttbase-framework' ),
				'param_name'	=> 'title',
				'value'			=> '',
				'description'	=> esc_html__( 'Add your progressbar title.', 'ttbase-framework' )
			),
			array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Percentage', 'ttbase-framework' ),
				'param_name'	=> 'percentage',
				'value'			=> '',
				'description'	=> esc_html__( 'Add a percentage value.', 'ttbase-framework' )
			),
			array(
				'type'			=> 'colorpicker',
				'heading'		=> esc_html__( 'Background', 'ttbase-framework' ),
				'param_name'	=> 'color',
				'value'			=> '',
				'description'	=> esc_html__( 'Choose your custom background color (Hex value).', 'ttbase-framework' ),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Display % Number', 'ttbase-framework' ),
				'param_name'	=> 'show_percent',
				'value'			=> array(
					 esc_html__( 'Yes', 'ttbase-framework' )	=> 'true',
					 esc_html__( 'No', 'ttbase-framework' )	=> 'false',
				),
			),
		)
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_progressbar_shortcode' );

?>