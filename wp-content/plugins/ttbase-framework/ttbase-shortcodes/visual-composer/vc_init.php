<?php
/**
 * Init Visual Composer Settings and map shortcodes
 *
 */
 
function ttbase_framework_shortcodes_vc_init() {
	
	/* ------------------------------------------------------------------------------- */
	/* VC Parameters
	/* ------------------------------------------------------------------------------- */
	
	/* Number ------------------------------------------------------------------------ */

	function ttbase_framework_shortcodes_number_settings_field($settings, $value) {
		
		$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
		$type       = isset($settings['type']) ? $settings['type'] : '';
		$min        = isset($settings['min']) ? $settings['min'] : '';
		$max        = isset($settings['max']) ? $settings['max'] : '';
		$suffix     = isset($settings['suffix']) ? $settings['suffix'] : '';
		$class      = isset($settings['class']) ? $settings['class'] : '';
		$output     = '<input type="number" min="' . $min . '" max="' . $max . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" style="max-width:100px; margin-right: 10px;" />' . $suffix;
		return $output;
	}

	if (function_exists('vc_add_shortcode_param')) {
		vc_add_shortcode_param('number', 'ttbase_framework_shortcodes_number_settings_field');
	}
	
	
	//Font Awesome Icon Param ------------------------------------------------------------- >
	function ttbase_framework_shortcodes_font_awesome_icon_field( $settings, $value ) {
        
        $return = '<div class="my_param_block">
            <div class="ttbase-font-awesome-icon-preview"></div>
            <input placeholder="' . esc_html__( "Type in an icon name or select one from below", 'ttbase-framework' ) . '" name="' . $settings['param_name'] . '"'
        . ' data-param-name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'].' '.$settings['type'].'_field" type="text" value="'. $value .'" style="width: 100%; vertical-align: top; margin-bottom: 10px" />';
        $return .= '<div class="ttbase-font-awesome-icon-select-window">
                    <span class="fa fa-times" style="color:red;" data-name="clear"></span>';
                        $icons = ttbase_framework_shortcodes_font_icons_array();
                        foreach ( $icons as $icon ) {
                            if ( '' != $icon ) {
                                if ( $value == $icon ) {
                                    $active = 'active';
                                } else {
                                    $active = '';
                                }
                                $return .= '<span class="fa fa-'. $icon .' '. $active .'" data-name="'. $icon .'"></span>';
                            }
                        }
        $return .= '</div></div><div style="clear:both;"></div>';
        return $return;
    }
    if (function_exists('vc_add_shortcode_param')) {
		vc_add_shortcode_param('font_awesome_icon', 'ttbase_framework_shortcodes_font_awesome_icon_field', TTBASE_FRAMEWORK_URL .'ttbase-shortcodes/shortcodes/js/ttbase-icon-type.min.js');
	}
	
	//Streamline Icon Param ------------------------------------------------------------- >
	function ttbase_framework_shortcodes_streamline_icon_field( $settings, $value ) {
        
        $return = '<div class="my_param_block">
            <div class="ttbase-streamline-icon-preview"></div>
            <input placeholder="' . esc_html__( "Type in an icon name or select one from below", 'ttbase-framework' ) . '" name="' . $settings['param_name'] . '"'
        . ' data-param-name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'].' '.$settings['type'].'_field" type="text" value="'. $value .'" style="width: 100%; vertical-align: top; margin-bottom: 10px" />';
        $return .= '<div class="ttbase-streamline-icon-select-window">
                    <span class="fa fa-times" style="color:red;" data-name="clear"></span>';
                        $icons = ttbase_framework_shortcodes_streamline_font_icons_array();
                        foreach ( $icons as $icon ) {
                            if ( '' != $icon ) {
                                if ( $value == $icon ) {
                                    $active = 'active';
                                } else {
                                    $active = '';
                                }
                                $return .= '<span class="sl sl-'. $icon .' '. $active .'" data-name="'. $icon .'"></span>';
                            }
                        }
        $return .= '</div></div><div style="clear:both;"></div>';
        return $return;
    }
    if (function_exists('vc_add_shortcode_param')) {
		vc_add_shortcode_param('streamline_icon', 'ttbase_framework_shortcodes_streamline_icon_field', TTBASE_FRAMEWORK_URL .'ttbase-shortcodes/shortcodes/js/ttbase-icon-type.min.js');
	}
	
	//Icons Mind Icon Param ------------------------------------------------------------- >
	function ttbase_framework_shortcodes_iconsmind_icon_field( $settings, $value ) {
        
        $return = '<div class="my_param_block">
            <div class="ttbase-iconsmind-icon-preview"></div>
            <input placeholder="' . esc_html__( "Type in an icon name or select one from below", 'ttbase-framework' ) . '" name="' . $settings['param_name'] . '"'
        . ' data-param-name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'].' '.$settings['type'].'_field" type="text" value="'. $value .'" style="width: 100%; vertical-align: top; margin-bottom: 10px" />';
        $return .= '<div class="ttbase-iconsmind-icon-select-window">
                    <span class="fa fa-times" style="color:red;" data-name="clear"></span>';
                        $icons = ttbase_framework_shortcodes_iconsmind_font_icons_array();
                        foreach ( $icons as $icon ) {
                            if ( '' != $icon ) {
                                if ( $value == $icon ) {
                                    $active = 'active';
                                } else {
                                    $active = '';
                                }
                                $return .= '<span class="im im-'. $icon .' '. $active .'" data-name="'. $icon .'"></span>';
                            }
                        }
        $return .= '</div></div><div style="clear:both;"></div>';
        return $return;
    }
    if (function_exists('vc_add_shortcode_param')) {
		vc_add_shortcode_param('iconsmind_icon', 'ttbase_framework_shortcodes_iconsmind_icon_field', TTBASE_FRAMEWORK_URL .'ttbase-shortcodes/shortcodes/js/ttbase-icon-type.min.js');
	}
	
    /* Team Category Dropdown --------------------------------------------------- */

	function ttbase_framework_team_cats_settings_field($settings, $value) {

		$cats_output = '<div class="team_categories">'
			. '<select name="' . $settings['param_name']
			. '" class="wpb_vc_param_value wpb-select dropdown '
			. $settings['param_name'] . ' ' . $settings['type'] . '_field">'
			. '<option value="">All Categories</option>';
		/* Get categories */
		$terms = get_terms('team_category', array(
			'orderby'    => 'name',
			'hide_empty' => TRUE
		));
		foreach ($terms as $term) {
			$cats_output .= '<option value="' . $term->term_id . '"';
			if ($term->term_id == $value) {
				$cats_output .= 'selected="selected"';
			}
			$cats_output .= '>' . $term->name . '</option>';
		}
		$cats_output .= '</select>'
			. '</div>';
		return $cats_output;
	}

	if (function_exists('vc_add_shortcode_param')) {
		vc_add_shortcode_param('team_cats', 'ttbase_framework_team_cats_settings_field');
	}
	
	//dropdownmulti
	vc_add_shortcode_param('dropdownmulti' , 'ttbase_framework_dropdownmultiple_settings_field');
	function ttbase_framework_dropdownmultiple_settings_field($settings, $value)
	{
		$value = ($value==null ? array() : $value);
		if(!is_array($value))
			$value = explode(",", $value);
		$output = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'" multiple>';
				foreach ( $settings['value'] as $text_val => $val ) {
					if ( is_numeric($text_val) && is_string($val) || is_numeric($text_val) && is_numeric($val) ) {
						$text_val = $val;
					}
					$text_val = esc_html__($text_val, "js_composer");
				   // $val = strtolower(str_replace(array(" "), array("_"), $val));
					$selected = '';
					if ( in_array($val,$value) ) $selected = ' selected="selected"';
					$output .= '<option class="'.$val.'" value="'.$val.'"'.$selected.'>'.$text_val.'</option>';
				}
				$output .= '</select>';
		return $output;
	}
	//hidden
	vc_add_shortcode_param('hidden', 'ttbase_framework_hidden_settings_field');
	function ttbase_framework_hidden_settings_field($settings, $value) 
	{
	   return '<input name="'.$settings['param_name']
				 .'" class="wpb_vc_param_value wpb-textinput '
				 .$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'
				 .$value.'"/>';
	}

}
add_action( 'vc_before_init', 'ttbase_framework_shortcodes_vc_init' );

// Map Shortcodes ----------------------------------------------------------------------->

require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_blog.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_button.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_callout.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_content-image.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_counter.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_google-map.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_half-carousel.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_heading.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_highlight.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_ft-carousel.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_icon.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_icon-box.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_image-box.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_image-carousel.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_image-gallery.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_items-list.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_modal.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_newsletter.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_post-carousel.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_post-grid.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_pricing.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_progressbar.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_spacer.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_tabs.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_table.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_text-intro.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_testimonial-carousel.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_testimonial-grid.php' );
require_once( plugin_dir_path( __FILE__ ) . '/parts/vc_wpml.php' );

//Add custom css to Visual Composer Admin
function ttbase_framework_shortcodes_vc_admin_css() {
	if ( class_exists( 'Vc_Manager' ) ) {
		wp_enqueue_style( 'ttbase-shortcodes-vc', TTBASE_FRAMEWORK_URL. 'ttbase-shortcodes/visual-composer/css/ttbase-shortcodes-vc.css',array(),null );
		wp_enqueue_style( 'gymx-streamline', TTBASE_FRAMEWORK_URL . 'css/gymx-streamline.min.css' );
		wp_enqueue_style( 'iconsmind', TTBASE_FRAMEWORK_URL . 'css/iconsmind.min.css' );
	}
}
add_action( 'admin_enqueue_scripts', 'ttbase_framework_shortcodes_vc_admin_css' );