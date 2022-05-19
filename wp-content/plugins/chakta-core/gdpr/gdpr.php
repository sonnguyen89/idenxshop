<?php

/*************************************************
## Scripts
*************************************************/
function chakta_gdpr_scripts() {
	wp_register_style( 'klb-gdpr',   plugins_url( 'css/gdpr.css', __FILE__ ), false, '1.0');
	wp_register_script( 'klb-gdpr',  plugins_url( 'js/gdpr.js', __FILE__ ), true );

}
add_action( 'wp_enqueue_scripts', 'chakta_gdpr_scripts' );

/*************************************************
## Chakta GDPR COOKIE
*************************************************/ 
function chakta_gdpr_cookie(){	
	$gdpr  = isset( $_COOKIE['cookie-popup-visible'] ) ? $_COOKIE['cookie-popup-visible'] : 'enable';
	if($gdpr){
		return $gdpr;
	}
}


/*************************************************
## Chakta GDPR WP_Footer
*************************************************/ 

add_action('wp_footer', 'chakta_gdpr_filter'); 
function chakta_gdpr_filter() { 

	if(get_theme_mod('chakta_gdpr_toggle',0) == 1 && chakta_gdpr_cookie() == 'enable'){
		wp_enqueue_script('jquery-cookie');
		wp_enqueue_script('klb-gdpr');
		wp_enqueue_style('klb-gdpr');
		?>
		
		<div class="gdpr-content mobile-menu-active" data-expires="<?php echo esc_attr(get_theme_mod('chakta_gdpr_expire_date')); ?>">
			<div class="container">
			    <div class="gdpr-inner">
					<p><?php echo chakta_sanitize_data(get_theme_mod('chakta_gdpr_text')); ?></p>
					<a href="#" class="btn btn-danger"><?php echo esc_html(get_theme_mod('chakta_gdpr_button_text')); ?></a>
			    </div>
			</div>
		</div>
		
		<?php
	}
}