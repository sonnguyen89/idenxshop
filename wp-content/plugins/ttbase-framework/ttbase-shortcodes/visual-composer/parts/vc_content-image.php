<?php

// VC Image with Text -------------------------------------------------------------- >
function ttbase_framework_vc_content_image_shortcode() {
	vc_map(
		array(
			"icon" => 'ttbase_vc_icon',
			'name'                    => esc_html__( 'TTBase Image with content' , 'ttbase-framework' ),
			'base'                    => 'ttbase_content_image',
			'description'             => esc_html__( 'Create images with content', 'ttbase-framework' ),
			"category" => esc_html__('TTBase', 'ttbase-framework'),
			'params' => array(
				array(
						"type" => "attach_image",
						"heading" => esc_html__("Choose Image", 'ttbase-framework'),
						"param_name" => "image"
				),
				array(
						"type" => "dropdown",
						"heading" => esc_html__("Image & Content Layout", 'ttbase-framework'),
						"param_name" => "layout",
						"value" => array(
								esc_html__('Image with inner Content Left', 'ttbase-framework') => 'offscreen-left',
								esc_html__('Image with inner Content Right', 'ttbase-framework') => 'offscreen-right',
								esc_html__('Boxed Image Left', 'ttbase-framework') => 'box-left',
								esc_html__('Boxed Image Right', 'ttbase-framework') => 'box-right'
						)
				),
				array(
					'type'			=> 'colorpicker',
					'heading'		=> esc_html__( 'Content Background Color', 'ttbase-framework' ),
					'param_name'	=> 'background_color',
					'value'			=> '',
					'description'	=> esc_html__( 'Choose your custom background color.', 'ttbase-framework' ),
					'dependency'    => array(
                        'element'   => 'layout',
                        'value'     => array( 'box-left', 'box-right' ),
                    ),
				),
				array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('CSS Animation (Image)', 'ttbase-framework'),
                    'description'   => esc_html__( 'Add animation when element comes in visible area.', 'ttbase-framework' ),
                    'param_name'    => 'css_animation_image',
                    'value'      => ttbase_framework_shortcodes_css_animations_array(),
                    'group'         => esc_html__( 'CSS Animation', 'ttbase-framework' )
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Animation Delay (Image)', 'ttbase-framework' ),
                    'description'   => esc_html__( 'Add time delay in milliseconds', 'ttbase-framework' ),
                    'param_name'    => 'css_delay_image',
                    'value'         => '',
                    'group'         => esc_html__( 'CSS Animation', 'ttbase-framework' )
                    
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__('CSS Animation (Content)', 'ttbase-framework'),
                    'description'   => esc_html__( 'Add animation when element comes in visible area.', 'ttbase-framework' ),
                    'param_name'    => 'css_animation_content',
                    'value'      => ttbase_framework_shortcodes_css_animations_array(),
                    'group'         => esc_html__( 'CSS Animation', 'ttbase-framework' )
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Animation Delay (Content)', 'ttbase-framework' ),
                    'description'   => esc_html__( 'Add time delay in milliseconds', 'ttbase-framework' ),
                    'param_name'    => 'css_delay_content',
                    'value'         => '',
                    'group'         => esc_html__( 'CSS Animation', 'ttbase-framework' )
                    
                ),
	            // Content
	            array(
	                'type'          => 'textarea_html',
	                'holder'        => 'div',
	                'heading'       => esc_html__( 'Content', 'ttbase-framework' ),
	                'param_name'    => 'content',
	                'value'         => esc_html__( 'Don\'t forget to change this dummy text in your page editor.', 'ttbase-framework' ),
	                'group'         => esc_html__( 'Content', 'ttbase-framework' ),
	            ),
			)
		)
	);
}
add_action( 'vc_before_init', 'ttbase_framework_vc_content_image_shortcode' );


?>