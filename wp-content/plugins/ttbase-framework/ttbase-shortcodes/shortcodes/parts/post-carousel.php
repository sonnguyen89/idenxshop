<?php

// Post Carousel ---------------------------------------------------------------------- >
function ttbase_framework_post_carousel_shortcode( $atts, $content = null ) {

	extract(shortcode_atts(array(
			'posts'      		=> '6',
			'categories' 		=> 'all',
			'background' 		=> '#ffffff',
			'border'			=> '#232a35',
			'featured_image'	=> 'true',
			'image_style' 		=> 'color',
			'img_crop'			=> 'true',
			'img_width'			=> '9999',
			'img_height'		=> '9999'
		), $atts));
		
		global $post;

		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $posts,
			'order'          => 'DESC',
			'orderby'        => 'date',
			'post_status'    => 'publish',
			'ignore_sticky_posts' => 1

		);
		
		if($categories != 'all'){
			$str = $categories;
			$arr = explode(',', $str); // string to array

			$args['tax_query'][] = array(
				'taxonomy'  => 'category',
				'field'   => 'slug',
				'terms'   => $arr
			);
		}

		wp_enqueue_script('ttbase-carousel');

		$wp_query = new WP_Query($args);
		$out = '';

		if( $wp_query->have_posts() ) :

			$out .= '<div class="ttbase-latest-blog">';

			$out .= '<div class="blog-carousel owl-carousel owl-theme">';  
		
			while ( $wp_query->have_posts() ) : $wp_query->the_post();
		  
		  		if ($featured_image == 'true') {
		  			$featured_img_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
					$featured_img     = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
					
					// Crop featured images if necessary
					if ( $img_crop == 'true' ) {
						$thumbnail_hard_crop = $img_height == '9999' ? false : true;
						$featured_img = ttbase_framework_shortcodes_img_resize( $featured_img_url, $img_width, $img_height, $thumbnail_hard_crop );
					}
		  		}
		  		
				
				if (isset($background)) {
					$out .= '<div class="blog-item card" style="background-color:' . esc_attr($background) . ';border-color:' . esc_attr($border) . '">';
				}
				else {
					$out .= '<div class="blog-item card">';
				}
				$post_format = get_post_format($post->ID);
				if ( false === $post_format ) {
					$post_format = '';
				}
				if ($post_format == 'audio' && get_post_meta( $post->ID, 'gymx_post_blog-audioembed', true ) != '') {
					$out .= '<div class="content-audio">';
					$out .= wp_kses(get_post_meta( $post->ID, 'gymx_post_blog-audioembed', true ), gymx_allowed_tags());
					$out .= '</div>';
					
				}elseif ($post_format == 'quote') {
					$out .= '<div class="content-quote">';
					$out .= '<a href="' . esc_url( get_permalink( $post->ID ) ) . '" title="' . get_the_title($post->ID). '" class="quote-text">';
					$out .= '<blockquote>';
					$out .= esc_html(get_post_meta( $post->ID, 'gymx_post_blog-quote', true ));
					$out .= '<cite>' . esc_html(get_post_meta( $post->ID, 'gymx_post_blog-quotesource', true )) . '</cite>';
					$out .= '</blockquote>';
					$out .= '</a>';
					$out .= '</div>';
				}elseif ($post_format == 'gallery') {
					$out .= '<div class="content-gallery"><div class="flexslider"><ul class="slides">';
					
					$images = rwmb_meta( 'gymx_post_blog-gallery', 'type=image_advanced&size=gymx-img-size-blog', $post->ID );
                    if (empty($images)) {
                        // Make sure the post has a gallery in it
                     	if( ! has_shortcode( $post->post_content, 'gallery' ) )
                     		$out .= $post->post_content;
                    
                     	// Retrieve the first gallery in the post
                     	$gallery = get_post_gallery_images( $post );
                     	// Loop through each image in each gallery
                    	foreach( $gallery as $image_url ) {
                            $out .= '<li><img src="'.esc_url($image_url).'"/></li>';
                    
                    	}
                    } else {
                        foreach ( $images as $image ) {
                            $out.= '<li><img src="' .esc_url($image['url']).'" width="'.esc_attr($image['width']).'" height="'.esc_attr($image['height']).'" alt="'.esc_attr($image['alt']).'"/></li>';
                        }    
                    }
					$out .= '</ul></div></div>';
				}elseif ($featured_image == 'true' && has_post_thumbnail( $post->ID )) {
		  			$out .= '<a href="'.esc_url(get_permalink()).'" title="' . esc_attr(get_the_title()) . '" class="blog-pic ' . esc_attr($image_style) . '"><img src="'.esc_url($featured_img).'" alt="" /><span class="blog-overlay"></span><i class="icon-plus"></i></a>';
		  		}
		  		
		  		if ($post_format != 'quote') {
		  			$out .= '<div class="blog-item-description">
		  					<span class="post-date text-center">'.esc_attr(get_the_date(get_option( 'date_format' ), $post->ID)).'</span>
							<h5 class="text-center"><a href="'.esc_url(get_permalink()).'" title="' . esc_attr(get_the_title()) . '">'.esc_html(get_the_title()) .'</a></h5>
					  		<div><p>'. wp_kses_post(gymx_custom_excerpt(20)) .'</p></div>
				  		</div>';
		  		}

				$out .= '</div>';
		  
			endwhile;

			$out .='</div>';
		
			$out .='</div><div class="clearfix"></div>';
		
		 	wp_reset_postdata();
	  
		endif;

		return $out;

}
add_shortcode( 'ttbase_post_carousel', 'ttbase_framework_post_carousel_shortcode' );

?>