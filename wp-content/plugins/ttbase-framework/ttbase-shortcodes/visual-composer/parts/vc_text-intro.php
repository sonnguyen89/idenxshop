<?php

// VC Intro Text ------------------------------------------------------------------------ >
function ttbase_framework_vc_intro_text_shortcode() {
	vc_map(array(
			'name'                    => esc_html__('TTBase Intro text', 'ttbase-framework'),
			'base'                    => 'ttbase_intro_text',
			'class'                   => '',
			'controls'                => 'full',
			'icon'                    => 'ttbase_vc_icon',
			'category'                => esc_html__('TTBase', 'ttbase-framework'),
			'show_settings_on_create' => TRUE,
			'params'				  => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Text Color', 'ttbase-framework' ),
				'param_name' => 'color',
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Text Alignment', 'ttbase-framework' ),
				'param_name'	=> 'text_align',
				'value'			=> array(
					 esc_html__( 'Left', 'ttbase-framework' )		=> '',
					 esc_html__( 'Center', 'ttbase-framework' )	=> 'text-center',
					 esc_html__( 'Right', 'ttbase-framework' )	=> 'text-right',
				),
			),
			array(
				'type'			=> 'textarea_html',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Content', 'ttbase-framework' ),
				'param_name'	=> 'content',
				'value'			=> esc_html__( 'Enter your content here.', 'ttbase-framework' ),
				'description'	=> esc_html__( 'Teaser Content', 'ttbase-framework' ),
			),
			array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('CSS Animation', 'ttbase-framework'),
                'description'   => esc_html__( 'Add animation when element comes in visible area.', 'ttbase-framework' ),
                'param_name'    => 'css_animation',
                'value'      => ttbase_framework_shortcodes_css_animations_array(),
                'group'         => esc_html__( 'CSS Animation', 'ttbase-framework' )
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__( 'Animation Delay', 'ttbase-framework' ),
                'description'   => esc_html__( 'Add time delay in milliseconds', 'ttbase-framework' ),
                'param_name'    => 'css_delay',
                'value'         => '',
                'group'         => esc_html__( 'CSS Animation', 'ttbase-framework' )
            ),
		)
	));
}
add_action( 'vc_before_init', 'ttbase_framework_vc_intro_text_shortcode' );

?>