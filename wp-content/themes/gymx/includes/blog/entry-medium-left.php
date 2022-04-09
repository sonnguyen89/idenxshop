<?php get_sidebar(); ?>
<div class="col-md-8">
    <div class="row blog-medium">
        <?php 
        	if ( have_posts() ) : while ( have_posts() ) : the_post();
        		
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
	    <?php gymx_paging_nav(); ?>
	</div>
</div>