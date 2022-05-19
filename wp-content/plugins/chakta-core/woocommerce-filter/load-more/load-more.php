<?php

/*************************************************
## Load More Button
*************************************************/

if(get_theme_mod('chakta_paginate_type') == 'loadmore' || chakta_ft() == 'load-more'){
	function chakta_load_more_button(){
		echo '<nav class="woocommerce-pagination klb-load-more">
				<div class="button main-btn">'.esc_html__('Load More','chakta-core').'</div>
			  </nav>';
	}

	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
	add_action( 'woocommerce_after_shop_loop', 'chakta_load_more_button', 10 );
}

/*************************************************
## Infinite Pagination
*************************************************/

if(get_theme_mod('chakta_paginate_type') == 'infinite' || chakta_ft() == 'infinite'){
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
}


/*************************************************
## Load More - Infinite Scroll
*************************************************/ 
if(get_theme_mod('chakta_paginate_type') == 'loadmore' || get_theme_mod('chakta_paginate_type') == 'infinite' || chakta_ft() == 'load-more' || chakta_ft() == 'infinite'){
	function chakta_load_more_scripts() {
		if(is_shop() || is_product_category()){
			if(get_theme_mod('chakta_paginate_type') == 'infinite' || chakta_ft() == 'infinite'){
				wp_enqueue_script( 'chakta-load-more',  plugins_url( 'js/infinite-scroll.js', __FILE__ ), true );
			} elseif(get_theme_mod('chakta_paginate_type') == 'loadmore' || chakta_ft() == 'load-more') {
				wp_enqueue_script( 'chakta-load-more',  plugins_url( 'js/load_more.js', __FILE__ ), true );
			}
			wp_localize_script( 'chakta-load-more', 'loadmore', array(
				'ajaxurl' => esc_url(admin_url( 'admin-ajax.php' )),
				'current_page' => (get_query_var('paged')) ? get_query_var('paged') : 1,
				'per_page' => wc_get_loop_prop( 'per_page' ),
				'max_page' => wc_get_loop_prop( 'total_pages' ),
				'cat_id' => isset(get_queried_object()->term_id) ? get_queried_object()->term_id : '',
				'filter_cat' => isset($_GET['filter_cat']) ? $_GET['filter_cat'] : '',
				'layered_nav' => WC_Query::get_layered_nav_chosen_attributes(),
				'on_sale' => isset($_GET['on_sale']) ? wc_get_product_ids_on_sale() : '',
				'orderby' => isset($_GET['orderby']) ? $_GET['orderby'] : '',
				'shop_view' => isset($_GET['shop_view']) ? $_GET['shop_view'] : '',
				
			));
		}
	}
	add_action( 'wp_enqueue_scripts', 'chakta_load_more_scripts' );
}
/*************************************************
## Load More CallBack
*************************************************/ 

add_action( 'wp_ajax_nopriv_load_more', 'chakta_load_more_callback' );
add_action( 'wp_ajax_load_more', 'chakta_load_more_callback' );
function chakta_load_more_callback() {
	
		$output = '';
				
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => $_POST['per_page'],
			'paged' 			=> $_POST['current_page'] + 1,
		);
		
		// On Sale Products
		if(isset($_POST['on_sale'])){
			$args['post__in'] = $_POST['on_sale'];
		}
		
		// Orderby
		if(isset($_POST['orderby'])){
			if($_POST['orderby'] == 'rating'){
				$args['meta_key'] = '_wc_average_rating'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				$args['order']    = 'DESC';
				$args['orderby']  = 'meta_value_num';
				add_filter( 'posts_clauses', array( WC()->query, 'order_by_rating_post_clauses' ) );
			}
			
			if($_POST['orderby'] == 'popularity'){
				$args['meta_key'] = 'total_sales';
				add_filter( 'posts_clauses', array( WC()->query, 'order_by_popularity_post_clauses' ) );
			}

			if($_POST['orderby'] == 'price'){
				add_filter( 'posts_clauses', array( WC()->query, 'order_by_price_asc_post_clauses' ) );
			}

			if($_POST['orderby'] == 'price-desc'){
				add_filter( 'posts_clauses', array( WC()->query, 'order_by_price_desc_post_clauses' ) );
			}
		}
		
		
		// Product Category Filter Widget on shop page
		if($_POST['filter_cat'] != null){
			if(!empty($_POST['filter_cat'])){
				$args['tax_query'][] = array(
					'taxonomy' 	=> 'product_cat',
					'field' 	=> 'id',
					'terms' 	=> explode(',',$_POST['filter_cat']),
				);

			}
		}
		
		// Product Category Page
		if($_POST['cat_id'] != null){
			$args['tax_query'][] = array(
				'taxonomy' 	=> 'product_cat',
				'field' 	=> 'id',
				'terms' 	=> $_POST['cat_id']
			);
		}
		
		// Product Filter By widget
		if (isset( $_POST['layered_nav'] )) {
			$choosen_attributes = $_POST['layered_nav'];
			
			foreach ( $choosen_attributes as $taxonomy => $data ) {
				$args['tax_query'][] = array(
					'taxonomy'         => $taxonomy,
					'field'            => 'slug',
					'terms'            => $data['terms'],
					'operator'         => 'and' === $data['query_type'] ? 'AND' : 'IN',
					'include_children' => false,
				);
			}
		}
		
		//Loop	
		$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
				ob_start();
				wc_get_template_part( 'content', 'product' );
				$output .= ob_get_clean();
			endwhile;
		} else {
			$output .= esc_html__( 'No products found','chakta' );
		}
		wp_reset_postdata();

	 	$output_escaped = $output;
	 	echo $output_escaped;
		
		wp_die();

}