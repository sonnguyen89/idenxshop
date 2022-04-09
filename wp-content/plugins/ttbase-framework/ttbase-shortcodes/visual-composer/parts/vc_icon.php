<?php

// VC Streamline, Icons Mind Icons and Fontawesome Icon ------------------------------------------------------------------------ >
function ttbase_framework_vc_icon_shortcode() {
	vc_map( array(
		'name'        => esc_html__( 'TTBase Font Icon', 'ttbase-framework' ),
		'base'        => 'ttbase_icon',
		'description' => esc_html__( 'Streamline, Icons Mind & Font Awesome Icon', 'ttbase-framework' ),
		'category'    => esc_html__( 'TTBase', 'ttbase-framework' ),
		'icon'        => 'ttbase_vc_icon',
		'params'      => array(
			array(
                'type'          => 'dropdown',
                'heading'       => esc_html__( 'Icon Font', 'ttbase-framework' ),
                'param_name'    => 'icon_font',
                'value'         => array(
                	esc_html__( 'Streamline', 'ttbase-framework' )    => 'streamline',
                	esc_html__( 'Icons Mind', 'ttbase-framework' )    => 'iconsmind',
                    esc_html__( 'Font Awesome', 'ttbase-framework' )  => 'fontawesome'
                ),
                
            ),
			array(
				'type'        => 'font_awesome_icon',
				'heading'     => esc_html__( 'Icon', 'ttbase-framework' ),
				'param_name'  => 'icon_fa',
				'admin_label' => true,
				'value'       => '',
				'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'fontawesome' ),
                    ),
			),
			array(
				'type'        => 'iconsmind_icon',
				'heading'     => esc_html__( 'Icon', 'ttbase-framework' ),
				'param_name'  => 'icon_im',
				'admin_label' => true,
				'value'       => '',
				'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'iconsmind' ),
                    ),
			),
			array(
				'type'        => 'streamline_icon',
				'heading'     => esc_html__( 'Icon', 'ttbase-framework' ),
				'param_name'  => 'icon_sl',
				'admin_label' => true,
				'value'       => '',
				'dependency'    => Array(
                        'element'   => 'icon_font',
                        'value'     => array( 'streamline' ),
                    ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Background Style', 'ttbase-framework' ),
				'param_name' => 'style',
				'value'      => array(
					 esc_html__( 'No Background', 'ttbase-framework' ) => '',
					 esc_html__( 'Circle', 'ttbase-framework' )       => 'circle',
					 esc_html__( 'Square', 'ttbase-framework' )      => 'square'
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Size', 'ttbase-framework' ),
				'param_name' => 'size',
				'std'        => 'normal',
				'value'      => array(
					 esc_html__( 'Extra Large', 'ttbase-framework' ) => 'xlarge',
					 esc_html__( 'Large', 'ttbase-framework' )       => 'large',
					 esc_html__( 'Normal', 'ttbase-framework' )      => 'normal',
					 esc_html__( 'Small', 'ttbase-framework' )       => 'small',
					 esc_html__( 'Tiny', 'ttbase-framework' )        => 'tiny',
					 esc_html__( 'Custom Font Size', 'ttbase-framework' ) => 'custom'
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Icon Font Size', 'ttbase-framework' ),
				'param_name' => 'custom_size',
				'dependency'    => Array(
                        'element'   => 'size',
                        'value'     => array( 'custom' )
                    ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Float', 'ttbase-framework' ),
				'param_name' => 'float',
				'value'      => array(
					 esc_html__( 'Center', 'ttbase-framework' ) => 'center',
					 esc_html__( 'Left', 'ttbase-framework' )   => 'left',
					 esc_html__( 'Right', 'ttbase-framework' )  => 'right',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Icon Color', 'ttbase-framework' ),
				'param_name' => 'color',
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'ttbase-framework' ),
				'param_name' => 'background',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Border Radius', 'ttbase-framework' ),
				'param_name' => 'border_radius',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'URL', 'ttbase-framework' ),
				'param_name' => 'url',
			  	'value'			=> '#',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'URL Title', 'ttbase-framework' ),
				'param_name' => 'url_title',
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
add_action( 'vc_before_init', 'ttbase_framework_vc_icon_shortcode' );

?>