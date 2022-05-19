<?php

/*************************************************
## chakta Metabox
*************************************************/

if ( ! function_exists( 'rwmb_meta' ) ) {
  function rwmb_meta( $key, $args = '', $post_id = null ) {
   return false;
  }
 }

add_filter( 'rwmb_meta_boxes', 'chakta_register_page_meta_boxes' );

function chakta_register_page_meta_boxes( $meta_boxes ) {
	
$prefix = 'klb_';
$meta_boxes = array();


/* ----------------------------------------------------- */
// Blog Post Slides Metabox
/* ----------------------------------------------------- */

$meta_boxes[] = array(
	'id'		=> 'klb-blogmeta-gallery',
	'title'		=> esc_html__('Blog Post Image Slides','chakta'),
	'pages'		=> array( 'post' ),
	'context' => 'normal',

	'fields'	=> array(
		array(
			'name'	=> esc_html__('Blog Post Slider Images','chakta'),
			'desc'	=> esc_html__('Upload unlimited images for a slideshow - or only one to display a single image.','chakta'),
			'id'	=> $prefix . 'blogitemslides',
			'type'	=> 'image_advanced',
		)
		
	)
);

/* ----------------------------------------------------- */
// Blog Audio Post Settings
/* ----------------------------------------------------- */
$meta_boxes[] = array(
	'id' => 'klb-blogmeta-audio',
	'title' => esc_html('Audio Settings','chakta'),
	'pages' => array( 'post'),
	'context' => 'normal',

	// List of meta fields
	'fields' => array(	
		array(
			'name'		=> esc_html('Audio Code','chakta'),
			'id'		=> $prefix . 'blogaudiourl',
			'desc'		=> esc_html__('Enter your Audio URL(Oembed) or Embed Code.','chakta'),
			'clone'		=> false,
			'type'		=> 'textarea',
			'std'		=> '',
			'sanitize_callback' => 'none'
		),
	)
);



/* ----------------------------------------------------- */
// Blog Video Metabox
/* ----------------------------------------------------- */
$meta_boxes[] = array(
	'id'		=> 'klb-blogmeta-video',
	'title'		=> esc_html__('Blog Video Settings','chakta'),
	'pages'		=> array( 'post' ),
	'context' => 'normal',

	'fields'	=> array(
		array(
			'name'		=> esc_html__('Video Type','chakta'),
			'id'		=> $prefix . 'blog_video_type',
			'type'		=> 'select',
			'options'	=> array(
				'youtube'		=> esc_html__('Youtube','chakta'),
				'vimeo'			=> esc_html__('Vimeo','chakta'),
				'own'			=> esc_html__('Own Embed Code','chakta'),
			),
			'multiple'	=> false,
			'std'		=> array( 'no' ),
			'sanitize_callback' => 'none'
		),
		array(
			'name'	=> chakta_sanitize_data(__('Embed Code<br />(Audio Embed Code is possible, too)','chakta')),
			'id'	=> $prefix . 'blog_video_embed',
			'desc'	=> chakta_sanitize_data(__('Just paste the ID of the video (E.g. http://www.youtube.com/watch?v=<strong>GUEZCxBcM78</strong>) you want to show, or insert own Embed Code. <br />This will show the Video <strong>INSTEAD</strong> of the Image Slider.<br /><strong>Of course you can also insert your Audio Embedd Code!</strong>','chakta')),
			'type' 	=> 'textarea',
			'std' 	=> "",
			'cols' 	=> "40",
			'rows' 	=> "8"
		)
	)
);
 

/* ----------------------------------------------------- */
// Products Vehicle Data
/* ----------------------------------------------------- */
if(taxonomy_exists('klb_make')){
	$meta_boxes[] = array(
		'id'		=> 'klb-vehicle-data',
		'title'		=> esc_html__('Vehicle Data','chakta'),
		'pages'		=> array( 'product' ),
		'context' => 'normal',

		'fields'	=> array(
			array(
				'name'			=> esc_html__('Make','chakta'),
				'id'			=> $prefix . 'make_type',
				'type'			=> 'select_advanced',
				'placeholder' 	=> esc_html__('Select Make','chakta'),
				'options'		=> chakta_get_makes(),
				'multiple'		=> true,
			),
			
			array(
				'name'			=> esc_html__('Model','chakta'),
				'id'			=> $prefix . 'model_type',
				'type'			=> 'select_advanced',
				'placeholder' 	=> esc_html__('Select Model','chakta'),
				'options' 		=> 	chakta_get_models(),
				'multiple'		=> true,
			),
			
			array(
				'name'    => esc_html__('Year','chakta'),
				'id'      => $prefix . 'year',
				'type'			=> 'select_advanced',
				'options' 		=> 	chakta_get_years(),
				'placeholder' 	=> esc_html__('Year','chakta'),
				'multiple'		=> true,
			),
			
			array(
				'name'    => esc_html__('Body Style','chakta'),
				'id'      => $prefix . 'body_style',
				'type'    => 'text',
				'placeholder' 	=> esc_html__('Body Style','chakta'),
			),
			
			array(
				'name'    => esc_html__('Color','chakta'),
				'id'      => $prefix . 'color',
				'type'    => 'text',
				'placeholder' 	=> esc_html__('Color','chakta'),
			),
			
			array(
				'name'    => esc_html__('Transmission','chakta'),
				'id'      => $prefix . 'transmission',
				'type'    => 'text',
				'placeholder' 	=> esc_html__('Transmission','chakta'),
			),


		)
	);
}

return $meta_boxes;
}
