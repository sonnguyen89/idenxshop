<?php
/**
 * 404.php
 * @package WordPress
 * @subpackage Chakta
 * @since Chakta 1.0
 */
?>

<?php get_header(); ?>

<div class="empty-klb"></div>
<div class="section pt-100 pb-100">
	<div class="error_wrap">
    	<div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-10 order-lg-first">
                	<div class="text-center">
                        <div class="error_txt"><?php esc_html_e('404','chakta'); ?></div>
                        <h5 class="mb-2 mb-sm-3"><?php esc_html_e('oops! The page you requested was not found!','chakta'); ?></h5> 
                        <p><?php esc_html_e('The page you are looking for was moved, removed, renamed or might never existed.','chakta'); ?></p>
						<div class="search_form pb-3 pb-md-4">
							<?php get_search_form(); ?>
						</div>
                        <a href="<?php echo esc_url( home_url('/') ); ?>" class="main-btn"><?php esc_html_e('Go To Homepage','chakta'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>