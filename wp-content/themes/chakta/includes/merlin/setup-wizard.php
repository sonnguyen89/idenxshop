<?php
/************************************************************
## Setup Wizard
*************************************************************/
require_once get_parent_theme_file_path( '/includes/merlin/vendor/autoload.php' );
require_once get_parent_theme_file_path( '/includes/merlin/class-merlin.php' );
require_once get_parent_theme_file_path( '/includes/merlin/merlin-config.php' );

/************************************************************
## Setup Wizard Local Import
*************************************************************/
function chakta_local_import_files() {
	return array(
		array(
			'import_file_name'             	=> 'Import Demo',
			'local_import_file'            	=> get_parent_theme_file_path( '/includes/merlin/demo-data/content.xml' ),
			'local_import_widget_file'     	=> get_parent_theme_file_path( '/includes/merlin/demo-data/widgets.wie' ),
			'local_import_customizer_file'  => get_parent_theme_file_path( '/includes/merlin/demo-data/customizer.dat' ),
		),
		
	);
}
add_filter( 'merlin_import_files', 'chakta_local_import_files' );

/************************************************************
## Setup Wizard After Import
*************************************************************/
function chakta_merlin_after_import_setup() {
	// Assign menus to their locations.
	$main_menu 	  = get_term_by( 'name', 'Menu 1', 'nav_menu' );
	$topleftmenu  = get_term_by( 'name', 'Top Left', 'nav_menu' );
	$toprightmenu = get_term_by( 'name', 'Top Right', 'nav_menu' );
	
	set_theme_mod(
		'nav_menu_locations', array(
			'main-menu' 	     => $main_menu->term_id,
			'top-left-menu' 	 => $topleftmenu->term_id,
			'top-right-menu' 	 => $toprightmenu->term_id,
		)
	);

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Home' );
	$blog_page_id  = get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );

    if ( did_action( 'elementor/loaded' ) ) {
        // disable some default elementor global settings after setup theme
        update_option( 'elementor_disable_color_schemes', 'yes' );
        update_option( 'elementor_disable_typography_schemes', 'yes' );
        update_option( 'elementor_global_image_lightbox', 'yes' );
    }
    if ( class_exists( 'woocommerce' ) ) {
        update_option( 'woocommerce_shop_page_id', '7' );
        update_option( 'woocommerce_cart_page_id', '8' );
        update_option( 'woocommerce_checkout_page_id', '9' );
        update_option( 'woocommerce_myaccount_page_id', '10' );
    }

}
add_action( 'merlin_after_all_import', 'chakta_merlin_after_import_setup' );

add_filter( 'woocommerce_prevent_automatic_wizard_redirect', '__return_true' );

add_action('init', 'do_output_buffer'); function do_output_buffer() { ob_start(); }
?>