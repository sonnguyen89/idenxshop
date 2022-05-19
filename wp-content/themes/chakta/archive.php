<?php
/**
 * archive.php
 * @package WordPress
 * @subpackage Chakta
 * @since Chakta 1.0
 * 
 */
 ?>

<?php get_header(); ?>


	<section class="klb-blog-breadcrumb breadcrumbs-section bg_cover">
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
 
	<section class="blog-standard-section blog-list pt-80 pb-80">
		<div class="container">
			<div class="row">
				<?php if( get_theme_mod( 'chakta_blog_layout' ) == 'right-sidebar') { ?>
					<div class="col-lg-8">
						<div class="blog-standard">
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

								<?php  get_template_part( 'post-format/content', get_post_format() ); ?>

							<?php endwhile; ?>
								
								<?php get_template_part( 'post-format/pagination' ); ?>
								
							<?php else : ?>

								<div class="no-post">
									<h2><?php esc_html_e('No Posts Found', 'chakta') ?></h2>
									
									<?php get_search_form(); ?>
								</div>

							<?php endif; ?>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="sidebar-widget-area">
							<?php if ( is_active_sidebar( 'blog-sidebar' ) ) { ?>
								<?php dynamic_sidebar( 'blog-sidebar' ); ?>
							<?php } ?>
						</div>
					</div>
				<?php } elseif( get_theme_mod( 'chakta_blog_layout' ) == 'full-width') { ?>
					<div class="col-lg-10 offset-lg-1">
						<div class="blog-standard">
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

								<?php  get_template_part( 'post-format/content', get_post_format() ); ?>

							<?php endwhile; ?>
								
								<?php get_template_part( 'post-format/pagination' ); ?>
								
							<?php else : ?>
							
								<div class="no-post">
									<h2><?php esc_html_e('No Posts Found', 'chakta') ?></h2>
									
									<?php get_search_form(); ?>
								</div>

							<?php endif; ?>
						</div>
					</div>
				<?php } else { ?>
					<?php if ( is_active_sidebar( 'blog-sidebar' ) ) { ?>
						<div class="col-lg-4">
							<div class="sidebar-widget-area blog-sidebar">
								<?php if ( is_active_sidebar( 'blog-sidebar' ) ) { ?>
									<?php dynamic_sidebar( 'blog-sidebar' ); ?>
								<?php } ?>
							</div>
						</div>
						<div class="col-lg-8">
							<div class="blog-standard">
								<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

									<?php  get_template_part( 'post-format/content', get_post_format() ); ?>

								<?php endwhile; ?>
									
									<?php get_template_part( 'post-format/pagination' ); ?>
									
								<?php else : ?>

									<div class="no-post">
										<h2><?php esc_html_e('No Posts Found', 'chakta') ?></h2>
										
										<?php get_search_form(); ?>
									</div>

								<?php endif; ?>
							</div>
						</div>
					<?php } else { ?>
						<div class="col-lg-10 offset-lg-1">
							<div class="blog-standard">
								<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

									<?php  get_template_part( 'post-format/content', get_post_format() ); ?>

								<?php endwhile; ?>
									
									<?php get_template_part( 'post-format/pagination' ); ?>
									
								<?php else : ?>

									<div class="no-post">
										<h2><?php esc_html_e('No Posts Found', 'chakta') ?></h2>
										
										<?php get_search_form(); ?>
									</div>

								<?php endif; ?>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
	</section>
<?php get_footer(); ?>