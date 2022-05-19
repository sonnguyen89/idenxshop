<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="blog-post-item">
		<div class="post-thumbnail">
			<?php $images = rwmb_meta( 'klb_blogitemslides', 'type=image_advanced&size=medium' ); ?>
			<?php if($images) { ?>
				<?php wp_enqueue_script( 'chakta-blog-gallery'); ?>
				<div class="blog-gallery">
					<?php  foreach ( $images as $image ) { ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<img src="<?php echo esc_url($image['full_url']); ?>" alt="<?php the_title_attribute(); ?>">
						</a>
					<?php } ?>
				</div>
			<?php } ?>
		</div>

		<div class="entry-content">
			<div class="post-meta">
				<ul>
					<li><span class="post-date"><i class="far fa-calendar-alt"></i><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></span></li>
					<?php if(has_category()){ ?>
					<li><span class="comment"><i class="far fa-folder"></i><?php the_category(', '); ?></span></li>
					<?php } ?>	
					
					<?php the_tags( '<li><span class="tags"><i class="far fa-bookmark"></i>', ', ', ' </span></li>'); ?>
					
					<?php if ( is_sticky()) {
						printf( '<li><span class="sticky"><i class="far fa-star"></i>%s</span></li>', esc_html__('Featured', 'chakta' ) );
					} ?>
					

				</ul>
			</div>
			<h3 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			<div class="klb-post">
				<?php the_content(); ?>
				<?php wp_link_pages(array('before' => '<div class="klb-pagination">' . esc_html__( 'Pages:', 'chakta' ),'after'  => '</div>', 'next_or_number' => 'number')); ?>
			</div>
		</div>
	</div>
</article>