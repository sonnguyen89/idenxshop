<?php

// Testimonial Carousel ------------------------------------------------------------------- >
function ttbase_framework_testimonial_carousel_shortcode( $atts, $content = null ) {

	extract(shortcode_atts(array(
			//'title'      => esc_html__('Testimonial', 'ttbase-framework'),
			'posts'      => '6',
			'categories' => 'all',
			'img_crop'			=> 'true',
			'img_width'			=> '9999',
			'img_height'		=> '9999',
			'img_border'		=> 'false',
			'border_color'		=> '',
			'border_width'		=> '2',
			'font_size'			=> '',
			'color' 			=> '',
			'author_color'		=> '',
			'company_color'		=> ''
		), $atts));
		
		global $post;

		$args = array(
			'post_type' => 'testimonial',
			'posts_per_page' => $posts,
			'order'          => 'DESC',
			'orderby'        => 'date',
			'post_status'    => 'publish'
		);
		
		if($categories != 'all'){
			$str = $categories;
			$arr = explode(',', $str); // string to array

			$args['tax_query'][] = array(
				'taxonomy'  => 'testimonial_category',
				'field'   => 'slug',
				'terms'   => $arr
			);
		}

		wp_enqueue_script('ttbase-carousel');

		$wp_query = new WP_Query($args);
		$out = '';

		if( $wp_query->have_posts() ) :

			$out .= '<div class="ttbase-testimonial-carousel">';
			
			//$out .= '<h2 class="testimonial-title text-center">' . esc_attr( $title ) . '</h2>';
			
			$out .= '<div class="testimonial-carousel owl-carousel owl-theme">';  
		
			while ( $wp_query->have_posts() ) : $wp_query->the_post();
		  		
		  		$featured_img_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
    			$featured_img     = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
				
				// Crop featured images if necessary
				if ( $img_crop == 'true' ) {
					$thumbnail_hard_crop = $img_height == '9999' ? false : true;
					$featured_img = ttbase_framework_shortcodes_img_resize( $featured_img_url, $img_width, $img_height, $thumbnail_hard_crop );
				}
			
				$out .= '<div class="testimonial-item">';
		  		
		  		if ( has_post_thumbnail( $post->ID ) ) {
		  		$img_style = '';
		  		if ($img_border == 'true' && $border_color != '') {
		  			$img_style = 'style="border:solid ' . $border_width . 'px '. $border_color .';"';
		  		}
		  		$out .= '<img class="testimonial-author-image" ' . $img_style . ' src="'.esc_url($featured_img).'" alt="" />';
		  		
		  		}
		  		$author = rwmb_meta('gymx_post_testimonial-author', $post->ID);
		  		$company = rwmb_meta('gymx_post_testimonial-company', $post->ID);
		  		$company_url = rwmb_meta('gymx_post_testimonial-companyurl', $post->ID);
		  		$author_style = ( $author_color != '' ) ? ' style="color:' . $author_color . ';"' : '';
		  		$company_style = ( $company_color != '' ) ? ' style="color:' . $company_color . ';"' : '';
		  		$testimonial_style = ( $color != '' || $font_size !='' ) ? ' style="' : '';
		  		$testimonial_style .= ( $color != '' ) ? 'color:' . $color . ';' : '';
		  		$testimonial_style .= ( $font_size != '' ) ? 'font-size:' . ttbase_framework_sanitize_data( $font_size, 'font_size' ) . ';' : '';
		  		$testimonial_style .= ( $color != '' || $font_size !='' ) ? '"' : '';
		  		$out .= '<div class="testimonial-item-description">
					  		<div>
					  			<p class="testimonial-quote"'. $testimonial_style .'>'. get_the_content() .'</p>
					  			<p class="testimonial-author"'. $author_style .'>' . esc_attr($author) . '</p>';
				if ( empty( $company_url ) ) {
					$out .= '<p class="testimonial-company"'. $company_style .'>' . ', ' . esc_attr( $company ) . '</p>';
				} else {
					$out .= '<a href="' .esc_url( $company_url ) . '" class="testimonial-companyurl"'. $company_style . ' title="' .esc_attr( $company ) . '">' . ', ' . esc_attr( $company ) . '</a>';
				}
				
				$out .= '</div></div></div>';
		  
			endwhile;

			$out .='</div>';
		
			$out .='</div><div class="clearfix"></div>';
		
		 	wp_reset_postdata();
	  
		endif;

		return $out;

}
add_shortcode( 'ttbase_testimonial_carousel', 'ttbase_framework_testimonial_carousel_shortcode' );

?>