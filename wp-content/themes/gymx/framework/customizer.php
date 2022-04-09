<?php
/**
 * Extend the Customizer with the GymX Theme options
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 */


/**
 * This function is only called when the user is actually on the customizer page
 * @param  WP_Customize_Manager $wp_customize
 */

if ( ! function_exists( 'gymx_customizer' ) ) {
	function gymx_customizer( $wp_customize ) {
		// add required files
		require_once get_template_directory() . '/framework/customizer/controls.php';
		require_once get_template_directory() . '/framework/customizer/dynamic-css.php';
		require_once get_template_directory() . '/framework/customizer/common.php';

		new GymX_Customizer_Common( $wp_customize );
		
	}
	add_action( 'customize_register', 'gymx_customizer' );
}

//Remove Nav Menu Panel
function gymx_remove_nav_menus_panel( $components ) {
        var_dump($components);
        $i = array_search( 'nav_menus', $components );
        if ( false !== $i ) {
            unset( $components[ $i ] );
        }
        return $components;
    }
add_filter( 'customize_loaded_components', 'gymx_remove_nav_menus_panel' );

//Remove Widgets Panel
function gymx_remove_widgets_panel( $components ) {
    $i = array_search( 'widgets', $components );
    if ( false !== $i ) {
        unset( $components[ $i ] );
    }
    return $components;
}
add_filter( 'customize_loaded_components', 'gymx_remove_widgets_panel' );

// Remove core panels and sections
if ( ! function_exists( 'gymx_remove_core_sections' ) ) {
	function gymx_remove_core_sections( $wp_customize ) {
		// Remove core sections
		$wp_customize->remove_section( 'colors' );
		$wp_customize->remove_section( 'themes' );
		$wp_customize->remove_section( 'background_image' );
		$wp_customize->remove_section( 'static_front_page' );
	
		// Remove core controls
		$wp_customize->remove_control( 'blogname' );
		$wp_customize->remove_control( 'blogdescription' );
		$wp_customize->remove_control( 'header_textcolor' );
		$wp_customize->remove_control( 'background_color' );
		$wp_customize->remove_control( 'background_image' );
	
		// Remove default settings
		$wp_customize->remove_setting( 'background_color' );
		$wp_customize->remove_setting( 'background_image' );
		
	}
	add_action( 'customize_register', 'gymx_remove_core_sections' );
}
		
/*
* Sanitize Callback for select boxes
*/
if( ! function_exists('gymx_sanitize_choices')) {
	function gymx_sanitize_choices( $input, $setting ) {
		global $wp_customize;

		$control = $wp_customize->get_control( $setting->id );

		if ( array_key_exists( $input, $control->choices ) ) {
			return $input;
		} else {
			return $setting->default;
		}
	}
}

/**
 * Frontend output from the customizer
 */
if ( ! function_exists( 'gymx_customizer_frontend' ) && ! class_exists( 'GymX_Customize_Frontend' ) ) {
	function gymx_customizer_frontend() {
		require_once get_template_directory() . '/framework/customizer/frontend.php';
		new GymX_Customize_Frontend();
	}
	add_action( 'init', 'gymx_customizer_frontend' );
}

/**
 * Include typography section for the customizer
 */
require_once get_template_directory() . '/framework/customizer/fonts.php';
require_once get_template_directory() . '/framework/customizer/typography.php';