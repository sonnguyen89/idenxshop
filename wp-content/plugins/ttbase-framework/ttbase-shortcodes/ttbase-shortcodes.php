<?php

if ( ! class_exists( 'TTBase_Framework_Shortcodes' ) ) {

	class TTBase_Framework_Shortcodes {

		/**
		 * Main Constructor
		 */
		function __construct() {

			// Define path
			$this->dir_path = plugin_dir_path( __FILE__ );

			// Actions
			add_action( 'admin_head', array( $this, 'ttbase_framework_shortcodes_add_mce_button' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'ttbase_framework_shortcodes_load_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'ttbase_framework_shortcodes_mce_css' ) );

			// Includes (useful functions and classes)
			require_once( $this->dir_path .'/inc/commons.php' );
			require_once( $this->dir_path .'/inc/image-resizer.php' );
			
			// The actual shortcodes
			require_once( $this->dir_path .'/shortcodes/shortcodes.php' );
			
			// Init Visual Composer
			require_once( $this->dir_path .'/visual-composer/vc_init.php' );


			// Add responsive tag to body
			add_filter( 'body_class', array( $this, 'ttbase_framework_shortcodes_body_class' ) );

		}

		/**
		 * Add filters for the TinyMCE buttton
		 *
		 */
		function ttbase_framework_shortcodes_add_mce_button() {

			// Check user permissions
			if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
				return;
			}

			// Check if WYSIWYG is enabled
			if ( 'true' == get_user_option( 'rich_editing' ) ) {
				add_filter( 'mce_external_plugins', array( $this, 'ttbase_framework_shortcodes_add_tinymce_plugin' ) );
				add_filter( 'mce_buttons', array( $this, 'ttbase_framework_shortcodes_register_mce_button' ) );
			}

		}

		/**
		 * Loads the TinyMCE button js file
		 */
		function ttbase_framework_shortcodes_add_tinymce_plugin( $plugin_array ) {
			$plugin_array['ttbase_framework_shortcodes_mce_button'] = plugins_url( '/tinymce/ttbase-shortcodes-tinymce.js', __FILE__ );
			return $plugin_array;
		}

		/**
		 * Adds the TinyMCE button to the post editor buttons
		 */
		function ttbase_framework_shortcodes_register_mce_button( $buttons ) {
			array_push( $buttons, 'ttbase_framework_shortcodes_mce_button' );
			return $buttons;
		}

		/**
		 * Loads custom CSS for the TinyMCE editor button
		 */
		function ttbase_framework_shortcodes_mce_css() {
			wp_enqueue_style('ttbase-shortcodes-tc', plugins_url( '/tinymce/ttbase-shortcodes-tinymce-style.css', __FILE__ ) );
		}

		/**
		 * Registers/Enqueues all scripts and styles
		 */
		function ttbase_framework_shortcodes_load_scripts() {

			// Define js directory
			$js_dir = plugin_dir_url( __FILE__ ) . 'shortcodes/js/';

			// JS
			wp_register_script('ttbase-skillbar', $js_dir . 'ttbase-skillbar.min.js', array ( 'jquery' ));
			wp_register_script('ttbase-counter', $js_dir . 'ttbase-counter.min.js', array ( 'jquery' ));
			wp_register_script('magnific-popup', $js_dir . 'magnific-popup.min.js', array ( 'jquery' ));
			wp_register_script('ttbase-lightbox', $js_dir . 'ttbase-lightbox.min.js', array ( 'jquery', 'magnific-popup' ));
			wp_register_script('ttbase-gallery', $js_dir . 'ttbase-gallery.min.js', array ( 'jquery' ));
			wp_register_script('ttbase-modal', $js_dir . 'ttbase-modal.min.js', 'jquery' );
			wp_register_script('ttbase-scroll-fade', $js_dir . 'ttbase-scroll-fade.min.js', array ( 'jquery' ) );
			wp_register_script('ttbase-icon', $js_dir . 'ttbase-icon-type.min.js', array ( 'jquery' ),null );
			wp_register_script('ttbase-carousel', $js_dir . 'ttbase-carousel.min.js', array( 'jquery', 'gymx-scripts' ), null );
			wp_register_script('ttbase-ft-carousel', $js_dir . 'ttbase-ft-carousel.min.js', array( 'jquery' ), null );
			wp_register_script('ttbase-tabs', $js_dir . 'ttbase-tabs.min.js', array( 'jquery' ) );
			wp_register_script('ttbase-service', $js_dir . 'ttbase-service.min.js', array( 'jquery', 'gymx-scripts' ) );
			wp_register_script('ttbase-team', $js_dir . 'ttbase-team.min.js', array( 'jquery', 'gymx-scripts' ) );
			wp_register_script('ttbase-testimonial', $js_dir . 'ttbase-testimonial.min.js', array( 'jquery', 'gymx-scripts' ) );
			
		}
		
		/**
		 * Adds classes to the body tag
		 */
		public function ttbase_framework_shortcodes_body_class( $classes ) {
			$classes[] = 'ttbase-shortcodes ';
			$responsive = apply_filters( 'ttbase_framework_shortcodes_responsive', true );
			if ( $responsive ) {
				$classes[] = 'ttbase-shortcodes-responsive';
			}
			return $classes;
		}
		
	}

	// Start things up
	$ttbase_framework_shortcodes = new TTBase_Framework_Shortcodes();

}