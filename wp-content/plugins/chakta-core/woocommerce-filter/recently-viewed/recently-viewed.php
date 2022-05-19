<?php

/*************************************************
## Recently Viewed Products Always
*************************************************/ 
function chakta_track_product_view() {
	if ( ! is_singular( 'product' )) {
		return;
	}

	global $post;

	if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) { // @codingStandardsIgnoreLine.
		$viewed_products = array();
	} else {
		$viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) ); // @codingStandardsIgnoreLine.
	}

	// Unset if already in viewed products list.
	$keys = array_flip( $viewed_products );

	if ( isset( $keys[ $post->ID ] ) ) {
		unset( $viewed_products[ $keys[ $post->ID ] ] );
	}

	$viewed_products[] = $post->ID;

	if ( count( $viewed_products ) > 15 ) {
		array_shift( $viewed_products );
	}

	// Store for session only.
	wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
}

remove_action( 'template_redirect', 'wc_track_product_view', 20 );
add_action( 'template_redirect', 'chakta_track_product_view', 20 );

/*************************************************
## Recently Viewed Products Loop
*************************************************/ 
function chakta_recently_viewed_product_loop(){
	$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array(); // @codingStandardsIgnoreLine
	$viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

	if ( empty( $viewed_products) || !is_woocommerce()) {
		return;
	}

	$args = array(
		'post_type' => 'product',
		'posts_per_page' => 3,
		'post__in'       => $viewed_products,
		'orderby'        => 'post__in',
		'post_status'    => 'publish',
	);
	
	$loop = new WP_Query( $args );
	
	echo '<section class="shop-grid-v2 recently-viewed pb-55">';
	echo '<div class="container">';
	echo '<div class="row justify-content-center">';
	echo '<div class="col-lg-12">';
	echo '<div class="section-title mb-45">';
	echo '<h2>'.esc_html__('Recently Viewed Products','chakta-core').'</h2>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	echo '<div class="row columns-2">';
	
	if ( $loop->have_posts() ) {
		while ( $loop->have_posts() ) : $loop->the_post();
			wc_get_template_part( 'content', 'product' );
		endwhile;
	} else {
		echo esc_html__( 'No products found', 'chakta-core');
	}
	
	echo '</div>';
	echo '</div>';
	echo '</section>';
	
	wp_reset_postdata();	
}
add_action('chakta_top_footer','chakta_recently_viewed_product_loop');