<?php
/**
 * The template for displaying 404 pages (not found).
 */

get_header(); 
$btn_style = get_theme_mod('gymx_button_style', 'style-2');
?>
<div class="wrapper" id="404-wrapper">
    
    <div class="container">
        
        <div class="row pd50">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="text-center">
                    <p class="intro"><?php esc_html_e("The page you requested couldn't be found - this could be due to a spelling error in the URL or a removed page.",'gymx'); ?></p>
                    <div class="mt35">
                        <a class="btn-primary <?php echo esc_attr($btn_style); ?>" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Go Back Home','gymx'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        
    </div><!-- Container end -->
    
</div><!-- Wrapper end -->

<?php get_footer(); ?>
