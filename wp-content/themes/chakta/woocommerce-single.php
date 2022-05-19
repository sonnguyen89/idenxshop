<?php
/**
 * woocommerce-single.php
 * @package WordPress
 * @subpackage Chakta
 * @since Chakta 1.0
 * 
 */
?>

<?php get_header(); ?>

<?php $breadcrumb = get_theme_mod('chakta_shop_breadcrumb','0'); ?>
<?php if($breadcrumb == '1'){ ?>
	<section class="klb-shop-breadcrumb breadcrumbs-section bg_cover">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="breadcrumbs-content text-center">
							<h1><?php echo esc_html_e('Product Detail','chakta'); ?></h1>
						<?php woocommerce_breadcrumb(); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } else { ?>
	<div class="empty-klb"></div>
<?php } ?>
<?php woocommerce_content(); ?>

<?php get_footer(); ?>