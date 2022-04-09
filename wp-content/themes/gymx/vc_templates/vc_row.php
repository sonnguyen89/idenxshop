<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $equal_height
 * @var $columns_placement
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $parallax_speed_bg
 * @var $parallax_speed_video
 * @var $content - shortcode content
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 */
$el_class = $full_height = $parallax_speed_bg = $parallax_speed_video = $full_width = $equal_height = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = '';
$disable_element = '';
$output = $after_output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'wpb_composer_front_js' );

$el_class = $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );

$css_classes = array(
	'vc_row',
	'wpb_row', //deprecated
	'vc_row-fluid',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

if ( 'yes' === $disable_element ) {
	if ( vc_is_page_editable() ) {
		$css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
	} else {
		return '';
	}
}

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') ) || $video_bg || $parallax) {
	$css_classes[]='vc_row-has-fill';
}

if (!empty($atts['gap'])) {
	$css_classes[] = 'vc_column-gap-'.$atts['gap'];
}

$wrapper_attributes = array();
$has_video_bg = false;

// build attributes for wrapper
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

if ( ! empty( $full_width ) ) {
	$wrapper_attributes[] = 'data-vc-full-width="true"';
	$wrapper_attributes[] = 'data-vc-full-width-init="false"';
	if ( 'stretch_row_content' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
	} elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
		$css_classes[] = 'vc_row-no-padding';
	}
	$after_output .= '<div class="vc_row-full-width vc_clearfix"></div>';
}

if ( ! empty( $full_height ) ) {
	$css_classes[] = 'vc_row-o-full-height';
	if ( ! empty( $columns_placement ) ) {
		$flex_row = true;
		$css_classes[] = 'vc_row-o-columns-' . $columns_placement;
		if ( 'stretch' === $columns_placement ) {
			$css_classes[] = 'vc_row-o-equal-height';
		}
	}
}

if ( ! empty( $equal_height ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-equal-height';
}

if ( ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = 'vc_row-flex';
}

// Use default video if user checked video, but didn't chose url
if ( 'youtube' == $video_bg && $bg_type == 'video' ) {
	if ( ! empty( $video_bg ) && empty( $video_bg_url ) ) {
		$video_bg_url = 'https://www.youtube.com/watch?v=lMJXxhRFO1k';
	} elseif ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && function_exists( 'vc_extract_youtube_id' ) ) {
		$has_video_bg = vc_extract_youtube_id( $video_bg_url );
	}
}

if ( $has_video_bg ) {
	$parallax = $video_bg_parallax;
	$parallax_image = $video_bg_url;
	$css_classes[] = ' vc_video-bg-container';
	wp_enqueue_script( 'vc_youtube_iframe_api_js' );
}

if ( ! empty( $parallax ) ) {
	wp_enqueue_script( 'vc_jquery_skrollr_js' );
	$wrapper_attributes[] = 'data-vc-parallax="1.5"'; // parallax speed
	$css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
	if ( strpos( $parallax, 'fade' ) !== false ) {
		$css_classes[] = 'js-vc_parallax-o-fade';
		$wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
	} elseif ( strpos( $parallax, 'fixed' ) !== false ) {
		$css_classes[] = 'js-vc_parallax-o-fixed';
	}
}

if ( ! empty ( $bg_image ) && ! empty ( $parallax ) ) {
	if ( $has_video_bg ) {
		$parallax_image_src = $bg_image;
	} else {
		$parallax_image_id = preg_replace( '/[^\d]/', '', $bg_image );
		$parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
		if ( ! empty( $parallax_image_src[0] ) ) {
			$parallax_image_src = $parallax_image_src[0];
		}
	}
	$wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image_src ) . '"';
}
if ( ! $parallax && $has_video_bg ) {
	$wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
}

if ( ! empty ( $video_bg ) || ! empty ( $bg_image ) ) {
	$css_classes[] = 'ttbase-relative';
}

/* Inline Styles */

// Generate inline CSS
$inline_style = '';
	
// Min Height
if ( $min_height ) {
	$inline_style .= 'min-height:'. $min_height .'; ';
}

//Padding
if($top_padding != ''){
	$inline_style .= 'padding-top: '. $top_padding .'px; ';
}
if($bottom_padding != ''){
	$inline_style .= 'padding-bottom: '. $bottom_padding .'px; ';
}

//Bottom Border
if( $bottom_border && ! empty( $border_color ) ){
	$inline_style .= 'border-bottom: solid 1px '. $border_color .'; ';
}

//Background Color
if ( $bg_type == 'color' && ! empty ( $bg_color ) ) {
	$inline_style .= 'background-color:' . $bg_color . '; ';
}

// Background Image
if( $bg_type == 'image' && ! empty ( $bg_image ) ) {
	$css_classes[] = "ttbase-row-image";
	
	if ( ! $parallax ) {
		if(!preg_match('/^\d+$/',$bg_image)){
			$inline_style .= 'background-image: url('. $bg_image . '); ';
	
		} else {
			$bg_image_src = wp_get_attachment_image_src($bg_image, 'full');
			$inline_style .= 'background-image: url('. $bg_image_src[0]. '); ';
			//$style .= 'background-position: '. $bg_position .'; ';
		}
	}
	

	//bg repeat
	if($bg_repeat == 'repeat'){
		$inline_style .= 'background-repeat: '. $bg_repeat .'; ';
	} else if($bg_repeat == 'stretch'){
		$css_classes[] = 'bg-stretch';
	}
}


// Add inline style to wrapper attributes
if ( $inline_style ) {
	$wrapper_attributes[] = ' style="'. $inline_style .'"';
}

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

//Row Output ?>
<div <?php echo implode( ' ', $wrapper_attributes ); ?>>

<?php echo wpb_js_remove_wpautop( $content ); ?>

<?php gymx_bg_image_overlay( $atts ); ?>

<?php gymx_row_video( $atts ); ?>

</div>
<?php
if ( ! empty( $full_width ) ) { ?>
    <div class="vc_row-full-width vc_clearfix"></div>
<?php } ?>