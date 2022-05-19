<?php

/*************************************************
## Register Make Taxonomy
*************************************************/ 

function custom_taxonomy_klb_make()  {
$labels = array(
    'name'                       => esc_html__('Makes','chakta-core'),
    'singular_name'              => esc_html__('Make','chakta-core'),
    'menu_name'                  => esc_html__('Makes & Models','chakta-core'),
    'all_items'                  => esc_html__('All Makes','chakta-core'),
    'parent_item'                => esc_html__('Parent Item','chakta-core'),
    'parent_item_colon'          => esc_html__('Parent Item:','chakta-core'),
    'new_item_name'              => esc_html__('New Item Name','chakta-core'),
    'add_new_item'               => esc_html__('Add New Make','chakta-core'),
    'edit_item'                  => esc_html__('Edit Item','chakta-core'),
    'update_item'                => esc_html__('Update Item','chakta-core'),
    'separate_items_with_commas' => esc_html__('Separate Item with commas','chakta-core'),
    'search_items'               => esc_html__('Search Items','chakta-core'),
    'add_or_remove_items'        => esc_html__('Add or remove Items','chakta-core'),
    'choose_from_most_used'      => esc_html__('Choose from the most used Items','chakta-core'),
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => false,
    'show_ui'                    => true,
    'show_admin_column'          => false,
    'show_in_nav_menus'          => false,
    'show_in_quick_edit'         => false,
    'meta_box_cb'                => false,
);
register_taxonomy( 'klb_make', array( 'product'), $args );
register_taxonomy_for_object_type( 'klb_make', array( 'product' ) );
}
add_action( 'init', 'custom_taxonomy_klb_make' );



/*************************************************
## Groci Query Vars
*************************************************/ 
function groci_query_vars( $query_vars ){
    $query_vars[] = 'klb_special_query';
    return $query_vars;
}
add_filter( 'query_vars', 'groci_query_vars' );

/*************************************************
## Groci Product Query for Klb Shortcodes
*************************************************/ 
function groci_product_query( $query ){
    if( isset( $query->query_vars['klb_special_query'] ) && groci_make() != 'all'){
		$tax_query[] = array(
			'taxonomy' => 'make',
			'field'    => 'slug',
			'terms'    => groci_make(),
		);

		$query->set( 'tax_query', $tax_query );
	}
}
add_action( 'pre_get_posts', 'groci_product_query' );

/*************************************************
## Groci Make
*************************************************/ 
function groci_make(){	
	$make  = isset( $_COOKIE['make'] ) ? $_COOKIE['make'] : 'all';
	if($make){
		return $make;
	}
}

/*************************************************
## Groci Make Output
*************************************************/ 
function groci_make_output(){	
	
	wp_enqueue_script( 'jquery-cookie');
	wp_enqueue_script( 'klb-make-filter');

	$terms = get_terms( array(
		'taxonomy' => 'make',
		'hide_empty' => true,
		'parent'    => 0,
	) );

	$output = '';
	
	$output .= '<select id="make">';
	$output .= '<option value="all">Your Make</option>';
	foreach ( $terms as $term ) {
		if($term->slug == groci_make()){
			$select = 'selected';
		} else {
			$select = '';
		}
		$output .= '<option value="'.esc_attr($term->slug).'" '.esc_attr($select).'>'.esc_html($term->name).'</option>';
	}
	$output .= '</select>';
	
	return $output;
}
