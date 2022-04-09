<?php 

/**
 * Init our framework options based on the theme options
 * if ttbase_framework_options is not set, everything is disabled by default
 */
$defaults = array(
	'ttbase_shortcodes'     => '0',
	'ttbase_widgets'        => '0',
	'portfolio_post_type'   => '0',
	'team_post_type'        => '0',
	'client_post_type'      => '0',
	'testimonial_post_type' => '0',
	'service_post_type' 	=> '0',
	'gymx_extension'		=> '0'
);
$framework_options = wp_parse_args( get_option('ttbase_framework_options'), $defaults);

/**
 * Turn on the image resizer.
 */
require_once( TTBASE_FRAMEWORK_PATH . 'inc/image-resize.php' );

/**
 * Register post meta boxes
 */
require_once( TTBASE_FRAMEWORK_PATH . 'meta-box/meta-box.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'meta-box/meta-box-tabs/meta-box-tabs.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'meta-box/meta-box-group/meta-box-group.php' );
require_once( TTBASE_FRAMEWORK_PATH . 'meta-box/meta-box-conditional-logic/meta-box-conditional-logic.php' );

/**
 * Register appropriate shortcodes
 */
if( '1' == $framework_options['ttbase_shortcodes'] ){
	require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-shortcodes/ttbase-shortcodes.php' );	
}

/**
 * Register appropriate widgets
 */
if( '1' == $framework_options['ttbase_widgets'] ){
	require_once( TTBASE_FRAMEWORK_PATH . 'widgets/ttbase-widgets.php' );	
}


/**
 * Register Portfolio Post Type
 */
if( '1' == $framework_options['portfolio_post_type'] ){
	require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-post-types/portfolio/portfolio_init.php' );
}

/**
 * Register Team Post Type
 */
if( '1' == $framework_options['team_post_type'] ){
	require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-post-types/team/team_init.php' );
}

/**
 * Register Client Post Type
 */
if( '1' == $framework_options['client_post_type'] ){
	require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-post-types/client/client_init.php' );
}

/**
 * Register Testimonial Post Type
 */
if( '1' == $framework_options['testimonial_post_type'] ){
	require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-post-types/testimonial/testimonial_init.php' );
}

/**
 * Register Service Post Type
 */
if( '1' == $framework_options['service_post_type'] ){
	require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-post-types/service/service_init.php' );
}

/**
 * Register GymX Theme Extensions
 */
if( '1' == $framework_options['gymx_extension'] ){
	//Register post types
	
	if ( get_theme_mod('gymx_weekdays_enabled', 'yes') != 'no' ) {
		require_once( TTBASE_FRAMEWORK_PATH . 'gymx-ext/post-types/weekday/weekday_init.php' );
	}
	
	require_once( TTBASE_FRAMEWORK_PATH . 'gymx-ext/post-types/trainer/trainer_init.php' );
	
	if ( get_theme_mod('gymx_classes_enabled', 'yes') != 'no' ) {
		require_once( TTBASE_FRAMEWORK_PATH . 'gymx-ext/post-types/class/class_init.php' );
	}
	
	//Register Metaboxes for post types
	require_once( TTBASE_FRAMEWORK_PATH . 'gymx-ext/gymx-meta-boxes.php' );
	
	//Register Shortcodes
	require_once( TTBASE_FRAMEWORK_PATH . 'gymx-ext/shortcodes/gymx-shortcodes.php' );
}

/**
 * Add TinyMCE Table Plugin
 */
require_once( TTBASE_FRAMEWORK_PATH . 'mce-table-buttons/mce_table_buttons.php' );

/**
 * Include Demo Importer
 */
require_once( TTBASE_FRAMEWORK_PATH . 'ttbase-demo-importer/one-click-demo-import.php' );

/**
 * Include Sanitize
 */
require_once( TTBASE_FRAMEWORK_PATH . 'inc/sanitize-data.php' );

/**
 * Include TTBase Admin Section
 */
require_once( TTBASE_FRAMEWORK_PATH . 'admin/admin.php' );