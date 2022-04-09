<?php

// VC Modal Popup ------------------------------------------------------------------------ >
function ttbase_framework_vc_modal_shortcode() {
	
	vc_map( 
		array(
			"icon" => 'ttbase_vc_icon',
		    'name'                    => esc_html__( 'TTBase Modal' , 'ttbase-framework' ),
		    'base'                    => 'ttbase_modal',
		    'description'             => esc_html__( 'Create a modal popup', 'ttbase-framework' ),
		    'as_parent'               => array('except' => 'ttbase_tabs_content'),
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('TTBase', 'ttbase-framework'),
		    'params' => array(
		    	array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Button Size', 'ttbase' ),
					'param_name' => 'button_size',
					'value'      => ttbase_framework_shortcodes_button_sizes_array(),
				),
		    	array(
					'type'			=> 'dropdown',
					'admin_label'	=> true,
					'heading'		=> esc_html__( 'Button Style', 'ttbase-framework' ),
					'param_name'	=> 'button_style',
					'value'			=> array(
						esc_html__( 'Style 1', 'ttbase-framework' )  => 'style-1',
						esc_html__( 'Style 2', 'ttbase-framework' )   => 'style-2',
						esc_html__( 'Style 3', 'ttbase-framework' )   => 'style-3'
					),
				),
		    	array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Icon Font for button', 'ttbase-framework' ),
					'param_name' => 'icon_font',
					'value'      => array(
						 esc_html__( 'Streamline', 'ttbase-framework' )      => 'streamline',
						 esc_html__( 'Icons Mind', 'ttbase-framework' )      => 'iconsmind',
						 esc_html__( 'Font Awesome', 'ttbase-framework' ) => 'fontawesome',
					),
				),
		    	array(
					'type'       => 'streamline_icon',
					'heading'    => esc_html__( 'Button Icon', 'ttbase-framework' ),
					'param_name' => 'icon_sl',
					'value'      => '',
					'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'streamline' )
                    )
				),
				array(
					'type'       => 'font_awesome_icon',
					'heading'    => esc_html__( 'Button Icon', 'ttbase-framework' ),
					'param_name' => 'icon_fa',
					'value'      => '',
					'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'fontawesome' )
                    )
				),
				array(
					'type'       => 'iconsmind_icon',
					'heading'    => esc_html__( 'Button Icon', 'ttbase-framework' ),
					'param_name' => 'icon_im',
					'value'      => '',
					'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'iconsmind' )
                    )
				),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Button Text", 'ttbase-framework'),
		    		"param_name" => "button_text"
		    	),
		    	array(
		    		"type" => "dropdown",
		    		"heading" => esc_html__("Button Alignment", 'ttbase-framework'),
		    		"param_name" => "align",
		    		"value" => array(
		    			esc_html__('Center', 'ttbase-framework') => 'text-center',
		    			esc_html__('Left', 'ttbase-framework') => 'text-left',
		    			esc_html__('Right', 'ttbase-framework') => 'text-right'
		    		)
		    	),
		    	array(
					"type"			=> "colorpicker",
					"admin_label"	=> false,
					"class"			=> "",
					"heading"		=> esc_html__( "Close Button Color", 'ttbase-framework' ),
					"param_name"	=> "close_color",
					"value"			=> "",
				),
		    	array(
					"type"			=> "colorpicker",
					"admin_label"	=> false,
					"class"			=> "",
					"heading"		=> esc_html__( "Background Color", 'ttbase-framework' ),
					"param_name"	=> "bg_color",
					"value"			=> "",
				),
		    	array(
		    		"type" => "attach_image",
		    		"heading" => esc_html__("Modal background image?", 'ttbase-framework'),
		    		"param_name" => "image"
		    	),
		    	array(
		    		"type" => "dropdown",
		    		"heading" => esc_html__("Show Full Height?", 'ttbase-framework'),
		    		"param_name" => "fullscreen",
		    		"value" => array(
		    			esc_html__('No', 'ttbase-framework') => 'no',
		    			esc_html__('Yes', 'ttbase-framework') => 'yes',
		    			esc_html__('FullHeight & FullWidth', 'ttbase-framework') => 'fullwidth'
		    		)
		    	),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Delay Timer", 'ttbase-framework'),
		    		"param_name" => "delay",
		    		'description' => esc_html__('Leave blank for infinite delay (manual trigger only) enter milliseconds for automatic popup on timer, e.g: 2000', 'ttbase-framework')
		    	),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Cookie Name", 'ttbase-framework'),
		    		"param_name" => "cookie",
		    		'description' => esc_html__('Set a plain text cookie name here to stop the delay popup if someone has already closed it.', 'ttbase-framework')
		    	),
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Set a manual ID for your modal (numeric)", 'ttbase-framework'),
		    		"param_name" => "manual_id",
		    		'description' => esc_html__('Not required, only set if you require a static ID for your modal, numeric only!', 'ttbase-framework')
		    	),
		    )
		) 
	);
	
}
add_action( 'vc_before_init', 'ttbase_framework_vc_modal_shortcode' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_Ttbase_Modal extends WPBakeryShortCodesContainer {

    }
}

?>