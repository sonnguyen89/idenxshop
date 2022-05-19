<?php
if ( ! function_exists( 'chakta_main_footer_function' ) ) {
	function chakta_main_footer_function(){
		
	?>
		<footer class="footer-area black-bg">
            <div class="container">
				<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) || is_active_sidebar( 'footer-4' ) ) { ?>
					<div class="footer_widget pt-80 pb-65">
						<div class="row">
							<?php if(get_theme_mod('chakta_footer_column') == '3columns'){ ?>
								<div class="col-lg-4 col-md-6 col-sm-12">
									<?php dynamic_sidebar( 'footer-1' ); ?>
								</div>
								<div class="col-lg-4 col-md-6 col-sm-12">
									<?php dynamic_sidebar( 'footer-2' ); ?>
								</div>
								<div class="col-lg-4 col-md-6 col-sm-12">
									<?php dynamic_sidebar( 'footer-3' ); ?>
								</div>
							<?php } elseif(get_theme_mod('chakta_footer_column') == '4columns') { ?>
								<div class="col-lg-3 col-md-6 col-sm-12">
									<?php dynamic_sidebar( 'footer-1' ); ?>
								</div>
								<div class="offset-lg-1 col-lg-2 col-md-6 col-sm-12">
									<?php dynamic_sidebar( 'footer-2' ); ?>
								</div>
								<div class="offset-lg-1 col-lg-2 col-md-6 col-sm-12">
									<?php dynamic_sidebar( 'footer-3' ); ?>
								</div>
								<div class="col-lg-3 col-md-6 col-sm-12">
									<?php dynamic_sidebar( 'footer-4' ); ?>
								</div>	
							<?php } else { ?>	
								<div class="col-lg-3 col-md-6 col-sm-12">
									<?php dynamic_sidebar( 'footer-1' ); ?>
								</div>
								<div class="col-lg-2 col-md-3 col-sm-6">
									<?php dynamic_sidebar( 'footer-2' ); ?>
								</div>
								<div class="col-lg-2 col-md-3 col-sm-6">
									<?php dynamic_sidebar( 'footer-3' ); ?>
								</div>
								<div class="col-lg-2 col-md-6 col-sm-6">
									<?php dynamic_sidebar( 'footer-4' ); ?>
								</div>
								<div class="col-lg-3 col-md-4 col-sm-6">
									<?php dynamic_sidebar( 'footer-5' ); ?>
								</div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
                <div class="copyright-area">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="copyright-text text-center">
								<?php if(get_theme_mod( 'chakta_copyright' )){ ?>
									<p><?php echo chakta_sanitize_data(get_theme_mod( 'chakta_copyright' )); ?></p>
								<?php } else { ?>
									<p><?php esc_html_e('Copyright 2021.KlbTheme . All rights reserved','chakta'); ?></p>
								<?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <a href="<?php echo esc_url('#'); ?>" class="back-to-top" ><i class="fas fa-angle-up"></i></a>
		
	<?php }
}

add_action('chakta_main_footer','chakta_main_footer_function', 10);