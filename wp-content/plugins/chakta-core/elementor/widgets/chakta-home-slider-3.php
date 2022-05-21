<?php

namespace Elementor;

class Chakta_Home_Slider_3_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'chakta-home-slider-3';
    }
    public function get_title() {
        return 'Home Slider 3 (K)';
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

		$defaultbg = plugins_url( 'images/hero.jpg', __DIR__ );
		
        $this->add_control( 'title',
            [
                'label' => esc_html__( 'Title', 'chakta-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Select Your Vehicle',
                'pleaceholder' => esc_html__( 'Enter title here', 'chakta-core' )
            ]
        );

        $this->add_control( 'subtitle',
            [
                'label' => esc_html__( 'Subitle', 'chakta-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'More than 25038 cars avaiable in our stocks',
                'pleaceholder' => esc_html__( 'Enter subtitle here', 'chakta-core' )
            ]
        );
        $this->add_control(
            'disable_search_box',
            [
                'label' => esc_html__('Disable Search Box', 'chakta-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'chakta-core' ),
                'label_off' => esc_html__( 'No', 'chakta-core' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

		$repeater = new Repeater();
        $repeater->add_control( 'slider_image',
            [
                'label' => esc_html__( 'Image', 'chakta-core' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );


        $this->add_control( 'slider_items',
            [
                'label' => esc_html__( 'Slide Items', 'chakta-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'slider_image' => ['url' => $defaultbg],
                    ],
					
                    [
                        'slider_image' => ['url' => $defaultbg],
                    ]
                ]
            ]
        );

		$this->end_controls_section();


		// Social Repeater
		$this->start_controls_section(
			'social_section',
			[
				'label' => esc_html__( 'Social Icons', 'chakta-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
        $this->add_control( 'social_title',
            [
                'label' => esc_html__( 'Social Title', 'chakta-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Follow Us',
                'pleaceholder' => esc_html__( 'Enter title here', 'chakta-core' )
            ]
        );
		
        $repeater->add_control( 'social_icon',
            [
                'label' => esc_html__( 'Social Icon', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Shop Now',
                'pleaceholder' => esc_html__( 'Enter icon name: facebook', 'chakta-core' )
            ]
        );
        $repeater->add_control( 'social_url',
            [
                'label' => esc_html__( 'Button Link', 'chakta-core' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => esc_html__( 'Place URL here', 'chakta-core' )
            ]
        );
		
        $this->add_control( 'social_items',
            [
                'label' => esc_html__( 'Social Items', 'chakta-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{social_icon}}',
                'default' => [
                    [
                        'social_icon' => 'facebook-f',
                        'social_url' => '#',
                    ],
                    [
                        'social_icon' => 'twitter',
                        'social_url' => '#',
                    ],
                    [
                        'social_icon' => 'instagram',
                        'social_url' => '#',
                    ],
                    [
                        'social_icon' => 'behance',
                        'social_url' => '#',
                    ],
                    [
                        'social_icon' => 'youtube',
                        'social_url' => '#',
                    ],


                ]
            ]
        );
		
		$this->end_controls_section();
		
		/*****   END CONTROLS SECTION   ******/
		
        /*****   START CONTROLS SECTION   ******/
		
		$this->start_controls_section('chakta_styling',
            [
                'label' => esc_html__( ' Style', 'chakta' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
		
		$this->add_responsive_control( 'home_slider_alignment',
            [
                'label' => esc_html__( 'Alignment', 'cosmetsy' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} .hero-content' => 'text-align: {{VALUE}} !important ;'],
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'cosmetsy' ),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'cosmetsy' ),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'cosmetsy' ),
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
               'selectors' => ['{{WRAPPER}} .hero-content h1' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'title_hvrcolor',
           [
               'label' => esc_html__( 'Title Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .hero-content h1:hover' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .hero-content h1 ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .hero-content h1',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .hero-content h1',
				
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
               'selectors' => ['{{WRAPPER}} .hero-content h5' => 'color: {{VALUE}};'],
           ]
        );
		
		$this->add_control( 'subtitle_hvrcolor',
           [
               'label' => esc_html__( 'Subtitle Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .hero-content h5:hover' => 'color: {{VALUE}};'],
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
                'selectors' => ['{{WRAPPER}} .hero-content h5' => 'opacity: {{VALUE}};'],
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'subtitle_text_shadow',
				'selector' => '{{WRAPPER}} .hero-content h5',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .hero-content h5',
            ]
        );

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( $settings['slider_items'] ) {
			echo '<section class="hero-area-v2">';
			echo '<div class="hero-slide-two">';
			
			foreach ( $settings['slider_items'] as $item ) {

				
				echo '<div class="single-hero bg_cover" style="background-image: url('.esc_url($item['slider_image']['url']).');">';
				echo '<div class="container">';
				echo '<div class="row justify-content-center">';
				echo '<div class="col-lg-8">';
				echo '<div class="hero-content text-center">';
				echo '<h1>'.esc_html($settings['title']).'</h1>';
				echo '<h5>'.esc_html($settings['subtitle']).'</h5>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
                if($settings['disable_search_box'] != 'yes') {
                    echo '<div class="hero-filter">';

                    echo '<form id="klb-vehicle-filter" action="' . esc_url(home_url('/')) . '" method="get">';
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
                    echo '<option value="0">' . esc_html__('Select Make First', 'chakta-core') . '</option>';
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
                    echo '<button class="main-btn">' . esc_html__('Find Auto Parts', 'chakta-core') . '</button>';
                    echo '<input type="hidden" name="s" id="klb-search-query" value="' . get_search_query() . '">';
                    echo '<input type="hidden" name="post_type" value="product" />';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</form>';

                    echo '</div>';
                }
				if ( $settings['social_items'] ) {
				echo '<div class="hero-social text-center">';
				echo '<ul class="social-link">';
				echo '<li><span>'.esc_html($settings['social_title']).'</span></li>';
					foreach ( $settings['social_items'] as $socialitem ) {
						echo '<li><a href="'.esc_url($socialitem['social_url']['url']).'"><i class="fab fa-'.esc_attr($socialitem['social_icon']).'"></i></a></li>';
					}
				echo '</ul>';
				echo '</div>';
				}
				echo '</div>';
				
			}

			echo '</div>';
			echo '</section>';
		}
	}

}
