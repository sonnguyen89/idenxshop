<?php

// VC Tabs ------------------------------------------------------------------------ >
function ttbase_framework_vc_tabs_shortcode() {
	vc_map( 
		array(
			"icon" => 'ttbase_vc_icon',
		    'name'                    => esc_html__( 'TTBase Icon Tabs' , 'ttbase-framework' ),
		    'base'                    => 'ttbase_tabs',
		    'description'             => esc_html__( 'Create Tabbed Content with icons', 'ttbase-framework' ),
		    'as_parent'               => array('only' => 'ttbase_tabs_content'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    "category" => esc_html__('TTBase', 'ttbase-framework'),
		    'params' => array(
		    	
		    	array(
		    		"type" => "dropdown",
		    		"heading" => esc_html__("Title Text Align", 'ttbase-framework'),
		    		"param_name" => "text_align",
		    		"value" => array(
		    			esc_html__( 'Center', 'ttbase-framework' ) => 'text-center',
		    			esc_html__( 'Left', 'ttbase-framework' ) => 'text-left',
		    			esc_html__( 'Right', 'ttbase-framework' ) => 'text-right'
		    		),
		    		'dependency'    => array(
                        'element'   => 'type',
                        'value'     => array( 'text-tabs' )
                    )
		    		
		    	),
		    )
		) 
	);
}
add_action( 'vc_before_init', 'ttbase_framework_vc_tabs_shortcode' );


// VC Tabs Content ------------------------------------------------------------------------ >
function ttbase_framework_vc_tabs_content_shortcode() {
	vc_map( 
		array(
			"icon" => 'ttbase_vc_icon',
		    'name'            => esc_html__('TTBase Icon Tabs Content', 'ttbase-framework'),
		    'base'            => 'ttbase_tabs_content',
		    'description'     => esc_html__( 'Icon Tab Content Element', 'ttbase-framework' ),
		    "category" => esc_html__('TTBase', 'ttbase-framework'),
		    'content_element' => true,
		    'as_child'        => array('only' => 'ttbase_tabs'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params'          => array(
		    	array(
		    		"type" => "textfield",
		    		"heading" => esc_html__("Title", 'ttbase-framework'),
		    		"param_name" => "title",
		    		'holder' => 'div'
		    	),
	            array(
	            	"type" => "textarea_html",
	            	"heading" => esc_html__("Content", 'ttbase-framework'),
	            	"param_name" => "content"
	            ),
	            array(
		    		"type" => "dropdown",
		    		"heading" => esc_html__("Icon Font (Icon tabs only)", 'ttbase-framework'),
		    		"param_name" => "icon_font",
		    		"value" => array(
		    			esc_html__( 'Streamline', 'ttbase-framework' ) => 'streamline',
		    			esc_html__( 'Streamline', 'ttbase-framework' ) => 'iconsmind',
		    			esc_html__( 'Font Awesome', 'ttbase-framework' ) => 'fontawesome'
		    		)
		    		
		    	),
	            array(
    				'type'       => 'font_awesome_icon',
    				'heading'    => esc_html__( 'Font Awesome Icons (Icon tabs only)', 'ttbase-framework' ),
    				'param_name' => 'icon_fa',
    				'value'      => '',
    				'description'    => esc_html__( 'Type "none" or leave blank to hide icons.', 'ttbase-framework' ),
    				'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'fontawesome' )
                    )
    			),
    			array(
    				'type'       => 'streamline_icon',
    				'heading'    => esc_html__( 'Streamline Icons (Icon tabs only)', 'ttbase-framework' ),
    				'param_name' => 'icon_sl',
    				'value'      => '',
    				'description'    => esc_html__( 'Type "none" or leave blank to hide icons.', 'ttbase-framework' ),
    				'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'streamline' )
                    )
    			),
    			array(
    				'type'       => 'iconsmind_icon',
    				'heading'    => esc_html__( 'Icons Mind Icons (Icon tabs only)', 'ttbase-framework' ),
    				'param_name' => 'icon_im',
    				'value'      => '',
    				'description'    => esc_html__( 'Type "none" or leave blank to hide icons.', 'ttbase-framework' ),
    				'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'iconsmind' )
                    )
    			)
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'ttbase_framework_vc_tabs_content_shortcode' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_ttbase_tabs extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_ttbase_tabs_content extends WPBakeryShortCode {

    }
}

?>