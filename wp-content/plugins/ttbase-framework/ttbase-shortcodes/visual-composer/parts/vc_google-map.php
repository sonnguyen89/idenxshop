<?php

// VC Google Map ---------------------------------------------------------------------- >
function ttbase_framework_vc_google_map_shortcode() {
	vc_map(array(
			"name"                    => esc_html__("TTBase Google Map", 'ttbase-framework'),
			"base"                    => "ttbase_google_map",
			"class"                   => "",
			"controls"                => "full",
			"icon"                    => "ttbase_vc_icon",
			"category"                => esc_html__("TTBase", 'ttbase-framework'),
			"show_settings_on_create" => TRUE,
			"params"                  => array(
				array(
					"type"        => "textfield",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("API Key", 'ttbase-framework'),
					"description" => sprintf( wp_kses( __( '<a href="%s" target="_blank">How to create API Key</a> for the google maps.', 'ttbase-framework' ), array(  'a' => array( 'href' => array(), 'target' =>array() ) ) ), esc_url( 'https://developers.google.com/maps/documentation/javascript/' ) ),
					"param_name"  => "api_key",
					"value"       => "",
				),
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Map Type", 'ttbase-framework'),
					"param_name"  => "map_type",
					"value"       => array(
						esc_html__("Road Map", 'ttbase-framework')   => 'ROADMAP',
						esc_html__("Satellite", 'ttbase-framework') => 'SATELLITE',
						esc_html__("Hybrid", 'ttbase-framework')    => 'HYBRID',
						esc_html__("Terrain", 'ttbase-framework')   => 'TERRAIN'
					),
				),
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Map Style", 'ttbase-framework'),
					"param_name"  => "style",
					"value"       => array(
						esc_html__( 'Shades of Grey', 'ttbase-framework' ) 	=> "1",
					    esc_html__( 'Greyscale', 'ttbase-framework' ) 		=> "2",
						esc_html__( 'Light Gray', 'ttbase-framework' ) 		=> "3",
					    esc_html__( 'Midnight Commander', 'ttbase-framework' ) => "4",
						esc_html__( 'Blue water', 'ttbase-framework' ) 		=> "5",
						esc_html__( 'Icy Blue', 'ttbase-framework' ) 			=> "6",
						esc_html__( 'Bright and Bubbly', 'ttbase-framework' ) => "7",
						esc_html__( 'Pale Dawn', 'ttbase-framework' ) 		=> "8",
						esc_html__( 'Paper', 'ttbase-framework' ) 			=> "9",
						esc_html__( 'Blue Essence', 'ttbase-framework' ) 		=> "10",
						esc_html__( 'Apple Maps-esque', 'ttbase-framework' ) 	=> "11",
						esc_html__( 'Subtle Grayscale', 'ttbase-framework' ) 	=> "12",
						esc_html__( 'Retro', 'ttbase-framework' ) 		    => "13",
						esc_html__( 'Hopper', 'ttbase-framework' ) 			=> "14",
						esc_html__( 'Red Hues', 'ttbase-framework' ) 			=> "15",
						esc_html__( 'Ultra Light with labels', 'ttbase-framework' ) 	=> "16",
						esc_html__( 'Unsaturated Browns', 'ttbase-framework' ) => "17",
						esc_html__( 'Light Dream', 'ttbase-framework' ) 		=> "18",
						esc_html__( 'Neutral Blue', 'ttbase-framework' ) 		=> "19",
						esc_html__( 'MapBox', 'ttbase-framework' ) 			=> "20",
					)
				),
				array(
					"type"        => "number",
					"holder"      => "div",
					"suffix"      => "px",
					"class"       => "",
					"heading"     => esc_html__("Height", 'ttbase-framework'),
					"param_name"  => "height",
					"value"       => "300"
				),
				array(
					"type"        => "textfield",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Latitude", 'ttbase-framework'),
					"param_name"  => "lat",
					"value"       => "51.4946416",
				),
				array(
					"type"        => "textfield",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Longitude", 'ttbase-framework'),
					"param_name"  => "lng",
					"value"       => "-0.172699",
				),
				array(
					"type"        => "number",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Zoom", 'ttbase-framework'),
					"param_name"  => "zoom",
					"value"       => "12"
				),
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => esc_html__("Show Marker?", 'ttbase-framework'),
					"param_name"  => "marker",
					"value"       => array(
						esc_html__("Yes", 'ttbase-framework') => 'yes',
						esc_html__("No", 'ttbase-framework')  => 'no',
					),
				),
			),
		));
	
}
add_action( 'vc_before_init', 'ttbase_framework_vc_google_map_shortcode' );

?>