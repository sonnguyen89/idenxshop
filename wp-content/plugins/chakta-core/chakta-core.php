<?php
/**
* Plugin Name: Chakta Core
* Description: Premium & Advanced Essential Elements for Elementor
* Plugin URI:  http://themeforest.net/user/KlbTheme
* Version:     1.1.2
* Author:      KlbTheme
* Author URI:  http://themeforest.net/user/KlbTheme
*/


/*
* Exit if accessed directly.
*/

if ( ! defined( 'ABSPATH' ) ) exit;

final class Chakta_Elementor_Addons
{
    /**
    * Plugin Version
    *
    * @since 1.0
    *
    * @var string The plugin version.
    */
    const VERSION = '1.0.0';

    /**
    * Minimum Elementor Version
    *
    * @since 1.0
    *
    * @var string Minimum Elementor version required to run the plugin.
    */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    /**
    * Minimum PHP Version
    *
    * @since 1.0
    *
    * @var string Minimum PHP version required to run the plugin.
    */
    const MINIMUM_PHP_VERSION = '7.0';

    /**
    * Instance
    *
    * @since 1.0
    *
    * @access private
    * @static
    *
    * @var Chakta_Elementor_Addons The single instance of the class.
    */
    private static $_instance = null;

    /**
    * Instance
    *
    * Ensures only one instance of the class is loaded or can be loaded.
    *
    * @since 1.0
    *
    * @access public
    * @static
    *
    * @return Chakta_Elementor_Addons An instance of the class.
    */
    public static function instance()
    {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
    * Constructor
    *
    * @since 1.0
    *
    * @access public
    */
    public function __construct()
    {
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }

    /**
    * Load Textdomain
    *
    * Load plugin localization files.
    *
    * Fired by `init` action hook.
    *
    * @since 1.0
    *
    * @access public
    */
    public function i18n()
    {
        load_plugin_textdomain( 'chakta-core' );
    }
	
   /**
    * Initialize the plugin
    *
    * Load the plugin only after Elementor (and other plugins) are loaded.
    * Checks for basic plugin requirements, if one check fail don't continue,
    * if all check have passed load the files required to run the plugin.
    *
    * Fired by `plugins_loaded` action hook.
    *
    * @since 1.0
    *
    * @access public
    */
    public function init()
    {
        // Check if Elementor is installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'chakta_admin_notice_missing_main_plugin' ] );
            return;
        }
        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'chakta_admin_notice_minimum_elementor_version' ] );
            return;
        }
        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'chakta_admin_notice_minimum_php_version' ] );
            return;
        }
		
		// Categories registered
        add_action( 'elementor/elements/categories_registered', [ $this, 'chakta_add_widget_category' ] );

		/* Init Include */
        require_once( __DIR__ . '/init.php' );

        /* Customizer Kirki */
        require_once( __DIR__ . '/inc/customizer.php' );

        /* Style php */
        require_once( __DIR__ . '/inc/style.php' );
		
		/* Aq Resizer Image Resize */
        require_once( __DIR__ . '/inc/aq_resizer.php' );
		
		/* Breadcrumb */
        require_once( __DIR__ . '/inc/breadcrumb.php' );

		/* Post view for popular posts widget */
        require_once( __DIR__ . '/inc/post_view.php' );
		
        /* Popular Posts Widget */
        require_once( __DIR__ . '/widgets/widget-popular-posts.php' );
		
		/* Footer About Widget */
        require_once( __DIR__ . '/widgets/widget-footer-about.php' );
		
		/* Vehicle Vehicle Filter */
        require_once( __DIR__ . '/widgets/widget-vehicle-filter.php' );

		/* Footer Contact Widget */
        require_once( __DIR__ . '/widgets/widget-footer-contact.php' );
		
		/* WooCommerce Filter */
        require_once( __DIR__ . '/woocommerce-filter/woocommerce-filter.php' );
		
		/* GDPR */
        require_once( __DIR__ . '/gdpr/gdpr.php' );
		
		/* Single Banner Widget */
		require_once( __DIR__ . '/widgets/widget-single-banner.php');

        /* Custom plugin helper functions */
        require_once( __DIR__ . '/elementor/classes/class-helpers-functions.php' );
		
        /* Custom plugin helper functions */
        require_once( __DIR__ . '/elementor/classes/class-customizing-page-settings.php' );
		
		/* Vehicle Taxonomy */
        require_once( __DIR__ . '/taxonomy/vehicle_taxonomy.php' );
		
		/* Vehicle Data */
        require_once( __DIR__ . '/taxonomy/vehicle-data.php' );

        // Register Widget Styles
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );
		
        // Register Widget Scripts
        add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'widget_scripts' ] );
		
		// Register Widget Editor Style
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'widget_editor_style' ] );
	
        // Register Widget Editor Scripts
        add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'widget_editor_scripts' ] );
		
        // Widgets registered
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
    }
	
    /**
    * Register Widgets Category
    *
    */
    public function chakta_add_widget_category( $elements_manager )
    {
        $elements_manager->add_category( 'chakta', ['title' => esc_html__( 'Chakta Core', 'chakta-core' )]);
    }	
	
    /**
    * Init Widgets
    *
    * Include widgets files and register them
    *
    * @since 1.0
    *
    * @access public
    */
    public function init_widgets()
    {

		// Home Slider
		require_once( __DIR__ . '/elementor/widgets/chakta-home-slider.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Home_Slider_Widget() );
		
		// Home Slider Two
		require_once( __DIR__ . '/elementor/widgets/chakta-home-slider-2.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Home_Slider_2_Widget() );

        // Home Slider Three
        require_once( __DIR__ . '/elementor/widgets/chakta-home-slider-3.php' );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Home_Slider_3_Widget() );
		
		// Breadcrumb
		require_once( __DIR__ . '/elementor/widgets/chakta-breadcrumb.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Breadcrumb_Widget() );
		
		// Custom Title
		require_once( __DIR__ . '/elementor/widgets/chakta-custom-title.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Custom_Title_Widget() );
		
		// Product Box
		require_once( __DIR__ . '/elementor/widgets/chakta-product-box.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Product_Box_Widget() );

		// Image Carousel
		require_once( __DIR__ . '/elementor/widgets/chakta-image-carousel.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Image_Carousel_Widget() );
		
		// Image Box
		require_once( __DIR__ . '/elementor/widgets/chakta-image-box.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Image_Box_Widget() );
		
		// Product Grid
		require_once( __DIR__ . '/elementor/widgets/chakta-product-grid.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Product_Grid_Widget() );
		
		// Product Carousel
		require_once( __DIR__ . '/elementor/widgets/chakta-product-carousel.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Product_Carousel_Widget() );

		// Subscribe Box
		require_once( __DIR__ . '/elementor/widgets/chakta-subscribe-box.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Subscribe_Box_Widget() );
		
		// Testimonial
		require_once( __DIR__ . '/elementor/widgets/chakta-testimonial.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Testimonial_Widget() );
		
		// Latest Blog
		require_once( __DIR__ . '/elementor/widgets/chakta-latest-blog.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Latest_Blog_Widget() );
		
		// Client Carousel
		require_once( __DIR__ . '/elementor/widgets/chakta-client-carousel.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Client_Carousel_Widget() );
		
		// Single Image
		require_once( __DIR__ . '/elementor/widgets/chakta-single-image.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Single_Image_Widget() );
		
		// Block List
		require_once( __DIR__ . '/elementor/widgets/chakta-block-list.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Block_List_Widget() );
		
		// Team Box
		require_once( __DIR__ . '/elementor/widgets/chakta-team-box.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Team_Box_Widget() );
		
		// Contact Form 7
		require_once( __DIR__ . '/elementor/widgets/chakta-contact-form-7.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Contact_Form_7_Widget() );
		
		// Contact List
		require_once( __DIR__ . '/elementor/widgets/chakta-contact-list.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Contact_List_Widget() );

		// Stores Grid
		if (function_exists('get_wcmp_vendor_settings')) {
		require_once( __DIR__ . '/elementor/widgets/chakta-stores-grid.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Chakta_Stores_Grid_Widget() );
		}

	}
	
	
    /**
    * Admin notice
    *
    * Warning when the site doesn't have Elementor installed or activated.
    *
    * @since 1.0
    *
    * @access public
    */
    public function chakta_admin_notice_missing_main_plugin()
    {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__( '%1$s requires %2$s to be installed and activated.', 'chakta-core' ),
            '<strong>' . esc_html__( 'Chakta Core', 'chakta-core' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'chakta-core' ) . '</strong>'
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
    * Admin notice
    *
    * Warning when the site doesn't have a minimum required Elementor version.
    *
    * @since 1.0
    *
    * @access public
    */
    public function chakta_admin_notice_minimum_elementor_version()
    {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '%1$s requires %2$s version %3$s or greater.', 'chakta-core' ),
            '<strong>' . esc_html__( 'Chakta Core', 'chakta-core' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'chakta-core' ) . '</strong>',
             self::MINIMUM_ELEMENTOR_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
    * Admin notice
    *
    * Warning when the site doesn't have a minimum required PHP version.
    *
    * @since 1.0
    *
    * @access public
    */
    public function chakta_admin_notice_minimum_php_version()
    {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '%1$s requires %2$s version %3$s or greater.', 'chakta-core' ),
            '<strong>' . esc_html__( 'Chakta Core', 'chakta-core' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'chakta-core' ) . '</strong>',
             self::MINIMUM_PHP_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
	
    public function widget_styles()
    {
    }

    public function widget_scripts()
    {


		if (is_admin ()){
			wp_enqueue_media ();
			wp_enqueue_script( 'widget-image', plugins_url( 'js/widget-image.js', __FILE__ ));
		}

        // custom-scripts
        wp_enqueue_script( 'chakta-core-custom-scripts', plugins_url( 'elementor/custom-scripts.js', __FILE__ ), true );
    }
	
    public function widget_editor_scripts(){
		
		wp_enqueue_script( 'klb-editor-scripts', plugins_url( 'elementor/editor-scripts.js', __FILE__ ), true );

    }
	
	public function widget_editor_style(){
		
		wp_enqueue_style( 'klb-editor-style', plugins_url( 'elementor/editor-style.css', __FILE__ ), true );

    }


} 
Chakta_Elementor_Addons::instance();