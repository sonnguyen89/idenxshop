<?php

// VC Highlight ------------------------------------------------------------------------ >
function ttbase_framework_vc_highlight_shortcode() {
	vc_map( array(
		'name'        => esc_html__( 'TTBase Highlight', 'ttbase-framework' ),
		'base'        => 'ttbase_highlight',
		'description' => esc_html__( 'Text highlighter', 'ttbase-framework' ),
		'category'    => esc_html__( 'TTBase' , 'ttbase-framework' ),
		'icon'        => 'ttbase_vc_icon',
		'params'      => array(
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Color', 'ttbase-framework' ),
				'param_name'	=> 'color',
				'value'			=> array(
					esc_html__( 'Blue', 'ttbase-framework' )   => 'blue',
					esc_html__( 'Green', 'ttbase-framework' )  => 'green',
					esc_html__( 'Gray', 'ttbase-framework' )   => 'gray',
					esc_html__( 'Red', 'ttbase-framework' )    => 'red',
					esc_html__( 'Yellow', 'ttbase-framework' ) => 'yellow',
				),
			),
			array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Highlighted Text', 'ttbase-framework' ),
				'param_name'	=> 'content',
				'value'			=> 'highlight me please',
				'description'	=> esc_html__( 'Add the text to be highlighted.', 'ttbase-framework' )
			),
		)
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_highlight_shortcode' );


?>