<?php
/**
 * GymX functions and definitions
 *
 */
$ok_php = true;
if ( function_exists( 'phpversion' ) ) {
	$php_version = phpversion();
	if (version_compare($php_version,'5.3.0') < 0) $ok_php = false;
}
if (!$ok_php && !is_admin()) {
	$title = esc_html__( 'PHP version obsolete','gymx' );
	$html = '<h2>' . esc_html__( 'Ooops, obsolete PHP version' ,'gymx' ) . '</h2>';
	$html .= '<p>' . sprintf( wp_kses( 'We have coded the GymX theme to run with modern technology and we have decided not to support the PHP version 5.2.x just because we want to challenge our customer to adopt what\'s best for their interests.%sBy running obsolete version of PHP like 5.2 your server will be vulnerable to attacks since it\'s not longer supported and the last update was done the 06 January 2011.%sSo please ask your host to update to a newer PHP version for FREE.%sYou can also check for reference this post of WordPress.org <a href="https://wordpress.org/about/requirements/">https://wordpress.org/about/requirements/</a>' ,'gymx', array('a' => 'href') ), '</p><p>', '</p><p>', '</p><p>') . '</p>';

	wp_die( $html, $title, array('response' => 403) );
}
/**
 * Define theme folder URL, saves querying the template directory multiple times.
 */
define('GYMX_THEME_DIRECTORY', esc_url(trailingslashit( get_template_directory_uri() )));

/**
 * Theme setup and custom theme supports.
 */
require_once get_template_directory() . '/framework/setup.php';

/**
 * Init Visual Composer
 */
if( function_exists('vc_set_as_theme') ){
    include_once get_template_directory() . '/framework/visual-composer/vc_init.php';
}
/**
 * Fix for metaboxes when TTBase Framework is deactivated
 */
if ( ! function_exists( 'rwmb_meta' ) ) {
    function rwmb_meta( $key, $args = '', $post_id = null ) {
        return false;
    }
}
