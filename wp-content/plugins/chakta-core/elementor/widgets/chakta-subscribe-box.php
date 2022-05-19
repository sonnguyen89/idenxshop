<?php

namespace Elementor;

class Chakta_Subscribe_Box_Widget extends Widget_Base {

    public function get_name() {
        return 'chakta-subscribe-box';
    }
    public function get_title() {
        return 'Subscribe Box (K)';
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
		
		$defaultimage = plugins_url( 'images/newsletter-bg.jpg', __DIR__ );
		
        $this->add_control( 'image',
            [
                'label' => esc_html__( 'Background Image', 'chakta-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => $defaultimage],
            ]
        );
		
        $this->add_control( 'title',
            [
                'label' => esc_html__( 'Title', 'chakta-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Every Update Subscribe Our Newsleters',
                'pleaceholder' => esc_html__( 'Set a title.', 'chakta-core' )
            ]
        );

        $this->add_control( 'subtitle',
            [
                'label' => esc_html__( 'Subtitle', 'chakta-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'newsletter subscribe',
                'pleaceholder' => esc_html__( 'Set a subtitle.', 'chakta-core' )
            ]
        );

        $this->add_control( 'subscribe_form_id',
            [
                'label' => esc_html__( 'Subscribe Form Id', 'chakta-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '60',
                'description' => esc_html__( 'You can find the form id in Dashboard > Mailchimp For Wp > Form', 'chakta-core' )
            ]
        );
		
		$this->end_controls_section();
		
		/*****   END CONTROLS SECTION   ******/
		
        /*****   START CONTROLS SECTION   ******/
		
		$this->start_controls_section('title_styling',
            [
                'label' => esc_html__( 'Style', 'chakta' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
		
		$this->add_responsive_control( 'home_slider_alignment',
            [
                'label' => esc_html__( 'Alignment', 'chakta' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} .newsletter-content , {{WRAPPER}} .klb-image-box-two.service-item' => 'text-align: {{VALUE}} !important;'],
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'chakta' ),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'chakta' ),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'chakta' ),
                        'icon' => 'eicon-text-align-right'
                    ]
                ],
                'toggle' => true,
                
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
               'selectors' => ['{{WRAPPER}} .newsletter-content h2 ' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'title_hvrcolor',
           [
               'label' => esc_html__( 'Title Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .newsletter-content h2:hover ' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_responsive_control( 'title_left',
            [
                'label' => esc_html__( 'Left', 'cosmetsy' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000
                    ],
                    'vh' => [
                        'min' => -50,
                        'max' => 50
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .newsletter-content h2' => 'margin-left: {{SIZE}}{{UNIT}}',
                ]
            ]
        );
		
		$this->add_responsive_control( 'title_top',
            [
                'label' => esc_html__( 'Top', 'cosmetsy' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    ' {{WRAPPER}} .newsletter-content h2 ' => 'margin-top: {{SIZE}}{{UNIT}}',
                ]
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
                'selectors' => ['{{WRAPPER}} .newsletter-content h2  ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .newsletter-content h2  ',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .newsletter-content h2 ',
				
            ]
        );
		
		$this->add_control( 'subtitle_heading',
            [
                'label' => esc_html__( 'SUBTITLE', 'chakta' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before',
            ]
        );
		
		$this->add_control( 'subtitle_color',
           [
               'label' => esc_html__( 'Subtitle Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .newsletter-content span.span ' => 'color: {{VALUE}};'],
           ]
        );
		
		$this->add_control( 'subtitle_hvrcolor',
           [
               'label' => esc_html__( 'Subtitle Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .newsletter-content span.span:hover ' => 'color: {{VALUE}};'],
           ]
        );
		
		$this->add_responsive_control( 'subtitle_left',
            [
                'label' => esc_html__( 'Left', 'cosmetsy' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000
                    ],
                    'vh' => [
                        'min' => -50,
                        'max' => 50
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .newsletter-content span.span' => 'margin-left: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
		
		$this->add_responsive_control( 'subtitle_top',
            [
                'label' => esc_html__( 'Top', 'cosmetsy' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .newsletter-content span.span' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
		
		$this->add_control( 'subtitle_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'chakta-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .newsletter-content span.span' => 'opacity: {{VALUE}};'],
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'subtitle_text_shadow',
				'selector' => '{{WRAPPER}} .newsletter-content span.span',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .newsletter-content span.span',
            ]
        );

		
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
	
		echo '<section class="newsletter-section bg_cover pt-75 pb-80" style="background-image: url('.$settings['image']['url'].')">';
		echo '<div class="container">';
		echo '<div class="row justify-content-center">';
		echo '<div class="col-lg-8">';
		echo '<div class="newsletter-content text-center">';
		echo '<span class="span">'.esc_html($settings['subtitle']).'</span>';
		echo '<h2>'.esc_html($settings['title']).'</h2>';
		echo do_shortcode('[mc4wp_form id="'.$settings['subscribe_form_id'].'"]');
		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '</section>';

	}

}
