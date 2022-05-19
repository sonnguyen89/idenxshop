<?php

namespace Elementor;

class Chakta_Testimonial_Widget extends Widget_Base {

    public function get_name() {
        return 'chakta-testimonial';
    }
    public function get_title() {
        return 'Testimonial (K)';
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
				'label' => esc_html__( 'Content', 'chakta-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		
		$customimg = plugins_url( 'images/testimonial.jpg', __DIR__ );
		$repeater = new Repeater();
		
        $repeater->add_control( 'customer_image',
            [
                'label' => esc_html__( 'Image', 'chakta-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => $customimg],
            ]
        );
		
        $repeater->add_control( 'customer_name',
            [
                'label' => esc_html__( 'Name', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
				'label_block' => true,
                'pleaceholder' => esc_html__( 'Enter the name here', 'chakta-core' ),
                'default' => 'Add some text here',
            ]
        );
		
        $repeater->add_control( 'customer_position',
            [
                'label' => esc_html__( 'Position', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
				'label_block' => true,
                'pleaceholder' => esc_html__( 'Enter the customer job.', 'chakta-core' ),
                'default' => 'Add some text here',
            ]
        );
		
        $repeater->add_control( 'customer_comment',
            [
                'label' => esc_html__( 'Comment', 'chakta-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'pleaceholder' => esc_html__( 'Enter desc here', 'chakta-core' ),
                'default' => 'Add some text here',
            ]
        );

        $this->add_control( 'testimonial_items',
            [
                'label' => esc_html__( 'Testimonial Items', 'chakta-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'customer_name' => 'David Warner',
                        'customer_position' => 'Business Manager',
                        'customer_comment' => 'Sed ut perspiciatis unde omnis istese us error sit voluptatem accusa oloque laudantium totam aperiam eaqupsa quae ab illo inventore veritatis quasc architecto beatae vitae dicta suntey plicabo enim ipsam volupt',
                        'customer_image' => ['url' => $customimg],
                    ],
                    [
                        'customer_name' => 'Oliver Greenwood',
                        'customer_position' => 'Computer Engineer',
                        'customer_comment' => 'Sed ut perspiciatis unde omnis istese us error sit voluptatem accusa oloque laudantium totam aperiam eaqupsa quae ab illo inventore veritatis quasc architecto beatae vitae dicta suntey plicabo enim ipsam volupt',
                        'customer_image' => ['url' => $customimg],
                    ],
                    [
                        'customer_name' => 'Daisy Lana',
                        'customer_position' => 'Web Designer',
                        'customer_comment' => 'Sed ut perspiciatis unde omnis istese us error sit voluptatem accusa oloque laudantium totam aperiam eaqupsa quae ab illo inventore veritatis quasc architecto beatae vitae dicta suntey plicabo enim ipsam volupt',
                        'customer_image' => ['url' => $customimg],
                    ],
                    [
                        'customer_name' => 'Alden Smith',
                        'customer_position' => 'Designer',
                        'customer_comment' => 'Sed ut perspiciatis unde omnis istese us error sit voluptatem accusa oloque laudantium totam aperiam eaqupsa quae ab illo inventore veritatis quasc architecto beatae vitae dicta suntey plicabo enim ipsam volupt',
                        'customer_image' => ['url' => $customimg],
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
		
		$this->add_control( 'image_heading',
            [
                'label' => esc_html__( 'IMAGE', 'chakta' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .testimonial-thumb-title .thumb img',
			]
		);
		
		$this->add_responsive_control( 'image_text_height',
            [
                'label' => esc_html__( 'Height', 'chakta' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}  .testimonial-thumb-title .thumb img' => 'height: {{SIZE}}{{UNIT}}',
                ]
            ]
        );
		
		$this->add_responsive_control( 'image_text_width',
            [
                'label' => esc_html__( 'Width', 'chakta' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-thumb-title .thumb img' => 'width: {{SIZE}}{{UNIT}}',
                ]
            ]
        );
		
		$this->add_responsive_control( 'image_left',
            [
                'label' => esc_html__( 'Left', 'chakta' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 20
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-thumb-title .thumb img' => 'margin-left: {{SIZE}}{{UNIT}}',
                ]
            ]
        );
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .testimonial-thumb-title .thumb img',
				
			]
		);
		
		$this->add_responsive_control( 'image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .testimonial-thumb-title .thumb img ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
		
		$this->add_control( 'name_heading',
            [
                'label' => esc_html__( 'NAME', 'chakta' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'name_color',
           [
               'label' => esc_html__( 'Name Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .testimonial-thumb-title .title h5' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'name_hvrcolor',
           [
               'label' => esc_html__( 'Name Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .testimonial-thumb-title .title h5:hover' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_responsive_control( 'name_left',
            [
                'label' => esc_html__( 'Left', 'chakta' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100
                    ],
                    'vh' => [
                        'min' => -50,
                        'max' => 50
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-thumb-title .title h5' => 'margin-left: {{SIZE}}{{UNIT}}',
                ]
            ]
        );
		
		$this->add_control( 'name_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'chakta-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .testimonial-thumb-title .title h5' => 'opacity: {{VALUE}} ;'],
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'name_text_shadow',
				'selector' => '{{WRAPPER}} .testimonial-thumb-title .title h5',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .testimonial-thumb-title .title h5'
            ]
        );
		
		$this->add_control( 'position_heading',
            [
                'label' => esc_html__( 'POSITION', 'chakta' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'position_color',
           [
               'label' => esc_html__( 'Position Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .testimonial-thumb-title .title span' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'position_hvrcolor',
           [
               'label' => esc_html__( 'Position Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .testimonial-thumb-title .title span:hover' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_responsive_control( 'position_left',
            [
                'label' => esc_html__( 'Left', 'chakta' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100
                    ],
                    'vh' => [
                        'min' => -50,
                        'max' => 50
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-thumb-title .title span' => 'margin-left: {{SIZE}}{{UNIT}}',
                ]
            ]
        );
		
		$this->add_control( 'position_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'chakta-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .testimonial-thumb-title .title span' => 'opacity: {{VALUE}} ;'],
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'position_text_shadow',
				'selector' => '{{WRAPPER}} .testimonial-thumb-title .title span',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'position_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .testimonial-thumb-title .title span'
            ]
        );
		
		$this->add_control( 'comment_heading',
            [
                'label' => esc_html__( 'COMMENT', 'chakta' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'comment_background_color',
           [
               'label' => esc_html__( 'Background Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .testimonial-content' => 'background-color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'comment_color',
           [
               'label' => esc_html__( 'Comment Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .testimonial-content p' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'comment_hvrcolor',
           [
               'label' => esc_html__( 'Comment Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .testimonial-content p:hover' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'comment_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'chakta-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .testimonial-content p' => 'opacity: {{VALUE}} ;'],
            ]
        );
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'comment_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .testimonial-content p'
            ]
        );

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		

		echo '<section class="testimonial-area-v2">';
		echo '<div class="container">';
		echo '<div class="row testimonial-slide-two">';
		
		if ( $settings['testimonial_items'] ) {
			foreach ( $settings['testimonial_items'] as $item ) {
				echo '<div class="col-lg-4">';
				echo '<div class="testimonial-item">';
				echo '<div class="testimonial-thumb-title">';
				echo '<div class="thumb">';
				echo '<img src="'.esc_url($item['customer_image']['url']).'" alt="testimonial">';
				echo '</div>';
				echo '<div class="title">';
				echo '<h5>'.esc_html($item['customer_name']).'</h5>';
				echo '<span>'.esc_html($item['customer_position']).'</span>';
				echo '</div>';
				echo '</div>';
				echo '<div class="testimonial-content">';
				echo '<p>'.esc_html($item['customer_comment']).'</p>';
				echo '<ul class="rating">';
				echo '<li class="star"><i class="fas fa-star"></i></li>';
				echo '<li class="star"><i class="fas fa-star"></i></li>';
				echo '<li class="star"><i class="fas fa-star"></i></li>';
				echo '<li class="star"><i class="fas fa-star"></i></li>';
				echo '<li class="star"><i class="fas fa-star"></i></li>';
				echo '</ul>';
				echo '<i class="far fa-quote-right quote-icon"></i>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}
		}
		echo '</div>';
		echo '</div>';
		echo '</section>';
		
	}

}
