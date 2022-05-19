<?php

/*************************************************
## Main Header Function
*************************************************/

add_action('chakta_main_header','chakta_main_header_function',10);

if ( ! function_exists( 'chakta_main_header_function' ) ) {
	function chakta_main_header_function(){

		if(chakta_page_settings('page_header_type') == 'type3'){
		
		get_template_part( 'includes/header/header-type3' );
		
		}elseif(chakta_page_settings('page_header_type') == 'type2'){
			
			get_template_part( 'includes/header/header-type2' );
			
		} elseif(chakta_page_settings('page_header_type') == 'type1') {
			
			get_template_part( 'includes/header/header-type1' );
			
		} elseif(get_theme_mod('chakta_header_type') == 'type3'){
			
			get_template_part( 'includes/header/header-type3' );

		} elseif(get_theme_mod('chakta_header_type') == 'type2'){
			
			get_template_part( 'includes/header/header-type2' );
			
		} else {
			
			get_template_part( 'includes/header/header-type1' );
			
		}
		
	}
}



?>
