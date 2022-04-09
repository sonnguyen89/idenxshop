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
 */

get_header();

//get blog layout from customizer
$blog_layout = 'normal';
$blog_sidebar = get_theme_mod('gymx_blog_sidebar','right');
$top_padding = get_post_meta(gymx_get_the_post_id(), 'gymx_post_top_padding', true);
$bottom_padding = get_post_meta(gymx_get_the_post_id(), 'gymx_post_bottom_padding', true);
?>

<section class="wrapper <?php echo esc_attr($top_padding) . ' ' . esc_attr($bottom_padding); ?>">
    <div class="container">
        <div class="row">
            <?php get_template_part('includes/blog/entry',$blog_layout . '-' . $blog_sidebar); ?>
        </div>
    </div>
</section>
<?php

get_footer();

?>
