<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="blog-post-item mb-40">
		<div class="post-thumbnail">
			<figure class="entry-media embed-responsive embed-responsive-16by9">
			    <?php  
				if (get_post_meta( get_the_ID(), 'klb_blog_video_type', true ) == 'vimeo') {  
				  echo '<iframe src="//player.vimeo.com/video/'.get_post_meta( get_the_ID(), 'klb_blog_video_embed', true ).'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" height="443" allowFullScreen></iframe>';  
				}  
				else if (get_post_meta( get_the_ID(), 'klb_blog_video_type', true ) == 'youtube') {  
				  echo '<iframe height="450" src="//www.youtube.com/embed/'.get_post_meta( get_the_ID(), 'klb_blog_video_embed', true ).'?rel=0&showinfo=0&modestbranding=1&hd=1&autohide=1&color=white" allowfullscreen></iframe>';  
				}  
				else {  
					echo ' '.get_post_meta( get_the_ID(), 'klb_blog_video_embed', true ).' '; 
				}  
				?>
			</figure>
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
				<?php the_excerpt(); ?>
				<?php wp_link_pages(array('before' => '<div class="klb-pagination">' . esc_html__( 'Pages:', 'chakta' ),'after'  => '</div>', 'next_or_number' => 'number')); ?>
			</div>
		</div>
	</div>
</article>
