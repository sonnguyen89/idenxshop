<?php

// VC Callout ------------------------------------------------------------------------ >
function ttbase_framework_vc_callout_shortcode() {
	vc_map( array(
		'name'        => esc_html__( 'TTBase Callout', 'ttbase-framework' ),
		'base'        => 'ttbase_callout',
		'description' => esc_html__( 'Call to action area', 'ttbase-framework' ),
		'category'    => esc_html__( 'TTBase', 'ttbase-framework' ),
		'icon'        => 'ttbase_vc_icon',
		'params'      => array(
			array(
				'type'			=> 'textarea_html',
				'admin_label'	=> true,
				'heading'		=> esc_html__( 'Callout Content', 'ttbase-framework' ),
				'param_name'	=> 'content',
				'value'			=> esc_html__( 'Enter your content here.', 'ttbase-framework' ),
				'description'	=> esc_html__( 'Callout Content', 'ttbase-framework' ),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Fade In', 'ttbase-framework' ),
				'param_name'	=> 'fade_in',
				'description'	=> esc_html__( 'Fade In Animation', 'ttbase-framework' ),
				'value'			=> array(
				 	esc_html__( 'No', 'ttbase-framework' )	=> 'false',
					esc_html__( 'Yes', 'ttbase-framework' )	=> 'true',
				),
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Button: URL', 'ttbase-framework' ),
				'param_name'	=> 'button_url',
				'value'			=> '#',
				'description'	=> esc_html__( 'Button: URL', 'ttbase-framework' )
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Button: Text', 'ttbase-framework' ),
				'param_name'	=> 'button_text',
				'value'			=> 'Button Text',
				'description'	=> esc_html__( 'Button: Text', 'ttbase-framework' )
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Button: Style', 'ttbase-framework' ),
				'param_name'	=> 'button_style',
				'description'	=> esc_html__( 'Select a button style.', 'ttbase-framework' ),
				'value'			=> array(
					 esc_html__( 'Style 1', 'ttbase-framework' )  => 'style-1',
					 esc_html__( 'Style 2', 'ttbase-framework' )	  => 'style-2'
				),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Button: Size', 'ttbase-framework' ),
				'param_name'  => 'button_size',
				'description' => esc_html__( 'Select a button size.', 'ttbase-framework' ),
				'value'       => ttbase_framework_shortcodes_button_sizes_array(),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Button: Link Target', 'ttbase-framework' ),
				'param_name'	=> 'button_target',
				'value'			=> array(
					 esc_html__( 'Self', 'ttbase-framework' )		=> 'self',
					 esc_html__( 'Blank', 'ttbase-framework' )	=> 'blank',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Button: Rel', 'ttbase-framework' ),
				'param_name'	=> 'button_rel',
				'value'			=> array(
					 esc_html__( 'None', 'ttbase-framework' )			=> 'none',
					 esc_html__( 'Nofollow', 'ttbase-framework' )	=> 'nofollow',
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Button: Icon Left', 'ttbase-framework' ),
				'param_name'	=> 'button_icon_left',
				'description'	=> sprintf( wp_kses(__( 'Icon to the left of your button text. See all the icons at %s', 'ttbase-framework' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome</a>' ),
				'value'			=> ttbase_framework_shortcodes_font_icons_array(),
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Button: Icon Right', 'ttbase-framework' ),
				'param_name'	=> 'button_icon_right',
				'description'	=> sprintf( wp_kses(__( 'Icon to the right of your button text. See all the icons at %s', 'ttbase-framework' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome</a>' ),
				'value'			=> ttbase_framework_shortcodes_font_icons_array(),
			),
		)
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_callout_shortcode' );


?>