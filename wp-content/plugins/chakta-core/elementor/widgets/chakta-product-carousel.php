<?php

namespace Elementor;

class Chakta_Product_Carousel_Widget extends Widget_Base {
    use Chakta_Helper;

    public function get_name() {
        return 'chakta-product-carousel';
    }
    public function get_title() {
        return 'Product Carousel (K)';
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
		
		$output .= '<section class="shop-grid-v2">';
		$output .= '<div class="container">';
		$output .= '<div class="row best-slide">';

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
		
				$output .= '<div class="col-lg-3">';
				$output .= '<div class="shop-item">';
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
				if($wishlist == '1'){
				$output .= '<li>'.do_shortcode('[ti_wishlists_addtowishlist]').'</li>';
				}
				$output .= '</ul>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '<div class="shop-content text-center">';
				$output .= $rating;
				$output .= '<h3 class="title"><a href="'.get_permalink().'" title="'.the_title_attribute( 'echo=0' ).'">'.get_the_title().'</a></h3>';
				$output .= '<p class="price">'.$price.'</p>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';

			endwhile;
		}
		wp_reset_postdata();

		$output .= '</div>';
		$output .= '</div>';
		$output .= '</section>';


		echo $output;
	}

}
