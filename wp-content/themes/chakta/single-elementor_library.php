<?php

/**
* The template for displaying all single posts
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
*
* @package WordPress
* @subpackage Chakta
* @since 1.0.0
*/

	remove_action( 'chakta_main_header', 'chakta_main_header_function', 10 );
	remove_action( 'chakta_main_footer', 'chakta_main_footer_function', 10 );

	remove_action( 'chakta_before_main_shop', 'chakta_get_elementor_template', 10);
	remove_action( 'chakta_after_main_shop', 'chakta_get_elementor_template', 10);
	remove_action( 'chakta_before_main_footer', 'chakta_get_elementor_template', 10);
	remove_action( 'chakta_after_main_footer', 'chakta_get_elementor_template', 10);
	remove_action( 'chakta_before_main_header', 'chakta_get_elementor_template', 10);
	remove_action( 'chakta_after_main_header', 'chakta_get_elementor_template', 10);

    get_header();

    while ( have_posts() ) : the_post();
        the_content();
    endwhile;

    get_footer();
?>
