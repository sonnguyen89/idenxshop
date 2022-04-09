<?php

// Testimonial Grid -------------------------------------------------------------------- >
function ttbase_framework_testimonial_grid_shortcode($atts) {
	
	// Extract and parse attributes
	extract( shortcode_atts( array(
        'posts'         	=> '6',
		'columns'       	=> '3',
		'categories'    	=> 'all',
		'showfilter'    	=> 'no',
		'img_crop'			=> 'true',
		'img_width'			=> '9999',
		'img_height'		=> '9999',
		'background_color'  => '',
		'border_color'      => '',
		'color' 			=> '',
		'author_color'		=> '',
		'company_color'		=> '',
		'pagination'		=> 'false'
		), $atts));
	
	wp_enqueue_script( 'ttbase-testimonial' );
	global $wp_query;
	global $post;
	// Pagination var
	if ( $pagination == 'true' ) {
		global $paged;
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	} else {
		$paged = null;
	}

	$args = array(
		'post_type' => 'testimonial',
		'posts_per_page' => intval( $posts ),
		'order'          => 'DESC',
		'orderby'        => 'date',
		'post_status'    => 'publish'
	);
		
	if($categories != 'all' && $categories != ''){
		// string to array
		$str = $categories;
		$arr = explode(',', $str);
		  
		$args['tax_query'][] = array(
			'taxonomy'  => 'testimonial_category',
			'field'   => 'slug',
			'terms'   => $arr
		);
	}

	query_posts($args);

	ob_start(); // start buffer

	if( $wp_query->have_posts() ) :
		
	$randomnumber = rand(); ?>

	<div class="ttbase-testimonial-grid">

	<?php 
	if($showfilter == 'yes'){ 

		// Get Filters from Shortcode Options
		if($categories != '' && $categories != 'all') {
			$testimonial_filters = explode(',', $categories);
		} else {
			$testimonial_filters = get_terms('testimonial_category');
			$arraytostring = '';
			foreach($testimonial_filters as $testimonial_filter){
				$arraytostring .= $testimonial_filter->slug . ',';
			}
			$arraytostring = rtrim($arraytostring,','); // Remove last commata;
			$testimonial_filters = explode(',', $arraytostring); // Create array
		} 
		?>
		<div class="ttbase-testimonial-filters" data-id="<?php echo intval($randomnumber); ?>">
			<?php if($testimonial_filters): ?>
    			<ul class="ttbase-testimonial-filter-list">
    				<li><a href="#" data-filter="*" class="filter-all active"><?php esc_html_e('All', 'ttbase-framework'); ?></a></li>	
    				<?php foreach($testimonial_filters as $testimonial_filter => $value){ ?>
    					<?php $filter_name = get_term_by('slug',$value,'testimonial_category'); ?>
    					<li><a href="#" data-filter=".term-<?php echo esc_attr($filter_name->slug); ?>"><?php echo esc_html($filter_name->name); ?></a></li>
    				<?php } ?>
    			</ul>
			<?php endif; ?>
		</div>

	<?php } //end if showfilter ?>
		<div id="<?php echo intval($randomnumber); ?>" class="ttbase-testimonial-items ttbase-grid clearfix" data-id="<?php echo intval($randomnumber); ?>">  
			<?php 
			$count=0;
			foreach ( $wp_query->posts as $post ) :
			    $post_id          = $post->ID;
    			$featured_img_url = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
    			$featured_img     = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
    			
    			$author = rwmb_meta('gymx_post_testimonial-author', $post->ID);
		  		$company = rwmb_meta('gymx_post_testimonial-company', $post->ID);
		  		$company_url = rwmb_meta('gymx_post_testimonial-companyurl', $post->ID);
		  		
                $count++;
				$terms = get_the_terms( get_the_ID(), 'testimonial_category' );
				
				// Crop featured images if necessary
				if ( $img_crop == 'true' ) {
					$thumbnail_hard_crop = $img_height == '9999' ? false : true;
					$featured_img = ttbase_framework_shortcodes_img_resize( $featured_img_url, $img_width, $img_height, $thumbnail_hard_crop );
				} ?>

				<div class="<?php if($terms) : foreach ($terms as $term) { echo 'term-'.esc_attr($term->slug).' '; } endif; ?>ttbase-testimonial-item-wrapper ttbase-col ttbase-count-<?php echo intval($count) ?> ttbase-col-<?php echo esc_attr($columns); ?>">
					<?php 
					$item_style ='';
					if ($background_color) {
						$item_style .='background-color:' . esc_attr($background_color) . ';';
					}
					if ($border_color) {
						$item_style .='border-color:' . esc_attr($border_color) . ';';
					}
					if ($item_style != '') {
						$item_style =' style="' . $item_style . '"';
					}
					
					$text_style ='';
					if ($color) {
						$text_style .='color:' . esc_attr($color) . ';';
					}
					if ($text_style != '') {
						$text_style =' style="' . $text_style . '"';
					}
					$author_style ='';
					if ($author_color) {
						$author_style .='color:' . esc_attr($author_color) . ';';
					}
					if ($author_style != '') {
						$author_style =' style="' . $author_style . '"';
					}
					$company_style ='';
					if ($company_color) {
						$company_style .='color:' . esc_attr($company_color) . ';';
					}
					if ($company_style != '') {
						$company_style =' style="' . $company_style . '"';
					}
					?>
					<div class="ttbase-testimonial-item card text-center"<?php echo $item_style; ?>>
        				<?php if ( has_post_thumbnail( $post_id ) ) { ?>
        					<img class="ttbase-testimonial-item-image mb25" src="<?php echo esc_url($featured_img); ?>" alt="<?php echo esc_attr($author); ?>" />
        			    <?php } ?>
        			    	<p class="testimonial-quote"<?php echo $text_style; ?>><?php echo esc_html($post->post_content); ?></p>
        			    	<span>
        			    		<strong<?php echo $author_style; ?>><?php echo esc_html($author); ?></strong>
        			    		<?php if ( empty( $company_url ) ) { ?>
									<span<?php echo $company_style; ?>><?php echo esc_html($company); ?></span>
							   <?php } else { ?>
									<a href="<?php echo esc_url($company_url); ?>" class="testimonial-companyurl"<?php echo esc_attr($company_style); ?> title="<?php echo esc_attr( $company ); ?>">- <?php echo esc_html( $company )?></a>
								<?php } ?>
        			    	</span>
					</div>
				</div>
			 
			<?php 
			    // Reset counter
			if ( $count == $columns ) {
				$count = '0';
			}
			endforeach; ?>
		</div>
	</div>
	<?php
	// Paginate Posts
	if ( $pagination == 'true' ) { ?>

		<div class="ttbase-grid-pagination clearfix">

			<?php $total = $wp_query->max_num_pages;

			$big = 999999999; // need an unlikely integer

			if ( $total > 1 )  {
				 if ( ! $current_page = get_query_var( 'paged' ) )
					 $current_page = 1;
				 if ( get_option( 'permalink_structure' ) ) {
					 $format = 'page/%#%/';
				 } else {
					 $format = '&paged=%#%';
				 }
				 echo paginate_links(array(
					'base'		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'	=> $format,
					'current'	=> max( 1, get_query_var( 'paged' ) ),
					'total'		=> $total,
					'mid_size'	=> 2,
					'type'		=> 'list',
					'prev_text'	=> '',
					'next_text'	=> '',
				 ));
			} ?>

		</div>
	<?php }
	
	wp_reset_query(); endif; // needs to be wp_reset_query() instead of wp_reset_postdata() so that pagination works.

	$testimonial_output = ob_get_contents(); // get buffered content

	ob_end_clean(); // clean buffer

	return $testimonial_output;
}
add_shortcode("ttbase_testimonial_grid", "ttbase_framework_testimonial_grid_shortcode");

?>