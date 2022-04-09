<?php

// VC Pricing Table ------------------------------------------------------------------------ >
function ttbase_framework_vc_pricing_shortcode() {
	vc_map( array(
		'name'        => esc_html__( 'TTBase Pricing Table', 'ttbase-framework' ),
		'base'        => 'ttbase_pricing_table',
		'description' => esc_html__( 'Insert a pricing table', 'ttbase-framework' ),
		'category'    => esc_html__( 'TTBase', 'ttbase-framework' ),
		'icon'        => 'ttbase_vc_icon',
		'params'      => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__("Title", 'ttbase-framework'),
				"param_name" => "title",
				'holder' => 'div'
			),
			array(
					"type"			=> "colorpicker",
					"heading"		=> esc_html__( "Title Color", 'ttbase-framework' ),
					"param_name"	=> "title_color",
					"value"			=> "",
				),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Amount", 'ttbase-framework'),
				"param_name" => "amount",
				"value" => '$3',
			),
			array(
					"type"			=> "colorpicker",
					"heading"		=> esc_html__( "Amount Text Color", 'ttbase-framework' ),
					"param_name"	=> "amount_color",
					"value"			=> "",
				),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Small Text", 'ttbase-framework'),
				"param_name" => "small",
			),
			array(
					"type"			=> "colorpicker",
					"heading"		=> esc_html__( "Small Text Color", 'ttbase-framework' ),
					"param_name"	=> "small_color",
					"value"			=> "",
				),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Display type", 'ttbase-framework'),
				"param_name" => "layout",
				"value" => array(
					esc_html__('Basic Background', 'ttbase-framework') => 'basic',
					esc_html__('Boxed Background', 'ttbase-framework') => 'boxed',
					esc_html__('Emphasis Background', 'ttbase-framework') => 'emphasis'
				)
			),
			array(
					"type"			=> "colorpicker",
					"heading"		=> esc_html__( "Border Color", 'ttbase-framework' ),
					"param_name"	=> "border_color",
					"value"			=> "",
					'dependency'    => Array(
                        'element'   => 'layout',
                        'value'     => array( 'basic' )
                    ),
				),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Button Text", 'ttbase-framework'),
				"param_name" => "button_text",
				"value" => 'Select Plan',
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Button URL", 'ttbase-framework'),
				"param_name" => "button_url",
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Button: Style', 'ttbase-framework' ),
				'param_name'  => 'button_style',
				'description' => esc_html__( 'Select a button style.', 'ttbase-framework' ),
				'value'			=> array(
					esc_html__( 'Style 1 (Bordered)', 'ttbase-framework' )  => 'style-1',
					esc_html__( 'Style 2 (Plain)', 'ttbase-framework' )   => 'style-2',
					esc_html__( 'Style 3 (Gradient)', 'ttbase-framework' )   => 'style-3',
				)
			),
			array(
				"type" => "textarea_html",
				"heading" => esc_html__("Table Content", 'ttbase-framework'),
				"param_name" => "content",
				'value' => '<ul>
							<li><strong>Unlimited</strong>&nbsp;access to content</li>
							<li><strong>Fully Secure</strong>&nbsp;online backup</li>
							<li><strong>One Year</strong>&nbsp;round the clock support</li>
							<li><strong>FREE</strong>&nbsp;complimentary lanyard</li>
							</ul>'
			),
		)
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_pricing_shortcode' );

?>