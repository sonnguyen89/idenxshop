<?php
/**
 * Class which handles the output of the WP customizer on the frontend.
 * Meaning that this stuff loads always, no matter if the global $wp_cutomize
 * variable is present or not.
 */
class GymX_Customize_Frontend {

	/**
	 * Add actions to load the right staff at the right places (header, footer).
	 */
	function __construct() {
		add_action( 'wp_enqueue_scripts' , array( $this, 'gymx_customizer_css' ), 220 );
		add_action( 'wp_head' , array( $this, 'gymx_head_output' ) );
		add_action( 'wp_footer' , array( $this, 'gymx_footer_output' ) );
	}

	/**
	* This will output the custom WordPress settings to the live theme's WP head.
	*
	* Used by hook: 'wp_head'
	*
	* @see add_action( 'wp_head' , array( $this, 'head_output' ) );
	*/
	public static function gymx_customizer_css() {
		// customizer settings
		$cached_css = get_theme_mod( 'gymx_cached_css', '' );
		$user_css   = get_theme_mod( 'gymx_custom_css', '' );

		ob_start();

		echo '/* WP Customizer start */' . PHP_EOL;
		echo apply_filters( 'gymx/cached_css', $cached_css );
		echo '/* WP Customizer end */';

		if ( strlen( $user_css ) ) {
			echo PHP_EOL . "/* User custom CSS start */" . PHP_EOL;
			echo PHP_EOL . $user_css . PHP_EOL; // no need to filter this, because it is 100% custom code
			echo PHP_EOL . "/* User custom CSS end */" . PHP_EOL;
		}

		wp_add_inline_style( 'gymx-theme', ob_get_clean() );
	}


	/**
	 * Outputs the code in head of the every page
	 *
	 * Used by hook: add_action( 'wp_head' , array( $this, 'head_output' ) );
	 */
	public static function gymx_head_output() {
		
		// custom JS from the customizer
		$script = get_theme_mod( 'gymx_custom_js_head', '' );

		if ( ! empty( $script ) ) {
			echo PHP_EOL . $script . PHP_EOL;
		}

	}
	
	/**
	 * Outputs the code in footer of the every page, right before closing </body>
	 *
	 * Used by hook: add_action( 'wp_footer' , array( $this, 'footer_output' ) );
	 */
	public static function gymx_footer_output() {
		$script = get_theme_mod( 'gymx_custom_js_footer', '' );

		if ( ! empty( $script ) ) {
			echo PHP_EOL . $script . PHP_EOL;
		}
	}
}