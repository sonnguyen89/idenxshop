<?php

// Icon Box -------------------------------------------------------------------------- >
function ttbase_framework_image_box_function( $atts, $content = null) {
		extract( shortcode_atts( array(
			'image' 					=> '',
			'overlay_color'             => '',
			'url'						=> '',
			'target'					=> '_self',
			'icon_image'                => '',
			'icon_image_width'          => '',
			'icon_font'         		=> 'streamline',
            'icon_fa'                   => '',
            'icon_im'                   => '',
            'icon_sl'                   => '',
            'icon_color'                => '',
            'heading'                   => 'Sample Heading',
            'heading_type'              => 'h3',
            'heading_color'             => '',
            'heading_size'              => '',
            'heading_weight'            => '',
            'heading_letter_spacing'    => '',
            'heading_transform'         => '',
            'heading_bottom_margin'     => '',
            'subtitle'                  => 'Subtitle',
            'subtitle_color'            => '',
            'subtitle_size'             => '',
            'subtitle_weight'           => '',
            'subtitle_transform'        => '',
            'subtitle_letter_spacing'   => '',
            'border_color'              => '',
            'bg_color'                  => ''
		), $atts ) );
		
		$output = '<div class="ttbase-imagebox-wrapper card">';
		
		if ($url != '') {
		    $output .= '<a href="'.esc_url($url).'" target="' .esc_attr($target). '" class="ttbase-imagebox">';
		}else {
		    $output .= '<div class="ttbase-imagebox">';
		}
		
		if($image != ''){
			$output .=  wp_get_attachment_image( $image, 'gymx-img-size-wide', 0, array('class' => 'img-responsive') );
		}
		
		$overlay_style = '';
		if ($overlay_color) {
		    $overlay_style .= 'background-color:' . $overlay_color . ';';
            if ( '' != $overlay_style ) {
                $overlay_style = ' style="' . $overlay_style . '"';
            }
		}
		$bg_style = '';
		if ($bg_color) {
		    $bg_style .= 'background-color:' . $bg_color . ';';
            if ( '' != $bg_style ) {
                $bg_style = ' style="' . $bg_style . '"';
            }
		}
		if ($border_color) {
		    $bg_style .= 'border-color:' . $border_color . ';';
		}
        if ( '' != $bg_style ) {
            $bg_style = ' style="' . $bg_style . '"';
        }
		$output .= '<div class="ttbase-imagebox-overlay clearfix"'. $overlay_style .'></div>';
		$output.= '<div class="ttbase-imagebox-image-content"' . $bg_style . '>';
		
		/** Subtitle ***/
        if ( $subtitle ) {
            // Subtitle Classes
            $add_classes ='';
            if ( $subtitle_weight ) {
                $add_classes .= 'font-weight-'. $subtitle_weight . ' ';
            }
            if ( $subtitle_transform ) {
                $add_classes .= 'text-transform-'. $subtitle_transform;
            }
            // Subtitle Style
            $subtitle_style = '';
            if ( '' != $subtitle_color ) {
                $subtitle_style .= 'color:'. $subtitle_color .';';
            }
            if ( '' != $subtitle_size ) {
                $subtitle_size = intval( $subtitle_size );
                $subtitle_style .= 'font-size:'. $subtitle_size .'px;';
            }
            if ( '' != $subtitle_letter_spacing ) {
                $subtitle_style .= 'letter-spacing:'. $subtitle_letter_spacing .';';
            }
            if ( '' != $subtitle_style ) {
                $subtitle_style = ' style=' . $subtitle_style . '';
            }
            $output .= '<h5 class="ttbase-imagebox-subtitle '. $add_classes .'"'. $subtitle_style . '>';
            $output .= $subtitle;
            $output .= '</h5>';
        }
		/** Heading ***/
        if ( $heading ) {
            // Heading Classes
            $add_classes ='';
            if ( $heading_weight ) {
                $add_classes .= 'font-weight-'. $heading_weight . ' ';
            }
            if ( $heading_transform ) {
                $add_classes .= 'text-transform-'. $heading_transform;
            }
            // Heading Style
            $heading_style = '';
            if ( '' != $heading_color ) {
                $heading_style .= 'color:'. $heading_color .';';
            }
            if ( '' != $heading_size ) {
                $heading_size = intval( $heading_size );
                $heading_style .= 'font-size:'. $heading_size .'px;';
            }
            if ( '' != $heading_letter_spacing ) {
                $heading_style .= 'letter-spacing:'. $heading_letter_spacing .';';
            }
            if ( $heading_bottom_margin ) {
                $heading_style .= 'margin-bottom:'. intval( $heading_bottom_margin ) .'px;';
            }
            if ( '' != $heading_style ) {
                $heading_style = ' style=' . $heading_style . '';
            }
            $output .= '<'. $heading_type .' class="ttbase-imagebox-heading '. $add_classes .'"'. $heading_style .'>';
            $output .= $heading;
            $output .= '</'. $heading_type .'>';
        }
        if ($url != '') {
		    $output .= '</div></a>';
		}else {
		    $output .= '</div></div>';
		}
		
		if ($content) {
		    $output .= '<div class="ttbase-imagebox-content">';
		    $output .= do_shortcode($content);
		    $output .= '</div>';
		}
		$output .= '</div>';
			
		return $output;
	}
add_shortcode('ttbase_imagebox', 'ttbase_framework_image_box_function');
