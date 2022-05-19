<?php

namespace Elementor;

class Chakta_Image_Carousel_Widget extends Widget_Base {

    public function get_name() {
        return 'chakta-image-carousel';
    }
    public function get_title() {
        return 'Image Carousel (K)';
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
		
		$custombg = plugins_url( 'images/company-bg.jpg', __DIR__ );
        $this->add_control( 'bg_image',
            [
                'label' => esc_html__( 'Background Image', 'chakta-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => $custombg],
            ]
        );

		$customimg = plugins_url( 'images/bmw.png', __DIR__ );
		$repeater = new Repeater();

        $repeater->add_control( 'title',
            [
                'label' => esc_html__( 'Title', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'BMW',
                'description'=> 'Add a title.',
				'label_block' => true,
            ]
        );

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
                'title_field' => '{{title}}',
                'default' => [
                    [
                        'image' => ['url' => $customimg],
                        'btn_link' => '#',
                        'title' => 'BMW',
                    ],
                    [
                        'image' => ['url' => $customimg],
                        'btn_link' => '#',
                        'title' => 'Volvo',
                    ],
                    [
                        'image' => ['url' => $customimg],
                        'btn_link' => '#',
                        'title' => 'Nissan',
                    ],
                    [
                        'image' => ['url' => $customimg],
                        'btn_link' => '#',
                        'title' => 'Yamaha',
                    ],
                    [
                        'image' => ['url' => $customimg],
                        'btn_link' => '#',
                        'title' => 'Opel',
                    ],
                    [
                        'image' => ['url' => $customimg],
                        'btn_link' => '#',
                        'title' => 'BMW',
                    ],
                    [
                        'image' => ['url' => $customimg],
                        'btn_link' => '#',
                        'title' => 'BMW',
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
				'selector' => '{{WRAPPER}} .company-item img',
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
                    '{{WRAPPER}} .company-item img' => 'height: {{SIZE}}{{UNIT}}',
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
                    '{{WRAPPER}}  .company-item img' => 'width: {{SIZE}}{{UNIT}}',
                ]
            ]
        );
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .company-item img',
				
			]
		);
		
		$this->add_responsive_control( 'image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .company-item img ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
		
        $this->end_controls_section();
     	
		/*****   END CONTROLS SECTION   ******/
		
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('title_styling',
            [
                'label' => esc_html__( ' Title Style', 'chakta' ),
                'tab' => Controls_Manager::TAB_STYLE
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
               'selectors' => ['{{WRAPPER}} .company-item h5' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'title_hvrcolor',
           [
               'label' => esc_html__( 'Title Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .company-item h5:hover' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .company-item h5 ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .company-item h5',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .company-item h5',
				
            ]
        );

        $this->end_controls_section();
     	
		/*****   END CONTROLS SECTION   ******/
		
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('chakta_nav_styling',
            [
                'label' => esc_html__( ' Nav Style', 'chakta' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
       
	    $this->start_controls_tabs( 'slider_nav_tabs');
        $this->start_controls_tab( 'slider_nav_normal_tab',
            [ 'label'  => esc_html__( 'Normal', 'chakta' ) ]
        );
        
		$this->add_control( 'nav_clr',
           [
               'label' => esc_html__( 'Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .company-slide .slick-arrow' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'nav_background',
                'label' => esc_html__( 'Background', 'chakta' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .company-slide .slick-arrow',
            ]
        );
		
		$this->add_control( 'nav_size',
            [
                'label' => esc_html__( ' Size', 'bacola' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .company-slide .slick-arrow ' => 'height: {{SIZE}}px;' ],
            ]
        );
		
		$this->add_control( 'home_slider_prev_heading',
            [
                'label' => __( 'PREV POSITION', 'chakta' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
       
	   $this->add_responsive_control( 'home_slider_prev_horizontal',
            [
                'label' => esc_html__( 'Horizontal Position ( % )', 'chakta' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .company-slide .slick-arrow.prev' => 'left:{{SIZE}}%;' ],
            ]
        );
       
	   $this->add_responsive_control( 'home_slider_prev_vertical',
            [
                'label' => esc_html__( 'Vertical Position ( % )', 'chakta' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .company-slide .slick-arrow.prev' => 'top:{{SIZE}}%;' ],
            ]
        );
        
		$this->add_control( 'home_slider_next_heading',
            [
                'label' => __( 'NEXT POSITION', 'chakta' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
		$this->add_responsive_control( 'home_slider_next_horizontal',
            [
                'label' => esc_html__( 'Horizontal Position ( % )', 'chakta' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .company-slide .slick-arrow.next' => 'left:{{SIZE}}%;' ],
            ]
        );
        
		$this->add_responsive_control( 'home_slider_next_vertical',
            [
                'label' => esc_html__( 'Vertical Position ( % )', 'chakta' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .company-slide .slick-arrow.next' => 'top:{{SIZE}}%;' ],
            ]
        );
       
	    $this->end_controls_tab(); //slider_nav_normal_tab
		
        $this->start_controls_tab( 'slider_nav_hover_tab',
            [ 'label' => esc_html__( 'Hover', 'chakta' ) ]
        );
       
	    $this->add_control( 'nav_hvrclr',
            [
               'label' => esc_html__( 'Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => [
                   '{{WRAPPER}} .company-slide .slick-arrow:hover' => 'color: {{VALUE}};'
               ]
            ]
        );
       
	    $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'nav_hvr_background',
                'label' => esc_html__( 'Background', 'chakta' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .company-slide .slick-arrow:hover ',
            ]
        );
		
		$this->end_controls_tab(); //slider_nav_hover_tab
		
        $this->end_controls_tabs(); //slider_nav_tabs
		
		$this->end_controls_section();


	}

	protected function render() {
		$settings = $this->get_settings_for_display();

			echo '<section class="company-section bg_cover pt-60 pb-55" style="background-image: url('.esc_url($settings['bg_image']['url']).');">';
			echo '<div class="container">';
			echo '<div class="row company-slide">';
			if ( $settings['carousel_items'] ) {
				foreach ( $settings['carousel_items'] as $item ) {
					$target = $item['btn_link']['is_external'] ? ' target="_blank"' : '';
					$nofollow = $item['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
					echo '<div class="col-lg-2">';
					echo '<div class="company-item text-center">';
					echo '<a href="'.esc_url($item['btn_link']['url']).'" '.esc_attr($target.$nofollow).'><img src="'.esc_url($item['image']['url']).'" alt="item"></a>';
					echo '<h5>'.esc_html($item['title']).'</h5>';
					echo '</div>';
					echo '</div>';
				}
			}
			echo '</div>';
			echo '</div>';
			echo '</section>';
		
	}

}
