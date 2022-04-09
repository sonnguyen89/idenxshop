<?php

function gymx_vc_set_as_theme() {
	vc_set_as_theme();
}
add_action( 'vc_before_init', 'gymx_vc_set_as_theme' );

/**
 * Disable Gutenberg when VC is active
 * Just check the "Disable Gutenberg" option
 */
function disable_gutenberg() {
	global $wp_version;

	if ( ! get_option( 'wpb_js_gutenberg_disable' ) && ! get_option( 'gymx_check_for_vc_gutenberg_disable_option' ) ) {
		update_option( 'wpb_js_gutenberg_disable', true );
	}

	update_option( 'gymx_check_for_vc_gutenberg_disable_option', true );
}

add_action( 'vc_before_init', 'disable_gutenberg' );

/**
 * Removes "About" page in the Visual Composer
 */
function gymx_remove_welcome() {
    remove_submenu_page( 'vc-general', 'vc-welcome' );
}

//Use Visual Composer for pages and service post type
if (function_exists("vc_set_default_editor_post_types")) {
	vc_set_default_editor_post_types(array(
			"page",
			"classes",
			"events",
			"trainers"
		));
}

/**
 * Redirect page template if vc_row shortcode is found in the page.
 */
if(!( function_exists('gymx_vc_page_template') )){
	function gymx_vc_page_template( $template ){
		global $post;
		
		if( gymx_is_blog_page() || is_404() || is_page_template( 'templates/template-sidebar-left.php' ) || is_page_template( 'templates/template-sidebar-right.php' ) )
			return $template;
		
		if( $post->post_type == 'classes' || $post->post_type == 'trainers')
			return $template;
			
		if(!( isset($post->post_content) ) || is_search())
			return $template;
			
		if( has_shortcode($post->post_content, 'vc_row') ){
			$new_template = locate_template( array( 'page-visual-composer.php' ) );
			if (!( '' == $new_template )){
				return $new_template;
			}
		}
		return $template;
	}
	add_filter( 'template_include', 'gymx_vc_page_template', 99 );
}

if ( ! function_exists( 'gymx_bg_image_overlay' ) ) {

	function gymx_bg_image_overlay( $atts ) {

		// Extract attributes
		extract( $atts );

		// Return if a video is defined
		if ( $bg_type != 'image' || empty( $bg_image ) || $image_bg_overlay == 'none' ) {
			return;
		}

		// Image overlay
		if ( 'color' != $image_bg_overlay ) { ?>
			<span class="ttbase-bg-overlay <?php echo sanitize_html_class($image_bg_overlay); ?>"></span>
		<?php } else { ?>
			<span class="ttbase-bg-overlay" style="background-color:<?php echo esc_attr($image_bg_overlay_color); ?>"></span>
		<?php } ?>

	<?php
	}

}

//Video Output for vc_row
if ( ! function_exists( 'gymx_row_video' ) ) {
	function gymx_row_video( $atts ) {

		// Extract attributes
		extract( $atts );

		// Return if video_bg is empty
		if ( $bg_type != 'video' || 'self-hosted' != $video_bg ) {
			return;
		}

		// Make sure videos are defined
		if ( ! $video_bg_webm && ! $video_bg_ogv && ! $video_bg_mp4 ) {
			return;
		}

		// Get background image
		$bg_image = ! empty( $bg_image ) ? $bg_image : '';

		// Check sound
		$sound = apply_filters( 'gymx_self_hosted_row_video_sound', false );
		$sound = $sound ? '' : 'muted volume="0"'; ?>

		<div class="ttbase-video-bg-wrap">
			<video class="ttbase-video-bg" poster="<?php echo esc_url($bg_image); ?>" preload="auto" autoplay="true" loop="loop" <?php echo esc_attr($sound); ?>>
				<?php if ( $video_bg_webm ) { ?>
					<source src="<?php echo esc_url($video_bg_webm); ?>" type="video/webm" />
				<?php } ?>
				<?php if ( $video_bg_ogv ) { ?>
					<source src="<?php echo esc_url($video_bg_ogv); ?>" type="video/ogg ogv" />
				<?php } ?>
				<?php if ( $video_bg_mp4 ) { ?>
					<source src="<?php echo esc_url($video_bg_mp4); ?>" type="video/mp4" />
				<?php } ?>
			</video>
		</div>

		<?php
		// Video overlay
		if ( ! empty( $video_bg_overlay ) && 'none' != $video_bg_overlay ) { ?>
			
			<?php if ( 'color' != $video_bg_overlay ) { ?>
				<span class="ttbase-bg-overlay ttbase-bg-video-overlay <?php echo sanitize_html_class($video_bg_overlay); ?>"></span>
			<?php } else { ?>
				<span class="ttbase-bg-overlay ttbase-bg-video-overlay" style="background-color:<?php echo esc_attr($video_bg_overlay_color); ?>"></span>
			<?php } ?>
		<?php } ?>

	<?php
	}
}

// Remove VC Teaser Metabox
if ( ! function_exists('gymx_vc_remove_teaserbox') ) {
	function gymx_vc_remove_teaserbox(){
		$post_types = get_post_types( '', 'names' ); 
		foreach ( $post_types as $post_type ) {
			remove_meta_box('vc_teaser',  $post_type, 'side');
		}
	}
}
add_action('do_meta_boxes', 'gymx_vc_remove_teaserbox');

if ( ! function_exists('gymx_update_params') ) {
	function gymx_update_params(){
		
		// Only needed on front-end
		if ( ! is_admin() ) return;
		
		// Set ID weight
		$param = WPBMap::getParam( 'vc_row', 'el_id' );
		if ( $param ) {
			$param['weight'] = 99;
			$param['description'] = esc_html__('Enter row id, so you can use it as an anchor link for one page layouts with a smooth scrolling effect. (Note: make sure it is unique and valid according to w3c specification).', 'gymx' );
			vc_update_shortcode_param( 'vc_row', $param );
		}
		
		// Set ID weight
		$param = WPBMap::getParam( 'vc_row', 'full-width' );
		if ( $param ) {
			$param['weight'] = 95;
			vc_update_shortcode_param( 'vc_row', $param );
		}
			
		// Move parallax
		$param = WPBMap::getParam( 'vc_row', 'parallax' );
		if ( $param ) {
			$param['group'] = esc_html__( 'Background', 'gymx' );
			$param['dependency'] = array(
				'element' => 'bg_image',
				'not_empty' => true,
			);
			vc_update_shortcode_param( 'vc_row', $param );
		}
		
		// Move video parallax setting
		$param = WPBMap::getParam( 'vc_row', 'video_bg_parallax' );
		if ( $param ) {
			$param['group'] = esc_html__( 'Background', 'gymx' );
			$param['dependency'] = array(
				'element' => 'video_bg',
				'value' => 'youtube',
			);
			vc_update_shortcode_param( 'vc_row', $param );
		}

		// Move youtube url
		$param = WPBMap::getParam( 'vc_row', 'video_bg_url' );
		if ( $param ) {
			$param['group'] = esc_html__( 'Background', 'gymx' );
			$param['dependency'] = array(
				'element' => 'video_bg',
				'value' => 'youtube',
			);
			vc_update_shortcode_param( 'vc_row', $param );
		}
	}
}

add_action( 'vc_after_init', 'gymx_update_params' );

/* ------------------------------------------------------------------------ */
/* Edit VC Row
/* ------------------------------------------------------------------------ */
vc_remove_param("vc_row", "parallax_image");
vc_remove_param("vc_row", "bg_color");
vc_remove_param("vc_row", "bg_image");
vc_remove_param("vc_row", "css");


vc_add_param("vc_row", array(
	'type' => 'textfield',
	'heading' => esc_html__( 'Minimum Height', 'gymx' ),
	'description' => esc_html__( 'Add a minimum height for this row. So you can show a video or image background at a certain height without any content.', 'gymx' ),
	'param_name' => 'min_height',
	'weight' => 90
));

vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => esc_html__( 'Padding Top', 'gymx' ),
	"value" => "",
	"param_name" => "top_padding",
	"description" => esc_html__( 'Add your top padding without px. For example: 40', 'gymx' ),
	'weight' => 85
));

vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => esc_html__( 'Padding Bottom', 'gymx' ),
	"value" => "",
	"param_name" => "bottom_padding",
	"description" => esc_html__( 'Add your bottom padding without px. For example: 40', 'gymx' ),
	'weight' => 80
));

vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => esc_html__('Bottom Border', 'gymx'),
	"value" => array(
		esc_html__('Enable Bottom Border for this row', 'gymx') => "false" 
	),
	"param_name" => "bottom_border",
	"description" => "",
	"group"	=> esc_html__( 'Background', 'gymx' ),
));

vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => esc_html__( 'Bottom Border Color', 'gymx' ),
	"param_name" => "border_color",
	"value" => "",
	"description" => "",
	"dependency" => array('element' => "bottom_border", 'not_empty' => true ),
	"group"	=> esc_html__( 'Background', 'gymx' ),
));


vc_add_param("vc_row", array(
	"type" 						=> "dropdown",
	"show_settings_on_create" 	=> true,
	"heading" 					=> esc_html__( 'Background Type', 'gymx' ),
	"param_name" 				=> "bg_type",
	"value" 					=> array(
		esc_html__( 'None', 'gymx' ) 		=> "",
		esc_html__( 'Color', 'gymx' ) 	=> "color",
		esc_html__( 'Image', 'gymx' ) 	=> "image",
		esc_html__( 'Video', 'gymx' ) 	=> "video",
	),
	"group"	=> esc_html__( 'Background', 'gymx' ),
	'weight' => 10
)); 

//Color
vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => esc_html__( 'Background Color', 'gymx' ),
	"param_name" => "bg_color",
	"value" => "",
	"description" => "",
	"dependency" => array('element' => "bg_type", 'value' => array('color')),
	"group"	=> esc_html__( 'Background', 'gymx' ),
	'weight' => 9
));

//Image
vc_add_param("vc_row", array(
	"type" => "attach_image",
	"class" => "",
	"heading" => esc_html__( 'Background Image', 'gymx' ),
	"param_name" => "bg_image",
	"value" => "",
	"description" => "",
	"dependency" => array('element' => "bg_type", 'value' => array('image')),
	"group"	=> esc_html__( 'Background', 'gymx' ),
	'weight' => 9
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => esc_html__( 'Background Repeat', 'gymx' ),
	"param_name" => "bg_repeat",
	"value" => array(
		esc_html__( 'No Repeat', 'gymx' ) 		=> "no-repeat",
		esc_html__( 'Repeat', 'gymx' ) 	=> "repeat",
		esc_html__( 'Stretch', 'gymx' ) 	=> "stretch"
	),
	"dependency" => Array('element' => "bg_image", 'not_empty' => true),
	"group"	=> esc_html__( 'Background', 'gymx' ),
));

vc_add_param("vc_row", array(
	'type' => 'dropdown',
	'heading' => esc_html__( 'Image Overlay', 'gymx' ),
	'param_name' => 'image_bg_overlay',
	'value' => array(
		esc_html__( 'None', 'gymx' ) => 'none',
		esc_html__( 'Dark', 'gymx' ) => 'dark',
		esc_html__( 'Dotted', 'gymx' ) => 'dotted',
		esc_html__( 'Diagonal Lines', 'gymx' ) => 'dashed',
		esc_html__( 'Custom Color', 'gymx' ) => 'color',
	),
	"dependency" => array('element' => "bg_image", 'not_empty' => true ),
	"group"	=> esc_html__( 'Background', 'gymx' ),
));

vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => esc_html__( 'Overlay Color', 'gymx' ),
	"param_name" => "image_bg_overlay_color",
	"value" => "",
	"description" => "",
	"dependency" => array('element' => "image_bg_overlay", 'value' => array('color')),
	"group"	=> esc_html__( 'Background', 'gymx' ),
));

//Video
vc_add_param("vc_row", array(
	"type" 						=> "dropdown",
	"show_settings_on_create" 	=> true,
	"heading" 					=> esc_html__( 'Video Background?', 'gymx' ),
	"param_name" 				=> "video_bg",
	"value" 					=> array(
		esc_html__( 'None', 'gymx' ) 		=> "",
		esc_html__( 'Youtube Video', 'gymx' ) 		=> "youtube",
		esc_html__( 'Self Hosted Video', 'gymx' ) 	=> "self-hosted",
	),
	"dependency" 				=> array('element' => "bg_type", 'value' => array('video')),
	"group"	=> esc_html__( 'Background', 'gymx' ),
	'weight' => 9
)); 

vc_add_param("vc_row", array(
	"type" 						=> "textfield",
	"heading" 					=> esc_html__( 'WebM File URL', 'gymx' ),
	"value" 					=> "",
	"param_name" 				=> "video_bg_webm",
	"description" 				=> esc_html__( 'You must include this format & the mp4 format to render your video with cross browser compatibility, OGV is optional.
Video must be in a 16:9 aspect ratio', 'gymx' ),
	"dependency" 				=> array('element' => "video_bg", 'value' => array('self-hosted')),
	"group"	=> esc_html__( 'Background', 'gymx' ),
));

vc_add_param("vc_row", array(
	"type" 						=> "textfield",
	"heading" 					=> esc_html__( 'MP4 File URL', 'gymx' ),
	"value" 					=> "",
	"param_name" 				=> "video_bg_mp4",
	"description" 				=> esc_html__( 'Enter the URL for your mp4 video file here', 'gymx' ),
	"dependency" 				=> array('element' => "video_bg", 'value' => array('self-hosted')),
	"group"					=> esc_html__( 'Background', 'gymx' ),
));

vc_add_param("vc_row", array(
	"type" 						=> "textfield",
	"heading" 					=> esc_html__( 'OGV File URL', 'gymx' ),
	"value" 					=> "",
	"param_name" 				=> "video_bg_ogv",
	"description" 				=> esc_html__( 'Enter the URL for your ogv video file here', 'gymx' ),
	"dependency" 				=> array('element' => "video_bg", 'value' => array('self-hosted')),
	"group"	=> esc_html__( 'Background', 'gymx' ),
));

vc_add_param("vc_row", array(
	'type' => 'dropdown',
	'heading' => esc_html__( 'Video Overlay', 'gymx' ),
	'param_name' => 'video_bg_overlay',
	'value' => array(
		esc_html__( 'None', 'gymx' ) => 'none',
		esc_html__( 'Dark', 'gymx' ) => 'dark',
		esc_html__( 'Dotted', 'gymx' ) => 'dotted',
		esc_html__( 'Diagonal Lines', 'gymx' ) => 'dashed',
		esc_html__( 'Custom Color', 'gymx' ) => 'color',
	),
	"dependency" => array('element' => "video_bg", 'value' => array('self-hosted')),
	"group"	=> esc_html__( 'Background', 'gymx' ),
));

vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => esc_html__( 'Overlay Color', 'gymx' ),
	"param_name" => "video_bg_overlay_color",
	"value" => "",
	"description" => "",
	"dependency" => array('element' => "video_bg_overlay", 'value' => array('color')),
	"group"	=> esc_html__( 'Background', 'gymx' ),
));
// vc_add_param("vc_row", array(
// 	'type' => 'dropdown',
// 	'heading' => esc_html__( 'CSS Animation', 'gymx' ),
// 	"description" => esc_html__( 'Add animation when row comes in visible area.', 'gymx' ),
// 	'param_name' => 'css_animation',
// 	'value' => array(
// 		esc_html__( 'No', 'gymx' )  			=> '',
// 		esc_html__( 'From Bottom', 'gymx' )    => 'has-animation from-bottom',
// 		esc_html__( 'From Top', 'gymx' )   	=> 'has-animation from-top',
// 		esc_html__( 'From Left', 'gymx' )    	=> 'has-animation from-left',
// 		esc_html__( 'From Right', 'gymx' )    	=> 'has-animation from-right',
// 		esc_html__( 'Fade In', 'gymx' )    	=> 'has-animation fade',
// 	),
// 	"group"	=> esc_html__( 'Animation', 'gymx' ),
// ));

/*-----------------------------------------------------------------------------------*/
/* Edit VC Pie
/*-----------------------------------------------------------------------------------*/
vc_remove_param("vc_pie", "color");

vc_add_param("vc_pie", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => esc_html__( 'Color', 'gymx' ),
	"param_name" => "color",
	"value" => "",
	"description" => ""
));

vc_add_param("vc_pie", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => esc_html__( 'Background Color', 'gymx' ),
	"param_name" => "background_color",
	"value" => "",
	"description" => "",
));

/*-----------------------------------------------------------------------------------*/
/* Edit VC Tabs
/*-----------------------------------------------------------------------------------*/
vc_remove_param("vc_tta_tabs", "title");
vc_remove_param("vc_tta_tabs", "style");
vc_remove_param("vc_tta_tabs", "shape");
vc_remove_param("vc_tta_tabs", "no_fill_content_area");
vc_remove_param("vc_tta_tabs", "color");
vc_remove_param("vc_tta_tabs", "pagination_color");
vc_remove_param("vc_tta_tabs", "spacing");
vc_remove_param("vc_tta_tabs", "gap");
//vc_remove_param("vc_tta_tabs", "tab_position");
vc_remove_param("vc_tta_tabs", "pagination_style");

/*-----------------------------------------------------------------------------------*/
/* Edit VC Accordion
/*-----------------------------------------------------------------------------------*/
vc_remove_param("vc_tta_accordion", "title");
//vc_remove_param("vc_tta_accordion", "style");
vc_remove_param("vc_tta_accordion", "shape");
vc_remove_param("vc_tta_accordion", "no_fill");
vc_remove_param("vc_tta_accordion", "color");
vc_remove_param("vc_tta_accordion", "spacing");
vc_remove_param("vc_tta_accordion", "gap");

/*-----------------------------------------------------------------------------------*/
/* Edit VC Contact Form 7
/*-----------------------------------------------------------------------------------*/
if(gymx_contact_form_7_installed()){
	vc_add_param("contact-form-7", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => esc_html__( 'Style', 'gymx' ),
		"param_name" => "html_class",
		"value" => array(
			esc_html__("Style 1",'gymx')		=> "wpcf7-style-1",
			esc_html__("Style 2",'gymx')		=> "wpcf7-style-2",
			esc_html__("Style 3",'gymx')		=> "wpcf7-style-3"
		),
		'save_always' => true,
		"description" => esc_html__( 'You can change each style in the Customizer > Contact Form 7', 'gymx' ),
	));
}