<?php

// Blog -------------------------------------------------------------------------- >
function ttbase_framework_blog_shortcode( $atts ) {
	extract( 
		shortcode_atts( 
			array(
				'type' => 'normal',
				'pppage' => '10',
				'filter' => 'all',
				'pagination' => 'no'
			), $atts 
		) 
	);
	
	// Fix for pagination
	if( is_front_page() ) { 
		$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; 
	} else { 
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; 
	}
	
	/**
	 * Setup post query
	 */
	$query_args = array(
		'post_type' => 'post',
		'posts_per_page' => $pppage,
		'paged' => $paged
	);
	
	if (!( $filter == 'all' )) {
		if( function_exists( 'icl_object_id' ) ){
			$filter = (int)icl_object_id( $filter, 'category', true);
		}
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field' => 'id',
				'terms' => $filter
			)
		);
	}
	
	/**
	 * Finally, here's the query.
	 */
	$blog_query = new WP_Query( $query_args );
	
	ob_start();
?>
	
	<?php if( 'masonry-2-col' == $type ) : ?>
	    <section class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row blog-masonry">
                		<?php 
                        	if ( $blog_query->have_posts() ) : while ( $blog_query->have_posts() ) : $blog_query->the_post();
                        		
                        		/**
                        		 * Get blog posts by blog layout.
                        		 */
                        		get_template_part('includes/blog/content', 'masonry-2-col');
                        	
                        	endwhile;
                        	else : 
                        		
                        		/**
                        		 * Display no posts message if none are found.
                        		 */
                        		get_template_part('includes/blog/content','none');
                        		
                        	endif;
                        ?>
		                </div>
		                <?php
                			if( 'yes' == $pagination ){ ?>
                		        <div class="row">
                        		    <nav class="navigation pagination">
                		        		<?php
										$big = 999999999; // need an unlikely integer
										
										echo paginate_links( array(
											'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format' => '?paged=%#%',
											'mid_size' => 2,
											'prev_text' => '<i class="icon-prev"></i>',
											'next_text' => '<i class="icon-next"></i>',
											'current' => max( 1, get_query_var('paged') ),
											'total' => $blog_query->max_num_pages
										) );
									?>	
                		        	</nav>
                        		</div>		
                			<?php } ?>
                    </div>
                </div>
            </div>
        </section>
	
	<?php elseif( 'masonry-2-col-left' == $type ) : ?>
	    <section class="wrapper">
            <div class="container">
                <div class="row">
                    <?php get_sidebar(); ?>
                    <div class="col-md-8">
                        <div class="row blog-masonry">
                		<?php 
                        	if ( $blog_query->have_posts() ) : while ( $blog_query->have_posts() ) : $blog_query->the_post();
                        		
                        		/**
                        		 * Get blog posts by blog layout.
                        		 */
                        		get_template_part('includes/blog/content', 'masonry-2-col');
                        	
                        	endwhile;
                        	else : 
                        		
                        		/**
                        		 * Display no posts message if none are found.
                        		 */
                        		get_template_part('includes/blog/content','none');
                        		
                        	endif;
                        ?>
		                </div>
		                <?php
                			if( 'yes' == $pagination ){ ?>
                		        <div class="row">
                        		    <nav class="navigation pagination">
                		        		<?php
											$big = 999999999; // need an unlikely integer
											
											echo paginate_links( array(
												'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
												'format' => '?paged=%#%',
												'mid_size' => 2,
												'prev_text' => '<i class="icon-prev"></i>',
												'next_text' => '<i class="icon-next"></i>',
												'current' => max( 1, get_query_var('paged') ),
												'total' => $blog_query->max_num_pages
											) );
										?>	
                		        	</nav>
                        		</div>		
                			<?php } ?>
                    </div>
                </div>
            </div>
        </section>
	
	<?php elseif( 'masonry-2-col-right' == $type ) : ?>
		<section class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row blog-masonry">
                		<?php 
                        	if ( $blog_query->have_posts() ) : while ( $blog_query->have_posts() ) : $blog_query->the_post();
                        		
                        		/**
                        		 * Get blog posts by blog layout.
                        		 */
                        		get_template_part('includes/blog/content', 'masonry-2-col');
                        	
                        	endwhile;
                        	else : 
                        		
                        		/**
                        		 * Display no posts message if none are found.
                        		 */
                        		get_template_part('includes/blog/content','none');
                        		
                        	endif;
                        ?>
		                </div>
		                <?php
                			if( 'yes' == $pagination ){ ?>
                		        <div class="row">
                        		    <nav class="navigation pagination">
                		        		<?php
										$big = 999999999; // need an unlikely integer
										
										echo paginate_links( array(
											'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format' => '?paged=%#%',
											'mid_size' => 2,
											'prev_text' => '<i class="icon-prev"></i>',
											'next_text' => '<i class="icon-next"></i>',
											'current' => max( 1, get_query_var('paged') ),
											'total' => $blog_query->max_num_pages
										) );
									?>	
                		        	</nav>
                        		</div>		
                			<?php } ?>
                    </div>
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </section>
		
	<?php elseif( 'masonry-3-col' == $type ) : ?>
		<section class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row blog-masonry">
                		<?php 
                        	if ( $blog_query->have_posts() ) : while ( $blog_query->have_posts() ) : $blog_query->the_post();
                        		
                        		/**
                        		 * Get blog posts by blog layout.
                        		 */
                        		get_template_part('includes/blog/content', 'masonry-3-col');
                        	
                        	endwhile;
                        	else : 
                        		
                        		/**
                        		 * Display no posts message if none are found.
                        		 */
                        		get_template_part('includes/blog/content','none');
                        		
                        	endif;
                        ?>
		                </div>
		                <?php
                			if( 'yes' == $pagination ){ ?>
                		        <div class="row">
                        		    <nav class="navigation pagination">
                		        		<?php
										$big = 999999999; // need an unlikely integer
										
										echo paginate_links( array(
											'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format' => '?paged=%#%',
											'mid_size' => 2,
											'prev_text' => '<i class="icon-prev"></i>',
											'next_text' => '<i class="icon-next"></i>',
											'current' => max( 1, get_query_var('paged') ),
											'total' => $blog_query->max_num_pages
										) );
									?>	
                		        	</nav>
                        		</div>		
                			<?php } ?>
                    </div>
                </div>
            </div>
        </section>
		
	<?php elseif( 'normal' == $type ) : ?>
	    <section class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row blog-normal">
                		<?php 
                        	if ( $blog_query->have_posts() ) : while ( $blog_query->have_posts() ) : $blog_query->the_post();
                        		
                        		/**
                        		 * Get blog posts by blog layout.
                        		 */
                        		get_template_part('includes/blog/content', 'normal');
                        	
                        	endwhile;
                        	else : 
                        		
                        		/**
                        		 * Display no posts message if none are found.
                        		 */
                        		get_template_part('includes/blog/content','none');
                        		
                        	endif;
                        ?>
		                </div>
		                <?php
                			if( 'yes' == $pagination ){ ?>
                		        <div class="row">
                        		    <nav class="navigation pagination">
                		        		<?php
										$big = 999999999; // need an unlikely integer
										
										echo paginate_links( array(
											'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format' => '?paged=%#%',
											'mid_size' => 2,
											'prev_text' => '<i class="icon-prev"></i>',
											'next_text' => '<i class="icon-next"></i>',
											'current' => max( 1, get_query_var('paged') ),
											'total' => $blog_query->max_num_pages
										) );
									?>	
                		        	</nav>
                        		</div>		
                			<?php } ?>
                    </div>
                </div>
            </div>
        </section>
        
    <?php elseif( 'normal-left' == $type ) : ?>
	    <section class="wrapper">
            <div class="container">
                <div class="row">
                    <?php get_sidebar(); ?>
                    <div class="col-md-8">
                        <div class="row blog-normal">
                		<?php 
                        	if ( $blog_query->have_posts() ) : while ( $blog_query->have_posts() ) : $blog_query->the_post();
                        		
                        		/**
                        		 * Get blog posts by blog layout.
                        		 */
                        		get_template_part('includes/blog/content', 'normal');
                        	
                        	endwhile;
                        	else : 
                        		
                        		/**
                        		 * Display no posts message if none are found.
                        		 */
                        		get_template_part('includes/blog/content','none');
                        		
                        	endif;
                        ?>
		                </div>
		                <?php
                			if( 'yes' == $pagination ){ ?>
                		        <div class="row">
                        		    <nav class="navigation pagination">
                		        		<?php
										$big = 999999999; // need an unlikely integer
										
										echo paginate_links( array(
											'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format' => '?paged=%#%',
											'mid_size' => 2,
											'prev_text' => '<i class="icon-prev"></i>',
											'next_text' => '<i class="icon-next"></i>',
											'current' => max( 1, get_query_var('paged') ),
											'total' => $blog_query->max_num_pages
										) );
									?>	
                		        	</nav>
                        		</div>		
                			<?php } ?>
                    </div>
                </div>
            </div>
        </section>
        
    <?php elseif( 'normal-right' == $type ) : ?>
        <section class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row blog-normal">
                		<?php 
                        	if ( $blog_query->have_posts() ) : while ( $blog_query->have_posts() ) : $blog_query->the_post();
                        		
                        		/**
                        		 * Get blog posts by blog layout.
                        		 */
                        		get_template_part('includes/blog/content', 'normal');
                        	
                        	endwhile;
                        	else : 
                        		
                        		/**
                        		 * Display no posts message if none are found.
                        		 */
                        		get_template_part('includes/blog/content','none');
                        		
                        	endif;
                        ?>
    	                </div>
    	                <?php
                			if( 'yes' == $pagination ){ ?>
                		        <div class="row">
                		        	<nav class="navigation pagination">
                		        		<?php
										$big = 999999999; // need an unlikely integer
										
										echo paginate_links( array(
											'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format' => '?paged=%#%',
											'mid_size' => 2,
											'prev_text' => '<i class="icon-prev"></i>',
											'next_text' => '<i class="icon-next"></i>',
											'current' => max( 1, get_query_var('paged') ),
											'total' => $blog_query->max_num_pages
										) );
									?>	
                		        	</nav>
                        		</div>		
                			<?php } ?>
                    </div>
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </section>
    
    <?php elseif( 'medium-left' == $type ) : ?>
    	<section class="wrapper">
		    <div class="container">
		        <div class="row">
		             <?php get_sidebar(); ?>
		            <div class="col-md-8">
		                <div class="row blog-medium">
		                    <?php 
		                    	if ( $blog_query->have_posts() ) : while ( $blog_query->have_posts() ) : $blog_query->the_post();
		                    		
		                    		/**
		                    		 * Get blog posts by blog layout.
		                    		 */
		                    		?>
		                    		<?php get_template_part('includes/blog/content', 'medium');
		                    	
		                    	endwhile;
		                    	else : 
		                    		
		                    		/**
		                    		 * Display no posts message if none are found.
		                    		 */
		                    		get_template_part('includes/blog/content','none');
		                    		
		                    	endif;
		                    ?>
		                </div>
		                
		                <div class="row">
		        		    <nav class="navigation pagination">
                		        		<?php
										$big = 999999999; // need an unlikely integer
										
										echo paginate_links( array(
											'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format' => '?paged=%#%',
											'mid_size' => 2,
											'prev_text' => '<i class="icon-prev"></i>',
											'next_text' => '<i class="icon-next"></i>',
											'current' => max( 1, get_query_var('paged') ),
											'total' => $blog_query->max_num_pages
										) );
									?>	
                		        	</nav>
		        		</div>
				
		            </div>
		        </div>
		    </div>
		</section>
	
	<?php elseif( 'medium-right' == $type ) : ?>
    	<section class="wrapper">
		    <div class="container">
		        <div class="row">
		            <div class="col-md-8">
		                <div class="row blog-medium">
		                    <?php 
		                    	if ( $blog_query->have_posts() ) : while ( $blog_query->have_posts() ) : $blog_query->the_post();
		                    		
		                    		/**
		                    		 * Get blog posts by blog layout.
		                    		 */
		                    		get_template_part('includes/blog/content', 'medium');
		                    	
		                    	endwhile;
		                    	else : 
		                    		
		                    		/**
		                    		 * Display no posts message if none are found.
		                    		 */
		                    		get_template_part('includes/blog/content','none');
		                    		
		                    	endif;
		                    ?>
		                </div>
		                
		                <div class="row">
		        		    <nav class="navigation pagination">
                		        		<?php
										$big = 999999999; // need an unlikely integer
										
										echo paginate_links( array(
											'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format' => '?paged=%#%',
											'mid_size' => 2,
											'prev_text' => '<i class="icon-prev"></i>',
											'next_text' => '<i class="icon-next"></i>',
											'current' => max( 1, get_query_var('paged') ),
											'total' => $blog_query->max_num_pages
										) );
									?>	
                		        	</nav>
		        		</div>
				
		            </div>
		            <?php get_sidebar(); ?>
		        </div>
		    </div>
		</section>
	
	<?php elseif( 'medium' == $type ) : ?>
    	<section class="wrapper">
		    <div class="container">
		        <div class="row">
		            <div class="col-md-12">
		                <div class="row blog-medium">
		                    <?php 
		                    	if ( $blog_query->have_posts() ) : while ( $blog_query->have_posts() ) : $blog_query->the_post();
		                    		
		                    		/**
		                    		 * Get blog posts by blog layout.
		                    		 */
		                    		get_template_part('includes/blog/content', 'medium');
		                    	
		                    	endwhile;
		                    	else : 
		                    		
		                    		/**
		                    		 * Display no posts message if none are found.
		                    		 */
		                    		get_template_part('includes/blog/content','none');
		                    		
		                    	endif;
		                    ?>
		                </div>
		                
		                <div class="row">
		        		    <nav class="navigation pagination">
                		        		<?php
										$big = 999999999; // need an unlikely integer
										
										echo paginate_links( array(
											'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format' => '?paged=%#%',
											'mid_size' => 2,
											'prev_text' => '<i class="icon-prev"></i>',
											'next_text' => '<i class="icon-next"></i>',
											'current' => max( 1, get_query_var('paged') ),
											'total' => $blog_query->max_num_pages
										) );
									?>	
                		        	</nav>
		        		</div>
				
		            </div>
		        </div>
		    </div>
		</section>
    	
	<?php endif; ?>
			
<?php	
	wp_reset_postdata();
	$output = ob_get_contents();
	ob_end_clean();
	
	return $output;
}
add_shortcode( 'ttbase_blog', 'ttbase_framework_blog_shortcode' );