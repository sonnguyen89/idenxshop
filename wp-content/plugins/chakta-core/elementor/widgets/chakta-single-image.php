<?php

namespace Elementor;

class Chakta_Single_Image_Widget extends Widget_Base {

    public function get_name() {
        return 'chakta-single-image';
    }
    public function get_title() {
        return 'Single Image (K)';
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

		$defaultimage = plugins_url( 'images/about-1.jpg', __DIR__ );
		
        $this->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'chakta-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => $defaultimage],
            ]
        );
		
		$shapeimage1 = plugins_url( 'images/shape-1.png', __DIR__ );
        $this->add_control( 'shape_img1',
            [
                'label' => esc_html__( 'Shape Image 1', 'chakta-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => $shapeimage1],
            ]
        );

		$shapeimage2 = plugins_url( 'images/about-2.jpg', __DIR__ );
        $this->add_control( 'shape_img2',
            [
                'label' => esc_html__( 'Shape Image 2', 'chakta-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => $shapeimage2],
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
				'selector' => '{{WRAPPER}} .about-img img',
			]
		);
		
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$output = '';
		
		echo '<div class="klb-single-image about-img-box">';
		echo '<img src="'.esc_url($settings['shape_img1']['url']).'" class="shape" alt="shape1">';
		echo '<div class="about-img about-big-img text-center">';
		echo '<img src="'.esc_url($settings['image']['url']).'" alt="image">';
		echo '</div>';
		echo '<div class="about-img about-small-img">';
		echo '<img src="'.esc_url($settings['shape_img2']['url']).'" alt="shape2">';
		echo '</div>';
		echo '</div>';


	}

}
