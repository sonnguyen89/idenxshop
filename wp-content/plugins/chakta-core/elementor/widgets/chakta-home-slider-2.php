<?php

namespace Elementor;

class Chakta_Home_Slider_2_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'chakta-home-slider-2';
    }
    public function get_title() {
        return 'Home Slider 2 (K)';
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

		$defaultbg = plugins_url( 'images/hero-2.jpg', __DIR__ );
		
        $this->add_control( 'slider_bg',
            [
                'label' => esc_html__( 'Image', 'medibazar' ),
                'type' => Controls_Manager::MEDIA,
				'default' => ['url' => $defaultbg],
            ]
        );
		
		$repeater = new Repeater();
        $repeater->add_control( 'item_title',
            [
                'label' => esc_html__( 'Item Title', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '25% Off For Auto Car Services',
                'pleaceholder' => esc_html__( 'Enter item title here.', 'chakta-core' )
            ]
        );
		
        $repeater->add_control( 'item_subtitle',
            [
                'label' => esc_html__( 'Item Subtitle', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'great offer for every auto & cars',
                'pleaceholder' => esc_html__( 'Enter item subtitle here.', 'chakta-core' )
            ]
        );
		
        $repeater->add_control( 'item_desc',
            [
                'label' => esc_html__( 'Item Desc', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Sed ut perspiciatis unde omnis iste natus error voluptatem accusantium remque laudantium totam aperiam eaque ipsa quae abillo inventore veritatis',
                'pleaceholder' => esc_html__( 'Enter item description here.', 'chakta-core' )
            ]
        );
		
        $repeater->add_control( 'slider_btn_title',
            [
                'label' => esc_html__( 'Button Title', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Shop Now',
                'pleaceholder' => esc_html__( 'Enter button title here', 'chakta-core' )
            ]
        );
        $repeater->add_control( 'slider_btn_link',
            [
                'label' => esc_html__( 'Button Link', 'chakta-core' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => esc_html__( 'Place URL here', 'chakta-core' )
            ]
        );
		
        $repeater->add_control( 'slider_btn_title_second',
            [
                'label' => esc_html__( 'Second Button Title', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Read More',
                'pleaceholder' => esc_html__( 'Enter button title here', 'chakta-core' )
            ]
        );
        $repeater->add_control( 'slider_btn_link_second',
            [
                'label' => esc_html__( 'Second Button Link', 'chakta-core' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => esc_html__( 'Place URL here', 'chakta-core' )
            ]
        );


        $this->add_control( 'slider_items',
            [
                'label' => esc_html__( 'Slide Items', 'chakta-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_title' => '25% Off For Auto Car Services',
                        'item_subtitle' => 'great offer for every auto & cars',
                        'item_desc' => 'Sed ut perspiciatis unde omnis iste natus error voluptatem accusantium remque laudantium totam aperiam eaque ipsa quae abillo inventore veritatis',
                        'slider_btn_title' => 'Shop Now',
                        'slider_btn_link' => '#',
                        'slider_btn_title_second' => 'Read More',
                        'slider_btn_link_second' => '#',
                    ],
					
                    [
                        'item_title' => '35% Off For Auto Parts Services',
                        'item_subtitle' => 'great offer for every auto & cars',
                        'item_desc' => 'Sed ut perspiciatis unde omnis iste natus error voluptatem accusantium remque laudantium totam aperiam eaque ipsa quae abillo inventore veritatis',
                        'slider_btn_title' => 'Shop Now',
                        'slider_btn_link' => '#',
                        'slider_btn_title_second' => 'Read More',
                        'slider_btn_link_second' => '#',
                    ],

                ]
            ]
        );

		$this->add_control(
			'disable_search_filter',
			[
				'label' => esc_html__('Disable Search Filter', 'chakta-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'chakta-core' ),
				'label_off' => esc_html__( 'No', 'chakta-core' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
		
		$searchtbg = plugins_url( 'images/filter-bg.png', __DIR__ );
        $this->add_control( 'search_filter_bg',
            [
                'label' => esc_html__( 'Search Filter Bg', 'medibazar' ),
                'type' => Controls_Manager::MEDIA,
				'default' => ['url' => $searchtbg],
            ]
        );
		
        $this->add_control( 'search_filter_title',
            [
                'label' => esc_html__( 'Search Filter Title', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Over 2500 Cars. Find Your Auto Parts',
                'pleaceholder' => esc_html__( 'Enter search filter title here.', 'chakta-core' )
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
		
		$this->add_responsive_control( 'home_slider_alignment',
            [
                'label' => esc_html__( 'Alignment', 'chakta' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} .hero-contnt-slide ' => 'text-align: {{VALUE}} !important;'],
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
               'selectors' => ['{{WRAPPER}} .hero-area-v1 .hero-content h1' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'title_hvrcolor',
           [
               'label' => esc_html__( 'Title Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .hero-area-v1 .hero-content h1:hover' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .hero-area-v1 .hero-content h1 ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .hero-area-v1 .hero-content h1',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .hero-area-v1 .hero-content h1',
				
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
               'selectors' => ['{{WRAPPER}} .hero-area-v1 .hero-content span.span' => 'color: {{VALUE}};'],
           ]
        );
		
		$this->add_control( 'subtitle_hvrcolor',
           [
               'label' => esc_html__( 'Subtitle Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .hero-area-v1 .hero-content span.span:hover' => 'color: {{VALUE}};'],
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
                'selectors' => ['{{WRAPPER}} .hero-area-v1 .hero-content span.span' => 'opacity: {{VALUE}};'],
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'subtitle_text_shadow',
				'selector' => '{{WRAPPER}} .hero-area-v1 .hero-content span.span',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .hero-area-v1 .hero-content span.span',
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
               'selectors' => ['{{WRAPPER}} .hero-area-v1 .hero-content p' => 'color: {{VALUE}};'],
           ]
        );
		
		$this->add_control( 'desc_hvrcolor',
           [
               'label' => esc_html__( 'Description Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .hero-area-v1 .hero-content p:hover' => 'color: {{VALUE}};'],
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
                'selectors' => ['{{WRAPPER}} .hero-area-v1 .hero-content p' => 'opacity: {{VALUE}};'],
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'desc_text_shadow',
				'selector' => '{{WRAPPER}} .hero-area-v1 .hero-content p',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .hero-area-v1 .hero-content p',
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
                'selectors' => ['{{WRAPPER}} .hero-content ul.button li a.main-btn.active-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],              
            ]
        );
  	    
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .hero-content ul.button li a.main-btn.active-btn'
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
                'selectors' => ['{{WRAPPER}} .hero-content ul.button li a.main-btn.active-btn' => 'opacity: {{VALUE}} ;'],
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
                'selectors' => ['{{WRAPPER}} .hero-content ul.button li a.main-btn.active-btn' => 'color: {{VALUE}};']
            ]
        );
       
	    $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'label' => esc_html__( 'Border', 'chakta' ),
                'selector' => '{{WRAPPER}} .hero-content ul.button li a.main-btn.active-btn ',
            ]
        );
        
		$this->add_responsive_control( 'btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .hero-content ul.button li a.main-btn.active-btn ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
       
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'label' => esc_html__( 'Background', 'chakta' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .hero-content ul.button li a.main-btn.active-btn ',
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
                'selectors' => ['{{WRAPPER}} .hero-content ul.button li a.main-btn.active-btn:hover ' => 'color: {{VALUE}};']
            ]
        );
		
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_hvr_border',
                'label' => esc_html__( 'Border', 'chakta' ),
                'selector' => '{{WRAPPER}} .hero-content ul.button li a.main-btn.active-btn:hover ',
            ]
        );
        
		$this->add_responsive_control( 'btn_hvr_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .hero-content ul.button li a.main-btn.active-btn:hover ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
		
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_hvr_background',
                'label' => esc_html__( 'Background', 'chakta' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .hero-content ul.button li a.main-btn.active-btn:hover',
            ]
        );
		
		$this->end_controls_tab(); //btn_hover_tab
		
        $this->end_controls_tabs(); //btn_tabs
		
        $this->end_controls_section();
     	
		/*****   END CONTROLS SECTION   ******/
		
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('btn2_styling',
            [
                'label' => esc_html__( 'Second Button Style', 'chakta' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
		
		$this->add_responsive_control( 'btn2_padding',
            [
                'label' => esc_html__( 'Padding', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}}  .hero-area-v1 .hero-content ul.button li .klb-homeslider-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],              
            ]
        );
  	    
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'btn2_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .hero-area-v1 .hero-content ul.button li .klb-homeslider-btn'
            ]
        );
		
		$this->add_control( 'btn2_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'chakta-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .hero-area-v1 .hero-content ul.button li .klb-homeslider-btn' => 'opacity: {{VALUE}} ;'],
            ]
        );

		$this->start_controls_tabs('btn2_tabs');
        $this->start_controls_tab( 'btn2_normal_tab',
            [ 'label' => esc_html__( 'Normal', 'chakta' ) ]
        );
		
		$this->add_control( 'btn2_color',
            [
                'label' => esc_html__( 'Color', 'chakta' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .hero-area-v1 .hero-content ul.button li .klb-homeslider-btn' => 'color: {{VALUE}};']
            ]
        );
       
	    $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn2_border',
                'label' => esc_html__( 'Border', 'chakta' ),
                'selector' => '{{WRAPPER}} .hero-area-v1 .hero-content ul.button li .klb-homeslider-btn ',
            ]
        );
        
		$this->add_responsive_control( 'btn2_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .hero-area-v1 .hero-content ul.button li .klb-homeslider-btn ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
       
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn2_background',
                'label' => esc_html__( 'Background', 'chakta' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .hero-area-v1 .hero-content ul.button li .klb-homeslider-btn ',
            ]
        );
       
		$this->end_controls_tab(); //btn2_normal_tab
		
        $this->start_controls_tab('btn2_hover_tab',
            [ 'label' => esc_html__( 'Hover', 'chakta' ) ]
        );
       
	    $this->add_control( 'btn2_hvrcolor',
            [
                'label' => esc_html__( 'Color', 'chakta' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .hero-area-v1 .hero-content ul.button li .klb-homeslider-btn:hover ' => 'color: {{VALUE}};']
            ]
        );
		
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn2_hvr_border',
                'label' => esc_html__( 'Border', 'chakta' ),
                'selector' => '{{WRAPPER}} .hero-area-v1 .hero-content ul.button li .klb-homeslider-btn:hover ',
            ]
        );
        
		$this->add_responsive_control( 'btn2_hvr_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .hero-area-v1 .hero-content ul.button li .klb-homeslider-btn:hover ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
		
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn2_hvr_background',
                'label' => esc_html__( 'Background', 'chakta' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}}  .hero-area-v1 .hero-content ul.button li .klb-homeslider-btn:hover',
            ]
        );
		
		$this->end_controls_tab(); //btn2_hover_tab
		
        $this->end_controls_tabs(); //btn2_tabs
		
        $this->end_controls_section();
     	
		/*****   END CONTROLS SECTION   ******/
		
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('filter_styling',
            [
                'label' => esc_html__( 'Search Filter Style', 'chakta' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
		
		$this->add_control( 'filter_title_heading',
            [
                'label' => esc_html__( 'TITLE', 'chakta' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'filter_title_color',
           [
               'label' => esc_html__( 'Title Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .hero-filter h4.title' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'filter_title_hvrcolor',
           [
               'label' => esc_html__( 'Title Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .hero-filter h4.title:hover' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'filter_title_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'chakta-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .hero-filter h4.title ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'filter_title_text_shadow',
				'selector' => '{{WRAPPER}} .hero-filter h4.title',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'filter_title_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .hero-filter h4.title',
				
            ]
        );
		
		$this->add_control( 'filter_btn_heading',
            [
                'label' => esc_html__( 'Button', 'chakta' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_responsive_control( 'filter_btn_padding',
            [
                'label' => esc_html__( 'Padding', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}}   .hero-filter .main-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],              
            ]
        );
  	    
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'filter_btn_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}}  .hero-filter .main-btn'
            ]
        );
		
		$this->add_control( 'filter_btn_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'chakta-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}}  .hero-filter .main-btn' => 'opacity: {{VALUE}} ;'],
            ]
        );

		$this->start_controls_tabs('filter_btn_tabs');
        $this->start_controls_tab( 'filter_btn_normal_tab',
            [ 'label' => esc_html__( 'Normal', 'chakta' ) ]
        );
		
		$this->add_control( 'filter_btn_color',
            [
                'label' => esc_html__( 'Color', 'chakta' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}}  .hero-filter .main-btn' => 'color: {{VALUE}};']
            ]
        );
       
	    $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'filter_btn_border',
                'label' => esc_html__( 'Border', 'chakta' ),
                'selector' => '{{WRAPPER}}  .hero-filter .main-btn ',
            ]
        );
        
		$this->add_responsive_control( 'filter_btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}}  .hero-filter .main-btn ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
       
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'filter_btn_background',
                'label' => esc_html__( 'Background', 'chakta' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}}  .hero-filter .main-btn ',
            ]
        );
       
		$this->end_controls_tab(); //filter_btn_normal_tab
		
        $this->start_controls_tab('filter_btn_hover_tab',
            [ 'label' => esc_html__( 'Hover', 'chakta' ) ]
        );
       
	    $this->add_control( 'filter_btn_hvrcolor',
            [
                'label' => esc_html__( 'Color', 'chakta' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}}  .hero-filter .main-btn:hover ' => 'color: {{VALUE}};']
            ]
        );
		
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'filter_btn_hvr_border',
                'label' => esc_html__( 'Border', 'chakta' ),
                'selector' => '{{WRAPPER}}  .hero-filter .main-btn:hover ',
            ]
        );
        
		$this->add_responsive_control( 'filter_btn_hvr_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}}  .hero-filter .main-btn:hover ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
		
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'filter_btn_hvr_background',
                'label' => esc_html__( 'Background', 'chakta' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}}  .hero-filter .main-btn:hover',
            ]
        );
		
		$this->end_controls_tab(); //filter_btn_hover_tab
		
        $this->end_controls_tabs(); //filter_btn_tabs
		
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		echo '<section class="hero-area-v1 bg_cover" style="background-image: url('.esc_url($settings['slider_bg']['url']).');">';
			if ( $settings['slider_items'] ) {
				echo '<div class="container">';
				echo '<div class="row">';
				echo '<div class="col-lg-8">';
				echo '<div class="hero-contnt-slide">';
				
				foreach ( $settings['slider_items'] as $item ) {
					$target = $item['slider_btn_link']['is_external'] ? ' target="_blank"' : '';
					$nofollow = $item['slider_btn_link']['nofollow'] ? ' rel="nofollow"' : '';
					$secondtarget = $item['slider_btn_link_second']['is_external'] ? ' target="_blank"' : '';
					$secondnofollow = $item['slider_btn_link_second']['nofollow'] ? ' rel="nofollow"' : '';


					echo '<div class="hero-content">';
					echo '<span class="span">'.esc_html($item['item_subtitle']).'</span>';
					echo '<h1>'.esc_html($item['item_title']).'</h1>';
					echo '<p>'.esc_html($item['item_desc']).'</p>';
					echo '<ul class="button">';
					echo '<li><a href="'.esc_url($item['slider_btn_link']['url']).'" '.esc_attr($target.$nofollow).' class="main-btn active-btn">'.esc_html($item['slider_btn_title']).'</a></li>';
					echo '<li><a href="'.esc_url($item['slider_btn_link_second']['url']).'" '.esc_attr($secondtarget.$nofollow).' class="klb-homeslider-btn main-btn">'.esc_html($item['slider_btn_title_second']).'</a></li>';
					echo '</ul>';
					echo '</div>';

					
				}

				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}
			if($settings['disable_search_filter'] != 'yes'){
				echo '<div class="hero-filter bg_cover" style="background-image: url('.esc_url($settings['search_filter_bg']['url']).');">';
				echo '<h4 class="title text-center">'.esc_html($settings['search_filter_title']).'</h4>';
				echo '<form id="klb-vehicle-filter" action="' . esc_url( home_url( '/'  ) ) . '" method="get">';
				echo '<div class="row">';
				echo '<div class="col-lg-3">';
				echo '<div class="form_group">';
				echo '<select id="make-select" name="make">';
				echo chakta_get_makes_output();
				echo '</select>';
				echo '</div>';
				echo '</div>';
				echo '<div class="col-lg-3">';
				echo '<div class="form_group model-select select-model-wrap">';
				echo '<select id="model-select" name="model" disabled>';
				echo '<option value="0">'.esc_html__('Select Make First','chakta-core').'</option>';
				echo '</select>';
				echo '</div>';
				echo '</div>';
				echo '<div class="col-lg-3">';
				echo '<div class="form_group select-year">';
				echo '<select name="klb_year" id="klb_year" disabled>';
				echo chakta_get_years_output();
				echo '</select>';
				echo '</div>';
				echo '</div>';
				echo '<div class="col-lg-3">';
				echo '<div class="form_group">';
				echo '<button class="main-btn">'.esc_html__('Find Auto Parts','chakta-core').'</button>';
				echo '<input type="hidden" name="s" id="s" value="' . get_search_query() . '">';
				echo '<input type="hidden" name="post_type" value="product" />';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</form>';
				echo '</div>';
			}
		echo '</section>';
		
	}

}
