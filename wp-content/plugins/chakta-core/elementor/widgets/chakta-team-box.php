<?php

namespace Elementor;

class Chakta_Team_Box_Widget extends Widget_Base {

    public function get_name() {
        return 'chakta-team-box';
    }
    public function get_title() {
        return 'Team Box (K)';
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

		$defaultimage = plugins_url( 'images/team.jpg', __DIR__ );
		
        $this->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'chakta-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => $defaultimage],
            ]
        );
		
        $this->add_control( 'name',
            [
                'label' => esc_html__( 'Name', 'chakta-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'DR. Michael Coleman',
                'placeholder' => esc_html__( 'Enter the text', 'chakta-core' )
            ]
        );

        $this->add_control( 'position',
            [
                'label' => esc_html__( 'Position', 'chakta-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'CEO & Founder',
                'placeholder' => esc_html__( 'Enter the text here', 'chakta-core' )
            ]
        );

        $this->add_control( 'popup_id',
            [
                'label' => esc_html__( 'Popup Id', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__( 'Place URL here', 'chakta-core' )
            ]
        );

        $this->add_control( 'context',
            [
                'label' => esc_html__( 'Context', 'chakta-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
				'default' => 'Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur vel illum dolorem',
                'placeholder' => esc_html__( 'Add the description here', 'chakta-core' )
            ]
        );

		$repeater = new Repeater();

        $repeater->add_control( 'social_icon',
            [
                'label' => esc_html__( 'Icon', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'fab fa-facebook-f',
                'description'=> 'You can add icon code. for example: fab fa-facebook-f'
            ]
        );
		
        $repeater->add_control( 'social_url',
            [
                'label' => esc_html__( 'Social URL', 'chakta-core' ),
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
                'default' => [
                    [
                        'social_icon' => 'fab fa-facebook-f',
                        'social_url' => '#',
                    ],
                    [
                        'social_icon' => 'fab fa-twitter',
                        'social_url' => '#',
                    ],
                    [
                        'social_icon' => 'fab fa-instagram',
                        'social_url' => '#',
                    ],
                    [
                        'social_icon' => 'fab fa-linkedin',
                        'social_url' => '#',
                    ],
                    [
                        'social_icon' => 'fab fa-youtube',
                        'social_url' => '#',
                    ]
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
				'selector' => '{{WRAPPER}} .team-img img',
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
                        'max' => 500
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}  .team-img img' => 'height: {{SIZE}}{{UNIT}}',
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
                        'max' => 500
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-img img' => 'width: {{SIZE}}{{UNIT}}',
                ]
            ]
        );
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .team-img img',
				
			]
		);
		
		$this->add_responsive_control( 'image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .team-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
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
               'selectors' => ['{{WRAPPER}} .team-info h5' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'name_hvrcolor',
           [
               'label' => esc_html__( 'Name Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .team-info h5:hover' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .team-info h5' => 'opacity: {{VALUE}} ;'],
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'name_text_shadow',
				'selector' => '{{WRAPPER}} .team-info h5',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .team-info h5'
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
               'selectors' => ['{{WRAPPER}} .team-info span' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'position_hvrcolor',
           [
               'label' => esc_html__( 'Position Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .team-info span:hover' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .team-info span' => 'opacity: {{VALUE}} ;'],
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'position_text_shadow',
				'selector' => '{{WRAPPER}} .team-info span',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'position_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .team-info span'
            ]
        );
		
		$this->add_control( 'comment_heading',
            [
                'label' => esc_html__( 'COMMENT', 'chakta' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'context_color',
           [
               'label' => esc_html__( 'Context Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .team-info p' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'context_hvrcolor',
           [
               'label' => esc_html__( 'Context Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .team-info p:hover' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'context_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'chakta-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .team-info p' => 'opacity: {{VALUE}} ;'],
            ]
        );
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'context_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .team-info p'
            ]
        );
		
		$this->add_control( 'items_icon_heading',
            [
                'label' => esc_html__( 'ICON', 'chakta' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'items_icon_color',
           [
               'label' => esc_html__( 'Icon Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .social-link li a i' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'items_icon_hover_color',
           [
               'label' => esc_html__( 'Icon Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .social-link li a i:hover' => 'color: {{VALUE}};']
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
                'selectors' => [ '{{WRAPPER}} .social-link li a i' => 'font-size: {{SIZE}}px;' ],
            ]
        );
		
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$output = '';
				
		echo '<div class="klb-team-box team-item">';
		echo '<div class="team-img">';
		echo '<a data-toggle="modal" data-target="#team-popup'.esc_attr($settings['popup_id']).'" href="#"><img src="'.esc_url($settings['image']['url']).'" alt="team"></a>';
		echo '<a data-toggle="modal" data-target="#team-popup'.esc_attr($settings['popup_id']).'" href="#" class="icon"><i class="fal fa-plus"></i></a>';
		echo '</div>';
		echo '<div class="team-info">';
		echo '<a data-toggle="modal" data-target="#team-popup'.esc_attr($settings['popup_id']).'" href="#" class="team-popup icon"><h5>'.esc_html($settings['name']).'</h5></a>';
		echo '<span>'.esc_html($settings['position']).'</span>';
		echo '</div>';

		echo '<div class="modal fade" id="team-popup'.esc_attr($settings['popup_id']).'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">';
		echo '<div class="modal-dialog modal-dialog-centered" role="document">';
		echo '<div class="modal-content">';
		echo '<div class="modal-body">';
		echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
		echo '<span aria-hidden="true">&times;</span>';
		echo '</button>';
		echo '<div class="klb-team-box team-item">';
		echo '<div class="team-img">';
		echo '<img src="'.esc_url($settings['image']['url']).'" alt="team">';
		echo '</div>';
		echo '<div class="team-info">';
		echo '<h5>'.esc_html($settings['name']).'</h5>';
		echo '<span>'.esc_html($settings['position']).'</span>';
		echo '<p>'.chakta_sanitize_data($settings['context']).'</p>';
		if($settings['social_items']){
			echo '<ul class="social-link">';
			foreach($settings['social_items'] as $item){
				$target = $item['social_url']['is_external'] ? ' target="_blank"' : '';
				$nofollow = $item['social_url']['nofollow'] ? ' rel="nofollow"' : '';
	
				echo '<li><a href="'.esc_url($item['social_url']['url']).'" '.esc_attr($target.$nofollow).'><i class="'.esc_attr($item['social_icon']).'"></i></a></li>';
			}

			echo '</ul>';
		}

		echo '</div>';
		echo '</div>';
		echo '</div>';

		echo '</div>';
		echo '</div>';
		echo '</div>';


		echo '</div>';
	}

}
