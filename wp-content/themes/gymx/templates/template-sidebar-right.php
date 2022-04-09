<?php
/* 
Template Name: Page with Right Sidebar
*/

get_header(); ?>

<div class="wrapper" id="page-wrapper">
    
    <div class="container">
        <div class="row">
            <div id="primary" class="col-md-8 content-area">
                <main id="main" class="site-main" role="main">

                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php get_template_part( 'content', 'page' ); ?>

                        <?php
                        // If comments are open or we have at least one comment, load up the comment template
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                        ?>

                    <?php endwhile; // end of the loop. ?>

                </main><!-- #main -->

            </div><!-- #primary -->
        	<?php get_sidebar('page'); ?>
        </div>
        
    </div><!-- Container end -->
    
</div><!-- Wrapper end -->

<?php get_footer(); ?>