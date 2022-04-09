<?php

//Support for WooCommerce
add_theme_support( 'woocommerce' );

// Disable WooCommerce CSS
	if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
		add_filter( 'woocommerce_enqueue_styles', '__return_false' );
	} else {
		define( 'WOOCOMMERCE_USE_CSS', false );
	}

	// Increase Number of Related Products to 4
	if (!function_exists('woocommerce_related_output')) {
		function woocommerce_related_output() {
			global $product, $orderby, $related;
			$args = array(
				'posts_per_page'	=> '4',
				'columns'			=> '4',
			);
			return $args;
		}
	}
	add_filter( 'woocommerce_output_related_products_args', 'woocommerce_related_output' );

	// Change products per page
	if(get_theme_mod('gymx_wc_items', '12') != ''){

		add_filter( 'loop_shop_per_page', function ($cols) { 
			return get_theme_mod('gymx_wc_items', '12');
		}, 20);
	}

	// Toggle Sort by Function
	if(get_theme_mod('gymx_wc_shop_sort', 'yes') == 'no'){
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	}

	// Toggle Result Count
	if(get_theme_mod('gymx_wc_result_count', 'yes') == 'no'){
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	}

	// Toggle Upsell Products
	if(get_theme_mod('gymx_wc_upsell', 'no') != 'yes'){
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
	}

	// Toggle Related Products
	if(get_theme_mod('gymx_wc_related', 'yes') == 'no'){
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
	}

	// Toggle Add to Cart Button
	if(get_theme_mod('gymx_wc_add_to_cart', 'no') != 'yes'){
		add_action('init','woocommerce_remove_loop_button');
	}

	// Remove Cart Cross Sells
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

	//change tab position to be inside summary
	remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
	add_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 1);

	// Remove WooCommerce Prettyphoto Style
	function gymx_woo_remove_styles() {
		wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		wp_dequeue_script( 'select2' );
	}
	add_action( 'wp_enqueue_scripts', 'gymx_woo_remove_styles', 99 );

	// Add Custom Pagination
	remove_action('woocommerce_pagination', 'woocommerce_pagination', 10);
	function woocommerce_pagination() {
		gymx_paging_nav(); 		
	}
	add_action( 'woocommerce_pagination', 'woocommerce_pagination', 10);

	// Ajaxfiy WooCommerce Cart
	function woocommerce_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;
		
		ob_start(); ?>
		<a href="<?php echo esc_url(wc_get_cart_url()); ?>" id="shopping-btn" class="cart-contents"><i class="im im-Shopping-Cart"></i><?php if ( sizeof( $woocommerce->cart->cart_contents ) != 0 ) { ?><span><?php echo esc_html($woocommerce->cart->cart_contents_count); ?></span><?php } ?></a>
		<?php
		
		$fragments['a.cart-contents'] = ob_get_clean();
		
		return $fragments;
	}
	add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

	// Remove Add to Cart Button
	function woocommerce_remove_loop_button(){
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	}

	// Add Second Image on Hover by http://jameskoster.co.uk
	// License: GNU General Public License v3.0
	if ( ! class_exists( 'WC_pif' ) ) {

		class WC_pif {

			public function __construct() {
				//add_action( 'wp_enqueue_scripts', array( $this, 'pif_scripts' ) );														// Enqueue the styles
				add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'woocommerce_template_loop_second_product_thumbnail' ), 11 );
				add_filter( 'post_class', array( $this, 'product_has_gallery' ) );
			}

			// Add pif-has-gallery class to products that have a gallery
			function product_has_gallery( $classes ) {
				global $product;
				$post_type = get_post_type( get_the_ID() );
				if ( ! is_admin() ) {
					if ( $post_type == 'product' ) {
						$attachment_ids = $product->get_gallery_image_ids();
						if ( $attachment_ids ) {
							$classes[] = 'pif-has-gallery';
						}
					}
				}
				return $classes;
			}

			// Display the second thumbnails
			function woocommerce_template_loop_second_product_thumbnail() {
				global $product, $woocommerce;

				$attachment_ids = $product->get_gallery_image_ids();

				if ( $attachment_ids ) {
					$secondary_image_id = $attachment_ids['0'];
					echo wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'secondary-image attachment-shop-catalog' ) );
				}
			}

		}

		$WC_pif = new WC_pif();
	}