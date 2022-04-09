<?php
add_filter( 'rwmb_meta_boxes', function( $meta_boxes )
{
	/* ----------------------------------------------------- */
	// Classes Metaboxes
	/* ----------------------------------------------------- */
	if ( post_type_exists( 'classes' ) && get_theme_mod('gymx_classes_enabled', 'yes') != 'no' ) {
		$meta_boxes[] = array(
			'id'		=> 'class_settings',
			'title' 	=> esc_html__('Class Settings','ttbase-framework'),
			'pages' 	=> array( 'classes' ),
			'context'	=> 'normal',
			'priority'	=> 'high',
		
			// List of meta fields
			'fields' => array(
				array(
					'name'	=> esc_html__( 'Trainers', 'ttbase-framework' ),
					'desc'	=> esc_html__( 'Add all trainers for this class', 'ttbase-framework' ),
					'id'	=> 'gymx_post_class_trainers',
					'type'	=> 'post',
					'post_type' => 'trainers',
					'field_type' => 'select_advanced',
					'multiple' => true
				),
				array(
					'name'		=> esc_html__( 'Timetable Box Background Color', 'ttbase-framework' ),
					'id'		=>  "gymx_post_class_tt_background_color",
					'type'		=> 'color',
					'desc'		=> esc_html__( 'Set background color for this class in the timetable', 'ttbase-framework' ),
				),
				array(
					'name'		=> esc_html__( 'Timetable Box Class Name Color', 'ttbase-framework' ),
					'id'		=>  "gymx_post_class_tt_title_color",
					'type'		=> 'color',
					'desc'		=> esc_html__( 'Set  color for this class name in the timetable', 'ttbase-framework' ),
				),
				array(
					'name'		=> esc_html__( 'Timetable Box Text Color', 'ttbase-framework' ),
					'id'		=>  "gymx_post_class_tt_text_color",
					'type'		=> 'color',
					'desc'		=> esc_html__( 'Set text color for this class in the timetable', 'ttbase-framework' ),
				)
				
			)
		);
	}
	
	/* ----------------------------------------------------- */
	// Team Metaboxes
	/* ----------------------------------------------------- */
	if ( post_type_exists( 'trainers' ) ) {
		$meta_boxes[] = array(
			'id'		=> 'trainersettings',
			'title' 	=> esc_html__( 'Trainer Settings', 'ttbase-framework' ),
			'pages' 	=> array( 'trainers' ),
			'context'	=> 'normal',
			'priority'	=> 'high',
		
			// List of meta fields
			'fields' => array(
				array(
					'name'	=> esc_html__( 'Position', 'ttbase-framework' ),
					'desc'	=> esc_html__( 'Enter the job position of the team member', 'ttbase-framework' ),
					'id'	=> 'gymx_post_trainer-position',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'Twitter Profile', 'ttbase-framework' ),
					'desc'	=> esc_html__( 'Enter your twitter profile url', 'ttbase-framework' ),
					'id'	=> 'gymx_post_trainer-twitter',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'Facebook Profile', 'ttbase-framework' ),
					'desc'	=> esc_html__( 'Enter your facebook profile url', 'ttbase-framework' ),
					'id'	=> 'gymx_post_trainer-facebook',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'Google+ Profile', 'ttbase-framework' ),
					'desc'	=> esc_html__( 'Enter your google plus profile url', 'ttbase-framework' ),
					'id'	=> 'gymx_post_trainer-googleplus',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'Instagram Profile', 'ttbase-framework' ),
					'desc'	=> esc_html__( 'Enter your instagram profile url', 'ttbase-framework' ),
					'id'	=> 'gymx_post_trainer-instagram',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'LinkedIn Profile', 'ttbase-framework' ),
					'desc'	=> esc_html__( 'Enter your linkedin profile url', 'ttbase-framework' ),
					'id'	=> 'gymx_post_trainer-linkedin',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'Dribbble Profile', 'ttbase-framework' ),
					'desc'	=> esc_html__( 'Enter your dribbble profile url', 'ttbase-framework' ),
					'id'	=> 'gymx_post_trainer-dribbble',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'Skype Profile', 'ttbase-framework' ),
					'desc'	=> esc_html__( 'Enter your skype profile url', 'ttbase-framework' ),
					'id'	=> 'gymx_post_trainer-skype',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'Phone Number', 'ttbase-framework' ),
					'desc'	=> esc_html__( 'Enter your phone number', 'ttbase-framework' ),
					'id'	=> 'gymx_post_trainer-phone',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'E-Mail', 'ttbase-framework' ),
					'desc'	=> esc_html__( 'Enter your mail', 'ttbase-framework' ),
					'id'	=> 'gymx_post_trainer-mail',
					'type'	=> 'text'
				)
			)
		);
	}
	
	return $meta_boxes;
} );