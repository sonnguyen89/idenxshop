<?php

if ( ! class_exists( 'GymX_Ext_Shortcodes' ) ) {

	class GymX_Ext_Shortcodes {

		/**
		 * Main Constructor
		 */
		function __construct() {

			// Define path
			$this->dir_path = plugin_dir_path( __FILE__ );

			// Actions
			add_action( 'wp_enqueue_scripts', array( $this, 'gymx_ext_shortcodes_load_scripts' ) );
			
			// The actual shortcodes
			require_once( $this->dir_path .'/parts/sc_init.php' );
			
			// Init Visual Composer
			require_once( $this->dir_path .'/parts/vc_init.php' );

		}


		/**
		 * Registers/Enqueues all scripts and styles
		 */
		function gymx_ext_shortcodes_load_scripts() {

			// Define js directory
			$js_dir = plugin_dir_url( __FILE__ ) . 'js/';

			// JS
			wp_register_script('gymx-class', $js_dir . 'gymx-class.min.js', array( 'jquery', 'gymx-scripts' ) );
			wp_register_script('gymx-trainer', $js_dir . 'gymx-trainer.min.js', array( 'jquery', 'gymx-scripts' ) );
			
		}
		
		
	}

	// Start things up
	$gymx_ext_shortcodes = new GymX_Ext_Shortcodes();

}