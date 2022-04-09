<?php
/**
 * Plugin Name: TTBase Framework with GymX Extension
 * Plugin URI: https://www.themetwins.com
 * Description: TTBase Framework - Main framework for themetwins themes
 * Version: 2.3.0
 * Author: Themetwins
 * Author URI: https://www.themetwins.com
 * Text Domain: ttbase-framework
*/


/**
 * Plugin definitions
 */
define( 'TTBASE_FRAMEWORK_PATH', trailingslashit(plugin_dir_path(__FILE__)) );
define( 'TTBASE_FRAMEWORK_URL', trailingslashit(plugin_dir_url(__FILE__)) );
define( 'TTBASE_FRAMEWORK_VERSION', '2.2.0');

/**
 * Enqueue styles & scripts
 */
if(!( function_exists('ttbase_framework_scripts') )){
	function ttbase_framework_scripts(){
		wp_enqueue_script( 'ttbase-framework-twitter', TTBASE_FRAMEWORK_URL . 'js/' . 'ttbase-twitter.min.js', array ( 'jquery' ), null);
		
		wp_enqueue_style('font-awesome', plugins_url( '/css/font-awesome.min.css' , __FILE__ ) );
		wp_enqueue_style('gymx-streamline', plugins_url( '/css/gymx-streamline.min.css' , __FILE__ ) );
		wp_enqueue_style('iconsmind', plugins_url( '/css/iconsmind.min.css' , __FILE__ ) );
		wp_enqueue_style('ttbase-framework-font', plugins_url( '/css/ttbase-font.min.css' , __FILE__ ) );
		wp_enqueue_style('ttbase-framework-plugins', plugins_url( '/css/plugins.min.css' , __FILE__ ) );
		wp_enqueue_style('ttbase-framework-shortcodes', plugins_url( '/css/shortcodes.min.css' , __FILE__ ) );
	}
	add_action('wp_enqueue_scripts', 'ttbase_framework_scripts', 10);
}

/**
 * Load text domain
 */
if(!( function_exists('ttbase_framework_load_plugin_textdomain') )){
    function ttbase_framework_load_plugin_textdomain(){
        load_plugin_textdomain('ttbase-framework', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
    }
    add_action('init', 'ttbase_framework_load_plugin_textdomain');
}

/**
 * Init framework functions based on theme options
 */
require_once( TTBASE_FRAMEWORK_PATH . 'init.php' );