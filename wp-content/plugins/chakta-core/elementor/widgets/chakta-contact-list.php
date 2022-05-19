<?php

namespace Elementor;

class Chakta_Contact_List_Widget extends Widget_Base {

    public function get_name() {
        return 'chakta-contact-list';
    }
    public function get_title() {
        return 'Contact List (K)';
    }
    public function get_icon() {
        return 'eicon-slider-push';
    }
    public function get_categories() {
        return [ 'chakta' ];
    }

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'plugin-name' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
       $this->add_control( 'title',
            [
                'label' => esc_html__( 'Title', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'pleaceholder' => esc_html__( 'Enter title here', 'chakta-core' ),
                'default' => 'Contact Us',
            ]
        );
       $this->add_control( 'subtitle',
            [
                'label' => esc_html__( 'Subtitle', 'chakta-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'pleaceholder' => esc_html__( 'Enter subtitle here', 'chakta-core' ),
                'default' => 'Sed ut perspiciatis unde omnis natus error',
            ]
        );
		
		$repeater = new Repeater();
		
		$repeater->add_control(
			'switcher_icon',
			[
				'label' => esc_html__( 'Use Custom Icon', 'chakta-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'chakta-core' ),
				'label_off' => esc_html__( 'No', 'chakta-core' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
		
		$repeater->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'chakta-core' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fab fa-facebook-f',
					'library' => 'fa-brands',
				],
                'label_block' => true,
				'condition' => ['switcher_icon' => '']
			]
		);
		
        $repeater->add_control( 'custom_icon',
            [
                'label' => esc_html__( 'Custom Icon', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'far fa-map-marked-alt',
                'description'=> 'You can add icon code. for example: far fa-check-circle',
				'condition' => ['switcher_icon' => 'yes']
            ]
        );

       $repeater->add_control( 'item_title',
            [
                'label' => esc_html__( 'Title', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'pleaceholder' => esc_html__( 'Enter title here', 'chakta-core' ),
                'default' => 'Our MIssion & Vision',
            ]
        );
       $repeater->add_control( 'item_desc',
            [
                'label' => esc_html__( 'Description', 'chakta-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'pleaceholder' => esc_html__( 'Enter desc here', 'chakta-core' ),
                'default' => 'Quis autem vel eum iure reprehenderit quin voluptate velit esse quam nihil molestiae consequatur vel illum qui dolorem eum',
            ]
        );
		
        $this->add_control( 'block_items',
            [
                'label' => esc_html__( 'Block Items', 'chakta-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_title' => 'Main Address',
						'custom_icon' => 'far fa-map-marked-alt',
						'item_desc' => '205 Main Street, 5th Floor D - Block, New York',
                    ],
                    [
                        'item_title' => 'Email Address',
						'custom_icon' => 'far fa-envelope-open-text',
						'item_desc' => 'support@gmail.com',
                    ],
                    [
                        'item_title' => 'Phone number',
						'custom_icon' => 'far fa-phone',
						'item_desc' => '+012 (345) 78967',
                    ],

                ]
            ]
        );
		
		$this->end_controls_section();
		
		/*****   END CONTROLS SECTION   ******/
		
        /*****   START CONTROLS SECTION   ******/
		
		$this->start_controls_section('chakta_styling',
            [
                'label' => esc_html__( 'Style', 'chakta' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
		
		$this->add_control( 'icon_heading',
            [
                'label' => esc_html__( 'ICON', 'chakta' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'icon_bg_color',
           [
               'label' => esc_html__( 'Icon Background Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .contact-info-list .list-item i' => 'background-color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'icon_color',
           [
               'label' => esc_html__( 'Icon Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .contact-info-list .list-item i' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'chakta' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .contact-info-list .list-item i' => 'font-size: {{SIZE}}px;' ],
            ]
        );
		
		$this->add_control( 'title_heading',
            [
                'label' => esc_html__( 'TITLE', 'chakta' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'title_color',
           [
               'label' => esc_html__( 'Title Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .contact-info-list .list-item h5' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'title_hvrcolor',
           [
               'label' => esc_html__( 'Title Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .contact-info-list .list-item h5:hover' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'title_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'chakta-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .contact-info-list .list-item h5 ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .contact-info-list .list-item h5',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .contact-info-list .list-item h5',
				
            ]
        );
		
		$this->add_control( 'desc_heading',
            [
                'label' => esc_html__( 'Description', 'chakta' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before',
            ]
        );
		
		$this->add_control( 'desc_color',
           [
               'label' => esc_html__( 'Description Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .contact-info-list .list-item p' => 'color: {{VALUE}};'],
           ]
        );
		
		$this->add_control( 'desc_hvrcolor',
           [
               'label' => esc_html__( 'Description Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .contact-info-list .list-item p:hover' => 'color: {{VALUE}};'],
           ]
        );
		
		$this->add_control( 'desc_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'chakta-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .contact-info-list .list-item p' => 'opacity: {{VALUE}};'],
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'desc_text_shadow',
				'selector' => '{{WRAPPER}} .contact-info-list .list-item p',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .contact-info-list .list-item p',
            ]
        );

		
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$output = '';
		
		if ( $settings['block_items'] ) {

			echo '<div class="contact-info-list">';
			foreach ( $settings['block_items'] as $item ) {
				
				echo '<div class="list-item mb-30">';
				if($item['switcher_icon'] == 'yes'){
					echo '<i class="'.esc_attr($item['custom_icon']).'"></i>';
				} else {
					Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'false' ] );						
				}
				echo '<h5>'.esc_html($item['item_title']).'</h5>';
				echo '<p>'.chakta_sanitize_data($item['item_desc']).'</p>';
				echo '</div>';
				
			}
			echo '</div>';
			
		}
		
	}

}
