<?php

// Trainers -------------------------------------------------------------------------- >
function ttbase_framework_trainer_grid_shortcode($atts) {
	
	// Extract and parse attributes
	extract( shortcode_atts( array(
        'trainers'          => '6',
		'background'        => '#ffffff',
		'columns'           => '3',
		'categories'        => 'all',
		'showfilter'        => 'no',
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
		'show_mail_phone'   => 'false',
		'show_social'		=> 'true'
		), $atts));
	
	wp_enqueue_script( 'gymx-trainer' );
	
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
		'post_type' => 'trainers',
		'posts_per_page' => intval( $trainers ),
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
			'taxonomy'  => 'trainers_category',
			'field'   => 'slug',
			'terms'   => $arr
		);
	}

	query_posts($args);

	ob_start(); // start buffer

	if( $wp_query->have_posts() ) :
		
	$randomnumber = rand(); ?>

	<div class="ttbase-trainer-grid">

	<?php 
	if($showfilter == 'yes'){ 

		// Get Filters from Shortcode Options
		if($categories != '' && $categories != 'all') {
			$trainer_filters = explode(',', $categories);
		} else {
			$trainer_filters = get_terms('trainers_category');
			$arraytostring = '';
			foreach($trainer_filters as $trainer_filter){
				$arraytostring .= $trainer_filter->slug . ',';
			}
			$arraytostring = rtrim($arraytostring,','); // Remove last commata;
			$trainer_filters = explode(',', $arraytostring); // Create array
		} 
		?>
		<div class="ttbase-trainer-filters" data-id="<?php echo intval($randomnumber); ?>">
			<?php if($trainer_filters): ?>
    			<ul class="ttbase-trainer-filter-list">
    				<li><a href="#" data-filter="*" class="filter-all active"><?php esc_html_e('All', 'ttbase-framework'); ?></a></li>	
    				<?php foreach($trainer_filters as $trainer_filter => $value){ ?>
    					<?php $filter_name = get_term_by('slug',$value,'trainers_category'); ?>
    					<li><a href="#" data-filter=".term-<?php echo esc_attr($filter_name->slug); ?>"><?php echo esc_html($filter_name->name); ?></a></li>
    				<?php } ?>
    			</ul>
			<?php endif; ?>
		</div>

	<?php } //end if showfilter ?>
		<div id="<?php echo intval($randomnumber); ?>" class="ttbase-trainer-items ttbase-grid clearfix" data-id="<?php echo intval($randomnumber); ?>">  
			<?php 
			$count=0;
			foreach ( $wp_query->posts as $post ) :
			    $post_id          = $post->ID;
    			$featured_img_url = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
    			$featured_img     = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
    			$url              = get_permalink($post_id);
    			$member_name      = get_the_title($post_id);
    			$post_excerpt     = $post->post_excerpt;
    			$custom_excerpt   = wp_trim_words( strip_shortcodes( $post->post_content ), $excerpt_length);
    			
    			if ($show_social == 'true') {
    				$twitter    = rwmb_meta( 'gymx_post_trainer-twitter',$post_id );
	    			$facebook   = rwmb_meta( 'gymx_post_trainer-facebook',$post_id );
	    			$googleplus = rwmb_meta( 'gymx_post_trainer-googleplus',$post_id );
	    			$instagram  = rwmb_meta( 'gymx_post_trainer-instagram',$post_id );
	    			$linkedin   = rwmb_meta( 'gymx_post_trainer-linkedin',$post_id );
	    			$dribbble   = rwmb_meta( 'gymx_post_trainer-dribbble',$post_id );
	    			$skype      = rwmb_meta( 'gymx_post_trainer-skype',$post_id );
    			}
    			$position   = rwmb_meta( 'gymx_post_trainer-position',$post_id );
    			
    			
    			if ( $show_mail_phone == 'true') {
    			    $phone      = rwmb_meta( 'gymx_post_trainer-phone',$post_id );
    			    $mail       = rwmb_meta( 'gymx_post_trainer-mail',$post_id );
    			}
    			
                $count++;
				$terms = get_the_terms( get_the_ID(), 'trainers_category' );
				
				// Crop featured images if necessary
				if ( $img_crop == 'true' ) {
					$thumbnail_hard_crop = $img_height == '9999' ? false : true;
					$featured_img = ttbase_framework_shortcodes_img_resize( $featured_img_url, $img_width, $img_height, $thumbnail_hard_crop );
				} ?>

				<div class="<?php if($terms) : foreach ($terms as $term) { echo 'term-'.esc_attr($term->slug).' '; } endif; ?>ttbase-trainer-item-wrapper ttbase-col ttbase-count-<?php echo intval($count) ?> ttbase-col-<?php echo esc_attr($columns); ?>">
					<div class="ttbase-trainer-item card">
						<a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($member_name) ?>" class="ttbase-trainer-item-image">
							<?php if ( has_post_thumbnail( $post_id ) ) { ?>
    							<img class="img-responsive" src="<?php echo esc_url($featured_img); ?>" alt="<?php echo esc_attr($member_name); ?>" />
    						<?php } ?>
    						<div class="ttbase-trainer-item-image-content">
    							<h5 class="ttbase-trainer-item-subtitle">
    								<?php echo esc_attr( $position ); ?>
    							</h5>
    							<h3 class="ttbase-trainer-item-heading">
    								<?php echo esc_attr( $member_name ); ?>
    							</h3>
    						</div>
    					</a>
					   	<div class="ttbase-trainer-item-content ttbase-trainer-item-excerpt" style="background-color:<?php echo esc_attr($background); ?>;">
					   		<?php //Phone & Mail
						    if ( $show_mail_phone == 'true') { ?>
						       <div class="ttbase-trainer-item-contact text-center">
						           <?php if ($phone) { ?>
						               <div><?php echo esc_attr($phone); ?></div>
						           <?php } ?>
						           <?php if ($mail) { ?>
						               <div><?php echo esc_attr($mail); ?></div>
						           <?php } ?>
						       </div>
						    <?php }
						    // Social Profiles
						    if ( $show_social == 'true' ) { ?>
						        <ul class="ttbase-trainer-item-social">
						            <?php if ($twitter) { ?>
						                <li>
						                    <a href="<?php echo esc_url($twitter);?>" title="<?php esc_html_e('Twitter','ttbase-framework'); ?>"><i class="sl sl-twitter"></i></a>
						                </li>
						            <?php } ?>
						            <?php if ($facebook) { ?>
						                <li>
						                    <a href="<?php echo esc_url($facebook);?>" title="<?php esc_html_e('Facebook','ttbase-framework'); ?>"><i class="sl sl-facebook"></i></a>
						                </li>
						            <?php } ?>
						            <?php if ($googleplus) { ?>
						                <li>
						                    <a href="<?php echo esc_url($googleplus);?>" title="<?php esc_html_e('Google+','ttbase-framework'); ?>"><i class="sl sl-google-plus"></i></a>
						                </li>
						            <?php } ?>
						            <?php if ($instagram) { ?>
						                <li>
						                    <a href="<?php echo esc_url($instagram);?>" title="<?php esc_html_e('Instagram','ttbase-framework'); ?>"><i class="sl sl-instagram"></i></a>
						                </li>
						            <?php } ?>
						            <?php if ($dribbble) { ?>
						                <li>
						                    <a href="<?php echo esc_url($dribbble);?>" title="<?php esc_html_e('Dribbble','ttbase-framework'); ?>"><i class="sl sl-dribbble"></i></a>
						                </li>
						            <?php } ?>
						            <?php if ($linkedin) { ?>
						                <li>
						                    <a href="<?php echo esc_url($linkedin);?>" title="<?php esc_html_e('LinkedIn','ttbase-framework'); ?>"><i class="sl sl-linkedin"></i></a>
						                </li>
						            <?php } ?>
						            <?php if ($skype) { ?>
						                <li>
						                    <a href="<?php echo esc_url($skype);?>" title="<?php esc_html_e('Skype','ttbase-framework'); ?>"><i class="sl sl-skype"></i></a>
						                </li>
						            <?php } ?>
						        </ul>
						    <?php } ?>
					   		<?php if ($excerpt != 'false') { ?>
						   		<p>
						   		<?php if ( $post_excerpt ) {
										echo esc_attr( $post_excerpt );
									} elseif ($custom_excerpt) {
										echo esc_attr( $custom_excerpt );
									} ?>
								</p>
								<?php if ( $read_more == 'true' && ( $post_excerpt || $custom_excerpt ) ) { ?>
										<div class="read-more-link-wrapper text-center"><a class="read-more-link" href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($member_name); ?>"><i class="icon-next"></i><?php echo esc_attr($read_more_text); ?></a></div>
								<?php } ?>
					   		
					   		<?php } ?>	
							
						</div>
					    
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

	$trainer_output = ob_get_contents(); // get buffered content

	ob_end_clean(); // clean buffer

	return $trainer_output;
}
add_shortcode("ttbase_trainer_grid", "ttbase_framework_trainer_grid_shortcode");

?>