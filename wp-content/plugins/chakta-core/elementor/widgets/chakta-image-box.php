<?php

namespace Elementor;

class Chakta_Image_Box_Widget extends Widget_Base {

    public function get_name() {
        return 'chakta-image-box';
    }
    public function get_title() {
        return 'Image Box (K)';
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

		$defaultimage = plugins_url( 'images/image-box.jpg', __DIR__ );
		
		$this->add_control( 'box_type',
			[
				'label' => esc_html__( 'Box Type', 'chakta-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'type1',
				'options' => [
					'select-column' => esc_html__( 'Select Type', 'chakta-core' ),
					'type1'	  => esc_html__( 'Type 1', 'chakta-core' ),
					'type2'	  => esc_html__( 'Type 2', 'chakta-core' ),
				],
			]
		);
		
        $this->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'chakta-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => $defaultimage],
            ]
        );
		
        $this->add_control( 'title',
            [
                'label' => esc_html__( 'Title', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Modern Auto Wheel Up To 25% Offer',
                'description'=> 'Add a title.',
				'label_block' => true,
            ]
        );
		
        $this->add_control( 'subtitle',
            [
                'label' => esc_html__( 'Subtitle', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => '25% big offer',
                'description'=> 'Add a subtitle.',
				'label_block' => true,
            ]
        );
		
        $this->add_control( 'btn_title',
            [
                'label' => esc_html__( 'Button Title', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Shop Now',
                'pleaceholder' => esc_html__( 'Enter button title here', 'chakta-core' )
            ]
        );
		
        $this->add_control( 'btn_link',
            [
                'label' => esc_html__( 'Button Link', 'chakta-core' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => esc_html__( 'Place URL here', 'chakta-core' )
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
		
		$this->add_control( 'image_box_background_color',
           [
               'label' => esc_html__( 'Background Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .klb-image-box-two.service-item' => 'background-color: {{VALUE}};'],
			   'condition' => ['box_type' => ['type2']]
           ]
        );
		
		$this->add_control( 'icon_bg',
			[
				'label' => esc_html__( 'Icon Color', 'chakta-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Core\Schemes\Color::get_type(),
					'value' =>Core\Schemes\Color::COLOR_1,
				],
				'default' => '#ff4545',
				'selectors' => [
					'{{WRAPPER}} .klb-image-box-two.service-item .icon' => 'background-color: {{value}};',
				],
			]
		);
		
		$this->add_responsive_control( 'home_slider_alignment',
            [
                'label' => esc_html__( 'Alignment', 'chakta' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} .offer-content , {{WRAPPER}} .klb-image-box-two.service-item' => 'text-align: {{VALUE}} !important;'],
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
               'selectors' => ['{{WRAPPER}} .offer-content h3 , {{WRAPPER}} .klb-image-box-two.service-item h5' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'title_hvrcolor',
           [
               'label' => esc_html__( 'Title Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .offer-content h3:hover , {{WRAPPER}} .klb-image-box-two.service-item h5:hover ' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .offer-content h3 , {{WRAPPER}} .klb-image-box-two.service-item h5 ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .offer-content h3 , {{WRAPPER}} .klb-image-box-two.service-item h5 ',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .offer-content h3 , {{WRAPPER}} .klb-image-box-two.service-item h5',
				
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
               'selectors' => ['{{WRAPPER}} .offer-content span.span , {{WRAPPER}} .klb-image-box-two.service-item p' => 'color: {{VALUE}};'],
           ]
        );
		
		$this->add_control( 'subtitle_hvrcolor',
           [
               'label' => esc_html__( 'Subtitle Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .offer-content span.span:hover , {{WRAPPER}} .klb-image-box-two.service-item p:hover ' => 'color: {{VALUE}};'],
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
                'selectors' => ['{{WRAPPER}} .offer-content span.span , {{WRAPPER}} .klb-image-box-two.service-item p' => 'opacity: {{VALUE}};'],
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'subtitle_text_shadow',
				'selector' => '{{WRAPPER}} .offer-content span.span , {{WRAPPER}} .klb-image-box-two.service-item p',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .offer-content span.span , {{WRAPPER}} .klb-image-box-two.service-item p',
            ]
        );
		
        $this->end_controls_section();
     	
		/*****   END CONTROLS SECTION   ******/
		
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('btn_styling',
            [
                'label' => esc_html__( ' Button Style', 'chakta' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
		
		$this->add_responsive_control( 'btn_padding',
            [
                'label' => esc_html__( 'Padding', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .offer-content .main-btn , {{WRAPPER}} .klb-image-box-two.service-item a.main-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],              
            ]
        );
  	    
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .offer-content .main-btn , {{WRAPPER}} .klb-image-box-two.service-item a.main-btn'
            ]
        );
		
		$this->add_control( 'btn_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'chakta-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .offer-content .main-btn , {{WRAPPER}} .klb-image-box-two.service-item a.main-btn' => 'opacity: {{VALUE}} ;'],
            ]
        );

		$this->start_controls_tabs('btn_tabs');
        $this->start_controls_tab( 'btn_normal_tab',
            [ 'label' => esc_html__( 'Normal', 'chakta' ) ]
        );
		
		$this->add_control( 'btn_color',
            [
                'label' => esc_html__( 'Color', 'chakta' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .offer-content .main-btn , {{WRAPPER}} .klb-image-box-two.service-item a.main-btn' => 'color: {{VALUE}};']
            ]
        );
       
	    $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'label' => esc_html__( 'Border', 'chakta' ),
                'selector' => '{{WRAPPER}} .offer-content .main-btn , {{WRAPPER}} .klb-image-box-two.service-item a.main-btn',
            ]
        );
        
		$this->add_responsive_control( 'btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .offer-content .main-btn , {{WRAPPER}} .klb-image-box-two.service-item a.main-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
       
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'label' => esc_html__( 'Background', 'chakta' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .offer-content .main-btn , {{WRAPPER}} .klb-image-box-two.service-item a.main-btn',
            ]
        );
       
		$this->end_controls_tab(); //btn_normal_tab
		
        $this->start_controls_tab('btn_hover_tab',
            [ 'label' => esc_html__( 'Hover', 'chakta' ) ]
        );
       
	    $this->add_control( 'btn_hvrcolor',
            [
                'label' => esc_html__( 'Color', 'chakta' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .offer-content .main-btn:hover , {{WRAPPER}} .klb-image-box-two.service-item a.main-btn:hover ' => 'color: {{VALUE}};']
            ]
        );
		
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_hvr_border',
                'label' => esc_html__( 'Border', 'chakta' ),
                'selector' => '{{WRAPPER}} .offer-content .main-btn:hover , {{WRAPPER}} .klb-image-box-two.service-item a.main-btn:hover ',
            ]
        );
        
		$this->add_responsive_control( 'btn_hvr_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .offer-content .main-btn:hover , {{WRAPPER}} .klb-image-box-two.service-item a.main-btn:hover ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
		
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_hvr_background',
                'label' => esc_html__( 'Background', 'chakta' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .offer-content .main-btn:hover , {{WRAPPER}} .klb-image-box-two.service-item a.main-btn:hover ',
            ]
        );
		
		$this->end_controls_tab(); //btn_hover_tab
		
        $this->end_controls_tabs(); //btn_tabs
		
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$target = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
		
		$output = '';
		
		if($settings['box_type'] == 'type2'){
			echo '<div class="klb-image-box-two service-item">';
			echo '<div class="icon">';
			echo '<img src="'.esc_url($settings['image']['url']).'" alt="">';
			echo '</div>';
			echo '<h5>'.esc_html($settings['title']).'</h5>';
			echo '<p>'.esc_html($settings['subtitle']).'</p>';
			if($settings['btn_title'] || $settings['btn_link']['url']){
			echo '<a href="'.esc_url($settings['btn_link']['url']).'" '.esc_attr($target.$nofollow).' class="main-btn">'.esc_html($settings['btn_title']).'</a>';
			}
			echo '</div>';
		} else {
			echo '<div class="klb-image-box offer-item bg_cover" style="background-image: url('.esc_url($settings['image']['url']).');">';
			echo '<div class="offer-content">';
			echo '<span class="span">'.esc_html($settings['subtitle']).'</span>';
			echo '<h3><a href="'.esc_url($settings['btn_link']['url']).'">'.esc_html($settings['title']).'</a></h3>';
			if($settings['btn_title'] || $settings['btn_link']['url']){
			echo '<a href="'.esc_url($settings['btn_link']['url']).'" '.esc_attr($target.$nofollow).' class="main-btn">'.esc_html($settings['btn_title']).'</a>';
			}
			echo '</div>';
			echo '</div>';
		}
	}

}
