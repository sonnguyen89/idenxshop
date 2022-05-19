<?php
/*************************************************
* Mobile Filter
*************************************************/
add_action('wp_footer', 'chakta_mobile_filter'); 
function chakta_mobile_filter() { 

	$mobilebottommenu = get_theme_mod('chakta_mobile_bottom_menu','0');
	if($mobilebottommenu == '1'){
		
	wp_enqueue_style( 'klb-mobile-filter');
	wp_enqueue_script( 'klb-mobile-filter');
?>
		<div class="footer-fix-nav shadow">
			<div class="row mx-0">
				<div class="col">
					<a href="<?php echo esc_url( home_url( "/" ) ); ?>" title="<?php bloginfo("name"); ?>"><i class="fal fa-home"></i></a>
				</div>
				<?php if(is_shop()){ ?>
				<div class="col">
					<a class="button-filter" data-toggle="offcanvas" href="#" href="<?php echo wc_get_page_permalink( 'shop' ); ?>"><i class="fal fa-filter"></i></a>
				</div>
				<?php } else { ?>
				<div class="col">
					<a href="<?php echo wc_get_page_permalink( 'shop' ); ?>"><i class="fal fa-th-large"></i></a>
				</div>
				<?php } ?>
				<div class="col">
					<?php global $woocommerce; ?>
					<a href="<?php echo esc_url(wc_get_cart_url()); ?>"><i class="fal fa-shopping-cart"></i><span class="count"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'chakta-core'), $woocommerce->cart->cart_contents_count);?></a>
				</div>
				<div class="col">
					<a href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>"><i class="fal fa-user-circle"></i></a>
				</div>
			</div>
		</div>
		
		<div class="mobile-filter">
			<div class="mobile-filter-header">
				<h5><?php esc_html_e('Product Filters','chakta-core'); ?> <a data-toggle="offcanvas" class="float-right" href="#"><i class="fa fa-times"></i></a></h5>
			</div>
			<div class="klb-sidebar sidebar">
				<div class="sidebar-widget-area products-sidebar">
					<?php if ( is_active_sidebar( 'shop-sidebar' ) ) { ?>
						<?php dynamic_sidebar( 'shop-sidebar' ); ?>
					<?php } ?>
				</div>
			</div>
		</div>
<?php }

    
}