<?php

// VC Button ------------------------------------------------------------------------ >
function ttbase_framework_vc_button_shortcode() {
	
	vc_map( array(
		'name'        => esc_html__( 'TTBase Button', 'ttbase-framework' ),
		'base'        => 'ttbase_button',
		'description' => esc_html__( 'TTBase Shortcode Button', 'ttbase-framework' ),
		'category'    => esc_html__( 'TTBase', 'ttbase-framework' ),
		'icon'        => 'ttbase_vc_icon',
		'params'      => array(
			array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'URL', 'ttbase-framework' ),
				'param_name'	=> 'url',
			  	'value'			=> '#',
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Button Title', 'ttbase-framework' ),
				'param_name'	=> 'title',
				'value'			=> esc_html__( 'Button', 'ttbase-framework' ) ,
			),
			array(
				'type'			=> 'dropdown',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Button Style', 'ttbase-framework' ),
				'param_name'	=> 'style',
				'value'			=> array(
					esc_html__( 'Style 1 (Bordered)', 'ttbase-framework' )  => 'style-1',
					esc_html__( 'Style 2 (Plain)', 'ttbase-framework' )   => 'style-2',
					esc_html__( 'Style 3 (Gradient)', 'ttbase-framework' )   => 'style-3',
				)
			),
			array(
				'type'			=> 'dropdown',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Color Style', 'ttbase-framework' ),
				'description'	=> esc_html__( 'Colors from the customizer', 'ttbase-framework' ),
				'param_name'	=> 'color_style',
				'value'			=> array(
					esc_html__( 'Primary Button Color', 'ttbase-framework' )  => 'color-1',
					esc_html__( 'Primary Button Hover Color', 'ttbase-framework' )   => 'color-2',
					esc_html__( 'Primary Theme Color', 'ttbase-framework' )  => 'color-3',
					esc_html__( 'Secondary Theme Color', 'ttbase-framework' )   => 'color-4',
					esc_html__( 'Dark Color', 'ttbase-framework' )  => 'color-5',
					esc_html__( 'Light Color', 'ttbase-framework' )   => 'color-6'
				),
				'dependency'    => Array(
                        'element'   => 'style',
                        'value'     => array( 'style-1', 'style-2' )
                    ),
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> true,
				"heading"		=> esc_html__( "Gradient Start Color", 'ttbase-framework' ),
				"param_name"	=> "gradient_start_color",
				"value"			=> "",
				'dependency'    => Array(
                        'element'   => 'style',
                        'value'     => array( 'style-3' )
                    ),
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> true,
				"heading"		=> esc_html__( "Gradient End Color", 'ttbase-framework' ),
				"param_name"	=> "gradient_end_color",
				"value"			=> "",
				'dependency'    => Array(
                        'element'   => 'style',
                        'value'     => array( 'style-3' )
                    ),
			),
			array(
				'type'			=> 'dropdown',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Gradient Direction', 'ttbase-framework' ),
				'param_name'	=> 'gradient_dir',
				'value'			=> array(
					esc_html__( 'Left to right', 'ttbase-framework' )  => '90deg',
					esc_html__( 'Right to left', 'ttbase-framework' )   => '-90deg',
					esc_html__( 'Top to bottom', 'ttbase-framework' )   => '180deg',
					esc_html__( 'Bottom to top', 'ttbase-framework' )   => '-180deg',
				),
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Title Color", 'ttbase-framework' ),
				"param_name"	=> "title_color",
				"value"			=> "#1e2221",
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Size', 'ttbase-framework' ),
				'param_name' => 'size',
				'value'      => ttbase_framework_shortcodes_button_sizes_array(),
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Button Border Radius', 'ttbase-framework' ),
				'param_name'	=> 'border_radius',
				'value'			=> '' ,
			),
			array(
	    		"type" => "checkbox",
	    		"heading" => esc_html__("Set Button Width to 100%", 'thm'),
	    		"param_name" => "width_100"
	    	),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Align', 'ttbase-framework' ),
				'param_name' => 'align',
				'value'      => array(
					esc_html__( 'Default', 'ttbase-framework' ) => '',
					esc_html__( 'Center', 'ttbase-framework' )  => 'aligncenter',
					esc_html__( 'Left', 'ttbase-framework' )    => 'alignleft',
					esc_html__( 'Right', 'ttbase-framework' )   => 'alignright',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Link Target', 'ttbase-framework' ),
				'param_name' => 'target',
				'value'      => array(
					 esc_html__( 'Self', 'ttbase-framework' )   => 'self',
					 esc_html__( 'Blank', 'ttbase-framework' ) => 'blank',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Link Rel', 'ttbase-framework' ),
				'param_name' => 'rel',
				'value'      => array(
					 esc_html__( 'None', 'ttbase-framework' )      => 'none',
					 esc_html__( 'Nofollow', 'ttbase-framework' ) => 'nofollow',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Font for left/right icon', 'ttbase-framework' ),
				'param_name' => 'icon_font',
				'value'      => array(
					esc_html__( 'Streamline', 'ttbase-framework' )    => 'streamline',
					 esc_html__( 'Icons Mind', 'ttbase-framework' )   => 'iconsmind',
					 esc_html__( 'Font Awesome', 'ttbase-framework' ) => 'fontawesome',
				),
				'group'      => esc_html__( 'Icon', 'ttbase-framework' ),
			),
			array(
				'type'       => 'streamline_icon',
				'heading'    => esc_html__( 'Icon Left', 'ttbase-framework' ),
				'param_name' => 'icon_left_sl',
				'value'      => '',
				'dependency'    => Array(
                        'element'   => 'icon_font',
                        'value'     => array( 'streamline' )
                    ),
                'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
			),
			array(
				'type'       => 'streamline_icon',
				'heading'    => esc_html__( 'Icon Right', 'ttbase-framework' ),
				'param_name' => 'icon_right_sl',
				'value'      => '',
				'dependency'    => Array(
                        'element'   => 'icon_font',
                        'value'     => array( 'streamline' )
                 ),
                 'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
			),
			array(
				'type'       => 'iconsmind_icon',
				'heading'    => esc_html__( 'Icon Left', 'ttbase-framework' ),
				'param_name' => 'icon_left_im',
				'value'      => '',
				'dependency'    => Array(
                        'element'   => 'icon_font',
                        'value'     => array( 'iconsmind' )
                    ),
                'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
			),
			array(
				'type'       => 'iconsmind_icon',
				'heading'    => esc_html__( 'Icon Right', 'ttbase-framework' ),
				'param_name' => 'icon_right_im',
				'value'      => '',
				'dependency'    => Array(
                        'element'   => 'icon_font',
                        'value'     => array( 'iconsmind' )
                    ),
                'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
			),
			array(
				'type'       => 'font_awesome_icon',
				'heading'    => esc_html__( 'Icon Left', 'ttbase-framework' ),
				'param_name' => 'icon_left_fa',
				'value'      => '',
				'dependency'    => Array(
                        'element'   => 'icon_font',
                        'value'     => array( 'fontawesome' )
                    ),
                'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
			),
			array(
				'type'       => 'font_awesome_icon',
				'heading'    => esc_html__( 'Icon Right', 'ttbase-framework' ),
				'param_name' => 'icon_right_fa',
				'value'      => '',
				'dependency'    => Array(
                        'element'   => 'icon_font',
                        'value'     => array( 'fontawesome' )
                    ),
                'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
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
add_action( 'vc_before_init', 'ttbase_framework_vc_button_shortcode' );

?>