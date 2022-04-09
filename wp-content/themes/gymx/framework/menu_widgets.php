<?php
/**
 * Declaring menus & widgets
 *
 */

/**
 * Register menus
 */
if(!( function_exists('gymx_register_nav_menus') )){
    function gymx_register_nav_menus() {
        register_nav_menus(
            array(
                'main'  => esc_html__( 'Main Menu', 'gymx' ),
                'mobile'  => esc_html__( 'Mobile Menu', 'gymx' )
            )
        );
    }
    add_action( 'init', 'gymx_register_nav_menus' );
}

/**
 * Register sidebars and footer widgets
 */
if(! function_exists('gymx_widgets_init')) {
    function gymx_widgets_init()
    {
        //Sidebars
        register_sidebar(array(
            'name' => esc_html__('Blog Sidebar', 'gymx'),
            'id' => 'sidebar-blog',
            'description' => esc_html__('Sidebar for the blog', 'gymx'),
            'before_widget' => '<aside id="%1$s" class="sidebar widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h5 class="title">',
            'after_title' => '</h5>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Page Sidebar', 'gymx'),
            'id' => 'sidebar-page',
            'description' => esc_html__('Sidebar for the page with sidebar template', 'gymx'),
            'before_widget' => '<aside id="%1$s" class="sidebar widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h5 class="title">',
            'after_title' => '</h5>',
        ));
        
        if( class_exists('Woocommerce') ){
            register_sidebar(array(
                'name' => esc_html__('Shop Sidebar', 'gymx'),
                'id' => 'sidebar-shop',
                'description' => esc_html__('Sidebar for the shop', 'gymx'),
                'before_widget' => '<aside id="%1$s" class="sidebar widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h5 class="title">',
                'after_title' => '</h5>',
            ));
        }
        //Header
        register_sidebar(array(
            'name' => esc_html__('Header', 'gymx'),
            'id' => 'header-widgets',
            'description' => esc_html__('Header Topbar Widget Area', 'gymx'),
            'before_widget' => '<div class="widget %2$s">',
            'after_widget' => '</div>'
        ));

        //Footer
        register_sidebar(array(
            'name' => esc_html__('Footer One', 'gymx'),
            'id' => 'footer-1',
            'description' => esc_html__('Add content to the footer', 'gymx'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Two', 'gymx'),
            'id' => 'footer-2',
            'description' => esc_html__('Add content to the footer', 'gymx'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Three', 'gymx'),
            'id' => 'footer-3',
            'description' => esc_html__('Add content to the footer', 'gymx'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Four', 'gymx'),
            'id' => 'footer-4',
            'description' => esc_html__('Add content to the footer', 'gymx'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Bottom Right', 'gymx'),
            'id' => 'footer-bottom-right',
            'description' => esc_html__('Footer Bottom Widget Area', 'gymx'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '',
            'after_title' => '',
        ));
    }

}
add_action( 'widgets_init', 'gymx_widgets_init' );