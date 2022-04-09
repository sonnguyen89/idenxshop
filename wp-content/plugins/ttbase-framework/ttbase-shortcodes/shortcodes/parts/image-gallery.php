<?php

// Image Gallery -------------------------------------------------------------------- >	
function ttbase_framework_gallery_shortcode($atts, $content = NULL) {

	extract(shortcode_atts(array(
	    'columns'           => 'cols-2',
	   	'spaces'            => 'gap-0',
	   	'style'             => 'style-1',
	), $atts));
	
	wp_enqueue_script( 'ttbase-gallery' );
	
	$output  = '<div class="ttbase-gallery clearfix '.$columns.' '.$spaces.' '.$style.'">';
	$output .= do_shortcode($content);
	$output .= '</div>';
	
	return $output;	
}

add_shortcode('ttbase_gallery', 'ttbase_framework_gallery_shortcode');

// Image Gallery Item -------------------------------------------------------------- >
function ttbase_framework_gallery_item_shortcode($atts, $content = NULL) {
	extract(shortcode_atts(array(
        'image'         => '',
        'caption'       => '',
        'overlay_color'     => ''
    ), $atts));

    global $post;
    
    $output  = '<div class="ttbase-gallery-item">';
    
    if ( !preg_match('/^\d+$/',$image )){
        $image_src = $image;
        $image_big_src = $image;
        
        $output .= '<a class="lightbox" href="'.$image_big_src.'" title="'.$caption.'" data-lightbox-gallery="gallery-'.$post->ID.'">';
        $output .= '<img alt="'.$caption.'" src="'.$image_src.'" />';    
        
    } else {
        $image_src = wp_get_attachment_image_src($image, 'gymx-img-size-grid');
        $image_big_src = wp_get_attachment_image_src($image, 'full');
        
        $output .= '<a class="lightbox" href="'.$image_big_src[0].'" title="'.$caption.'" data-lightbox-gallery="gallery-'.$post->ID.'">';
        $output .= '<img alt="'.$caption.'" src="'.$image_src[0].'" />';
    }
    $caption = ($caption != '') ? '<h5><span>' . $caption . '</span></h5>' : '';
    $output .= '<div class="overlay" style="background-color:' . $overlay_color .';">'.$caption.'<i class="icon-plus"></i></div>';
    $output .= '</a>';
    if ($caption != '') {
        $output .= '<div class="image-title"><span>'. $caption .'</span><i class="icon-next pull-right"></i></div>';
    }
    $output .= '</div>';

    return $output;
}

add_shortcode('ttbase_gallery_item', 'ttbase_framework_gallery_item_shortcode');
?>