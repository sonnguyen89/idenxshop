<?php

/*************************************************
## Scripts
*************************************************/
function chakta_products_navigation_scripts() {
	wp_enqueue_style( 'klb-products-navigation',   plugins_url( 'css/single-products-navigation.css', __FILE__ ), false, '1.0');

}
add_action( 'wp_enqueue_scripts', 'chakta_products_navigation_scripts' );

/*************************************************
## Single Product Nav
*************************************************/ 

if ( ! function_exists( 'chakta_product_nav' ) ) {
	function chakta_product_nav() {
		
?>

		<div class="klb-products-nav">
			<?php 
				$prev_post = get_next_post();
				if($prev_post) {
					$prev_title = strip_tags(str_replace('"', '', $prev_post->post_title));
					$prevPrice = wc_get_product( $prev_post );
			
			?>		
				<div class="product-btn product-prev">			
					<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>"><span class="product-btn-icon"></span></a>			
					<div class="wrapper-short">
						<div class="product-short">
							<div class="product-short-image">
								<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="product-thumb">
									<?php echo apply_filters( 'chakta_products_nav_image', get_the_post_thumbnail( $prev_post ) ); ?>
								</a>
							</div>
							<div class="product-short-description">
								<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="klb-entities-title">
									<?php echo get_the_title( $prev_post ); ?>
								</a>
								<span class="price">
									<?php echo wp_kses_post( $prevPrice->get_price_html() ); ?>
								</span>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			
			
				<a href="<?php echo ( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="klb-back-btn"></a>
			
			<?php 
				
				$next_post = get_previous_post();
				if($next_post) {		
					$next_title = strip_tags(str_replace('"', '', $next_post->post_title));
					$nextPrice = wc_get_product( $next_post );
			?>
				<div class="product-btn product-next">
					<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"><span class="product-btn-icon"></span></a>
					<div class="wrapper-short">
						<div class="product-short">
							<div class="product-short-image">
								<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="product-thumb">
									<?php echo apply_filters( 'chakta_products_nav_image', get_the_post_thumbnail( $next_post ) ); ?>
								</a>
							</div>
							<div class="product-short-description">
								<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="klb-entities-title">
									<?php echo get_the_title( $next_post ); ?>
								</a>
								<span class="price">
									<?php echo wp_kses_post( $nextPrice->get_price_html() ); ?>
								</span>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		
<?php
			
	}
}

add_action( 'woocommerce_single_product_summary', 'chakta_product_nav', 2 );