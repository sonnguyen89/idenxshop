<?php

// VC Spacer ------------------------------------------------------------------------ >
function ttbase_framework_vc_spacer_shortcode() {
	vc_map( array(
		'name'        => esc_html__( 'TTBase Spacer', 'ttbase-framework' ),
		'base'        => 'ttbase_spacer',
		'description' => esc_html__( 'Empty Space', 'ttbase-framework' ),
		'category'    => esc_html__( 'TTBase' , 'ttbase-framework' ),
		'icon'        => 'ttbase_vc_icon',
		'params'      => array(
			array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Spacer Height', 'ttbase-framework' ),
				'param_name'	=> 'height',
				'value'			=> '',
				'description'	=> esc_html__( 'Add height in px for the empty space', 'ttbase-framework' )
			),
		)
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_spacer_shortcode' );


?>