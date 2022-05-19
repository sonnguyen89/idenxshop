<?php

/*************************************************
## Vehicle Data Scripts
*************************************************/ 

function chakta_vehicle_data_scripts() {
    wp_enqueue_script( 'chakta-vehicle-data', plugins_url( 'js/vehicle-data.js', __FILE__ ), true );
	wp_localize_script( 'chakta-vehicle-data', 'MyAjax', array(
		'ajaxurl' => esc_url(admin_url( 'admin-ajax.php' )),
	));
}
add_action( 'admin_enqueue_scripts', 'chakta_vehicle_data_scripts' );
add_action( 'wp_enqueue_scripts', 'chakta_vehicle_data_scripts' );


/*************************************************
## Models Callback
*************************************************/ 

add_action( 'wp_ajax_klb_models', 'chakta_klb_models_callback' );
function chakta_klb_models_callback() {

	global $wpdb;

	$term_id = $_POST['selected_id'];
	$taxonomy_name = 'klb_make';
	$termchildren = get_term_children( $term_id, $taxonomy_name );
	foreach ( $termchildren as $child ) {
		$term = get_term_by( 'id', $child, $taxonomy_name );
		echo '<option value="'.$term->term_id.'">'.$term->name.'</option>';
		
	}
	wp_die();
}

/*************************************************
## Models Output Callback
*************************************************/ 
add_action( 'wp_ajax_nopriv_klb_models_output', 'chakta_klb_models_output_callback' );
add_action( 'wp_ajax_klb_models_output', 'chakta_klb_models_output_callback' );
function chakta_klb_models_output_callback() {

	global $wpdb;

	$term_id = $_POST['selected_id'];
	$taxonomy_name = 'klb_make';
	$termchildren = get_term_children( $term_id, $taxonomy_name );
	echo '<option value="">'.esc_html__('Select Model','chakta-core').'</option>';
	foreach ( $termchildren as $child ) {
		$term = get_term_by( 'id', $child, $taxonomy_name );
		echo '<option value="'.$term->term_id.'">'.$term->name.'</option>';
		
	}
	wp_die();
}

/*************************************************
## Get Makes Output
*************************************************/ 
function chakta_get_makes_output() {
	$terms = get_terms( array(
		'taxonomy' => 'klb_make',
		'hide_empty' => false,
		'parent'    => 0,
	) );
		
	echo '<option value="">'.esc_html__('Select Make','chakta-core').'</option>';
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		foreach ( $terms as $term ) {
			echo '<option value="'.$term->term_id.'">'.$term->name.'</option>';
		}
	}
}


/*************************************************
## Get Makes
*************************************************/ 
function chakta_get_makes() {
	$terms = get_terms( array(
		'taxonomy' => 'klb_make',
		'hide_empty' => false,
		'parent'    => 0,
	) );
		
	$options = array();
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		foreach ( $terms as $term ) {
			$options[ $term->term_id ] = $term->name;
		}
	}
	return $options;
}

/*************************************************
## Get Models
*************************************************/ 
function chakta_get_models() {
	$terms = get_terms( array(
		'taxonomy' => 'klb_make',
		'hide_empty' => false,
	) );
	
	$post_id = isset( $_GET['post'] ) ? $_GET['post'] : '';

	$options = array();
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		
		foreach ( $terms as $term ) {
			if( $term->parent == 0 ) {
				foreach( $terms as $subcategory ) {
					if($subcategory->parent == $term->term_id) {
						$options[ $subcategory->term_id ] = $subcategory->name;
					}
				}
			}
		}
	}

	return $options;
}

/*************************************************
## Get Years
*************************************************/ 
function chakta_get_years() {
	$options = array();
	
	$year = get_theme_mod('chakta_shop_year');
	
	if($year){
		foreach($year as $y){
			$options[ $y['year_data'] ] = $y['year_data'];
		}
	}
	return $options;

}

/*************************************************
## Get Years Output
*************************************************/ 
function chakta_get_years_output() {

	$year = get_theme_mod('chakta_shop_year');
	
	echo '<option value="">'.esc_html__('Select Year','chakta-core').'</option>';
	if($year){
		foreach($year as $y){
			echo '<option value="'.$y['year_data'].'">'.$y['year_data'].'</option>';
		}
	}
}

/*************************************************
## Medibazar Vehicle Product Query
*************************************************/ 
function chakta_vehicle_product_query( $q ){
	
	$make = isset( $_GET['make'] ) ? $_GET['make'] : '';
	$model = isset( $_GET['model'] ) ? $_GET['model'] : '';
	$year = isset( $_GET['klb_year'] ) ? $_GET['klb_year'] : '';

	if($make > 0){
		$q->set( 'meta_query', array (
			'relation' => 'AND',
			array(
				'meta_key' 	=> 'klb_make_type',
				'value' 	=> $make,
			),
			
			array(
				'meta_key' 	=> 'klb_model_type',
				'value' 	=> $model,
			),
			
			array(
				'meta_key' 	=> 'klb_year',
				'value' 	=> $year,
			)
		));
	}

}
add_action( 'woocommerce_product_query', 'chakta_vehicle_product_query', 10, 2 );




/*************************************************
## WooCommerce Vehicle Details Tab Callback
*************************************************/ 
add_action( 'woocommerce_single_product_summary', 'klb_vehicle_details', 25);
function klb_vehicle_details() {
	
	$make = rwmb_the_value( 'klb_make_type', '', null, false );
	$makemeta = rwmb_meta( 'klb_make_type' );

	$model = rwmb_the_value( 'klb_model_type', '', null, false );
	$modelmeta = rwmb_meta( 'klb_model_type');

	$year = rwmb_the_value( 'klb_year', '', null, false );
	$yearmeta = rwmb_meta( 'klb_year');

	$body_style = rwmb_the_value( 'klb_body_style', '', null, false );
	$color = rwmb_the_value( 'klb_color', '', null, false );
	$transmission = rwmb_the_value( 'klb_transmission', '', null, false );
	
	$output = '';
	
	$output .='<table class="specifications">';
	$output .='<tbody>';
	if($makemeta){
		$output .='<tr>';
		$output .='<th>'.esc_html__('Make','chakta-core').'</th>';
		$output .='<td><span class="klb-vehicle-data">'.chakta_sanitize_data($make).'</span></td>';
		$output .='</tr>';
	}
	if($modelmeta){
		$output .='<tr>';
		$output .='<th>'.esc_html__('Model','chakta-core').'</th>';
		$output .='<td><span class="klb-vehicle-data">'.chakta_sanitize_data($model).'</span></td>';
		$output .='</tr>';
	}
	
	if($yearmeta){
		$output .='<tr>';
		$output .='<th>'.esc_html__('Year','chakta-core').'</th>';
		$output .='<td><span class="klb-vehicle-data">'.chakta_sanitize_data($year).'</span></td>';
		$output .='</tr>';
	}
	
	if($body_style){
		$output .='<tr>';
		$output .='<th>'.esc_html__('Body Style','chakta-core').'</th>';
		$output .='<td><span class="klb-vehicle-data">'.chakta_sanitize_data($body_style).'</span></td>';
		$output .='</tr>';
	}
	
	if($color){
		$output .='<tr>';
		$output .='<th>'.esc_html__('Color','chakta-core').'</th>';
		$output .='<td><span class="klb-vehicle-data">'.chakta_sanitize_data($color).'</span></td>';
		$output .='</tr>';
	}
	
	if($transmission){
		$output .='<tr>';
		$output .='<th>'.esc_html__('Transmission','chakta-core').'</th>';
		$output .='<td><span class="klb-vehicle-data">'.chakta_sanitize_data($transmission).'</span></td>';
		$output .='</tr>';
	}
	$output .='</tbody>';
	$output .='</table>';

	echo chakta_sanitize_data($output);
}
