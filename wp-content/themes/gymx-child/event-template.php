<?php
/*
Template Name: Timetable Event
*/
get_header();
$top_padding = rwmb_meta('gymx_post_top_padding',get_the_ID());
$bottom_padding = rwmb_meta('gymx_post_bottom_padding',get_the_ID());
?>
<section class="wrapper <?php echo esc_attr($top_padding) . ' ' . esc_attr($bottom_padding); ?>" id="single-wrapper">
    <?php 
    if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="container">
            <div class="row">
			    <?php
			    //Service Sidebar
			    if ( is_active_sidebar('sidebar-event') && rwmb_meta('gymx_post_content_sidebar', $post->ID ) != 'hide' ) { ?>
				    <div class="col-md-4">
				        <div class="class-sidebar">
                    		<?php dynamic_sidebar( 'sidebar-class' ); ?>
                    	</div>
            	    </div>
            	<?php }
            	 if (is_active_sidebar('sidebar-event') && rwmb_meta('gymx_post_content_sidebar', $post->ID ) != 'hide') { ?>
            	    <div class="col-md-8">    
            	<?php } else { ?>
            	    <div class="col-md-12">
            	<?php } ?>
            	    <div class="row">
                		<article id="post-<?php the_ID(); ?>" <?php post_class(array('col-sm-12','service-content', 'clearfix')); ?>>
    		                <?php the_content(); ?>
        			    </article>
                	</div>
            	</div>
            </div>
        </div>
    <?php
	endwhile;
	endif;
    ?>
</section>

<?php get_footer(); ?>
