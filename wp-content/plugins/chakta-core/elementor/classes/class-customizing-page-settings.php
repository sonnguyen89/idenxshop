<?php

function chakta_add_elementor_page_settings_controls( $page ) {

	$page->add_control( 'chakta_elementor_hide_page_header',
		[
			'label'          => esc_html__( 'Hide Header', 'chakta-core' ),
            'type'           => \Elementor\Controls_Manager::SWITCHER,
			'label_on'       => esc_html__( 'Yes', 'chakta-core' ),
			'label_off'      => esc_html__( 'No', 'chakta-core' ),
			'return_value'   => 'yes',
			'default'        => 'no',
		]
	);
	
	$page->add_control( 'chakta_elementor_page_header_type',
		[
			'label' => esc_html__( 'Header Type', 'chakta-core' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				'' => esc_html__( 'Select a type', 'chakta-core' ),
				'type1' 	  => esc_html__( 'Type 1', 'chakta-core' ),
				'type2'		  => esc_html__( 'Type 2', 'chakta-core' ),
				'type3'		  => esc_html__( 'Type 3', 'chakta-core' ),
			],
		]
	);

	$page->add_control( 'chakta_elementor_hide_page_footer',
		[
			'label'          => esc_html__( 'Hide Footer', 'chakta-core' ),
			'type'           => \Elementor\Controls_Manager::SWITCHER,
			'label_on'       => esc_html__( 'Yes', 'chakta-core' ),
			'label_off'      => esc_html__( 'No', 'chakta-core' ),
			'return_value'   => 'yes',
			'default'        => 'no',
		]
	);

	
	$page->add_control(
		'page_width',
		[
			'label' => __( 'Width', 'chakta-core' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'devices' => [ 'desktop' ],
			'size_units' => [ 'px'],
			'range' => [
				'px' => [
					'min' => 1100,
					'max' => 1650,
					'step' => 5,
				],
			],
			'default' => [
				'unit' => 'px',
				'size' => 1200,
			],
			'selectors' => [
				'{{WRAPPER}} .container' => 'max-width: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .elementor-section.elementor-section-boxed>.elementor-container' => 'max-width: {{SIZE}}{{UNIT}};',
			],
			

			
		]
	);

}

add_action( 'elementor/element/wp-page/document_settings/before_section_end', 'chakta_add_elementor_page_settings_controls' );