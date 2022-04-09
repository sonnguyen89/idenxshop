<?php
//custom post type - weekdays
function gymx_ext_weekdays_init()
{
	$labels = array(
		'name' => _x('Weekdays', 'post type general name', 'ttbase-framework'),
		'singular_name' => _x('Day', 'post type singular name', 'ttbase-framework'),
		'add_new' => _x('Add New', 'gymx_ext_day', 'ttbase-framework'),
		'add_new_item' => __('Add New Day', 'ttbase-framework'),
		'edit_item' => __('Edit Day', 'ttbase-framework'),
		'new_item' => __('New Day', 'ttbase-framework'),
		'all_items' => __('All Weekdays', 'ttbase-framework'),
		'view_item' => __('View Day', 'ttbase-framework'),
		'search_items' => __('Search Weekdays', 'ttbase-framework'),
		'not_found' =>  __('No weekdays found', 'ttbase-framework'),
		'not_found_in_trash' => __('No weekdays found in Trash', 'ttbase-framework'), 
		'parent_item_colon' => '',
		'menu_name' => __("Weekdays", 'ttbase-framework')
	);
	$args = array(  
		"labels" => $labels, 
		"public" => true,  
		"show_ui" => true,  
		"capability_type" => "post",  
		"menu_position" => 36,
		"hierarchical" => false,  
		"rewrite" => true,  
		"supports" => array("title", "page-attributes")
	);
	register_post_type("gymx_weekdays", $args);
}  
add_action("init", "gymx_ext_weekdays_init"); 

//custom weekdays items list
function gymx_ext_weekdays_edit_columns($columns)
{
	$columns = array(  
		"cb" => "<input type=\"checkbox\" />",  
		"title" => _x('Day name', 'post type singular name', 'ttbase-framework'),   
		"date" => __('Date', 'ttbase-framework')
	);    

	return $columns;  
}  
add_filter("manage_edit-gymx_ext_weekdays_columns", "gymx_ext_weekdays_edit_columns");
?>