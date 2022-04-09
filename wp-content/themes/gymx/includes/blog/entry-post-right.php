<div class="col-md-8">
	<div class="row blog-normal">
		<?php 
        	if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        		<article id="post-<?php the_ID(); ?>" <?php post_class(array('col-sm-12','blog-item', 'clearfix')); ?>>
			        <?php 
			        	get_template_part('includes/post-formats/content', get_post_format());
			        	get_template_part('includes/blog/content', 'post');
			        ?>
			        
			    </article>
       	<?php
        	endwhile;
        	else : 
        		
        		/**
        		 * Display no posts message if none are found.
        		 */
        		get_template_part('includes/blog/content','none');
        		
        	endif;
        ?>
	</div>
</div>
<?php get_sidebar(); ?>