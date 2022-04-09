<?php
/**
 * Adds typography options to the Customizer and outputs the custom CSS for them
 * 
 */

if ( ! class_exists( 'GymX_Theme_Customizer_Typography' ) ) {
	class GymX_Theme_Customizer_Typography {

		/*-----------------------------------------------------------------------------------*/
		/*	- Constructor
		/*-----------------------------------------------------------------------------------*/
		public function __construct() {
			// Loads customizer js file for postmessage transport method
			//add_action( 'customize_preview_init', array( $this, 'preview_init' ) );
			add_action( 'customize_register', array( $this , 'gymx_register' ) );
			add_action( 'customize_save_after', array( $this, 'gymx_reset_cache' ) );
			add_action( 'wp_head', array( $this, 'gymx_load_fonts' ) );
			add_action( 'wp_head', array( $this, 'gymx_output_css' ) );
		}
		
		function gymx_typo_sanitize_choices( $input, $setting ) {
			global $wp_customize;
		 
			$control = $wp_customize->get_control( $setting->id );
		 
			if ( array_key_exists( $input, $control->choices ) ) {
				return $input;
			} else {
				return $setting->default;
			}
		}
		
		/*-----------------------------------------------------------------------------------*/
		/*	- Array of elements for typography options
		/*-----------------------------------------------------------------------------------*/
		public function gymx_elements() {
			$array = array(
				'body'	=> array(
					'label'		=>	esc_html__( 'Body', 'gymx' ),
					'target'	=>	'body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title'
				),
				'paragraph'	=> array(
					'label'		=>	esc_html__( 'Paragraph <p>', 'gymx' ),
					'target'	=>	'p, .textwidget'
				),
				'intro'	=> array(
					'label'		=>	esc_html__( 'Intro Text', 'gymx' ),
					'target'	=>	'.intro'
				),
				'headings_xl_title'	=> array(
					'label'		=> esc_html__( 'Page Title XL', 'gymx' ),
					'target'	=> '.x-large .header_text_wrapper h1'
				),
				'headings_xl_subtitle'	=> array(
					'label'		=> esc_html__( 'Page Title XL Subtitle', 'gymx' ),
					'target'	=> '.header_text_wrapper .subtitle'
				),
				'headings_large_title'	=> array(
					'label'		=> esc_html__( 'Page Title L', 'gymx' ),
					'target'	=> '.large .header_text_wrapper h1'
				),
				'headings_small_title'	=> array(
					'label'		=> esc_html__( 'Page Title S', 'gymx' ),
					'target'	=> '.small .header_text_wrapper h1'
				),
				'headings_xs_title'	=> array(
					'label'		=> esc_html__( 'Page Title XS', 'gymx' ),
					'target'	=> '.x-small .header_text_wrapper h1'
				),
				'headings2'	=> array(
					'label'		=> esc_html__( 'Heading H2', 'gymx' ),
					'target'	=> 'h2'
				),
				'headings3'	=> array(
					'label'		=> esc_html__( 'Heading H3', 'gymx' ),
					'target'	=> 'h3'
				),
				'headings4'	=> array(
					'label'		=> esc_html__( 'Heading H4', 'gymx' ),
					'target'	=> 'h4'
				),
				'headings5'	=> array(
					'label'		=> esc_html__( 'Heading H5', 'gymx' ),
					'target'	=> 'h5'
				),
				'nav_menu'	=> array(
					'label'		=> esc_html__( 'Main Menu', 'gymx' ),
					'target'	=> '.nav-menu li a, .nav-menu li.menu-button a'
				),
				'menu_dropdown'	=> array(
					'label'		=> esc_html__( 'Main Menu: Dropdowns', 'gymx' ),
					'target'	=> '.nav-menu ul ul li a'
				),
				'mobile_menu'	=> array(
					'label'		=> esc_html__( 'Mobile Menu', 'gymx' ),
					'target'	=> '#mobile-navigation ul li a'
				),
				'breadcrumb'	=> array(
					'label'		=> esc_html__( 'Breadcrumbs', 'gymx' ),
					'target'	=> '.breadcrumb'
				),
				'sidebar_widget_title'	=> array(
					'label'		=> esc_html__( 'Sidebar Widget Heading', 'gymx' ),
					'target'	=> '.sidebar.widget .title'
				),
				'footer_widget_title'	=> array(
					'label'		=> esc_html__( 'Footer Widget Heading', 'gymx' ),
					'target'	=> '.site-footer .widget .title'
				),
				'footer_paragraph'	=> array(
					'label'		=>	esc_html__( 'Footer Paragraph <p>', 'gymx' ),
					'target'	=>	'.site-footer p'
				),
				'footer_list'	=> array(
					'label'		=>	esc_html__( 'Footer Lists <ul>', 'gymx' ),
					'target'	=>	'.site-footer ul'
				),
				'blog_post_title'	=> array(
					'label'			=> esc_html__( 'Blog Post Title', 'gymx' ),
					'target'		=> '.blog-normal .content-wrap .entry-title'
				),
				'forms_label'	=> array(
					'label'			=> esc_html__( 'Forms Label', 'gymx' ),
					'target'		=> 'label'
				),
				'copyright'	=> array(
					'label'		=> esc_html__( 'Copyright', 'gymx' ),
					'target'	=> '.site-info'
				),
				'button'	=> array(
					'label'		=> esc_html__( 'Primary Button', 'gymx' ),
					'target'	=> '.btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button'
				),
				'tab'	=> array(
					'label'		=> esc_html__( 'Accordion&Tabs', 'gymx' ),
					'target'	=> '.vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a, .timetable-tabs.ui-tabs .ui-tabs-nav li a, .ttbase-trainer-filter-list li a, .ttbase-class-filter-list li a'
				),
				'quote'	=> array(
					'label'		=> esc_html__( 'Quotes', 'gymx' ),
					'target'	=> 'blockquote'
				),
				// 'load_custom_font_1'	=> array(
				// 	'label'				=> esc_html__( 'Load Custom Font', 'gymx' ),
				// 	'settings'			=> array( 'font-family' )
				// ),
			);
			if (post_type_exists('classes')) {
				$array['timetable'] = array(
					'label'		=> esc_html__( 'Schedule', 'gymx' ),
					'target'	=> '.timetable, .timetable.small .box_header'
				);
			}
			return $array;
		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Register Typography Panel and Sections
		/*-----------------------------------------------------------------------------------*/
		public function gymx_register ( $wp_customize ) {
		    
			require_once get_template_directory() . '/framework/customizer/controls.php';
			
			// Get elements
			$elements = $this->gymx_elements();

			// Return if elements are empty. This check is needed due to the filter added above
			if ( empty( $elements ) ) {
				return;
			}
			
			// Add General Panel
			$wp_customize->add_panel( 'gymx_typography', array(
				'priority'		=> 25,
				'capability'	=> 'edit_theme_options',
				'title'			=> esc_html__( 'Typography', 'gymx' ),
			) );
			
			// Add General Tab with font smoothing
			$wp_customize->add_section( 'gymx_typography_general' , array(
				'title' => esc_html__( 'General', 'gymx' ),
				'priority' => 1,
				'panel' => 'gymx_typography',
			) );

			// Font Smoothing
			$wp_customize->add_setting( 'gymx_enable_font_smoothing', array(
				'type' => 'theme_mod',
				'default' => false,
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'gymx_enable_font_smoothing', array(
				'label' => esc_html__( 'Font Smoothing', 'gymx' ),
				'section' => 'gymx_typography_general',
				'settings' => 'gymx_enable_font_smoothing',
				'priority' => 1,
				'type' => 'checkbox',
				'description' => esc_html__( 'Enable font-smoothing site wide. This makes fonts look a little "skinner".', 'gymx' ),
			) ) );


			// Lopp through elements
			$count = '1';
			foreach( $elements as $element => $array ) {
				$count++;
				
				// Get label
				$label            = ! empty( $array['label'] ) ? $array['label'] : '';
				$exclude_settings = ! empty( $array['exclude'] ) ? $array['exclude'] : '';
				$active_callback  = isset( $array['active_callback'] ) ? $array['active_callback'] : '';
				$margin           = isset( $array['margin'] ) ? true : false;
				
				// Get settings
				if ( ! isset ( $array['settings'] ) ) {
					$settings = array(
						'font-family',
						'font-weight',
						'font-style',
						'text-transform',
						'font-size',
						'line-height',
						'letter-spacing',
						//'font-color',
					);
				} else {
					$settings = $array['settings'];
				}

				// Set keys equal to vals
				$settings = array_combine( $settings, $settings );

				// Exclude options
				if ( $exclude_settings ) {
					foreach ( $exclude_settings as $key => $val ) {
						unset( $settings[ $val ] );
					}
				}

				if ( $label ) {

					// Define Section
					$wp_customize->add_section( 'gymx_typography_'. $element , array(
						'title' => $label,
						'priority' => $count,
						'panel' => 'gymx_typography',
					) );

					// Font Family
					if ( in_array( 'font-family', $settings ) ) {

						// Get default
						$default = ! empty( $array['defaults']['font-family'] ) ? $array['defaults']['font-family'] : NULL;

						// Add setting
						$wp_customize->add_setting( 'gymx_' . $element .'_typography[font-family]', array(
							'type' => 'theme_mod',
							'default' => $default,
							'sanitize_callback' => false,
						) );

						// Add Control
						$wp_customize->add_control( new gymx_Fonts_Dropdown_Custom_Control( $wp_customize, 'gymx_' . $element .'_typography[font-family]', array(
								'label' => esc_html__( 'Font Family', 'gymx' ),
								'section' => 'gymx_typography_'. $element,
								'settings' => 'gymx_' .$element .'_typography[font-family]',
								'priority' => 1,
								'active_callback' => $active_callback,
						) ) );

					}

					// Font Weight
					if ( in_array( 'font-weight', $settings ) ) {
						$wp_customize->add_setting( 'gymx_' .$element .'_typography[font-weight]', array(
							'type' => 'theme_mod',
							'description' => esc_html__( 'Note: Not all Fonts support every font weight style.', 'gymx' ),
							'sanitize_callback' => false,
						) );
						$wp_customize->add_control( 'gymx_' .$element .'_typography[font-weight]', array(
							'label' => esc_html__( 'Font Weight', 'gymx' ),
							'section' => 'gymx_typography_'. $element,
							'settings' => 'gymx_' .$element .'_typography[font-weight]',
							'priority' => 2,
							'type' => 'select',
							'active_callback' => $active_callback,
							'choices' => array (
								'' => esc_html__( 'Default', 'gymx' ),
								'100' => esc_html__( 'Extra Light: 100', 'gymx' ),
								'200' => esc_html__( 'Light: 200', 'gymx' ),
								'300' => esc_html__( 'Book: 300', 'gymx' ),
								'400' => esc_html__( 'Normal: 400', 'gymx' ),
								'500' => esc_html__( 'Medium: 500', 'gymx' ),
								'600' => esc_html__( 'Semibold: 600', 'gymx' ),
								'700' => esc_html__( 'Bold: 700', 'gymx' ),
								'800' => esc_html__( 'Extra Bold: 800', 'gymx' ),
							),
							'description' => esc_html__( 'Important: Not all fonts support every font-weight.', 'gymx' ),
						) );
					}

					// Font Style
					if ( in_array( 'font-style', $settings ) ) {
						$wp_customize->add_setting( 'gymx_' .$element .'_typography[font-style]', array(
							'type' => 'theme_mod',
							'sanitize_callback' => false,
						) );
						$wp_customize->add_control( 'gymx_' .$element .'_typography[font-style]', array(
							'label' => esc_html__( 'Font Style', 'gymx' ),
							'section' => 'gymx_typography_'. $element,
							'settings' => 'gymx_' .$element .'_typography[font-style]',
							'priority' => 3,
							'type' => 'select',
							'active_callback' => $active_callback,
							'choices' => array (
								'' => esc_html__( 'Default', 'gymx' ),
								'normal' => esc_html__( 'Normal', 'gymx' ),
								'italic' => esc_html__( 'Italic', 'gymx' ),
							),
						) );
					}

					// Text-Transform
					if ( in_array( 'text-transform', $settings ) ) {
						$wp_customize->add_setting( 'gymx_' .$element .'_typography[text-transform]', array(
							'type' => 'theme_mod',
							'sanitize_callback' => false,
						) );
						$wp_customize->add_control( 'gymx_' .$element .'_typography[text-transform]', array(
							'label' => esc_html__( 'Text Transform', 'gymx' ),
							'section' => 'gymx_typography_'. $element,
							'settings' => 'gymx_' .$element .'_typography[text-transform]',
							'priority' => 4,
							'type' => 'select',
							'active_callback' => $active_callback,
							'choices' => array (
								'' => esc_html__( 'Default', 'gymx' ),
								'capitalize' => esc_html__( 'Capitalize', 'gymx' ),
								'lowercase' => esc_html__( 'Lowercase', 'gymx' ),
								'uppercase' => esc_html__( 'Uppercase', 'gymx' ),
								'none' => esc_html__( 'None', 'gymx' ),
							),
						) );
					}

					// Font Size
					if ( in_array( 'font-size', $settings ) ) {
						$wp_customize->add_setting( 'gymx_' .$element .'_typography[font-size]', array(
							'type' => 'theme_mod',
							'sanitize_callback' => false,
						) );
						$wp_customize->add_control( 'gymx_' .$element .'_typography[font-size]', array(
							'label' => esc_html__( 'Font Size', 'gymx' ),
							'section' => 'gymx_typography_'. $element,
							'settings' => 'gymx_' .$element .'_typography[font-size]',
							'priority' => 5,
							'type' => 'text',
							'description' => esc_html__( 'Value in pixels.', 'gymx' ),
							'active_callback' => $active_callback,
						) );
					}

					// Font Color
					if ( in_array( 'font-color', $settings ) ) {
						$wp_customize->add_setting( 'gymx_' .$element .'_typography[color]', array(
							'type' => 'theme_mod',
							'default' => '',
							'sanitize_callback' => false,
						) );
						$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'gymx_' . $element .'_typography_color', array(
							'label' => esc_html__( 'Font Color', 'gymx' ),
							'section' => 'gymx_typography_'. $element,
							'settings' => 'gymx_' . $element .'_typography[color]',
							'priority' => 6,
							'active_callback' => $active_callback,
						) ) );
					}

					// Line Height
					if ( in_array( 'line-height', $settings ) ) {
						$wp_customize->add_setting( 'gymx_' . $element .'_typography[line-height]', array(
							'type' => 'theme_mod',
							'sanitize_callback' => false,
						) );
						$wp_customize->add_control( 'gymx_' . $element .'_typography[line-height]',
							array(
								'label' => esc_html__( 'Line Height', 'gymx' ),
								'section' => 'gymx_typography_'. $element,
								'settings' => 'gymx_' . $element .'_typography[line-height]',
								'priority' => 7,
								'type' => 'text',
								'active_callback' => $active_callback,
						) );
					}

					// Letter Spacing
					if ( in_array( 'letter-spacing', $settings ) ) {
						$wp_customize->add_setting( 'gymx_' . $element .'_typography[letter-spacing]', array(
							'type' => 'theme_mod',
							'sanitize_callback' => false,
						) );
						$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'gymx_' . $element .'_typography_letter_spacing', array(
							'label' => esc_html__( 'Letter Spacing', 'gymx' ),
							'section' => 'gymx_typography_'. $element,
							'settings' => 'gymx_' . $element .'_typography[letter-spacing]',
							'priority' => 8,
							'type' => 'text',
							'active_callback' => $active_callback,
						) ) );
					}

					// Margin
					if ( $margin ) {
						$wp_customize->add_setting( 'gymx_' . $element .'_typography[margin]', array(
							'type' => 'theme_mod',
							'sanitize_callback' => false,
						) );
						$wp_customize->add_control( 'gymx_' . $element .'_typography[margin]',
							array(
								'label' => esc_html__( 'Margin', 'gymx' ),
								'section' => 'gymx_typography_'. $element,
								'settings' => 'gymx_' . $element .'_typography[margin]',
								'priority' => 9,
								'type' => 'text',
								'active_callback' => $active_callback,
						) );
					}

				}
			}
		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Reset Cache after customizer save
		/*-----------------------------------------------------------------------------------*/
		public function gymx_reset_cache() {
			remove_theme_mod( 'gymx_customizer_typography_cache' );
		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Output Custom CSS
		/*-----------------------------------------------------------------------------------*/
		public function gymx_loop( $return = 'css' ) {
			// Get typography data cache
			$data = get_theme_mod( 'gymx_customizer_typography_cache', false );
			// If theme mod cache empty or is live customizer loop through elements and set output
			if ( empty( $data ) || is_customize_preview() ) {
				// Define Vars
				$css			= '';
				$load_scripts	= '';
				$fonts			= array();
				$scripts		= array();
				$scripts_output = '';
				$elements		= $this->gymx_elements();
				// Loop through each elements that need typography styling applied to them
				foreach( $elements as $element => $array ) {
					// Attributes to loop through
					if ( ! empty( $array['settings'] ) ) {
						$attributes = $array['settings'];
					} else {
						$attributes = array( 'font-family', 'font-weight', 'font-style', 'font-size', 'color', 'line-height', 'letter-spacing', 'text-transform', 'margin' );
					}
					$add_css	= '';
					$target		= isset( $array['target'] ) ? $array['target'] : '';
					$get_mod	= get_theme_mod( 'gymx_' . $element .'_typography' );
					foreach ( $attributes as $attribute ) {
						$val = isset ( $get_mod[$attribute] ) ? $get_mod[$attribute] : '';
						if ( $val ) {
							// Sanitize
						$val = str_replace( '"', '', $val );

						// Sanitize data
						$val = ( 'font-size' == $attribute ) ? gymx_sanitize_data( $val, 'font_size' ) : $val;
						$val = ( 'letter-spacing' == $attribute ) ? gymx_sanitize_data( $val, 'px' ) : $val;
						$val = ( 'line-height' == $attribute ) ? gymx_sanitize_data( $val, 'px' ) : $val;

						// Add quotes around font-family && font family to scripts array
						if ( 'font-family' == $attribute ) {
							$fonts[] = $val;
							$val = $val;
						}
							// Add custom CSS
							$add_css .= $attribute .':'. $val .';';
						}
					}
					if ( $add_css ) {
						$css .= $target .'{'. $add_css .'}';
					} 
				}
				if ( $css || $fonts ) {
					// Only load 1 of each font
					if ( ! empty( $fonts ) ) {
						array_unique( $fonts );
					}
					// Get Google Scripts to load on the front end
					if ( ! empty ( $fonts ) ) {
						$google_fonts	= gymx_google_fonts_array();
						// Loop through fonts and create Google Font Link
						foreach ( $fonts as $font ) {
							if ( in_array( $font, $google_fonts ) ) {
								$scripts[] = 'https://fonts.googleapis.com/css?family='.str_replace(' ', '%20', $font ) .'';
							}
						}
						// If scripts need to be loaded create the link tags
						if ( ! empty( $scripts ) ) {
							$scripts_output = '<!-- Load Google Fonts -->';
							foreach ( $scripts as $script ) {
								$scripts_output .= '<link href="'. $script .':300italic,400italic,500italic,600italic,700italic,800italic,400,300,500,600,700,800&amp;subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic" rel="stylesheet" type="text/css">';
							}
						}
					}
				}
			}
			// Set cache or get cache if not in customizer
			if ( ! is_customize_preview() ) {
				// Get Cache vars
				if ( $data ) {
					$css			= isset( $data['css'] ) ? $data['css'] : '';
					$fonts			= isset( $data['fonts'] ) ? $data['fonts'] : '';
					$scripts		= isset( $data['scripts'] ) ? $data['scripts'] : '';
					$scripts_output	= isset( $data['scripts_output'] ) ? $data['scripts_output'] : '';
				}
				// Set Cache
				else {
					set_theme_mod( 'gymx_customizer_typography_cache', array (
						'css'				=> $css,
						'fonts'				=> $fonts,
						'scripts'			=> $scripts,
						'scripts_output'	=> $scripts_output,
					) );
				}
			}
			// Return CSS
			if ( 'css' == $return && $css ) {
				$css = '<!-- Typography CSS --><style type="text/css">'. $css .'</style>';
				return $css;
			}
			// Return Fonts Array
			if ( 'fonts' == $return && ! empty( $fonts ) ) {
				return $fonts;
			}
			// Return Scripts Array
			if ( 'scripts' == $return && ! empty( $scripts ) ) {
				return $scripts;
			}
			// Return Scripts Output
			if ( 'scripts_output' == $return && $scripts_output ) {
				return $scripts_output;
			}
		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Output Custom CSS
		/*-----------------------------------------------------------------------------------*/
		public function gymx_output_css() {
			echo GymX_Theme_Customizer_Typography::gymx_loop( 'css' );
		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Load Google Fonts
		/*-----------------------------------------------------------------------------------*/
		public function gymx_load_fonts() {
			echo GymX_Theme_Customizer_Typography::gymx_loop( 'scripts_output' );
		}
		
		/**
		 * Loads customizer js file for postmessage transport method
		 *
		 * @link http://codex.wordpress.org/Theme_Customization_API
		 */
		public function gymx_preview_init() {
			wp_enqueue_script(
				'gymx-typography-postmessage',
				get_template_directory_uri() . '/framework/customizer/assets/typography-postmessage.js',
				array( 'jquery','customize-preview' ),
				false,
				true
			);
		}

	}
}
new GymX_Theme_Customizer_Typography();