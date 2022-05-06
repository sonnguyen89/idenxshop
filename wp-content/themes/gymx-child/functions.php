<?php

// enqueue the parent theme stylesheet
function gymx_child_enqueue_styles() {
	wp_enqueue_style( 'gymx-theme', get_template_directory_uri() . '/css/theme.min.css', array() );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('gymx-theme')  );
	wp_enqueue_style( 'owl-carousel-style', get_stylesheet_directory_uri() . '/js/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css', array('gymx-theme')  );
	wp_enqueue_style( 'owl-carousel-them-style', get_stylesheet_directory_uri() . '/js/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css', array('gymx-theme')  );

    if(!is_admin()) {
        wp_register_script('customjs',get_stylesheet_directory_uri() . '/js/custom.js', false, null);
        wp_enqueue_script('customjs');

        wp_register_script('owl_carousel_js',get_stylesheet_directory_uri() . '/js/OwlCarousel2-2.3.4/dist/owl.carousel.min.js', false, null);
        wp_enqueue_script('owl_carousel_js');

    }
}
add_action( 'wp_enqueue_scripts', 'gymx_child_enqueue_styles');
