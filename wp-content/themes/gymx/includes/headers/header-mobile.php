<?php
/**
 * Header Mobile
 */

$logo = get_theme_mod( 'gymx_logo_mobile', get_template_directory_uri() . '/img/logo_small.png' );
$logo2x = get_theme_mod( 'gymx_logo2x_mobile', get_template_directory_uri() . '/img/logo_small2x.png' );
if( is_ssl() ) {
    $logo = str_replace( 'http://', 'https://', $logo );
    $logo2x = str_replace( 'http://', 'https://', $logo2x );
};
$logo_width_height = get_theme_mod( 'gymx_logo_width_height', '' );
?>
<div id="mobile-header" class="mobile-header">
	<div class="container">
	    <div class="row">
	        <div class="col-xs-12 v-align">
    			<div id="mobile-logo" class="logo">
    				<?php if ( ! empty( $logo ) ){ ?>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="site-logo-mobile" title="<?php echo esc_attr( get_bloginfo( 'name','display' ) ); ?>" rel="home">
                                <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" srcset="<?php echo esc_url($logo); ?><?php echo empty ( $logo2x ) ? '' : ', ' . esc_url($logo2x) . ' 2x'; ?>" class="img-responsive" <?php echo wp_kses_post($logo_width_height); ?> />
                            </a>
                        <?php } else { ?>
    					<a href="<?php echo esc_url(home_url()); ?>/"><?php esc_html(bloginfo('name')); ?></a>
    				<?php } ?>
    			</div>
    			<a href="#" id="mobile-navigation-btn"><i class="fa fa-bars"></i></a>
    		</div>    
	    </div>
	</div>
</div>
<div id="mobile-navigation">
	<div class="container">
		<div class="row">
		    <div class="col-xs-12">

		        <?php
				$page_menu = rwmb_meta( 'gymx_post_header_menu', $id );
				if ($page_menu != '') {
					wp_nav_menu( array(
						'theme_location' => 'mobile',
						'menu'              => $page_menu,
						'menu_id' => 'mobile-nav',
						'fallback_cb' => false
					));
				}
				else {
					wp_nav_menu( array(
						'theme_location' => 'mobile',
						'menu_id' => 'mobile-nav',
						'fallback_cb' => false
					));
				} ?>
		        <?php if( get_theme_mod('gymx_header_show_search','no') == 'yes') { ?>
    			<form action="<?php echo esc_url(home_url()) ?>" method="GET">
    	      		<input type="text" name="s" value="" placeholder="<?php echo esc_html__('Search..', 'gymx') ?>"  autocomplete="off" />
    			</form> 
    			<?php } ?>
		    </div>
		</div>
	</div>
</div>