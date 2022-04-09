<?php

// VC Counter ------------------------------------------------------------------------ >
function ttbase_framework_vc_counter_shortcode() {
	vc_map( array(
		"name"					=> esc_html__( "TTBase Counter", 'ttbase-framework' ),
		"description"			=> esc_html__( "Animated Counter", 'ttbase-framework' ),
		"base"					=> "ttbase_counter",
		'category'				=> esc_html__( "TTBase", 'ttbase-framework' ),
		"icon"					=> "ttbase_vc_icon",
		"params"				=> array(
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> esc_html__( "Number", 'ttbase-framework' ),
				"param_name"	=> "number",
				"value"			=> "197",
			),
			array(
				"type"			=> "textfield",
				"admin_label"	=> true,
				"class"			=> "",
				"heading"		=> esc_html__( "Title", 'ttbase-framework' ),
				"param_name"	=> "title",
				"value"			=> "",
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Number Color", 'ttbase-framework' ),
				"param_name"	=> "color",
				"value"			=> "#3cb087",
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
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Background Color", 'ttbase-framework' ),
				"param_name"	=> "background_color",
				"value"			=> "#ffffff",
			),
			array(
				"type"			=> "colorpicker",
				"admin_label"	=> false,
				"class"			=> "",
				"heading"		=> esc_html__( "Border Color", 'ttbase-framework' ),
				"param_name"	=> "border_color",
				"value"			=> "",
			),
		)
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_counter_shortcode' );

?>