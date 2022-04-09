<?php
/**
 * Gutenberg helpers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'gymx_gutenberg_can_edit_post_type' ) ) :

	/**
	 * Check if Gutenberg or block editor can edit this post type
	 */
	function gymx_gutenberg_can_edit_post_type( $post_type ) {
		global $wp_version;

		if ( version_compare( $wp_version, '5', '>=' ) ) {
			// WP 5+, check for block editor
			return use_block_editor_for_post_type( $post_type );
		} else {
			// WP 4 or older
			// If Gutenberg plugin is not active return false
			// otherwise check if Gutenberg can edit the post type
			if ( ! function_exists( 'gutenberg_can_edit_post_type' ) ) {
				return false;
			}

			return gutenberg_can_edit_post_type( $post_type );
		}

		return false;
	}

endif;

if ( ! function_exists( 'gymx_is_gutenberg_current_editor' ) ) :

	/**
	 * Check if Gutenberg is the active editor
	 */
	function gymx_is_gutenberg_current_editor( $post_type ) {
		// Gutenberg is not active
		if ( ! gymx_is_gutenberg_active() ) {
			return false;
		}

		// Gutenberg can't edit this post type
		if ( ! gymx_gutenberg_can_edit_post_type( $post_type ) ) {
			return false;
		}

		if ( isset( $_REQUEST ) && isset( $_REQUEST[ 'classic-editor' ] ) ) {
			return false;
		}

		if ( function_exists( 'vc_is_wpb_content' ) && vc_is_wpb_content() ) {
			return false;
		}

		return true;
	}

endif;
