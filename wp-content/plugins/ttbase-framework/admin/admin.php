<?php
global $pagenow;

function ttbase_framework_welcome_page(){
	require_once TTBASE_FRAMEWORK_PATH . 'admin/admin-pages/welcome.php';
}

function ttbase_framework_admin_menu(){
	if ( current_user_can( 'edit_theme_options' ) ) {
		add_theme_page( 'GymX', 'GymX', 'manage_options', 'ttbase_framework_welcome_page','ttbase_framework_welcome_page');
	}
}

add_action( 'admin_menu', 'ttbase_framework_admin_menu' );

/**
 * Remove top margin for admin bar
 */
function ttbase_framework_remove_adminbar_margin()
{
	remove_action('wp_head', '_admin_bar_bump_cb');
}

add_action('get_header', 'ttbase_framework_remove_adminbar_margin');

if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
    header( 'Location: '.admin_url().'plugins.php');
}

function ttbase_framework_load_admin_script()
{
    wp_enqueue_script( 'jquery-tiptip', TTBASE_FRAMEWORK_URL . 'admin/assets/js/jquery.tipTip.min.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'admin-timetable', TTBASE_FRAMEWORK_URL . 'admin/assets/js/admin_timetable.js', array( 'jquery' ), '1.0', true );
}
add_action('admin_enqueue_scripts', 'ttbase_framework_load_admin_script');

function ttbase_framework_init_admin_css()
{
	wp_enqueue_style('ttbase-admin', TTBASE_FRAMEWORK_URL . 'admin/assets/css/ttbase-admin.css', false, '1.0');
}

add_action('admin_init', 'ttbase_framework_init_admin_css');