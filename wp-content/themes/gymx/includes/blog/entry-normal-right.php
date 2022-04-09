<div class="col-md-8">
    <div class="row blog-normal">
        <?php 
        	if ( have_posts() ) : while ( have_posts() ) : the_post();
        		
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
    <div class="row">
	    <?php gymx_paging_nav(); ?>
	</div>
</div>
<?php get_sidebar(); ?>