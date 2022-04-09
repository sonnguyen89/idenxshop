<?php
function gymx_demo_import_files() {
	return array(
		array(
			'import_file_name'             => 'GymX Demo Import',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo-content/content.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'demo-content/widgets.json',
			'local_import_revslider_file'  => trailingslashit( get_template_directory() ) . 'demo-content/home.zip',
			'import_preview_image_url'     => 'https://ttdemo2.wpengine.com/gymx/wp-content/uploads/sites/3/2017/01/screenshot.jpg',
		)
	);
}
add_filter( 'pt-ocdi/import_files', 'gymx_demo_import_files' );

function gymx_after_demo_import_setup($selected_import) {
	
// Assign menus to their locations.
		$main_menu = get_term_by( 'name', 'Main', 'nav_menu' );
		$mobile_menu = get_term_by( 'name', 'Mobile', 'nav_menu' );
	
		set_theme_mod( 'nav_menu_locations', array(
				'main' => $main_menu->term_id,
				'mobile' => $mobile_menu->term_id
			)
		);
	
		// Assign front page and posts page (blog page).
		$front_page_id = get_page_by_title( 'Home' );
		$blog_page_id  = get_page_by_title( 'Blog' );
	
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
		update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'gymx_after_demo_import_setup' );