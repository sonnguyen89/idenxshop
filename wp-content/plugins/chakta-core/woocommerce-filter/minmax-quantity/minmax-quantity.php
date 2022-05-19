<?php

/*************************************************
## Admin style and scripts  
*************************************************/ 
function klb_admin_styles() {
	wp_enqueue_script( 'klb-gdpr', 	 plugin_dir_url( __FILE__ )  . '/js/minmax-quantity.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'klb_admin_styles');

/*************************************************
## Quantity Data Fields
*************************************************/
add_action( 'woocommerce_product_options_general_product_data', 'chakta_woocommerce_quantity_data_fields' );
function chakta_woocommerce_quantity_data_fields() {
	
	echo '<div class="options_group show_if_simple show_if_variable">';
	
	woocommerce_wp_checkbox([
		'id' => '_klb_quantity_check',
		'label' => esc_html__('Quantity Settings', 'chakta-core'),
		'wrapper_class' => 'show_if_simple show_if_variable hide_if_grouped',
		'description' => esc_html__( 'Enable this to show and enable the additional quantity setting fields.', 'chakta-core' ),
	]);
	
	echo '<div class="quantity_fields show_if_simple show_if_variable">';
	
	woocommerce_wp_text_input([
		'id' => '_klb_min_quantity',
		'label' => esc_html__('Minimum Quantity', 'chakta-core'),
		'wrapper_class' => 'show_if_simple show_if_variable hide_if_grouped',
		'desc_tip'    => true,
		'description' => esc_html__( 'Set a minimum allowed quantity limit (a number greater than 0).', 'chakta-core' ),
	]);
	
	woocommerce_wp_text_input([
		'id' => '_klb_max_quantity',
		'label' => esc_html__('Maximum Quantity', 'chakta-core'),
		'wrapper_class' => 'show_if_simple hide_if_variable hide_if_grouped',
		'desc_tip'    => true,
		'description' => esc_html__( 'Set the maximum allowed quantity limit (a number greater than 0).', 'chakta-core' ),
	]);
	
	woocommerce_wp_text_input([
		'id' => '_klb_step_quantity',
		'label' => esc_html__('Quantity Step', 'chakta-core'),
		'wrapper_class' => 'show_if_simple show_if_variable hide_if_grouped',
		'desc_tip'    => true,
		'description' => esc_html__( 'Optional. Set quantity step (a number greater than 0).', 'chakta-core' ),
	]);
	
	echo '</div>';
	echo '</div>';
}

add_action('woocommerce_process_product_meta', function($post_id) {
	$product = wc_get_product($post_id);
	
	$product->update_meta_data('_klb_quantity_check', sanitize_text_field($_POST['_klb_quantity_check']));
	$product->update_meta_data('_klb_min_quantity', sanitize_text_field($_POST['_klb_min_quantity']));
	$product->update_meta_data('_klb_max_quantity', sanitize_text_field($_POST['_klb_max_quantity']));
	$product->update_meta_data('_klb_step_quantity', sanitize_text_field($_POST['_klb_step_quantity']));
 

	$product->save();
});

/*************************************************
## Add to Cart Quantity
*************************************************/

function chakta_loop_add_to_cart_args( $args, $product ) {
	if ( $product ) {
		$args['quantity'] = chakta_min_quantity($product);
	}

	return $args;
}
add_filter( 'woocommerce_loop_add_to_cart_args', 'chakta_loop_add_to_cart_args', 10, 2 );

/*************************************************
## Quantity Input Args
*************************************************/

add_filter( 'woocommerce_quantity_input_args', 'chakta_woocommerce_quantity_input_args', 10, 2 ); // Simple products
function chakta_woocommerce_quantity_input_args( $args, $product ) {
	if ( is_singular( 'product' ) ) {
		if ( substr( $args['input_name'], 0, 8 ) === 'quantity' ) {
			// check if isn't in the cart
			$args['input_value'] = chakta_step_quantity($product);
		}
	}
	$args['product_id'] = $product->get_id();
	
	$args['max_value'] 	= chakta_max_quantity($product); 	// Maximum value
	$args['min_value'] 	= chakta_min_quantity($product);   	// Minimum value
	$args['step'] 		= chakta_step_quantity($product);    // Quantity steps
	
	return $args;
}

/*************************************************
## Quantity Input Args Variable
*************************************************/

add_filter( 'woocommerce_available_variation', 'chakta_woocommerce_available_variation' ); // Variations
function chakta_woocommerce_available_variation( $args ) {
	global $product;
	
	$args['max_qty'] = chakta_max_quantity($product); 		// Maximum value (variations)
	$args['min_qty'] = chakta_min_quantity($product);   	// Minimum value (variations)
	return $args;
}

/*************************************************
## Min Quantity
*************************************************/

function chakta_min_quantity($product){
	$min_quantity = $product->get_meta('_klb_min_quantity');
	
	$quantity = 0 < $min_quantity ? $min_quantity : '1';
	
	return $quantity;
}

/*************************************************
## Max Quantity
*************************************************/

function chakta_max_quantity($product){
	$max_quantity = $product->get_meta('_klb_max_quantity');
	$max_value    = ($product->get_max_purchase_quantity() > 0) ? $product->get_max_purchase_quantity() : '';
	
	if ( ( $max_value > 0 ) && ( $max_quantity > $max_value ) ) {
		$max_quantity = $max_value;
	}
	
	if ( !$max_quantity) {
		$max_quantity = $max_value;
	}
	
	return $max_quantity;
}

/*************************************************
## Step Quantity
*************************************************/

function chakta_step_quantity($product){
	$step_quantity = $product->get_meta('_klb_step_quantity');
	
	$quantity = 0 < $step_quantity ? $step_quantity : '1';
	
	return $quantity;
}
