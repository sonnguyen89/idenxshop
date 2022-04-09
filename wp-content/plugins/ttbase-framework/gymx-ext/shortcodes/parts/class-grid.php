<?php

// Class Grid -------------------------------------------------------------------------- >
function ttbase_framework_class_grid_shortcode($atts) {
	
	// Extract and parse attributes
	extract( shortcode_atts( array(
        'classes'           => '6',
        'trainer'			=> '',
		'background'        => '#ffffff',
		'border'            => '#232a35',
		'columns'           => '3',
		'categories'           => 'all',
		'showfilter'        => 'no',
		'img_padding'		=> '',
		'pagination'        => 'false',
		'order'				=> 'DESC',
		'orderby'			=> 'date',
		'img_crop'			=> 'true',
		'img_width'			=> '9999',
		'img_height'		=> '9999',
		'excerpt'		    => 'true',
		'excerpt_length'    => '15',
		'read_more'			=> 'true',
		'read_more_text'	=> esc_html__( 'read more', 'ttbase-framework' ),
		'overlay_color'		=> ''
		), $atts));
	
	wp_enqueue_script( 'gymx-class' );
	
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
		'post_type' => 'classes',
		'posts_per_page' => intval( $classes ),
		'order'          => $order,
		'orderby'        => $orderby,
		'post_status'    => 'publish',
		'suppress_filters' => false,
		'paged' => $paged
	);
		
	if($categories != 'all' && $categories != ''){
		// string to array
		$str = $categories;
		$arr = explode(',', $str);
		  
		$args['tax_query'][] = array(
			'taxonomy'  => 'class_category',
			'field'   => 'slug',
			'terms'   => $arr
		);
	}
	if ($trainer != '') {
		$args['meta_query'][] = array(
	        array(
	            'key' => 'gymx_post_class_trainers',
	            'value' => $trainer,
	            'compare' => 'LIKE'
	        )
	    );
	}
	

	query_posts($args);

	ob_start(); // start buffer

	if( $wp_query->have_posts() ) :
		
	$randomnumber = rand(); ?>

	<div class="ttbase-class-grid">

	<?php 
	if($showfilter == 'yes'){ 

		// Get Filters from Shortcode Options
		if($categories != '' && $categories != 'all') {
			$class_filters = explode(',', $categories);
		} else {
			$class_filters = get_terms('class_category');
			$arraytostring = '';
			foreach($class_filters as $class_filter){
				$arraytostring .= $class_filter->slug . ',';
			}
			$arraytostring = rtrim($arraytostring,','); // Remove last commata;
			$class_filters = explode(',', $arraytostring); // Create array
		} 
		?>
		<div class="ttbase-class-filters" data-id="<?php echo intval($randomnumber); ?>">
			<?php if($class_filters): ?>
    			<ul class="ttbase-class-filter-list">
    				<li><a href="#" data-filter="*" class="filter-all active"><?php esc_html_e('All', 'ttbase-framework'); ?></a></li>	
    				<?php foreach($class_filters as $class_filter => $value){ ?>
    					<?php $filter_name = get_term_by('slug',$value,'class_category'); ?>
    					<li><a href="#" data-filter=".term-<?php echo esc_attr($filter_name->slug); ?>"><?php echo esc_html($filter_name->name); ?></a></li>
    				<?php } ?>
    			</ul>
			<?php endif; ?>
		</div>

	<?php } //end if showfilter ?>
		<div id="<?php echo intval($randomnumber); ?>" class="ttbase-class-items ttbase-grid clearfix" data-id="<?php echo intval($randomnumber); ?>">  
			<?php 
			$count=0;
			foreach ( $wp_query->posts as $post ) :
			    $post_id          = $post->ID;
    			$featured_img_url = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
    			$featured_img     = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
    			$url              = get_permalink($post_id);
    			$class_name      = get_the_title($post_id);
    			$post_excerpt     = wp_trim_words( strip_shortcodes( $post->post_excerpt ), $excerpt_length);
    			$custom_excerpt   = wp_trim_words( strip_shortcodes( $post->post_content ), $excerpt_length);
    			
                $count++;
				$terms = get_the_terms( get_the_ID(), 'class_category' );
				
				$overlay_style = '';
				if ($overlay_color) {
				    $overlay_style .= 'background-color:' . esc_attr($overlay_color) . ';';
		            if ( '' != $overlay_style ) {
		                $overlay_style = ' style="' . $overlay_style . '"';
		            }
				}
				
				// Crop featured images if necessary
				if ( $img_crop == 'true' ) {
					$thumbnail_hard_crop = $img_height == '9999' ? false : true;
					$featured_img = ttbase_framework_shortcodes_img_resize( $featured_img_url, $img_width, $img_height, $thumbnail_hard_crop );
				} ?>   

				<div class="<?php if($terms) : foreach ($terms as $term) { echo 'term-'.esc_attr($term->slug).' '; } endif; ?>ttbase-class-item-wrapper ttbase-col ttbase-count-<?php echo intval($count) ?> ttbase-col-<?php echo esc_attr($columns); ?>">
					<div class="ttbase-class-item card">
        				<?php if ( has_post_thumbnail( $post_id ) ) { ?>
        					<a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($class_name) ?>" class="ttbase-class-item-image">
        						<img class="img-responsive" src="<?php echo esc_url($featured_img); ?>" alt="<?php echo esc_attr($class_name); ?>" />
        						<div class="ttbase-class-item-image-overlay clearfix" <?php echo $overlay_style ?>></div>
        						<div class="ttbase-class-item-image-content">
        							<h5 class="ttbase-class-item-subtitle">
        								<?php if($terms) : foreach ($terms as $term) { echo esc_attr($term->name) . ' '; } endif; ?>
        							</h5>
        							<h3 class="ttbase-class-item-heading">
        								<?php echo esc_attr( $class_name ); ?>
        							</h3>
        						</div>
        					</a>
        			    <?php } ?>
					    
					    <?php
					    // Excerpt
						if ( $excerpt == 'true' && ( $post_excerpt || $custom_excerpt )) { ?>
							<div class="ttbase-class-item-content ttbase-class-item-excerpt" style="background-color:<?php echo esc_attr($background); ?>; border-color:<?php echo esc_attr($border); ?>"><p>
							<?php if ( $post_excerpt ) {
									echo esc_attr( $post_excerpt );
								} elseif ($custom_excerpt) {
									echo esc_attr( $custom_excerpt );
								} ?>
							</p>
							<?php if ( $read_more == 'true' && ( $post_excerpt || $custom_excerpt ) ) { ?>
									<div class="read-more-link-wrapper text-center"><a class="read-more-link" href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($class_name); ?>"><i class="icon-next"></i><?php echo esc_attr($read_more_text); ?></a></div>
							<?php } ?>
							</div>
					<?php } ?>
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

	$class_output = ob_get_contents(); // get buffered content

	ob_end_clean(); // clean buffer

	return $class_output;
}
add_shortcode("ttbase_class_grid", "ttbase_framework_class_grid_shortcode");

?>