<?php

namespace Elementor;

class Chakta_Breadcrumb_Widget extends Widget_Base {

    public function get_name() {
        return 'chakta-breadcrumb';
    }
    public function get_title() {
        return 'Breadcrumb (K)';
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

		$defaultimage = plugins_url( 'images/breadcrumb.jpg', __DIR__ );
		
        $this->add_control( 'title',
            [
                'label' => esc_html__( 'Title', 'chakta-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'About Us',
                'pleaceholder' => esc_html__( 'Set a title.', 'chakta-core' )
            ]
        );
		
        $this->add_control( 'bg_image',
            [
                'label' => esc_html__( 'Background Image', 'chakta-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => $defaultimage],
            ]
        );
		
		$this->end_controls_section();
		
		/*****   END CONTROLS SECTION   ******/
		
        /*****   START CONTROLS SECTION   ******/
		$this->start_controls_section( 'bread_style',
            [
                'label' => esc_html__( 'Breadcrumb', 'chakta' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
		$this->add_responsive_control( 'alignment',
            [
                'label' => esc_html__( 'Alignment', 'chakta' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} .breadcrumbs-content' => 'text-align: {{VALUE}} !important '],
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
               'selectors' => ['{{WRAPPER}} .breadcrumbs-content h1 ' => 'color: {{VALUE}} ;']
           ]
        );
		
		$this->add_control( 'title_hvrcolor',
           [
               'label' => esc_html__( 'Title Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .breadcrumbs-content h1 :hover' => 'color: {{VALUE}} ;']
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
                'selectors' => ['{{WRAPPER}} .breadcrumbs-content h1  ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .breadcrumbs-content h1 ',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => ' {{WRAPPER}} .breadcrumbs-content h1  ',
				
            ]
        );
        
        $this->add_control( 'bread_color',
            [
                'label' => esc_html__( 'Page/Post Color', 'chakta' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} ul.breadcrumb-menu li a ' => 'color:{{VALUE}}  ;' ]
            ]
        );
		
		$this->add_control( 'bread_hvr_color',
            [
                'label' => esc_html__( 'Page/Post Hover Color', 'chakta' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} ul.breadcrumb-menu li a:hover ' => 'color:{{VALUE}}  ;' ]
            ]
        );
		
        $this->add_control( 'bread_sepcolor',
            [
                'label' => esc_html__( 'Separator Color', 'chakta' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} ul.breadcrumb-menu li a:after' => 'color:{{VALUE}} ;' ]
            ]
        );
		
		$this->add_control( 'bread_actvcolor',
            [
                'label' => esc_html__( 'Current Page/Post Color', 'chakta' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}}  ul.breadcrumb-menu li span' => 'color:{{VALUE}}  ;' ],
            ]
        );
		
        $this->add_control( 'bread_hvrcolor',
            [
                'label' => esc_html__( ' Current/Post Hover Color', 'chakta' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} ul.breadcrumb-menu li span:hover ' => 'color:{{VALUE}} ;' ],
            ]
        );
        
		
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$output = '';
				
		echo '<section class="breadcrumbs-section bg_cover" style="background-image: url('.esc_url($settings['bg_image']['url']).');">';
		echo '<div class="container">';
		echo '<div class="row justify-content-center">';
		echo '<div class="col-lg-8">';
		echo '<div class="breadcrumbs-content text-center">';
		echo '<h1>'.esc_html($settings['title']).'</h1>';
		echo chakta_breadcrubms();
		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '</section>';

		
	}

}
