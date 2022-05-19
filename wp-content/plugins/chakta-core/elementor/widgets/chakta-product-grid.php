<?php

namespace Elementor;

class Chakta_Product_Grid_Widget extends Widget_Base {
    use Chakta_Helper;

    public function get_name() {
        return 'chakta-product-grid';
    }
    public function get_title() {
        return 'Product Grid (K)';
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
		
        $this->add_control( 'btn_title',
            [
                'label' => esc_html__( 'Button Title', 'chakta-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'View More Products',
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
		
		$this->add_control( 'column',
			[
				'label' => esc_html__( 'Column', 'chakta-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'col-lg-3',
				'options' => [
					'select-column' => esc_html__( 'Select Column', 'chakta-core' ),
					'col-lg-6'	  => esc_html__( '2 Columns', 'chakta-core' ),
					'col-lg-4' 	  => esc_html__( '3 Columns', 'chakta-core' ),
					'col-lg-3'	  => esc_html__( '4 Columns', 'chakta-core' ),
				],
			]
		);
		
        // Posts Per Page
        $this->add_control( 'post_count',
            [
                'label' => esc_html__( 'Posts Per Page', 'chakta-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => count( get_posts( array('post_type' => 'product', 'post_status' => 'publish', 'fields' => 'ids', 'posts_per_page' => '-1') ) ),
                'default' => 8
            ]
        );
		
        $this->add_control( 'cat_filter',
            [
                'label' => esc_html__( 'Filter Category', 'chakta-core' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->chakta_cpt_taxonomies('product_cat'),
                'description' => 'Select Category(s)',
                'default' => '',
				'label_block' => true,
            ]
        );
		
        $this->add_control( 'post_include_filter',
            [
                'label' => esc_html__( 'Include Post', 'chakta-core' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->chakta_cpt_get_post_title('product'),
                'description' => 'Select Post(s) to Include',
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
				'selector' => '{{WRAPPER}} .shop-item .shop-img img',
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
               'selectors' => ['{{WRAPPER}} .shop-grid-v1 .shop-item .shop-content h3.title' => 'color: {{VALUE}};']
           ]
        );
		
		$this->add_control( 'title_hvrcolor',
           [
               'label' => esc_html__( 'Title Hover Color', 'chakta' ),
               'type' => Controls_Manager::COLOR,
               'default' => '',
               'selectors' => ['{{WRAPPER}} .shop-grid-v1 .shop-item .shop-content h3.title:hover' => 'color: {{VALUE}};']
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
                'selectors' => ['{{WRAPPER}} .shop-grid-v1 .shop-item .shop-content h3.title ' => 'opacity: {{VALUE}} ;']
            ]
        );
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .shop-grid-v1 .shop-item .shop-content h3.title ',
			]
		);
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => ' {{WRAPPER}} .shop-grid-v1 .shop-item .shop-content h3.title',
				
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
                'selectors' => ['{{WRAPPER}} .shop-grid-v1 .button-box .main-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],              
            ]
        );
  	    
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typo',
                'label' => esc_html__( 'Typography', 'chakta' ),
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .shop-grid-v1 .button-box .main-btn'
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
                'selectors' => ['{{WRAPPER}} .shop-grid-v1 .button-box .main-btn' => 'opacity: {{VALUE}} ;'],
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
                'selectors' => ['{{WRAPPER}} .shop-grid-v1 .button-box .main-btn' => 'color: {{VALUE}};']
            ]
        );
       
	    $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'label' => esc_html__( 'Border', 'chakta' ),
                'selector' => '{{WRAPPER}} .shop-grid-v1 .button-box .main-btn ',
            ]
        );
        
		$this->add_responsive_control( 'btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .shop-grid-v1 .button-box .main-btn ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
       
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'label' => esc_html__( 'Background', 'chakta' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .shop-grid-v1 .button-box .main-btn ',
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
                'selectors' => ['{{WRAPPER}} .shop-grid-v1 .button-box .main-btn:hover ' => 'color: {{VALUE}};']
            ]
        );
		
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_hvr_border',
                'label' => esc_html__( 'Border', 'chakta' ),
                'selector' => '{{WRAPPER}} .shop-grid-v1 .button-box .main-btn:hover ',
            ]
        );
        
		$this->add_responsive_control( 'btn_hvr_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'chakta' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .shop-grid-v1 .button-box .main-btn:hover ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'],
            ]
        );
		
		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_hvr_background',
                'label' => esc_html__( 'Background', 'chakta' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .shop-grid-v1 .button-box .main-btn:hover',
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
		
		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}
	
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => $settings['post_count'],
			'order'          => 'DESC',
			'post_status'    => 'publish',
			'paged' 			=> $paged,
            'post__in'       => $settings['post_include_filter'],
            'order'          => $settings['order'],
			'orderby'        => $settings['orderby']
		);
	
		if($settings['cat_filter']){
			$args['tax_query'][] = array(
				'taxonomy' 	=> 'product_cat',
				'field' 	=> 'term_id',
				'terms' 	=> $settings['cat_filter']
			);
		}
	
	
		?>
		
		<?php
		
		$output .= '<section class="shop-grid-v1">';
		$output .= '<div class="container">';
		$output .= '<div class="row">';

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
				$image_src = $image_src[0];
				$imageresize = chakta_resize( $image_src, 304, 173, true, true, true );

				$cart_url = wc_get_cart_url();
				$price = $allproduct->get_price_html();
				$weight = $product->get_weight();
				$stock_status = $product->get_stock_status();
				$stock_text = $product->get_availability();
				$rating = wc_get_rating_html($product->get_average_rating());
				$ratingcount = $product->get_review_count();
				$wishlist = get_theme_mod( 'chakta_wishlist_button', '0' );
				$quickview = get_theme_mod( 'chakta_quick_view_button', '0' );
		
				$output .= '<div class="'.esc_attr($settings['column']).' col-md-6 col-sm-12">';
				$output .= '<div class="shop-item mb-35">';
				$output .= '<div class="shop-img">';
				$output .= chakta_sale_percentage();
				$output .= '<img src="'.chakta_product_image().'" alt="'.the_title_attribute( 'echo=0' ).'">';
				$output .= chakta_vendor_name();
				$output .= '<div class="shop-overlay">';
				$output .= '<a href="'.get_permalink().'" class="link-item"></a>';
				$output .= '<div class="overlay-content">';
				$output .= '<ul>';
				$output .= '<li>'.chakta_add_to_cart_button().'</li>';
				if($quickview == '1'){
				$output .= '<li><a href="'.$product->get_id().'" class="icon detail-bnt"><i class="far fa-search-plus"></i></a></li>';
				}
				$output .= '</ul>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '<div class="shop-content">';
				$output .= '<h3 class="title"><a href="'.get_permalink().'" title="'.the_title_attribute( 'echo=0' ).'">'.get_the_title().'</a></h3>';
				$output .= '<p class="price">'.$price.'</p>';
				if($wishlist == '1'){
				$output .= do_shortcode('[ti_wishlists_addtowishlist]');
				}
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';

			endwhile;
			}
			wp_reset_postdata();

		$output .= '</div>';
		
		$output .= '<div class="row">';
		$output .= '<div class="col-lg-12">';
		$output .= '<div class="button-box text-center mt-20">';
		$output .= '<a href="'.esc_url($settings['btn_link']['url']).'" '.esc_attr($target.$nofollow).' class="main-btn">'.esc_html($settings['btn_title']).'</a>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
		
		$output .= '</div>';
		$output .= '</section>';


		echo $output;
	}

}
