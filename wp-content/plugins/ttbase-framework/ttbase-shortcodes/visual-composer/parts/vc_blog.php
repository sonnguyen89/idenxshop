<?php

// VC Blog ------------------------------------------------------------------------ >
function ttbase_framework_vc_blog_shortcode() {
	vc_map( array(
		'name'				=> esc_html__( 'TTBase Blog', 'ttbase-framework' ),
		'base'				=> 'ttbase_blog',
		'description'		=> esc_html__( 'Add blog in different styles.', 'ttbase-framework' ),
		'category'			=> esc_html__( 'TTBase', 'ttbase-framework' ),
		'icon'        => 'ttbase_vc_icon',
		'params'			=> array(
			array(
					"type" => "textfield",
					"heading" => esc_html__("Show How Many Posts?", 'ttbase-framework'),
					"param_name" => "pppage",
					"value" => '8'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Display type", 'ttbase-framework'),
					"param_name" => "type",
					"value" 				=> array(
						esc_html__( 'Normal Feed, No Sidebar', 'ttbase-framework' )     	=> "normal",
						esc_html__( 'Normal Feed, Left Sidebar', 'ttbase-framework' )     => "normal-left",
    					esc_html__( 'Normal Feed, Right Sidebar', 'ttbase-framework' )    => "normal-right",
					    esc_html__( 'Masonry Left Sidebar', 'ttbase-framework' )          => "masonry-2-col-left",
					    esc_html__( 'Masonry Right Sidebar', 'ttbase-framework' )         => "masonry-2-col-right",
    					esc_html__( 'Masonry 2 Columns', 'ttbase-framework' )             => "masonry-2-col",
    					esc_html__( 'Masonry 3 Columns', 'ttbase-framework' ) 	        => "masonry-3-col",
    					esc_html__( 'Medium Images, No Sidebar', 'ttbase-framework' )     => "medium",
						esc_html__( 'Medium Images, Left Sidebar', 'ttbase-framework' )     => "medium-left",
    					esc_html__( 'Medium Images, Right Sidebar', 'ttbase-framework' )    => "medium-right",
    				),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__('Show Pagination?', 'ttbase-framework'),
					'param_name' => 'pagination',
					'value' => array(
						esc_html__('No', 'ttbase-framework') => 'no',
						esc_html__('Yes', 'ttbase-framework') => 'yes'
					)
				)
		)
	) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_blog_shortcode' );

?>