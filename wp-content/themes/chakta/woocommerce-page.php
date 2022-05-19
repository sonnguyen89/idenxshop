<?php

/**
 * woocommerce-page.php
 * @package WordPress
 * @subpackage chakta
 * @since chakta 1.0
 * 
 */

?>

<?php get_header(); ?>

<?php $breadcrumb = get_theme_mod('chakta_shop_breadcrumb','0'); ?>
<?php if($breadcrumb == '1'){ ?>
	<?php if(is_product_category()){ ?>
		<section class="klb-shop-breadcrumb breadcrumbs-section bg_cover">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-8">
						<div class="breadcrumbs-content text-center">
							<h1><?php the_archive_title(); ?></h1>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php } elseif(is_search()){ ?>
		<section class="klb-shop-breadcrumb breadcrumbs-section bg_cover">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-8">
						<div class="breadcrumbs-content text-center">
							<h1><?php printf( esc_html__( 'Search Results for: %s', 'chakta' ), get_search_query() ); ?></h1>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php } else { ?>
		<section class="klb-shop-breadcrumb breadcrumbs-section bg_cover">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-8">
						<div class="breadcrumbs-content text-center">
							<?php $breadcrumb_title = get_theme_mod('chakta_breadcrumb_title'); ?>
							<?php if($breadcrumb_title){ ?>
								<h1><?php echo esc_html($breadcrumb_title); ?></h1>
							<?php } else { ?>
								<h1><?php echo esc_html_e('Products','chakta'); ?></h1>
							<?php } ?>
							<?php woocommerce_breadcrumb(); ?>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php } ?>

<?php } else { ?>
	<div class="empty-klb"></div>
<?php } ?>


<?php if(chakta_shop_view() == 'list_view' || get_theme_mod('chakta_view_type') == 'list-view' && chakta_shop_view() != 'grid_view') { ?>
<section class="shop-list-section shop-list-sidebar shop-grid-sidebar pt-80 pb-80">
<?php } else { ?>
<section class="shop-grid-v2 shop-grid-sidebar pt-80 pb-80">
<?php } ?>
	<div class="container">
	
		<?php chakta_do_action( 'chakta_before_main_shop'); ?>
	
		<div class="row">
			<?php if( get_theme_mod( 'chakta_shop_layout' ) == 'full-width' || chakta_get_option() == 'full-width') { ?>
				<div class="col-lg-12">
					<?php woocommerce_content(); ?>
				</div>
			<?php } elseif( get_theme_mod( 'chakta_shop_layout' ) == 'right-sidebar' || chakta_get_option() == 'right-sidebar') { ?>
					<div class="col-lg-9">
						<?php woocommerce_content(); ?>
					</div>
					<div class="col-lg-3">
						<div class="sidebar-widget-area products-sidebar">
							<?php if ( is_active_sidebar( 'shop-sidebar' ) ) { ?>
								<?php dynamic_sidebar( 'shop-sidebar' ); ?>
							<?php } ?>
						</div>
					</div>
			<?php } else { ?>
				<?php if ( is_active_sidebar( 'shop-sidebar' ) ) { ?>
					<div class="col-lg-3 order-xs-2">
						<div class="sidebar-widget-area products-sidebar">
							<?php if ( is_active_sidebar( 'shop-sidebar' ) ) { ?>
								<?php dynamic_sidebar( 'shop-sidebar' ); ?>
							<?php } ?>
						</div>
					</div>
					<div class="col-lg-9 order-xs-1">
						<?php woocommerce_content(); ?>
					</div>
				<?php } else { ?>
					<div class="col-lg-12">
						<?php woocommerce_content(); ?>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
		
		<?php chakta_do_action( 'chakta_after_main_shop'); ?>
		
	</div>
</section>

<?php get_footer(); ?>