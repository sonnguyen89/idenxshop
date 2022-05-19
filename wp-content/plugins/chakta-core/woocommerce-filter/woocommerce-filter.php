<?php

/*************************************************
## Get options
*************************************************/
function chakta_ft(){	
	$getft  = isset( $_GET['ft'] ) ? $_GET['ft'] : '';

	return esc_html($getft);
}

/*************************************************
## Filter Scripts
*************************************************/
function chakta_custom_scripts() {
	wp_register_style( 'klb-mobile-filter',  			  plugins_url( 'mobile-filter/css/mobile-filter.css', __FILE__ ), false, '1.0');	
	wp_register_script( 'klb-mobile-filter',			  plugins_url( 'mobile-filter/js/mobile-filter.js', __FILE__ ), true );
	wp_register_style( 'klb-widget-product-categories',   plugins_url( 'widgets/product-categories/css/widget-product-categories.css', __FILE__ ), false, '1.0');	
	wp_register_script( 'klb-widget-product-categories',  plugins_url( 'widgets/product-categories/js/widget-product-categories.js', __FILE__ ), true );
	wp_register_style( 'klb-remove-filter',   plugins_url( 'grid-list/css/remove-filter.css', __FILE__ ), false, '1.0');
}
add_action( 'wp_enqueue_scripts', 'chakta_custom_scripts' );


/* Product Categories Widget */
require_once( __DIR__ . '/widgets/product-categories/widget-product-categories.php');

/* Product Status Widget */
require_once( __DIR__ . '/widgets/product-status/widget-product-status.php');

/* Grid List View */
require_once( __DIR__ . '/grid-list/grid-list-view.php' );

/* Mobile Filter */
require_once( __DIR__ . '/mobile-filter/mobile-filter.php' );

/* Load More */
require_once( __DIR__ . '/load-more/load-more.php' );

/* Single Ajax */
if(get_theme_mod('chakta_shop_single_ajax_addtocart') == 1){
	require_once( __DIR__ . '/single-ajax/single-ajax.php' );
}

/* Product Data Tabs*/
require_once( __DIR__ . '/product-data/product-data-video.php' );

/* Image Zoom */
require_once( __DIR__ . '/image-zoom/image-zoom.php' );

/* Product360 View */
if(get_theme_mod('chakta_shop_single_product360',0) == 1){
	require_once( __DIR__ . '/product360/product360.php' );
}

/* Single Products Navigation */
if(get_theme_mod('chakta_products_navigation',0) == 1){
	require_once( __DIR__ . '/single-products-navigation/single-products-navigation.php' );
}

/* Recently Viewed */
if(get_theme_mod('chakta_recently_viewed_products',0) == 1){
	require_once( __DIR__ . '/recently-viewed/recently-viewed.php' );
}

/* Min/Max Quantity */
if(get_theme_mod('chakta_min_max_quantity',0) == 1){
	require_once( __DIR__ . '/minmax-quantity/minmax-quantity.php' );
}

/*************************************************
## Chakta Stock Status
*************************************************/ 
function chakta_stock_status(){
	$stock_status  = isset( $_GET['stock_status'] ) ? $_GET['stock_status'] : '';

	if($stock_status == 'instock'){
		return $stock_status;
	}
}

/*************************************************
## Chakta on Sale
*************************************************/ 
function chakta_on_sale(){
	$on_sale  = isset( $_GET['on_sale'] ) ? $_GET['on_sale'] : '';

	if($on_sale == 'onsale'){
		return $on_sale;
	}
}

/*************************************************
## Chakta GET Cat URL
*************************************************/ 
function chakta_get_cat_url($termid){
	global $wp;
	if ( '' === get_option( 'permalink_structure' ) ) {
		$link = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
	} else {
		$link = preg_replace( '%\/page/[0-9]+%', '', add_query_arg( null, null ) );
	}

	if(isset($_GET['filter_cat'])){
		$explode_old = explode(',',$_GET['filter_cat']);
		$explode_termid = explode(',',$termid);
		
		if(in_array($termid, $explode_old)){
			$data = array_diff( $explode_old, $explode_termid);
			$checkbox = 'checked';
		} else {
			$data = array_merge($explode_termid , $explode_old);
		}
	} else {
		$data = array($termid);
	}
	
	$dataimplode = implode(',',$data);
	
	if(empty($dataimplode)){
		$link = remove_query_arg('filter_cat',$link);
	} else {
		$link = add_query_arg('filter_cat',implode(',',$data),$link);
	}
	
	return $link;
}

/*************************************************
## Chakta Remove Filter
*************************************************/ 
function chakta_remove_klb_filter(){
	
	$output = '';

	$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();

	if(! empty( $_chosen_attributes ) || isset($_GET['filter_cat']) || chakta_stock_status() == 'instock' || chakta_on_sale() == 'onsale'){

		global $wp;
	
		if ( '' === get_option( 'permalink_structure' ) ) {
			$baselink = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
		} else {
			$baselink = preg_replace( '%\/page/[0-9]+%', '', home_url( add_query_arg( null, null ) ) );
		}

		$output .= '<ul class="remove-filter">';
		
		if ( ! empty( $_chosen_attributes ) ) {
			foreach ( $_chosen_attributes as $taxonomy => $data ) {
				foreach ( $data['terms'] as $term_slug ) {
					$term = get_term_by( 'slug', $term_slug, $taxonomy );
					
					$filter_name    = 'filter_' . wc_attribute_taxonomy_slug( $taxonomy );
					$explode_old = explode(',',$_GET[$filter_name]);
					$explode_termid = explode(',',$term->slug);
					$klbdata = array_diff( $explode_old, $explode_termid);
					$klbdataimplode = implode(',',$klbdata);
					
					if(empty($klbdataimplode)){
						$link = remove_query_arg($filter_name);
					} else {
						$link = add_query_arg($filter_name,implode(',',$klbdata),$baselink );
					}

					$output .= '<li><a href="'.esc_url($link).'" class="remove-filter-element attributes">'.esc_html($term->name).'</a></li>';

				}
			}
		}

		if(chakta_stock_status() == 'instock'){
		$output .= '<li><a href="'.esc_url(remove_query_arg('stock_status')).'" class="remove-filter-element stock_status">'.esc_html__('In Stock','chakta-core').'</a></li>';
		}
		
		if(chakta_on_sale() == 'onsale'){
		$output .= '<li><a href="'.esc_url(remove_query_arg('on_sale')).'" class="remove-filter-element on_sale">'.esc_html__('On Sale','chakta-core').'</a></li>';
		}
		
		if(isset($_GET['filter_cat'])){
			$terms = get_terms( array(
				'taxonomy' => 'product_cat',
				'hide_empty' => false,
				'parent'    => 0,
				'include' 	=> explode(',',$_GET['filter_cat']),
			) );
			
			foreach ( $terms as $term ) {
				$term_children = get_term_children( $term->term_id, 'product_cat' );
				$output .= '<li><a href="'.esc_url( chakta_get_cat_url($term->term_id) ).'" class="remove-filter-element product_cat" id="'.esc_attr($term->term_id).'">'.esc_html($term->name).'</a></li>';
				if($term_children){
					foreach($term_children as $child){
						$childterm = get_term_by( 'id', $child, 'product_cat' );
						if(in_array($childterm->term_id, explode(',',$_GET['filter_cat']))){ 
							$output .= '<li><a href="'.esc_url( chakta_get_cat_url($childterm->term_id) ).'" class="remove-filter-element product_cat" id="'.esc_attr($childterm->term_id).'">'.esc_html($childterm->name).'</a></li>';
						}
					}
				}
			}
		
		}
		
		$output .= '</ul>';
	}
	
	return $output;
}

/*************************************************
## Chakta Product Query
*************************************************/ 
function chakta_product_query( $q ){
	if(chakta_stock_status() == 'instock'){
		$q->set( 'meta_query', array (
			array(
				'meta_key' 	=> '_stock_status',
				'value' 	=> 'instock',
			)
		));
	}
	
	if(chakta_on_sale() == 'onsale'){
		$q->set ( 'post__in', wc_get_product_ids_on_sale() );
	}

}
add_action( 'woocommerce_product_query', 'chakta_product_query', 10, 2 );


/*************************************************
## Chakta Product Tax Query
*************************************************/ 
function chakta_woocommerce_product_query_tax_query( $tax_query, $instance ) {
	
	if(isset($_GET['filter_cat'])){
		if(!empty($_GET['filter_cat'])){
			$tax_query[] = array(
				'taxonomy' => 'product_cat',
				'field' 	=> 'id',
				'terms' 	=> explode(',',$_GET['filter_cat']),
			);
		}
	}
	
    return $tax_query; 
}; 
add_filter( 'woocommerce_product_query_tax_query', 'chakta_woocommerce_product_query_tax_query', 10, 2 );

/*************************************************
## Chakta Current Page URL
*************************************************/ 
add_filter( 'woocommerce_widget_get_current_page_url', 'chakta_current_page_url', 10, 2 );
function chakta_current_page_url( $link, $that ){
	if ( isset( $_GET['filter_cat'] ) ) {
		$link = add_query_arg( 'filter_cat', wc_clean( wp_unslash( $_GET['filter_cat'] ) ), $link );
	}

	if ( isset( $_GET['shop_view'] ) ) {
		$link = add_query_arg( 'shop_view', wc_clean( wp_unslash( $_GET['shop_view'] ) ), $link );
	}

	if ( isset( $_GET['on_sale'] ) ) {
		$link = add_query_arg( 'on_sale', wc_clean( wp_unslash( $_GET['on_sale'] ) ), $link );
	}
	
	if ( isset( $_GET['stock_status'] ) ) {
		$link = add_query_arg( 'stock_status', wc_clean( wp_unslash( $_GET['stock_status'] ) ), $link );
	}
	
	return $link;
}