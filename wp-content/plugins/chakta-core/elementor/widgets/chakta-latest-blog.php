<?php

namespace Elementor;

class Chakta_Latest_Blog_Widget extends Widget_Base {
    use Chakta_Helper;

    public function get_name() {
        return 'chakta-latest-blog';
    }
    public function get_title() {
        return 'Lateste Posts (K)';
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
				
        $this->add_control( 'post_count',
            [
                'label' => esc_html__( 'Posts Per Page', 'chakta-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => count( get_posts( array('post_type' => 'post', 'post_status' => 'publish', 'fields' => 'ids', 'posts_per_page' => '-1') ) ),
                'default' => 3
            ]
        );
		
        $this->add_control( 'category_filter',
            [
                'label' => esc_html__( 'Category', 'naturally' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->chakta_get_categories(),
                'description' => 'Select Category(s)',
				'label_block' => true,
            ]
        );
		
        $this->add_control( 'post_filter',
            [
                'label' => esc_html__( 'Specific Post(s)', 'naturally' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->chakta_get_posts(),
                'description' => 'Select Specific Post(s)',
				'label_block' => true,
            ]
        );
		
        $this->add_control( 'order',
            [
                'label' => esc_html__( 'Select Order', 'chakta-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC' => esc_html__( 'Ascending', 'chakta-core' ),
                    'DESC' => esc_html__( 'Descending', 'chakta-core' )
                ],
                'default' => 'DESC'
            ]
        );
		
        $this->add_control( 'orderby',
            [
                'label' => esc_html__( 'Order By', 'chakta-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'id' => esc_html__( 'Post ID', 'chakta-core' ),
                    'menu_order' => esc_html__( 'Menu Order', 'chakta-core' ),
                    'rand' => esc_html__( 'Random', 'chakta-core' ),
                    'date' => esc_html__( 'Date', 'chakta-core' ),
                    'title' => esc_html__( 'Title', 'chakta-core' ),
                ],
                'default' => 'date',
            ]
        );
		
		$this->add_control(
			'disable_pagination',
			[
				'label' => esc_html__('Disable Pagination', 'chakta-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'chakta-core' ),
				'label_off' => esc_html__( 'No', 'chakta-core' ),
				'return_value' => 'yes',
				'default' => '',
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
                'selectors' => ['{{WRAPPER}} .entry-content' => 'text-align: {{VALUE}} !important;'],
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
		
		$this->add_control( 'date_heading',
            [
                'label' => esc_html__( 'Date', 'chakta' ),
                'type' => Controls_Manager::HEADING,
				'separator' => 'before'
            ]
        );
		
		$this->add_control( 'icon_color',
           [
               'label' => esc_html__( 'Icon Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .post-meta ul li span i' => 'color: {{VALUE}};']
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
                'selectors' => [ '{{WRAPPER}} .post-meta ul li span i' => 'font-size: {{SIZE}}px;' ],
            ]
        );
		
		$this->add_control( 'date_color',
           [
               'label' => esc_html__( 'Date Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .post-meta ul li span a' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'date_hvrcolor',
           [
               'label' => esc_html__( 'Date Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .post-meta ul li span a:hover ' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'date_opacity_important_style',
            [
                'label' => esc_html__( 'Opacity', 'chakta-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .post-meta ul li span a ,{{WRAPPER}} .post-meta ul li span i ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_control( 'date_size',
            [
                'label' => esc_html__( 'Date Size', 'chakta' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .post-meta ul li span a' => 'font-size: {{SIZE}}px;' ],
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
               'selectors' => ['{{WRAPPER}} .post-overlay .entry-content h3.title' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'title_hvrcolor',
           [
               'label' => esc_html__( 'Title Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}}  .post-overlay .entry-content h3.title:hover ' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .post-overlay .entry-content h3.title ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .post-overlay .entry-content h3.title ',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .post-overlay .entry-content h3.title',
				
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
                'selectors' => ['{{WRAPPER}} .post-overlay .entry-content a.main-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],              
            ]
        );
  	    
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .post-overlay .entry-content a.main-btn'
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
                'selectors' => ['{{WRAPPER}} .post-overlay .entry-content a.main-btn' => 'opacity: {{VALUE}} ;'],
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
                'selectors' => ['{{WRAPPER}} .post-overlay .entry-content a.main-btn' => 'color: {{VALUE}};']
            ]
        );
       
	    $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'label' => esc_html__( 'Border', 'chakta' ),
                'selector' => '{{WRAPPER}} .post-overlay .entry-content a.main-btn',
            ]
        );
        
		$this->add_responsive_control( 'btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .post-overlay .entry-content a.main-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
       
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'label' => esc_html__( 'Background', 'chakta' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .post-overlay .entry-content a.main-btn',
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
                'selectors' => ['{{WRAPPER}} .post-overlay .entry-content a.main-btn:hover ' => 'color: {{VALUE}};']
            ]
        );
		
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_hvr_border',
                'label' => esc_html__( 'Border', 'chakta' ),
                'selector' => '{{WRAPPER}} .post-overlay .entry-content a.main-btn:hover ',
            ]
        );
        
		$this->add_responsive_control( 'btn_hvr_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .post-overlay .entry-content a.main-btn:hover ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
		
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_hvr_background',
                'label' => esc_html__( 'Background', 'chakta' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .post-overlay .entry-content a.main-btn:hover ',
            ]
        );

		$this->end_controls_tab(); //btn_hover_tab
	   
		$this->end_controls_tabs(); //btn_tabs

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();		
		$output = '';
		
		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}
	
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $settings['post_count'],
			'order'          => 'DESC',
			'post_status'    => 'publish',
			'paged' 			=> $paged,
            'post__in'       => $settings['post_filter'],
            'order'          => $settings['order'],
			'orderby'        => $settings['orderby'],
            'category__in'     => $settings['category_filter'],
		);
	
	
		
		$output .= '<section class="blog-grid-v2">';
		$output .= '<div class="container">';
		$output .= '<div class="row blog-slide-two">';

		
		$count = 1;
		$loop = new \WP_Query( $args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
				global $product;
				global $post;
				global $woocommerce;
			
				$id = get_the_ID();
				$allproduct = wc_get_product( get_the_ID() );
				
				$att=get_post_thumbnail_id();
				$image_src = wp_get_attachment_image_src( $att, 'full' );
				if($image_src){
					$image_src = $image_src[0];
					$imageresize = chakta_resize( $image_src, 370, 360, true, true, true );
				} else {
					$imageresize = $image_src;
				}
				$taxonomy = strip_tags( get_the_term_list($post->ID, 'category', '', ', ', '') );

				$output .= '<div class="col-lg-4">';
				$output .= '<div class="blog-item">';
				$output .= '<div class="post-thumbnail">';
				$output .= '<a href="'.get_permalink().'" title="'.the_title_attribute( 'echo=0' ).'"><img src="'.esc_url($imageresize).'" alt="'.the_title_attribute( 'echo=0' ).'"></a>';
				$output .= '<div class="post-overlay">';
				$output .= '<div class="entry-content">';
				$output .= '<div class="post-meta">';
				$output .= '<ul>';
				$output .= '<li><span><i class="fal fa-calendar-alt"></i><a href="'.get_permalink().'" title="'.the_title_attribute( 'echo=0' ).'">'.get_the_date('j M Y').'</a></span></li>';
				$output .= '</ul>';
				$output .= '</div>';
				$output .= '<h3 class="title"><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
				$output .= '<a href="'.get_permalink().'" class="main-btn">'.esc_html__('Read More','chakta-core').'</a>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';

			endwhile;
			
			if($settings['disable_pagination'] != 'yes'){
				ob_start();
				get_template_part( 'post-format/pagination' );
				$output .= '<div class="col-12">'. ob_get_clean().'</div>';
			}
			
		}
		wp_reset_postdata();
		

		$output .= '</div>';
		$output .= '</div>';
		$output .= '</section>';

		
		echo $output;
	}

}
