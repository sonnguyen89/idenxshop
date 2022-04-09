<?php

// VC Wpml ------------------------------------------------------------------------ >
function ttbase_framework_vc_wpml_shortcode() {
	vc_map( array(
		'name'				=> esc_html__( 'TTBase WPML', 'ttbase-framework' ),
		'base'				=> 'ttbase_wpml',
		'description'		=> esc_html__( 'WPML translatable text.', 'ttbase-framework' ),
		'category'			=> esc_html__( 'TTBase', 'ttbase-framework' ),
		'icon'        => 'ttbase_vc_icon',
		'params'			=> array(
			array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Language', 'ttbase-framework' ),
				'param_name'	=> 'lang',
				'value'			=> 'es',
				'description'	=> esc_html__( 'Select a WPML language.', 'ttbase-framework' ),
			),
			array(
				'type'			=> 'textarea_html',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Content', 'ttbase-framework' ),
				'param_name'	=> 'content',
				'value'			=> 'Hola',
			),
		)
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_wpml_shortcode' );

?>