<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 */

get_header();
$top_padding = get_post_meta(get_the_ID(), 'gymx_post_top_padding', true);
$bottom_padding = get_post_meta(get_the_ID(), 'gymx_post_bottom_padding', true);
?>

<div class="wrapper <?php echo esc_attr($top_padding) . ' ' . esc_attr($bottom_padding); ?>" id="page-wrapper">
    
    <div class="container">
        <div class="row">
            <div id="primary" class="col-sm-12 content-area">
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
        </div>
        
    </div><!-- Container end -->
    
</div><!-- Wrapper end -->

<?php get_footer(); ?>
