<?php
	/**
	 * Include the TGM_Plugin_Activation class.
	 */
	add_action('tgmpa_register', 'gymx_register_plugins');
	/**
	 * Register the required plugins for this theme.
	 * The variable passed to tgmpa_register_plugins() should be an array of plugin
	 * arrays.
	 * This function is hooked into tgmpa_init, which is fired within the
	 * TGM_Plugin_Activation class constructor.
	 */
	function gymx_register_plugins() {
		/**
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		// Visual Composer
		$plugins = array(
			array(
				'name'               => esc_attr__('TTBase Framework with GymX Extension', 'gymx'), // The plugin name
				'slug'               => 'ttbase-framework', // The plugin slug (typically the folder name)
				'source'             => get_template_directory_uri() . '/framework/plugins/ttbase-framework.zip', // The plugin source', // The plugin source
				'required'           => TRUE, // If false, the plugin is only 'recommended' instead of required
				'version'            => '2.3.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => FALSE, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => TRUE, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_attr__('WPBakery Page Builder', 'gymx'), // The plugin name
				'slug'               => 'js_composer', // The plugin slug (typically the folder name)
				'source'             => get_template_directory_uri() . '/framework/plugins/js_composer.zip', // The plugin source
				'required'           => TRUE, // If false, the plugin is only 'recommended' instead of required
				'version'            => '6.4.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => FALSE, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => TRUE, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '', // If set, overrides default API URL and points to an external URL
			),
			// Timetable
			array(
				'name'     				=> esc_attr__('Timetable Responsive Schedule', 'gymx'), // The plugin name
				'slug'     				=> 'timetable', // The plugin slug (typically the folder name)
				'source'   				=> get_template_directory_uri() . '/framework/plugins/timetable.zip', // The plugin source
				'required' 				=> FALSE, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '6.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> FALSE, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> FALSE, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),
			// Revolution Slider
			array(
				'name'     				=> esc_attr__('Revolution Slider', 'gymx'), // The plugin name
				'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
				'source'   				=> get_template_directory_uri() . '/framework/plugins/revslider.zip', // The plugin source
				'required' 				=> FALSE, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '6.2.23', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> FALSE, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> FALSE, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),
			array(
	        	'name'      		=> esc_attr__('Contact Form 7', 'gymx'),
	        	'slug'      		=> 'contact-form-7',
	        	'required'  		=> FALSE,
	        	'force_activation'	=> FALSE,
	        )
		);

		$config = array(
			'domain'       		=> 'gymx',
			'default_path' 		=> '',			
			'menu'         		=> 'install-required-plugins', 
			'has_notices'      	=> TRUE,                       
			'is_automatic'    	=> FALSE,					   
			'message' 			=> ''
		);
		
		tgmpa($plugins, $config);
	}