<?php
/**
 * page.php
 * @package WordPress
 * @subpackage Chakta
 * @since Chakta 1.0
 */
?>

<?php get_header(); ?>

	<?php $elementor_page = get_post_meta( get_the_ID(), '_elementor_edit_mode', true ); ?> 

	<?php if ( class_exists( 'woocommerce' ) ) { ?>

		<?php if (is_cart()) { ?>
			<?php $breadcrumb = get_theme_mod('chakta_shop_breadcrumb','0'); ?>
			<?php if($breadcrumb == '1'){ ?>
				<section class="klb-shop-breadcrumb breadcrumbs-section bg_cover">
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-lg-8">
								<div class="breadcrumbs-content text-center">
									<h1><?php the_title(); ?></h1>
									<?php woocommerce_breadcrumb(); ?>
								</div>
							</div>
						</div>
					</div>
				</section>
			<?php } else { ?>
				<div class="empty-klb"></div>
			<?php } ?>
			
			<section class="cart-area pt-80 pb-80">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<?php while(have_posts()) : the_post(); ?>
								<?php the_content (); ?>
								<?php wp_link_pages(array('before' => '<div class="klb-pagination">' . esc_html__( 'Pages:', 'chakta' ),'after'  => '</div>', 'next_or_number' => 'number')); ?>
							<?php endwhile; ?>
						</div>
					</div>
				</div>
			</section>

		<?php } elseif (is_checkout()) { ?>
			<?php $breadcrumb = get_theme_mod('chakta_shop_breadcrumb','0'); ?>
			<?php if($breadcrumb == '1'){ ?>
				<section class="klb-shop-breadcrumb breadcrumbs-section bg_cover">
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-lg-8">
								<div class="breadcrumbs-content text-center">
									<h1><?php the_title(); ?></h1>
									<?php woocommerce_breadcrumb(); ?>
								</div>
							</div>
						</div>
					</div>
				</section>
			<?php } else { ?>
				<div class="empty-klb"></div>
			<?php } ?>
		
			<section class="checkout-area pt-80 pb-80">
				<div class="container">
					<?php while(have_posts()) : the_post(); ?>
						<?php the_content (); ?>
						<?php wp_link_pages(array('before' => '<div class="klb-pagination">' . esc_html__( 'Pages:', 'chakta' ),'after'  => '</div>', 'next_or_number' => 'number')); ?>
					<?php endwhile; ?>
				</div>
			</section>
	   <?php } elseif (is_account_page()) { ?>
			<?php $breadcrumb = get_theme_mod('chakta_shop_breadcrumb','0'); ?>
			<?php if($breadcrumb == '1'){ ?>
				<section class="klb-shop-breadcrumb breadcrumbs-section bg_cover">
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-lg-8">
								<div class="breadcrumbs-content text-center">
									<h1><?php the_title(); ?></h1>
									<?php woocommerce_breadcrumb(); ?>
								</div>
							</div>
						</div>
					</div>
				</section>
			<?php } else { ?>
				<div class="empty-klb"></div>
			<?php } ?>
	   
			<section class="my-account-page pt-80 pb-80">
				<div class="container">
					<div class="row ">
						<div class="col-md-12">
							<?php while(have_posts()) : the_post(); ?>
								<?php the_content (); ?>
								<?php wp_link_pages(array('before' => '<div class="klb-pagination">' . esc_html__( 'Pages:', 'chakta' ),'after'  => '</div>', 'next_or_number' => 'number')); ?>
							<?php endwhile; ?>
						</div>
					</div>
				</div>
			</section>
	   <?php } elseif ($elementor_page ) { ?>
		  
			<?php while(have_posts()) : the_post(); ?>
				<?php the_content (); ?>
				<?php wp_link_pages(array('before' => '<div class="klb-pagination">' . esc_html__( 'Pages:', 'chakta' ),'after'  => '</div>', 'next_or_number' => 'number')); ?>
			<?php endwhile; ?>
			
		<?php } else { ?>
			<div class="empty-klb"></div>
			<div class="klb-page section pt-80 pb-80">
				<div class="container">
					<div class="row ">
						<div class="col-md-10 offset-md-1">
							<?php while(have_posts()) : the_post(); ?>
								<h1 class="klb-page-title"><?php the_title(); ?></h1>
								<div class="klb-post">
									<?php the_content (); ?>
									<?php wp_link_pages(array('before' => '<div class="klb-pagination">' . esc_html__( 'Pages:', 'chakta' ),'after'  => '</div>', 'next_or_number' => 'number')); ?>
								</div>
							<?php endwhile; ?>
							<?php comments_template(); ?>
						</div>
					</div>         
				</div>
			</div>
		<?php } ?>
	<?php } else { ?>

	   <?php if ($elementor_page ) { ?>
		  
			<?php while(have_posts()) : the_post(); ?>
				<?php the_content (); ?>
				<?php wp_link_pages(array('before' => '<div class="klb-pagination">' . esc_html__( 'Pages:', 'chakta' ),'after'  => '</div>', 'next_or_number' => 'number')); ?>
			<?php endwhile; ?>
			
		<?php } else { ?>
			<div class="empty-klb"></div>
			<div class="klb-page section pt-80 pb-80">
				<div class="container">
					<div class="row ">
						<div class="col-md-10 offset-md-1">
							<?php while(have_posts()) : the_post(); ?>
								<h1 class="klb-page-title"><?php the_title(); ?></h1>
								<div class="klb-post">
									<?php the_content (); ?>
									<?php wp_link_pages(array('before' => '<div class="klb-pagination">' . esc_html__( 'Pages:', 'chakta' ),'after'  => '</div>', 'next_or_number' => 'number')); ?>
								</div>
							<?php endwhile; ?>
							<?php comments_template(); ?>
						</div>
					</div>         
				</div>
			</div>
		<?php } ?>
	<?php } ?>
<?php get_footer(); ?>