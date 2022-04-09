<?php

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Display admin error message if PHP version is older than 5.3.2.
 * Otherwise execute the main plugin class.
 */
if ( version_compare( phpversion(), '5.3.2', '<' ) ) {

	/**
	 * Display an admin error notice when PHP is older the version 5.3.2.
	 * Hook it to the 'admin_notices' action.
	 */
	function ocdi_old_php_admin_error_notice() {
		$message = sprintf( esc_html__( 'The %2$sOne Click Demo Import%3$s plugin requires %2$sPHP 5.3.2+%3$s to run properly. Please contact your hosting company and ask them to update the PHP version of your site to at least PHP 5.3.2.%4$s Your current version of PHP: %2$s%1$s%3$s', 'ttbase-framework' ), phpversion(), '<strong>', '</strong>', '<br>' );

		printf( '<div class="notice notice-error"><p>%1$s</p></div>', wp_kses_post( $message ) );
	}
	add_action( 'admin_notices', 'ocdi_old_php_admin_error_notice' );
}
else {

	// Current version of the plugin.
	define( 'TTBASE_OCDI_VERSION', '1.0.0' );

	// Require main plugin file.
	require TTBASE_FRAMEWORK_PATH . 'ttbase-demo-importer/inc/class-ocdi-main.php';

	// Instantiate the main plugin class *Singleton*.
	$ttbase_framework_one_click_demo_import = TTBase_Framework_One_Click_Demo_Import::getInstance();
}
