<?php

// VC Items List ------------------------------------------------------------------------ >
function ttbase_framework_vc_list_shortcode() {
	vc_map( array(
	    "name" 						=> esc_html__( 'TTBase Items List', 'ttbase-framework' ),
	    "base" 						=> 'ttbase_list',
	    "description" 				=> esc_html__( 'Add Items List', 'ttbase-framework' ),
	    "icon" 						=> "ttbase_vc_icon",
	    "category" 					=> esc_html__( 'TTBase', 'ttbase-framework' ),
	    "as_parent" 				=> array('only' => 'ttbase_item'),
	    "content_element" 			=> true,
	    "show_settings_on_create" 	=> true,
	    "js_view" 					=> 'VcColumnView',
	    'params'			=> array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text Align', 'ttbase-framework' ),
				'param_name' => 'text_align',
				'value'      => array(
					 esc_html__( 'Left', 'ttbase-framework' )   	 => '',
					 esc_html__( 'Center', 'ttbase-framework' )      => 'text-center',
					 esc_html__( 'Right', 'ttbase-framework' )		 => 'text-right',
				)
			),
		)
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_list_shortcode' );


// VC List Item ------------------------------------------------------------------------ >
function ttbase_framework_vc_item_shortcode() {
	vc_map( array(
	    "name" 				=> esc_html__( 'TTBase List Item', 'ttbase-framework' ),
	    "base" 				=> 'ttbase_item',
	    "description" 		=> esc_html__( 'Add list item', 'ttbase-framework' ),
	    "icon" 				=> "ttbase_vc_icon",
	    "content_element" 	=> true,
	    "as_child" 			=> array('only' => 'ttbase_list'),
	    "params" 			=> array(
    		array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Font', 'ttbase-framework' ),
				'param_name' => 'icon_font',
				'value'      => array(
					 esc_html__( 'Streamline', 'ttbase-framework' )      => 'streamline',
					 esc_html__( 'Icons Mind', 'ttbase-framework' )      => 'iconsmind',
					 esc_html__( 'Font Awesome', 'ttbase-framework' ) => 'fontawesome',
				)
			),
	    	array(
				'type'       => 'streamline_icon',
				'heading'    => esc_html__( 'Icon', 'ttbase-framework' ),
				'param_name' => 'icon_sl',
				'value'      => '',
				'dependency'    => Array(
                    'element'   => 'icon_font',
                    'value'     => array( 'streamline' )
                )
			),
			array(
				'type'       => 'font_awesome_icon',
				'heading'    => esc_html__( 'Icon', 'ttbase-framework' ),
				'param_name' => 'icon_fa',
				'value'      => '',
				'dependency'    => Array(
                    'element'   => 'icon_font',
                    'value'     => array( 'fontawesome' )
                )
			),
			array(
				'type'       => 'iconsmind_icon',
				'heading'    => esc_html__( 'Icon', 'ttbase-framework' ),
				'param_name' => 'icon_im',
				'value'      => '',
				'dependency'    => Array(
                    'element'   => 'icon_font',
                    'value'     => array( 'iconsmind' )
                )
			),
			array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__( 'Icon Color', 'ttbase-framework' ),
                    'param_name'    => 'icon_color',
                    'value'         => ''
                ),
            array(
				'type'			=> 'textfield',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Fixed Width', 'ttbase-framework' ),
				'param_name'	=> 'width',
				'value'			=> '',
				'description'	=> esc_html__( 'Set a fixed width, useful for right aligned text.', 'ttbase-framework' ),
			),
			array(
                    'type'          => 'textarea_html',
                    'holder'        => 'div',
                    'heading'       => esc_html__( 'Content', 'ttbase-framework' ),
                    'param_name'    => 'content',
                    'value'         => esc_html__( 'Don\'t forget to change this dummy text.', 'ttbase-framework' ),
                    'group'         => esc_html__( 'Content', 'ttbase-framework' ),
                ),
		),
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_item_shortcode' );

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_TTBase_Item extends WPBakeryShortCode {
    }
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_TTBase_List extends WPBakeryShortCodesContainer {
    }
}

?>