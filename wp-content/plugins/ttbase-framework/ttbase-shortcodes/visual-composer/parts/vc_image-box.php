<?php

// VC Image Box ------------------------------------------------------------------------ >
function ttbase_framework_vc_image_box_shortcode() {
	vc_map( array(
                'name'                  => esc_html__( 'TTBase Image Box', 'ttbase-framework' ),
                'base'                  => 'ttbase_imagebox',
                'category'                => esc_html__('TTBase', 'ttbase-framework'),
                'icon'                  => 'ttbase_vc_icon',
                'description'           => esc_html__( 'Image box with icon and title', 'ttbase-framework' ),
                "params"				=> array(
        			array(
        				"type"			=> "attach_image",
        				"admin_label"	=> false,
        				"class"			=> "",
        				"heading"		=> esc_html__( "Background Image", 'ttbase-framework' ),
        				"param_name"	=> "image",
        				"value"			=> "",
        				"description"	=> esc_html__( "Select an image", 'ttbase-framework' ),
        			),
        			array(
                        'type'          => 'colorpicker',
                        'heading'       => esc_html__( 'Image Overlay Color', 'ttbase-framework' ),
                        'param_name'    => 'overlay_color',
                        'value'         => '',
                        'dependency'    => array(
                            'element'   => 'image',
                            'not_empty' => true,
                        ),
                    ),
        			array(
        				"type"			=> "textfield",
        				"admin_label"	=> false,
        				"class"			=> "",
        				"heading"		=> esc_html__( "Link", 'ttbase-framework' ),
        				"param_name"	=> "url",
        				"value"			=> "http://",
        				"description"	=> esc_html__( "Link of the Category Image", 'ttbase-framework' )
        			),
        			array(
        				"type"			=> "dropdown",
        				"admin_label"	=> false,
        				"class"			=> "",
        				"heading"		=> esc_html__( "Link Target", 'ttbase-framework' ),
        				"param_name"	=> "target",
        				"value"			=> array(
        					esc_html__('Same Window', 'ttbase-framework' ) => '_self',
        					esc_html__('New Window', 'ttbase-framework' ) => '_blank',
        				),
        			),
        			array(
                        'type'          => 'colorpicker',
                        'heading'       => esc_html__( 'Background Color', 'ttbase-framework' ),
                        'param_name'    => 'bg_color',
                        'value'         => ''
                    ),
        			array(
                        'type'          => 'colorpicker',
                        'heading'       => esc_html__( 'Bottom Border Color', 'ttbase-framework' ),
                        'param_name'    => 'border_color',
                        'value'         => ''
                    ),
                    // Heading
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Heading', 'ttbase-framework' ),
                        'param_name'    => 'heading',
                        'value'         => 'Sample Heading',
                        'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                    ),
                    array(
                        'type'          => 'dropdown',
                        'heading'       => esc_html__( 'Heading Type', 'ttbase-framework' ),
                        'param_name'    => 'heading_type',
                        'std'           => 'h3',
                        'value'     => array(
                            'h2'    => 'h2',
                            'h3'    => 'h3',
                            'h4'    => 'h4',
                            'h5'    => 'h5',
                            'div'   => 'div',
                            'span'  => 'span',
                        ),
                        'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                    ),
                    array(
                        'type'          => 'colorpicker',
                        'heading'       => esc_html__( 'Heading Font Color', 'ttbase-framework' ),
                        'param_name'    => 'heading_color',
                        'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                    ),
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Heading Font Size', 'ttbase-framework' ),
                        'param_name'    => 'heading_size',
                        'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                    ),
                    array(
                        'type'          => 'dropdown',
                        'heading'       => esc_html__( 'Heading Font Weight', 'ttbase-framework' ),
                        'description'   => esc_html__( 'Not all fonts support every font weight.', 'ttbase-framework' ),
                        'param_name'    => 'heading_weight',
                        'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                        'value'         => array(
                            esc_html__( 'Default', 'ttbase-framework' )               => '',
                            esc_html__( 'Extra Light: 100', 'ttbase-framework' )      => '100',
                            esc_html__( 'Light: 200', 'ttbase-framework' )            => '200',
                            esc_html__( 'Book : 300', 'ttbase-framework' )            => '300',
                            esc_html__( 'Normal: 400', 'ttbase-framework' )           => '400',
                            esc_html__( 'Medium: 500', 'ttbase-framework' )           => '500',
                            esc_html__( 'Semibold: 600', 'ttbase-framework' )         => '600',
                            esc_html__( 'Bold: 700', 'ttbase-framework' )             => '700',
                            esc_html__( 'Extra Bold: 800', 'ttbase-framework' )       => '800',
                        ),
                    ),
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Heading Letter Spacing', 'ttbase-framework' ),
                        'param_name'    => 'heading_letter_spacing',
                        'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                    ),
                    array(
                        'type'          => 'dropdown',
                        'heading'       => esc_html__( 'Heading Text Transform', 'ttbase-framework' ),
                        'param_name'    => 'heading_transform',
                        'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                        'value'         => array(
                            esc_html__( 'Default', 'ttbase-framework' )     => '',
                            esc_html__( 'None', 'ttbase-framework' )        => 'none',
                            esc_html__( 'Capitalize', 'ttbase-framework' )  => 'capitalize',
                            esc_html__( 'Uppercase', 'ttbase-framework' )   => 'uppercase',
                            esc_html__( 'Lowercase', 'ttbase-framework' )   => 'lowercase',
                        ),
                    ),
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Heading Bottom Margin', 'ttbase-framework' ),
                        'param_name'    => 'heading_bottom_margin',
                        'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                    ),
                    // Subtitle
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Subtitle', 'ttbase-framework' ),
                        'param_name'    => 'subtitle',
                        'value'         => 'Subtitle',
                        'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                    ),
                    array(
                        'type'          => 'colorpicker',
                        'heading'       => esc_html__( 'Subtitle Font Color', 'ttbase-framework' ),
                        'param_name'    => 'subtitle_color',
                        'group'         => esc_html__( 'Heading', 'ttbase-framework' )
                    ),
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Subtitle Font Size', 'ttbase-framework' ),
                        'param_name'    => 'subtitle_size',
                        'group'         => esc_html__( 'Heading', 'ttbase-framework' )
                    ),
                    array(
                        'type'          => 'dropdown',
                        'heading'       => esc_html__( 'Subtitle Font Weight', 'ttbase-framework' ),
                        'description'   => esc_html__( 'Not all fonts support every font weight.', 'ttbase-framework' ),
                        'param_name'    => 'subtitle_weight',
                        'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                        'value'         => array(
                            esc_html__( 'Default', 'ttbase-framework' )               => '',
                            esc_html__( 'Extra Light: 100', 'ttbase-framework' )      => '100',
                            esc_html__( 'Light: 200', 'ttbase-framework' )            => '200',
                            esc_html__( 'Book : 300', 'ttbase-framework' )            => '300',
                            esc_html__( 'Normal: 400', 'ttbase-framework' )           => '400',
                            esc_html__( 'Medium: 500', 'ttbase-framework' )           => '500',
                            esc_html__( 'Semibold: 600', 'ttbase-framework' )         => '600',
                            esc_html__( 'Bold: 700', 'ttbase-framework' )             => '700',
                            esc_html__( 'Extra Bold: 800', 'ttbase-framework' )       => '800',
                        )
                    ),
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Subtitle Letter Spacing', 'ttbase-framework' ),
                        'param_name'    => 'subtitle_letter_spacing',
                        'group'         => esc_html__( 'Heading', 'ttbase-framework' )
                    ),
                    array(
                        'type'          => 'dropdown',
                        'heading'       => esc_html__( 'Subtitle Text Transform', 'ttbase-framework' ),
                        'param_name'    => 'subtitle_transform',
                        'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                        'value'         => array(
                            esc_html__( 'Default', 'ttbase-framework' )     => '',
                            esc_html__( 'None', 'ttbase-framework' )        => 'none',
                            esc_html__( 'Capitalize', 'ttbase-framework' )  => 'capitalize',
                            esc_html__( 'Uppercase', 'ttbase-framework' )   => 'uppercase',
                            esc_html__( 'Lowercase', 'ttbase-framework' )   => 'lowercase',
                            
                        )
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
        ) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_image_box_shortcode' );

?>