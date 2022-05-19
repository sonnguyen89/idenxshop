<?php

namespace Elementor;

class Chakta_Client_Carousel_Widget extends Widget_Base {

    public function get_name() {
        return 'chakta-client-carousel';
    }
    public function get_title() {
        return 'Client Carousel (K)';
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

		$customimg = plugins_url( 'images/client.png', __DIR__ );
		$repeater = new Repeater();

        $repeater->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'chakta-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => $customimg],
            ]
        );
		
        $repeater->add_control( 'btn_link',
            [
                'label' => esc_html__( 'Button Link', 'chakta-core' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => esc_html__( 'Place URL here', 'chakta-core' )
            ]
        );

        $this->add_control( 'carousel_items',
            [
                'label' => esc_html__( 'Image Items', 'chakta-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'image' => ['url' => $customimg],
                        'btn_link' => '#',
                    ],
                    [
                        'image' => ['url' => $customimg],
                        'btn_link' => '#',
                    ],
                    [
                        'image' => ['url' => $customimg],
                        'btn_link' => '#',
                    ],
                    [
                        'image' => ['url' => $customimg],
                        'btn_link' => '#',
                    ],
                    [
                        'image' => ['url' => $customimg],
                        'btn_link' => '#',
                    ],
                    [
                        'image' => ['url' => $customimg],
                        'btn_link' => '#',
                    ],
                    [
                        'image' => ['url' => $customimg],
                        'btn_link' => '#',
                    ],



					
                ]
            ]
        );
		
		$this->end_controls_section();
		
		/*****   END CONTROLS SECTION   ******/
		
        /*****   START CONTROLS SECTION   ******/
		
		$this->start_controls_section('chakta_styling',
            [
                'label' => esc_html__( ' Image', 'chakta' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
		
		$this->add_control( 'carousel_background_color',
           [
               'label' => esc_html__( 'Background Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .sponsor-area' => 'background-color: {{VALUE}} !important ;']
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
				'selector' => '{{WRAPPER}} .sponsor-slide .slick-slide img',
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
                        'max' => 250
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sponsor-slide .slick-slide img' => 'height: {{SIZE}}{{UNIT}}',
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
                        'max' => 250
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}  .sponsor-slide .slick-slide img' => 'width: {{SIZE}}{{UNIT}}',
                ]
            ]
        );
		$this->end_controls_section();


	}

	protected function render() {
		$settings = $this->get_settings_for_display();

			echo '<div class="sponsor-area red-bg pt-60 pb-60">';
			echo '<div class="container">';
			echo '<div class="row sponsor-slide">';
			
			if ( $settings['carousel_items'] ) {
				foreach ( $settings['carousel_items'] as $item ) {
					$target = $item['btn_link']['is_external'] ? ' target="_blank"' : '';
					$nofollow = $item['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
					echo '<div class="col-lg-2 sponsor-item">';
					echo '<a href="'.esc_url($item['btn_link']['url']).'" '.esc_attr($target.$nofollow).'><img src="'.$item['image']['url'].'" class="img-fluid" alt="item"></a>';
					echo '</div>';
				}
			}
			echo '</div>';
			echo '</div>';
			echo '</div>';
		
	}

}
