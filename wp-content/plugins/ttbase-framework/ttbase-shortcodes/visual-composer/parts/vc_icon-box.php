<?php

// VC Icon Box ------------------------------------------------------------------------ >
function ttbase_framework_vc_icon_box_shortcode() {
	vc_map( array(
            'name'                  => esc_html__( 'TTBase Icon Box', 'ttbase-framework' ),
            'base'                  => 'ttbase_icon_box',
            'category'                => esc_html__('TTBase', 'ttbase-framework'),
            'icon'                  => 'ttbase_vc_icon',
            'description'           => esc_html__( 'Content box with icon', 'ttbase-framework' ),
            'params'                => array(
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Extra class name', 'ttbase-framework' ),
                    'param_name'    => 'el_class',
                    'description'   => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'ttbase-framework' ),
                ),
                
                // Icon
                array(
                    'type'          => 'attach_image',
                    'heading'       => esc_html__( 'Icon Image Alternative', 'ttbase-framework' ),
                    'param_name'    => 'image',
                    'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Icon Image Alternative Width', 'ttbase-framework' ),
                    'param_name'    => 'image_width',
                    'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
					'dependency'    => array(
                        'element'   => 'image',
                        'not_empty' => true,
                    ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'Icon Font', 'ttbase-framework' ),
                    'param_name'    => 'icon_font',
                    'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
                    'value'         => array(
                        esc_html__( 'Font Awesome', 'ttbase-framework' )          => 'fontawesome',
                        esc_html__( 'Icons Mind', 'ttbase-framework' )    => 'iconsmind',
                        esc_html__( 'Streamline', 'ttbase-framework' )    => 'streamline',
                    ),
                    
                ),
                array(
                    'type'          => 'font_awesome_icon',
                    'heading'       => esc_html__( 'Icon', 'ttbase-framework' ),
                    'param_name'    => 'icon_fa',
                    'value'         => '',
                    'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
                    'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'fontawesome' ),
                    ),
                    
                ),
                array(
                    'type'          => 'streamline_icon',
                    'heading'       => esc_html__( 'Icon', 'ttbase-framework' ),
                    'param_name'    => 'icon_sl',
                    'value'         => '',
                    'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
                    'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'streamline' ),
                    ),
                    
                ),
                array(
                    'type'          => 'iconsmind_icon',
                    'heading'       => esc_html__( 'Icon', 'ttbase-framework' ),
                    'param_name'    => 'icon_im',
                    'value'         => '',
                    'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
                    'dependency'    => array(
                        'element'   => 'icon_font',
                        'value'     => array( 'iconsmind' ),
                    ),
                    
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Icon Font Alternative Classes', 'ttbase-framework' ),
                    'param_name'    => 'icon_alternative_classes',
                    'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
                    
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__( 'Icon Color', 'ttbase-framework' ),
                    'param_name'    => 'icon_color',
                    'value'         => '',
                    'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
                    
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__( 'Icon Background', 'ttbase-framework' ),
                    'param_name'    => 'icon_background',
                    'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
                    
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Icon Padding', 'ttbase-framework' ),
                    'param_name'    => 'icon_padding',
                    'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
                    'value'         => '20px',
                    'dependency'    => array(
                        'element'   => 'icon_background',
                        'not_empty' => true
                    ),
                    
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Icon Border Radius', 'ttbase-framework' ),
                    'param_name'    => 'icon_border_radius',
                    'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
                    
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Icon Size In Pixels', 'ttbase-framework' ),
                    'param_name'    => 'icon_size',
                    'value'         => '',
                    'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
                    
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Fixed Icon Width', 'ttbase-framework' ),
                    'param_name'    => 'icon_width',
                    'value'         => '',
                    'group'         => esc_html__( 'Icon', 'ttbase-framework' ),
                    
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Fixed Icon Height', 'ttbase-framework' ),
                    'param_name'    => 'icon_height',
                    'value'         => '',
                    'group'         => esc_html__( 'Icon', 'ttbase-framework' )
                ),

                // Design
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
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'Icon Box Style', 'ttbase-framework' ),
                    'param_name'    => 'style',
                    'value'         => array(
                        esc_html__( 'Left Icon', 'ttbase-framework')                    => 'one',
                        esc_html__( 'Right Icon', 'ttbase-framework')                   => 'seven',
                        esc_html__( 'Top Icon', 'ttbase-framework' )                    => 'two',
                        esc_html__( 'Top Icon Style 2', 'ttbase-framework' )   => 'three',
                        esc_html__( 'Outlined and Top Icon', 'ttbase-framework' )         => 'four',
                        esc_html__( 'Boxed and Top Icon', 'ttbase-framework' )            => 'five',
                        esc_html__( 'Boxed and Top Icon Style 2', 'ttbase-framework' )    => 'six',
                        esc_html__( 'Flipping Icon Box', 'ttbase-framework' )    => 'eight',
                    ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'Alignment', 'ttbase-framework' ),
                    'param_name'    => 'alignment',
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'two' ),
                    ),
                    'value'         => array(
                        esc_html__( 'Default', 'ttbase-framework')  => '',
                        esc_html__( 'Center', 'ttbase-framework')   => 'center',
                        esc_html__( 'Left', 'ttbase-framework' )    => 'left',
                        esc_html__( 'Right', 'ttbase-framework' )   => 'right',
                    ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Icon Bottom Margin', 'ttbase-framework' ),
                    'param_name'    => 'icon_bottom_margin',
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'two', 'three', 'four', 'five', 'six', 'eight' ),
                    ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Container Left Padding', 'ttbase-framework' ),
                    'param_name'    => 'container_left_padding',
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'one' )
                    ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Container Right Padding', 'ttbase-framework' ),
                    'param_name'    => 'container_right_padding',
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'seven' )
                    ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__( 'Background Color', 'ttbase-framework' ),
                    'param_name'    => 'background',
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'two', 'four', 'five', 'six', 'eight' )
                    ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__( 'Hover Background Color', 'ttbase-framework' ),
                    'param_name'    => 'hover_background',
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'eight' ),
                    ),
                ),
                array(
                    'type'          => 'attach_image',
                    'heading'       => esc_html__( 'Background Image', 'ttbase-framework' ),
                    'param_name'    => 'background_image',
                    'value'         => '',
                    'description'   => esc_html__( 'Select image from media library.', 'ttbase-framework' ),
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'four', 'five', 'six', 'eight' ),
                    ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'Background Image Style', 'ttbase-framework' ),
                    'param_name'    => 'background_image_style',
                    'value'         => array(
                        esc_html__( 'Default', 'ttbase-framework' )     => '',
                        esc_html__( 'Stretched', 'ttbase-framework' )   => 'stretch',
                        esc_html__( 'Fixed', 'ttbase-framework' )       => 'fixed',
                        esc_html__( 'Repeat', 'ttbase-framework' )      => 'repeat',
                    ),
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'four', 'five', 'six', 'eight' ),
                    ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__( 'Border Color', 'ttbase-framework' ),
                    'param_name'    => 'border_color',
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'four', 'eight' ),
                    ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Padding', 'ttbase-framework' ),
                    'param_name'    => 'padding',
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'four', 'five', 'six', 'eight' )
                    ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Border Radius', 'ttbase-framework' ),
                    'param_name'    => 'border_radius',
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'four', 'five', 'six', 'eight' )
                    ),
                ),

                // Heading
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Heading', 'ttbase-framework' ),
                    'param_name'    => 'heading',
                    'value'         => '',
                    'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'Heading Type', 'ttbase-framework' ),
                    'param_name'    => 'heading_type',
                    'value'     => array(
                        'h3'    => 'h3',
                        'h2'    => 'h2',
                        'h4'    => 'h4',
                        'h5'    => 'h5',
                        'div'   => 'div',
                        'span'  => 'span',
                    ),
                    'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__( 'Heading Font Color', 'ttbase-framework' ),
                    'param_name'    => 'heading_color',
                    'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Heading Font Size', 'ttbase-framework' ),
                    'param_name'    => 'heading_size',
                    'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'Heading Font Weight', 'ttbase-framework' ),
                    'description'   => esc_html__( 'Not all fonts support every font weight.', 'ttbase-framework' ),
                    'param_name'    => 'heading_weight',
                    'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                    'value'         => array(
                        esc_html__( 'Default', 'ttbase-framework' )               => '',
                        esc_html__( 'Extra Light: 100', 'ttbase-framework' )      => '100',
                        esc_html__( 'Light: 200', 'ttbase-framework' )            => '200',
                        esc_html__( 'Book : 300', 'ttbase-framework' )            => '300',
                        esc_html__( 'Normal: 400', 'ttbase-framework' )           => '400',
                        esc_html__( 'Medium: 500', 'ttbase-framework' )           => '500',
                        esc_html__( 'Semibold: 600', 'ttbase-framework' )         => '600',
                        esc_html__( 'Bold: 700', 'ttbase-framework' )             => '700',
                        esc_html__( 'Extra Bold: 800', 'ttbase-framework' )       => '800',
                    ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Heading Letter Spacing', 'ttbase-framework' ),
                    'param_name'    => 'heading_letter_spacing',
                    'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'Heading Text Transform', 'ttbase-framework' ),
                    'param_name'    => 'heading_transform',
                    'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                    'value'         => array(
                        esc_html__( 'Default', 'ttbase-framework' )     => '',
                        esc_html__( 'None', 'ttbase-framework' )        => 'none',
                        esc_html__( 'Capitalize', 'ttbase-framework' )  => 'capitalize',
                        esc_html__( 'Uppercase', 'ttbase-framework' )   => 'uppercase',
                        esc_html__( 'Lowercase', 'ttbase-framework' )   => 'lowercase',
                    ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Heading Bottom Margin', 'ttbase-framework' ),
                    'param_name'    => 'heading_bottom_margin',
                    'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                ),
                // Subtitle
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Subtitle', 'ttbase-framework' ),
                    'param_name'    => 'subtitle',
                    'value'         => 'Subtitle',
                    'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'eight' )
                    ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__( 'Subtitle Font Color', 'ttbase-framework' ),
                    'param_name'    => 'subtitle_color',
                    'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'eight' )
                    ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Subtitle Font Size', 'ttbase-framework' ),
                    'param_name'    => 'subtitle_size',
                    'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'eight' )
                    ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'Subtitle Font Weight', 'ttbase-framework' ),
                    'description'   => esc_html__( 'Not all fonts support every font weight.', 'ttbase-framework' ),
                    'param_name'    => 'subtitle_weight',
                    'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                    'value'         => array(
                        esc_html__( 'Default', 'ttbase-framework' )               => '',
                        esc_html__( 'Extra Light: 100', 'ttbase-framework' )      => '100',
                        esc_html__( 'Light: 200', 'ttbase-framework' )            => '200',
                        esc_html__( 'Book : 300', 'ttbase-framework' )            => '300',
                        esc_html__( 'Normal: 400', 'ttbase-framework' )           => '400',
                        esc_html__( 'Medium: 500', 'ttbase-framework' )           => '500',
                        esc_html__( 'Semibold: 600', 'ttbase-framework' )         => '600',
                        esc_html__( 'Bold: 700', 'ttbase-framework' )             => '700',
                        esc_html__( 'Extra Bold: 800', 'ttbase-framework' )       => '800',
                    ),
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'eight' )
                    ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Subtitle Letter Spacing', 'ttbase-framework' ),
                    'param_name'    => 'subtitle_letter_spacing',
                    'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'eight' )
                    ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'Subtitle Text Transform', 'ttbase-framework' ),
                    'param_name'    => 'subtitle_transform',
                    'group'         => esc_html__( 'Heading', 'ttbase-framework' ),
                    'value'         => array(
                        esc_html__( 'Default', 'ttbase-framework' )     => '',
                        esc_html__( 'None', 'ttbase-framework' )        => 'none',
                        esc_html__( 'Capitalize', 'ttbase-framework' )  => 'capitalize',
                        esc_html__( 'Uppercase', 'ttbase-framework' )   => 'uppercase',
                        esc_html__( 'Lowercase', 'ttbase-framework' )   => 'lowercase',
                        
                    ),
                    'dependency'    => array(
                        'element'   => 'style',
                        'value'     => array( 'eight' )
                    ),
                ),
                
                // Content
                array(
                    'type'          => 'textarea_html',
                    'holder'        => 'div',
                    'heading'       => esc_html__( 'Content', 'ttbase-framework' ),
                    'param_name'    => 'content',
                    'value'         => esc_html__( 'Don\'t forget to change this dummy text in your page editor for this lovely icon box.', 'ttbase-framework' ),
                    'group'         => esc_html__( 'Content', 'ttbase-framework' ),
                ),
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Content Font Size', 'ttbase-framework' ),
                    'param_name'    => 'font_size',
                    'group'         => esc_html__( 'Content', 'ttbase-framework' ),
                ),
                array(
                    'type'          => 'colorpicker',
                    'heading'       => esc_html__( 'Content Font Color', 'ttbase-framework' ),
                    'param_name'    => 'font_color',
                    'group'         => esc_html__( 'Content', 'ttbase-framework' ),
                ),

                // URL
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'URL', 'ttbase-framework' ),
                    'param_name'    => 'url',
                    'value'         => '#',
                    'group'         => esc_html__( 'URL', 'ttbase-framework' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'URL Target', 'ttbase-framework' ),
                    'param_name'    => 'url_target',
                     'value'        => array(
                        esc_html__( 'Self', 'ttbase-framework' )    => '',
                        esc_html__( 'Blank', 'ttbase-framework' )   => '_blank',
                        esc_html__( 'Local', 'ttbase-framework' )   => 'local',
                    ),
                    'group'         => esc_html__( 'URL', 'ttbase-framework' ),
                ),
                array(
                    'type'          => 'dropdown',
                    'heading'       => esc_html__( 'URL Rel', 'ttbase-framework' ),
                    'param_name'    => 'url_rel',
                    'value'         => array(
                        esc_html__( 'None', 'ttbase-framework' )        => '',
                        esc_html__( 'Nofollow', 'ttbase-framework' )    => 'nofollow',
                    ),
                    'group'         => esc_html__( 'URL', 'ttbase-framework' ),
                ),

                // Margin
                array(
                    'type'          => 'textfield',
                    'heading'       => esc_html__( 'Bottom Margin', 'ttbase-framework' ),
                    'param_name'    => 'margin_bottom',
                    'group'         => esc_html__( 'Margin', 'ttbase-framework' ),
                ),
            )
        ) );
}
add_action( 'vc_before_init', 'ttbase_framework_vc_icon_box_shortcode' );

?>