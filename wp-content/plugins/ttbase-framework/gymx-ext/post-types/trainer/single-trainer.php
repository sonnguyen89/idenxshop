<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package ttbase
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
	    		<article id="post-<?php the_ID(); ?>" <?php post_class(array('col-sm-12','team-member-content', 'clearfix')); ?>>
	                <?php the_content(); ?>
			    </article>
	    	</div>
        </div>
    <?php
	endwhile;
	endif;
    ?>
</section>

<?php get_footer(); ?>
