<?php

// Recent Posts -------------------------------------------------------------------------- >
function ttbase_framework_posts_grid_shortcode($atts) {
	
	// Extract and parse attributes
	extract( shortcode_atts( array(
			'taxonomy'			=> '',
			'term_slug'			=> '',
			'count'				=> '12',
			'style'				=> 'default', // Maybe add more styles in the future?
			'background' 		=> '',
			'border'			=> '#232a35',
			'fade_in'			=> 'false',
			'columns'			=> '3',
			'order'				=> 'DESC',
			'orderby'			=> 'date',
			'thumbnail'			=> 'true',
			'img_crop'			=> 'true',
			'img_width'			=> '9999',
			'img_height'		=> '9999',
			'title'				=> 'true',
			'meta'				=> 'true',
			'excerpt'			=> 'true',
			'excerpt_length'	=> '15',
			'read_more'			=> 'true',
			'read_more_text'	=> esc_html__( 'read more', 'ttbase-framework' ),
			'pagination'		=> 'false',
			'filter_content'	=> 'false',
			'categories' 		=> 'all',
		), $atts));
	
	// FadeIn Class
	$fade_in_class = null;
	if ( $fade_in == 'true' ) {
		wp_enqueue_script( 'ttbase-scroll-fade' );
		$fade_in_class = 'ttbase-fadein';
	}
	
	// Pagination var
	if ( $pagination == 'true' ) {
		global $paged;
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	} else {
		$paged = null;
	}
	
	$args = array(
			'post_type'			=> 'post',
			'posts_per_page'	=> $count,
			'order'				=> $order,
			'orderby'			=> $orderby,
			'filter_content'	=> $filter_content,
			'paged'				=> $paged,
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
	
	// The Query
	$ttbase_post_grid_query = new WP_Query($args);

	$output = '';

	//Output posts
	if ( $ttbase_post_grid_query->posts ) :
	
		// Main wrapper div
		$output .= '<div class="ttbase-recent-posts"><div class="ttbase-grid ' . $style . ' clearfix">';
	
		// Loop through posts
		$count=0;
		foreach ( $ttbase_post_grid_query->posts as $post ) :
		$count++;
		
			// Post VARS
			$post_id          = $post->ID;
			if ($thumbnail == 'true') {
				$featured_img_url = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
				$featured_img     = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );	
			}
			$post_date		  = sprintf(wp_kses(__( '<span class="ttbase-recent-posts-entry-posted-on text-center">%1$s</span>', 'ttbase-framework'), array( 'span' => array( 'class' => array() ) ) ),esc_html( get_the_date(get_option( 'date_format' ), $post_id) ) );
			$url              = get_permalink($post_id);
			$post_title       = get_the_title($post_id);
			$post_excerpt     = wp_trim_words( strip_shortcodes( $post->post_excerpt ), $excerpt_length);
			$custom_excerpt   = wp_trim_words( strip_shortcodes( $post->post_content ), $excerpt_length);
			
			// Crop featured images if necessary
			if ( $img_crop == 'true' ) {
				$thumbnail_hard_crop = $img_height == '9999' ? false : true;
				$featured_img = ttbase_framework_shortcodes_img_resize( $featured_img_url, $img_width, $img_height, $thumbnail_hard_crop );
			}

			// Recent post article start
			$output .= '<article id="post-'. $post_id .'" class="ttbase-recent-posts-entry ttbase-col ttbase-count-'. $count .' ttbase-col-'. $columns .' fitvids '. $fade_in_class .' ttbase-grid-post">';
			$output .= '<div class="ttbase-recent-posts-item card">';	
				$post_format = get_post_format($post_id);
				if ( false === $post_format ) {
					$post_format = '';
				}
				if ($post_format == 'audio' && get_post_meta( $post_id, 'gymx_post_blog-audioembed', true ) != '') {
					$output .= '<div class="content-audio">';
					$output .= wp_kses(get_post_meta( $post_id, 'gymx_post_blog-audioembed', true ), gymx_allowed_tags());
					$output .= '</div>';
					
				}elseif ($post_format == 'quote') {
					$output .= '<div class="content-quote">';
					$output .= '<a href="' . esc_url( get_permalink( $post_id ) ) . '" title="' . get_the_title($post_id). '" class="quote-text">';
					$output .= '<blockquote>';
					$output .= esc_html(get_post_meta( $post_id, 'gymx_post_blog-quote', true ));
					$output .= '<cite>' . esc_html(get_post_meta( $post_id, 'gymx_post_blog-quotesource', true )) . '</cite>';
					$output .= '</blockquote>';
					$output .= '</a>';
					$output .= '</div>';
				}elseif ($post_format == 'gallery') {
					$output .= '<div class="content-gallery"><div class="flexslider"><ul class="slides">';
					
					$images = rwmb_meta( 'gymx_post_blog-gallery', 'type=image_advanced&size=gymx-img-size-blog', $post_id );
                    if (empty($images)) {
                        // Make sure the post has a gallery in it
                     	if( ! has_shortcode( $post->post_content, 'gallery' ) )
                     		$output .= $post->post_content;
                    
                     	// Retrieve the first gallery in the post
                     	$gallery = get_post_gallery_images( $post );
                     	// Loop through each image in each gallery
                    	foreach( $gallery as $image_url ) {
                            $output .= '<li><img src="'.esc_url($image_url).'"/></li>';
                    
                    	}
                    } else {
                        foreach ( $images as $image ) {
                            $output.= '<li><img src="' .esc_url($image['url']).'" width="'.esc_attr($image['width']).'" height="'.esc_attr($image['height']).'" alt="'.esc_attr($image['alt']).'"/></li>';
                        }    
                    }
					$output .= '</ul></div></div>';
				}
				elseif ( has_post_thumbnail( $post_id ) && $thumbnail == 'true' ) {
					$output .= '<div class="ttbase-recent-posts-entry-media">';
					$output .= '<a href="'. esc_url($url) .'" title="'. $post_title .'" class="ttbase-recent-posts-entry-img">';
					$output .= '<img class="img-responsive" src="'. $featured_img .'" alt="'. $post_title .'" />';
					$output .= '</a><!-- .ttbase-recent-posts-entry-img -->';
					$output .= '</div>';
				}
			
				// Open details div
				if ( ($title == 'true' || $excerpt == 'true') && $post_format != 'quote' ) {

					$output .= '<div class="ttbase-recent-posts-entry-details" style="background-color:' . esc_attr($background) . ';border-color:' . esc_attr($border) . '>';
						//Post Date
						$output .=  '<span class="post-date">' . $post_date . '</span>';

						// Title
						if ( $title == 'true' ) {
							$output .= '<header class="ttbase-recent-posts-entry-heading entry-header">';
								$output .= '<h5 class="ttbase-recent-posts-entry-title"><a href="'. esc_url($url) .'" title="'. $post_title .'">'. $post_title .'</a></h5>';
							$output .= '</header><!-- .ttbase-recent-posts-entry-heading -->';
						}
						
						// Excerpt
						if ( $excerpt == 'true' ) {
							$output .= '<div class="ttbase-recent-posts-entry-excerpt"><p>';
								if ( $post_excerpt ) {
									$output .= $post_excerpt;
								} else {
									$output .= $custom_excerpt;
								}
							$output .= '</p>';
								if ( $read_more == 'true' && ( $post_excerpt || $custom_excerpt ) ) { 
									$output .= '<div class="read-more-link-wrapper text-center"><a class="read-more-link" href="'. esc_url($url) .'" title="'. $post_title .'"><i class="icon-next"></i>'. $read_more_text .'</a></div>';
								}
							$output .= ' </div><!-- /ttbase-recent-posts-entry-excerpt -->';
						}
				
					// Close details div
					$output .= '</div><!-- .ttbase-recent-posts-entry-details -->';
				}
				
			// Close main wrap	
			$output .= '</div></article>';

			// Reset counter
			if ( $count == $columns ) {
				$count = '0';
			}
		
		// End foreach loop
		endforeach;
		
		// Close main wrap
		$output .= '</div></div><div class="ttbase-clear-floats"></div>';
		
		// Paginate Posts
		if ( $pagination == 'true' ) {

			$output .= '<div class="ttbase-grid-pagination clearfix">';

				$total = $ttbase_post_grid_query->max_num_pages;

				$big = 999999999; // need an unlikely integer

				if ( $total > 1 )  {
					 if ( ! $current_page = get_query_var( 'paged' ) )
						 $current_page = 1;
					 if ( get_option( 'permalink_structure' ) ) {
						 $format = 'page/%#%/';
					 } else {
						 $format = '&paged=%#%';
					 }
					 $output .= paginate_links(array(
						'base'		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'	=> $format,
						'current'	=> max( 1, get_query_var( 'paged' ) ),
						'total'		=> $total,
						'mid_size'	=> 2,
						'type'		=> 'list',
						'prev_text'	=> '',
						'next_text'	=> '',
					 ));
				}

			$output .= '</div>';
		}
	
	endif; // End has posts check
			
	// Set things back to normal
	$ttbase_post_grid_query = null;
	wp_reset_postdata();

	// Return output
	return $output; 
	
}
add_shortcode("ttbase_posts_grid", "ttbase_framework_posts_grid_shortcode");

?>