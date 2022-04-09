<?php

// enqueue the parent theme stylesheet
function gymx_child_enqueue_styles() {
	wp_enqueue_style( 'gymx-theme', get_template_directory_uri() . '/css/theme.min.css', array() );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('gymx-theme')  );
}
add_action( 'wp_enqueue_scripts', 'gymx_child_enqueue_styles');