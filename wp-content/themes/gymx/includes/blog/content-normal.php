<?php 
	$post_format = get_post_format();
	if ( false === $post_format ) {
		$post_format = '';
	}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(array('col-sm-12','blog-item', 'clearfix')); ?>>
    <?php get_template_part('includes/post-formats/content', $post_format); ?>
    
    <?php if(!( 'quote' == $post_format || 'link' == $post_format )) { ?>
	    <div class="content-wrap">
	    	
	        <header class="entry-header">
	        	<div class="clearfix">
	        		<div class="date-wrapper">
			         <?php 
	        		//Post Date
	        		if ( 'post' == get_post_type() ) : ?>
						<a href="<?php esc_url(the_permalink()) ?>">
						<?php echo sprintf(wp_kses(__( '<span class="entry-posted-on">%1$s</span>', 'gymx'), array( 'span' => array( 'class' => array() ) ) ),esc_html( get_the_date('d. M') ) ); ?>
						</a>
					<?php endif; ?>
					<?php if (is_sticky()) { ?>
						<div class="sticky-post">
							<?php esc_html_e('sticky','gymx'); ?>
						</div>
					<?php } ?>
				    </div>
				    <div class="meta col-sm-10">
	                	<div class="author">
	                    	<i class="icon-user"></i>
	                    	<?php the_author_posts_link(); ?>
	                    </div>
	                    <?php
	                    $categories_list = get_the_category_list( esc_html_x( ', ', 'Used between list items, there is a space after the comma.', 'gymx' ) );
	            		if ( $categories_list ) {
	            			printf( '<div class="categories"><i class="icon-folder"></i>%1$s</div>',
	            				$categories_list
	            			);
	            		} ?>
	                </div>
	        	</div>
				
				<?php //Post Title
				the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
		        
			</header><!-- .entry-header -->
	        
	        <?php 
	        	if(!( 'page' == get_post_type() ) || '' == $post_format)
	        		the_excerpt();
	        		
	        		 wp_link_pages( array(
        				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'gymx' ) . '</span>',
        				'after'       => '</div>',
        				'link_before' => '<span>',
        				'link_after'  => '</span>',
        				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'gymx' ) . ' </span>%',
        			) );
	        ?>
	        
	    </div>
	<?php } ?>
    
</article>