<?php

// VC Heading ------------------------------------------------------------------------ >
function ttbase_framework_vc_heading_shortcode() {
	vc_map( array(
		'name'        => esc_html__( 'TTBase Heading', 'ttbase-framework' ),
		'base'        => 'ttbase_heading',
		'description' => esc_html__( 'Styled heading', 'ttbase-framework' ),
		'category'    => esc_html__( 'TTBase', 'ttbase-framework' ),
		'icon'        => 'ttbase_vc_icon',
		'params'      => array(
			array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Title', 'ttbase-framework' ),
				'param_name'	=> 'title',
				'value'			=> 'This is a Heading',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Type', 'ttbase-framework' ),
				'param_name' => 'type',
				'std'        => 'h2',
				'default'    => 'h2',
				'value'      => array(
					'h1'   => 'h1',
					'h2'   => 'h2',
					'h3'   => 'h3',
					'h4'   => 'h4',
					'h5'   => 'h5',
					'h6'   => 'h6',
					'div'  => 'div',
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Margin Top', 'ttbase-framework' ),
				'param_name' => 'margin_top',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Margin Bottom', 'ttbase-framework' ),
				'param_name' => 'margin_bottom',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Font Size', 'ttbase-framework' ),
				'param_name' => 'font_size',
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Heading Color', 'ttbase-framework' ),
				'param_name' => 'color',
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Span Background', 'ttbase-framework' ),
				'param_name' => 'span_bg',
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Text Alignment', 'ttbase-framework' ),
				'param_name'	=> 'text_align',
				'value'			=> array(
					 esc_html__( 'Left', 'ttbase-framework' )		=> 'left',
					 esc_html__( 'Center', 'ttbase-framework' )	=> 'center',
					 esc_html__( 'Right', 'ttbase-framework' )	=> 'right',
				),
			),
			array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Extra css class', 'ttbase-framework' ),
				'param_name'	=> 'class'
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Font for left/right icon', 'ttbase-framework' ),
				'param_name' => 'icon_font',
				'value'      => array(
					 esc_html__( 'Streamline', 'ttbase-framework' )      => 'streamline',
					 esc_html__( 'Icons Mind', 'ttbase-framework' )      => 'iconsmind',
					 esc_html__( 'Font Awesome', 'ttbase-framework' ) => 'fontawesome',
				),
				'group'         => esc_html__( 'Icon', 'ttbase-framework' )
			),
			array(
				'type'       => 'streamline_icon',
				'heading'    => esc_html__( 'Icon Left', 'ttbase-framework' ),
				'param_name' => 'icon_left_sl',
				'value'      => '',
				'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'streamline' )
                    ),
                'group'         => esc_html__( 'Icon', 'ttbase-framework' )
			),
			array(
				'type'       => 'iconsmind_icon',
				'heading'    => esc_html__( 'Icon Right', 'ttbase-framework' ),
				'param_name' => 'icon_right_im',
				'value'      => '',
				'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'iconsmind' )
                    ),
                'group'         => esc_html__( 'Icon', 'ttbase-framework' )
			),
			array(
				'type'       => 'iconsmind_icon',
				'heading'    => esc_html__( 'Icon Left', 'ttbase-framework' ),
				'param_name' => 'icon_left_im',
				'value'      => '',
				'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'iconsmind' )
                    ),
                'group'         => esc_html__( 'Icon', 'ttbase-framework' )
			),
			array(
				'type'       => 'streamline_icon',
				'heading'    => esc_html__( 'Icon Right', 'ttbase-framework' ),
				'param_name' => 'icon_right_sl',
				'value'      => '',
				'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'streamline' )
                    ),
                'group'         => esc_html__( 'Icon', 'ttbase-framework' )
			),
			array(
				'type'       => 'font_awesome_icon',
				'heading'    => esc_html__( 'Icon Left', 'ttbase-framework' ),
				'param_name' => 'icon_left_fa',
				'value'      => '',
				'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'fontawesome' )
                    ),
                'group'         => esc_html__( 'Icon', 'ttbase-framework' )
			),
			array(
				'type'       => 'font_awesome_icon',
				'heading'    => esc_html__( 'Icon Right', 'ttbase-framework' ),
				'param_name' => 'icon_right_fa',
				'value'      => '',
				'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'fontawesome' )
                    ),
                'group'         => esc_html__( 'Icon', 'ttbase-framework' )
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
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_heading_shortcode' );

?>