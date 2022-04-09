<?php

// VC Timetable ------------------------------------------------------------------------ >
function ttbase_vc_timetable_shortcode() {
		
	//get classes list
	$classes_list = get_posts(array(
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'suppress_filters' => false,
		'post_type' => 'classes'
	));
	$classes_array = array();
	$classes_array[esc_html__("All", 'ttbase-framework')] = "";
	foreach($classes_list as $class){
		$classes_array[$class->post_title] = $class->post_name;
	}
	//get all pages
	$classes_page = get_page_by_title("classes");	
	$pages_list = get_posts(array(
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_type' => 'page',
		'suppress_filters' => false,
		'post__not_in' => !empty($classes_page->ID) ? array($classes_page->ID) : ""
	));
	if(!empty($classes_page)) {
		array_unshift($pages_list, $classes_page);
	}
	$pages_array = array();
	foreach($pages_list as $page){
		$pages_array[$page->post_title] = home_url() . "/" . $page->post_name;
	}
	//get all class categories
	$class_categories = get_terms(array(
		"class_category"
	));
	
	$class_categories_array = array();
	$class_categories_array["All"] = "";
	foreach($class_categories as $class_category){
		$class_categories_array[$class_category->name] = $class_category->slug;
	}
	//get all hour categories
	global $wpdb;
	global $blog_id;
	$query = "SELECT distinct(category) AS category FROM ".$wpdb->prefix."class_hours AS t1
			LEFT JOIN {$wpdb->posts} AS t2 ON t1.class_id=t2.ID 
			WHERE 
			t2.post_type='classes'
			AND t2.post_status='publish'
			AND category<>''";
	$hour_categories = $wpdb->get_results($query);
	$hour_categories_array = array();
	$hour_categories_array[esc_html__("All", 'ttbase-framework')] = "";
	foreach($hour_categories as $hour_category) {
		$hour_categories_array[$hour_category->category] = $hour_category->category;
	}
	if (function_exists('vc_map')) {
		vc_map( array(
			"name" => esc_html__("Timetable", 'ttbase-framework'),
			"base" => "ttbase_timetable",
			"class" => "",
			"controls" => "full",
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-layer-timetable",
			"category" => esc_html__('TTBase', 'ttbase-framework'),
			"params" => array(
				array(
					"type" => "dropdownmulti",
					"class" => "",
					"heading" => esc_html__("Display selected", 'ttbase-framework'),
					"param_name" => "class",
					"value" => $classes_array
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__("Time Format", 'ttbase-framework'),
					"param_name" => "mode",
					"value" => array(
						esc_html__("24h", 'ttbase-framework') => "", 
						esc_html__("12h", 'ttbase-framework') => "12h"
					)
				),
				array(
					"type" => "dropdownmulti",
					"class" => "",
					"heading" => esc_html__("Display from class category", 'ttbase-framework'),
					"param_name" => "class_category",
					"value" => $class_categories_array
				),
				array(
					"type" => "dropdownmulti",
					"class" => "",
					"heading" => esc_html__("Display from hour category", 'ttbase-framework'),
					"param_name" => "hour_category",
					"value" => $hour_categories_array
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__("Classes page", 'ttbase-framework'),
					"param_name" => "classes_url",
					"value" => $pages_array
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__("Hour minute separator", 'ttbase-framework'),
					"param_name" => "hour_minute_separator",
					"value" => array(".", ":")
				)
			)
		));
	}
	
}
add_action( 'init', 'ttbase_vc_timetable_shortcode', 20 );

?>