<?php

/*************************************************
## Styles and Scripts
*************************************************/ 
define('KLB_INDEX_JS', plugin_dir_url( __FILE__ )  . '/js');
define('KLB_INDEX_CSS', plugin_dir_url( __FILE__ )  . '/css');

function klb_scripts() {
	wp_register_script( 'jquery-socialshare',    KLB_INDEX_JS . '/jquery-socialshare.js', array('jquery'), '1.0', true);
	wp_register_script( 'klb-social-share', 	  KLB_INDEX_JS . '/custom/social_share.js', array('jquery'), '1.0', true);
	wp_register_script( 'klb-widget-product-categories', 	  plugins_url( 'widgets/js/widget-product-categories.js', __FILE__ ), true );
	if (function_exists('get_wcmp_vendor_settings') && is_user_logged_in()) {
		if(is_vendor_dashboard()){
			wp_deregister_script( 'bootstrap');
			wp_deregister_script( 'jquery-nice-select');
		}
	}

}
add_action( 'wp_enqueue_scripts', 'klb_scripts' );

/*----------------------------
  Elementor Get Templates
 ----------------------------*/
if ( ! function_exists( 'chakta_get_elementorTemplates' ) ) {
    function chakta_get_elementorTemplates( $type = null )
    {
        if ( class_exists( '\Elementor\Plugin' ) ) {

            $args = [
                'post_type' => 'elementor_library',
                'posts_per_page' => -1,
            ];

            $templates = get_posts( $args );
            $options = array();

            if ( !empty( $templates ) && !is_wp_error( $templates ) ) {

				$options['0'] = esc_html__('Set a Template','chakta-core');

                foreach ( $templates as $post ) {
                    $options[ $post->ID ] = $post->post_title;
                }
            } else {
                $options = array(
                    '' => esc_html__( 'No template exist.', 'chakta-core' )
                );
            }

            return $options;
        }
    }
}

/*----------------------------
  Single Share
 ----------------------------*/
add_action( 'woocommerce_single_product_summary', 'chakta_social_share', 70);
function chakta_social_share(){
	$socialshare = get_theme_mod( 'chakta_shop_social_share', '0' );

	if($socialshare == '1'){
		wp_enqueue_script('jquery-socialshare');
		wp_enqueue_script('klb-social-share');
		
		$single_share_multicheck = get_theme_mod('chakta_shop_single_share',array( 'facebook', 'twitter', 'pinterest', 'linkedin', 'whatsapp'));
	
		echo '<ul class="social-link social-container">';
		
		   echo '<li><span>'.esc_html__('Share:','chakta-core').'</span></li>';
		   
			if(in_array('facebook', $single_share_multicheck)){
				echo '<li><a href="#" class="facebook" aria-label="'.esc_attr__('Share this page with Facebook','chakta-core').'" role="button"><i class="fab fa-facebook-f"></i></a></li>';
			}
		   
			if(in_array('twitter', $single_share_multicheck)){
				echo '<li><a href="#" class="twitter" aria-label="'.esc_attr__('Share this page with Twitter','chakta-core').'"><i class="fab fa-twitter"></i></a></li>';
			}
		   
			if(in_array('pinterest', $single_share_multicheck)){  
				echo '<li><a href="#" class="pinterest" aria-label="'.esc_attr__('Share this page with Pinterest','chakta-core').'"><i class="fab fa-pinterest"></i></a></li>';
			}
		   
			if(in_array('linkedin', $single_share_multicheck)){
				echo '<li><a href="#" class="linkedin" aria-label="'.esc_attr__('Share this page with Linkedin','chakta-core').'"><i class="fab fa-linkedin"></i></a></li>';
			}
			
			if(in_array('whatsapp', $single_share_multicheck)){
				echo '<li><a href="#" class="whatsapp" aria-label="'.esc_attr__('Share this page with Whatsapp','chakta-core').'"><i class="fab fa-whatsapp"></i></a></li>';
			}
		   
		echo '</ul>';
	}
}

/*----------------------------
  Disable Crop Image WCMP
 ----------------------------*/
add_filter('wcmp_frontend_dash_upload_script_params', 'chakta_crop_function');
function chakta_crop_function( $image_script_params ) {
	$image_script_params['canSkipCrop'] = true;
	return $image_script_params;
}
