<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) : ?>
	<section class="shop-grid-v2 up-sells upsells products pb-50">
		<div class="container">
			<?php
			$heading = apply_filters( 'woocommerce_product_upsells_products_heading', esc_html__( 'You may also like&hellip;', 'chakta' ) );

			if ( $heading ) :
				?>
				<div class="row justify-content-center">
					<div class="col-lg-12">
						<div class="section-title mb-45">
							<h2><?php echo esc_html( $heading ); ?></h2>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php foreach ( $upsells as $upsell ) : ?>

					<?php
					$post_object = get_post( $upsell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

					wc_get_template_part( 'content', 'related-product' );
					?>

				<?php endforeach; ?>

			<?php woocommerce_product_loop_end(); ?>
		</div>
	</section>

	<?php
endif;

wp_reset_postdata();
