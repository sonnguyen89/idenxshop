<?php

// VC Time ------------------------------------------------------------------------ >
function ttbase_framework_vc_time_shortcode() {
	vc_map(array(
		"name"                    => esc_html__("TTBase Local Time", 'ttbase-framework'),
		"description"             => esc_html__("show the local time", 'ttbase-framework'),
		"base"                    => "ttbase_time",
		"class"                   => "",
		"controls"                => "full",
		"icon"                    => "ttbase_vc_icon",
		"category"                => esc_html__("TTBase", 'ttbase-framework'),
		"show_settings_on_create" => TRUE,
		"params"                  => array(
		
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => esc_html__("Time icon", 'ttbase-framework'),
				"description" => esc_html__("show time icon", 'ttbase-framework'),
				"param_name"  => "icon",
				"value"       => array(
					esc_html__("yes", 'ttbase-framework')  => 'yes',
					esc_html__("no", 'ttbase-framework')  => 'no'
				),
			),
			array(
				"type"        => "colorpicker",
				"holder"      => "div",
				"class"       => "",
				"heading"     => esc_html__("Icon Color", 'ttbase-framework'),
				"param_name"  => "icon_color",
				"value"       => ""
			),
			array(
				"type"        => "colorpicker",
				"holder"      => "div",
				"class"       => "",
				"heading"     => esc_html__("Text Color", 'ttbase-framework'),
				"param_name"  => "text_color",
				"value"       => ""
			),
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => esc_html__("Time Format", 'ttbase-framework'),
				"param_name"  => "time_format",
				"value"       => "h:i A"
			),
		),
    ));
}
add_action( 'vc_before_init', 'ttbase_framework_vc_time_shortcode' );


?>