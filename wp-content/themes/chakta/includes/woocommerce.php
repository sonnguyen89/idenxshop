<?php

/*************************************************
## Woocommerce 
*************************************************/

function chakta_product_image(){
	$att=get_post_thumbnail_id();
	$image_src = wp_get_attachment_image_src( $att, 'full' );
	$image_src = $image_src[0];

	$size = get_theme_mod( 'chakta_product_image_size', array( 'width' => '', 'height' => '') );

	if($size['width'] && $size['height']){
		$image = chakta_resize( $image_src, $size['width'], $size['height'], true, true, true );  
	} else {
		$image = $image_src;
	}
	
	return esc_url($image);
}

function chakta_sale_percentage(){
	global $product;

	if ( $product->is_on_sale() && $product->is_type( 'variable' ) ) {
		$percentage = ceil(100 - ($product->get_variation_sale_price( 'max' ) / $product->get_variation_regular_price( 'min' )) * 100);
	} elseif( $product->is_on_sale() && $product->get_regular_price() ) {
		$percentage = ceil(100 - ($product->get_sale_price() / $product->get_regular_price()) * 100);
	}
	
	if($product->is_on_sale() && $product->get_regular_price()){
		return '<span class="span off">-'.$percentage.'%</span>';
	}
}

function chakta_vendor_name(){
	if (function_exists('get_wcmp_vendor_settings')) {
		global $post;
		$vendor = get_wcmp_product_vendors($post->ID);
		if (isset($vendor->page_title)) {
			$store_name = $vendor->page_title;
			return '<div class="klb-vendor-name"><a href="'.esc_url($vendor->permalink).'">'.esc_html($store_name).'</a></div>';
		}
	}
}

if ( class_exists( 'woocommerce' ) ) {
add_theme_support( 'woocommerce' );
add_image_size('chakta-woo-product', 450, 450, true);

// Remove woocommerce defauly styles
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

// hide default shop title anasayfadaki title gizlemek için
add_filter('woocommerce_show_page_title', 'chakta_override_page_title');
function chakta_override_page_title() {
return false;
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 ); /*remove result count above products*/
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 ); //remove rating
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 ); //remove rating
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title',10);

add_action( 'woocommerce_before_shop_loop_item', 'chakta_shop_thumbnail', 10);
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 ); /*remove breadcrumb*/

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products',20);
remove_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products',10);
add_action( 'woocommerce_after_single_product_summary', 'chakta_related_products', 20);

function chakta_related_products(){
	$related_column = get_theme_mod('chakta_shop_related_post_column') ? get_theme_mod('chakta_shop_related_post_column') : '4';
    woocommerce_related_products( array('posts_per_page' => $related_column, 'columns' => $related_column));
}

/*----------------------------
  Vendor Info Widget
 ----------------------------*/
add_action('extra_vendor_info_widget','chakta_vendor_info',10);
function chakta_vendor_info(){
	global $post;
	$vendor = get_wcmp_product_vendors($post->ID);

	$vendor_fb_profile = get_user_meta($vendor->id, '_vendor_fb_profile', true);
	$vendor_twitter_profile = get_user_meta($vendor->id, '_vendor_twitter_profile', true);
	$vendor_linkdin_profile = get_user_meta($vendor->id, '_vendor_linkdin_profile', true);
	$vendor_google_plus_profile = get_user_meta($vendor->id, '_vendor_google_plus_profile', true);
	$vendor_youtube = get_user_meta($vendor->id, '_vendor_youtube', true);
	$vendor_instagram = get_user_meta($vendor->id, '_vendor_instagram', true);
	$store_name = $vendor->page_title;

	$output = '';
	$output .= '<div class="store-detail-box">';
	if($vendor->image){
		$output .= '<img class="img-responsive" src="'.esc_url(wp_get_attachment_url( $vendor->image )).'" alt="'.esc_attr($store_name).'">';
	}
	$output .= '<h4><a href="#">'.esc_html($store_name).'</a></h4>';
	$output .= '<div class="mail-box"><a href="mailto:'.esc_attr($vendor->user_data->user_email).'">'.esc_html($vendor->user_data->user_email).'</a></div>';
	$output .= '<div class="social">';
	$output .= '<ul class="link">';
	if ($vendor_fb_profile) {
		$output .= '<li class="fb"><a target="_blank" rel="nofollow" href="'.esc_url($vendor_fb_profile).'" title="'.esc_attr__('Facebook','chakta').'"><i class="fab fa-facebook-f"></i></a></li>';
	}
	if ($vendor_twitter_profile) {
		$output .= '<li class="tw"><a target="_blank" rel="nofollow" href="'.esc_url($vendor_twitter_profile).'" title="'.esc_attr__('Twitter','chakta').'"><i class="fab fa-twitter"></i></a></li>';
	}
	
	if ($vendor_linkdin_profile) {
		$output .= '<li class="linkedin"><a target="_blank" rel="nofollow" href="'.esc_url($vendor_linkdin_profile).'" title="'.esc_attr__('linkedin','chakta').'"><i class="fab fa-linkedin"></i></a></li>';
	}
	if ($vendor_youtube) {
		$output .= '<li class="youtube"><a target="_blank" rel="nofollow" href="'.esc_url($vendor_youtube).'" title="'.esc_attr__('youtube','chakta').'"><i class="fab fa-youtube"></i></a></li>';
	}
	if ($vendor_instagram) {
		$output .= '<li class="instagram"><a target="_blank" rel="nofollow" href="'.esc_url($vendor_instagram).'" title="'.esc_attr__('instagram','chakta').'"><i class="fab fa-instagram"></i></a></li>';
	}

	$output .= '</ul>';
	$output .= '</div>';
	$output .= '<p>'.chakta_sanitize_data($vendor->description).'</p>';
	$output .= '</div>';

	echo chakta_sanitize_data($output);
}

/*************************************************
## Re-order WooCommerce Single Product Summary
*************************************************/
$reorder_single = get_theme_mod( 'chakta_shop_single_reorder', 
	array( 
		'woocommerce_template_single_title', 
		'woocommerce_template_single_rating', 
		'woocommerce_template_single_price', 
		'woocommerce_template_single_excerpt',
		'klb_vehicle_details', 		
		'woocommerce_template_single_add_to_cart', 
		'woocommerce_template_single_meta', 
		'chakta_social_share', 
	) 
);

if($reorder_single){
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	remove_action( 'woocommerce_single_product_summary', 'klb_vehicle_details', 25 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	remove_action( 'woocommerce_single_product_summary', 'chakta_social_share', 70);
	
	$count = 7;
	
	foreach ( $reorder_single as $single_part ) {
		
		add_action( 'woocommerce_single_product_summary', $single_part, $count );
		
		$count+=7;
	}
}

/*----------------------------
  Product Type 1
 ----------------------------*/
function chakta_product_type1(){
	global $product;
	global $post;
	global $woocommerce;
	
	$output = '';
	
	$id = get_the_ID();
	$allproduct = wc_get_product( get_the_ID() );
	
	$att=get_post_thumbnail_id();
	$image_src = wp_get_attachment_image_src( $att, 'full' );
	$image_src = $image_src[0];

	$size = get_theme_mod( 'chakta_product_image_size', array( 'width' => '', 'height' => '') );

	if($size['width'] && $size['height']){
		$imageresize = chakta_resize( $image_src, $size['width'], $size['height'], true, true, true );  
	} else {
		$imageresize = $image_src;
	}

	$cart_url = wc_get_cart_url();
	$price = $allproduct->get_price_html();
	$weight = $product->get_weight();
	$stock_status = $product->get_stock_status();
	$stock_text = $product->get_availability();
	$rating = wc_get_rating_html($product->get_average_rating());
	$ratingcount = $product->get_review_count();
	$wishlist = get_theme_mod( 'chakta_wishlist_button', '0' );
	$compare = get_theme_mod( 'chakta_compare_button', '0' );
	$quickview = get_theme_mod( 'chakta_quick_view_button', '0' );
	
	$postview  = isset( $_POST['shop_view'] ) ? $_POST['shop_view'] : '';

	if(chakta_shop_view() == 'list_view' || get_theme_mod('chakta_view_type') == 'list-view' || $postview == 'list_view' && chakta_shop_view() != 'grid_view') {
		$output .= '<div class="klb-product-list shop-item mb-30">';
		$output .= '<div class="row klb-product">';
		$output .= '<div class="col-xl-4 col-lg-4 ">';
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
		$output .= '</div>';
		$output .= '<div class="col-xl-8 col-lg-8">';
		
		$output .= '<div class="shop-content">';
		$output .= $rating;
		$output .= '<h3 class="title"><a href="'.get_permalink().'" title="'.the_title_attribute( 'echo=0' ).'">'.get_the_title().'</a></h3>';
		$output .= '<p class="price">'.$price.'</p>';
		$output .= '<p>'.chakta_limit_words(get_the_excerpt(), '20').'</p>';
		$output .= '<a href="'.get_permalink().'" class="main-btn" title="'.the_title_attribute( 'echo=0' ).'">'.esc_html__('Shop Now','chakta').'</a>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
	} else {
		
		$output .= '<div class="shop-item mb-30">';
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
		$output .= '<div class="shop-content">';
		$output .= $rating;
		$output .= '<h3 class="title"><a href="'.get_permalink().'" title="'.the_title_attribute( 'echo=0' ).'">'.get_the_title().'</a></h3>';
		$output .= '<p class="price">'.$price.'</p>';
		$output .= '</div>';
		$output .= '</div>';
	}

	
	return $output;
}


/*----------------------------
  Add my owns
 ----------------------------*/
function chakta_shop_thumbnail () {
	echo chakta_product_type1();
}

/*************************************************
## Woocommerce Cart Text
*************************************************/

//add to cart button
function chakta_add_to_cart_button(){
	global $product;
	$output = '';

	ob_start();
	woocommerce_template_loop_add_to_cart();
	$output .= ob_get_clean();

	if(!empty($output)){
		$pos = strpos($output, ">");
		
		if ($pos !== false) {
		    $output = substr_replace($output,">", $pos , strlen(1));
		}
	}
	
	if($product->get_type() == 'variable' && empty($output)){
		$output = "<a class='btn btn-primary add-to-cart cart-hover' href='".get_permalink($product->id)."'>".esc_html__('Select options','chakta')."</a>";
	}

	if($product->get_type() == 'simple'){
		$output .= "";
	} else {
		$btclass  = "single_bt";
	}
	
	if($output) return "$output";
}



/*************************************************
## Woo Cart Ajax
*************************************************/ 

add_filter('woocommerce_add_to_cart_fragments', 'chakta_header_add_to_cart_fragment');
function chakta_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	
	<span class="cart-count"> <?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'chakta'), $woocommerce->cart->cart_contents_count);?> </span>
	

	<?php
	$fragments['span.cart-count'] = ob_get_clean();

	return $fragments;
}

add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {

    ob_start();
    ?>

    <div class="fl-mini-cart-content">
        <?php woocommerce_mini_cart(); ?>
    </div>

    <?php $fragments['div.fl-mini-cart-content'] = ob_get_clean();

    return $fragments;

} );

/*************************************************
## Chakta Woo Search Form
*************************************************/ 

add_filter( 'get_product_search_form' , 'chakta_custom_product_searchform' );

function chakta_custom_product_searchform( $form ) {

	$form = '<form class="product-search-form" action="' . esc_url( home_url( '/'  ) ) . '" role="search" method="get" id="searchform">
				<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search','chakta').'">
				<button type="submit"><i class="far fa-search"></i></button>
                <input type="hidden" name="post_type" value="product" />
			</form>';

	return $form;
}

function chakta_header_product_search() {

	$form = '<form class="header-search-form" action="' . esc_url( home_url( '/'  ) ) . '" role="search" method="get" id="searchform">
				<div class="form_group">
					<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search','chakta').'">
					<button type="submit"><i class="far fa-search"></i></button>
					<input type="hidden" name="post_type" value="product" />
				</div>
			</form>';

	return $form;
}





/*************************************************
## Chakta Gallery Thumbnail Size
*************************************************/ 
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
    return array(
        'width' => 90,
        'height' => 54,
        'crop' => 0,
    );
} );


/*************************************************
## Quick View Scripts
*************************************************/ 

function chakta_quick_view_scripts() {
  	wp_enqueue_script( 'chakta-quick-ajax', get_template_directory_uri() . '/assets/js/custom/quick_ajax.js', array('jquery'), '1.0.0', true );
	wp_localize_script( 'chakta-quick-ajax', 'MyAjax', array(
		'ajaxurl' => esc_url(admin_url( 'admin-ajax.php' )),
	));
}
add_action( 'wp_enqueue_scripts', 'chakta_quick_view_scripts' );

/*************************************************
## Quick View CallBack
*************************************************/ 

add_action( 'wp_ajax_nopriv_quick_view', 'chakta_quick_view_callback' );
add_action( 'wp_ajax_quick_view', 'chakta_quick_view_callback' );
function chakta_quick_view_callback() {

	global $wpdb,$post; // this is how you get access to the database
	$id = intval( $_POST['id'] );
	$loop = new WP_Query( array(
		'post_type' => 'product',
		'p' => $id,
	  )
	);
	
	while ( $loop->have_posts() ) : $loop->the_post(); 
	$product = new WC_Product(get_the_ID());
	
	$rating = wc_get_rating_html($product->get_average_rating());
	$price = $product->get_price_html();
	$rating_count = $product->get_rating_count();
	$review_count = $product->get_review_count();
	$average      = $product->get_average_rating();
	$product_image_ids = $product->get_gallery_attachment_ids();

	$output = '';
 
			
		$output .= '<div class="ajax_quick_view product">';
		$output .= '<div class="row">';
		if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {
			$count = 0;
			$number = 0;
			
			$att=get_post_thumbnail_id();
			$image_src = wp_get_attachment_image_src( $att, 'full' );
			$image_src = $image_src[0];
			$output .= '<div class="col-lg-6 col-md-6 mb-4 mb-md-0">';
			

			
			$output .= '<div class="product-details-img">';
			$output .= '<div class="tab-content" id="myTabContent2">';
			
				$output .= '<div class="tab-pane fade show active" id="home" role="tabpanel">';
				$output .= '<div class="product-large-img">';
				$output .= '<img src="'.esc_url($image_src).'" alt="'.the_title_attribute( 'echo=0' ).'">';
				$output .= '</div>';
				$output .= '</div>';
			
			foreach( $product_image_ids as $product_image_id ){
				$image_url = wp_get_attachment_url( $product_image_id );
				if($number < 2 ){
				$output .= '<div class="tab-pane fade show " id="home'.esc_attr($number).'" role="tabpanel">';
				$output .= '<div class="product-large-img">';
				$output .= '<img src="'.esc_url($image_url).'" alt="'.the_title_attribute( 'echo=0' ).'">';
				$output .= '</div>';
				$output .= '</div>';
				}
				$number++;
			}

			$output .= '</div>';
			$output .= '</div>';
			
			
			$output .= '<div class="shop-thumb-tab">';
			$output .= '<ul class="nav" id="myTab2" role="tablist">';
			
			$output .= '<li class="nav-item">';
			$output .= '<a class="active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-selected="true">';
			$output .= '<img src="'.esc_url($image_src).'" alt="'.the_title_attribute( 'echo=0' ).'">';
			$output .= '</a>';
			$output .= '</li>';
			
			foreach( $product_image_ids as $product_image_id ){
				$image_url = wp_get_attachment_url( $product_image_id );
				if($count < 2){
				$output .= '<li class="nav-item">';
				$output .= '<a class="" id="home'.esc_attr($count).'-tab" data-toggle="tab" href="#home'.esc_attr($count).'" role="tab" aria-selected="false">';
				$output .= '<img src="'.esc_url($image_url).'" alt="'.the_title_attribute( 'echo=0' ).'">';
				$output .= '</a>';
				$output .= '</li>';
				}
				$count++;
			}

			$output .= '</ul>';
			$output .= '</div>';
			

			$output .= '</div>';
		}
		
		$output .= '<div class="col-lg-6 col-md-6">';
		$output .= '<div class="pr_detail">';
		$output .= '<div class="product_description">';
		$output .= '<h4 class="product_title"><a href="'.get_permalink().'" title="'.the_title_attribute( 'echo=0' ).'">'.get_the_title().'</a></h4>';
		$output .= '<div class="product_price">';
		$output .= $price;
		$output .= '</div>';
		$output .= '<div class="rating_wrap">';
		$output .= $rating;
		if($ratingcount){
		$output .= '<span class="rating_num">('.$review_count.')</span>';
		}
		$output .= '</div>';
		$output .= '<div class="pr_desc">';
		$output .= '<p>'.get_the_excerpt().'</p>';
		$output .= '</div>';

		$output .= '</div>';

		$output .= '<div class="cart_extra">';
		$output .= '<div class="cart_btn">';
		ob_start();
		woocommerce_template_single_add_to_cart();
		$output .= ob_get_clean();
		$output .= '</div>';
		$output .= '</div>';

		ob_start();
		woocommerce_template_single_meta();
		$output .= ob_get_clean();
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';



		endwhile; 
		wp_reset_postdata();

	 	$output_escaped = $output;
	 	echo $output_escaped;
		
		wp_die();

}

/*************************************************
## Chakta Filter by Attribute
*************************************************/ 
function chakta_woocommerce_layered_nav_term_html( $term_html, $term, $link, $count ) { 

	$attribute_label_name = wc_attribute_label($term->taxonomy);;
	$attribute_id = wc_attribute_taxonomy_id_by_name($attribute_label_name);
	$attr  = wc_get_attribute($attribute_id);
	$array = json_decode(json_encode($attr), true);

	if(in_array('color',$array)){
		$color = get_term_meta( $term->term_id, 'product_attribute_color', true );
		$term_html = '<div class="type-color"><span class="color-box" style="background-color:'.esc_attr($color).';"></span>'.$term_html.'</div>';
	}
	
	if(in_array('button',$array)){
		$term_html = '<div class="type-button"><span class="button-box"></span>'.$term_html.'</div>';
	}

    return $term_html; 
}; 
         
add_filter( 'woocommerce_layered_nav_term_html', 'chakta_woocommerce_layered_nav_term_html', 10, 4 ); 

/*************************************************
## Stock Availability Translation
*************************************************/ 

if(get_theme_mod('chakta_stock_quantity',0) != 1){
add_filter( 'woocommerce_get_availability', 'chakta_custom_get_availability', 1, 2);
function chakta_custom_get_availability( $availability, $_product ) {
    
    // Change In Stock Text
    if ( $_product->is_in_stock() ) {
        $availability['availability'] = esc_html__('In Stock', 'chakta');
    }
    // Change Out of Stock Text
    if ( ! $_product->is_in_stock() ) {
        $availability['availability'] = esc_html__('Out of stock', 'chakta');
    }
    return $availability;
}
}


} // is woocommerce activated

?>