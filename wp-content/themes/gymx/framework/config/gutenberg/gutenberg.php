<?php
/**
 * Gutenberg support
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Check if Gutenberg is active
// (the standalone plugin or WP5+)
if ( ! gymx_is_gutenberg_active() ) {
	return;
}

if ( ! class_exists( 'GymX_Gutenberg' ) ) :

/**
 * GymX_Gutenberg Class
 */
class GymX_Gutenberg {

	/**
	 * Construct.
	 */
	public function __construct() {
		// Declare Gutenberg support
		add_action( 'after_setup_theme', array( $this, 'declare_support' ) );

		// Admin scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

		// Front-end scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );

		// Editor scripts
		add_action( 'enqueue_block_editor_assets', array( $this, 'editor_scripts' ) );
	}

	/**
	 * Declare Gutenberg support
	 */
	public function declare_support() {
		add_theme_support( 'align-wide' );
	}

	/**
	 * Admin scripts
	 */
	public function admin_scripts( $hook_suffix ) {
		if ( 'post.php' == $hook_suffix || 'post-new.php' == $hook_suffix ) {
			wp_enqueue_style( 'gymx-gutenberg-admin', get_template_directory_uri() . '/framework/config/gutenberg/assets/css/gymx-gutenberg-admin.css', array(), '2.1.0', 'all' );
		}
	}

	/**
	 * Front-end scripts
	 */
	public function frontend_scripts() {
		global $wp_version;

		$has_blocks = version_compare( $wp_version, '5', '>=' ) ? has_blocks( get_the_ID() ) : gutenberg_post_has_blocks( get_the_ID() );

		if ( $has_blocks ) {
			wp_enqueue_style( 'gymx-gutenberg-frontend', get_template_directory_uri() . '/framework/config/gutenberg/assets/css/gymx-gutenberg-frontend.css', array(), '2.1.0', 'all' );
		}
	}

	/**
	 * Editor scripts
	 */
	public function editor_scripts() {
		wp_enqueue_style( 'gymx-gutenberg-editor', get_template_directory_uri() . '/framework/config/gutenberg/assets/css/gymx-gutenberg-editor.css', array(), '2.1.0', 'all' );
	}
}

endif;

return new GymX_Gutenberg();
