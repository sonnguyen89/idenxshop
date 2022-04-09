<div class="col-sm-12">
	<div class="content-quote">
		<?php if (get_post_meta( get_the_ID(), 'gymx_post_blog-quote', true ) != '') {   ?>
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'gymx'), the_title_attribute('echo=0') ); ?>" class="quote-text">
				<blockquote>
					<?php echo esc_html(get_post_meta( get_the_ID(), 'gymx_post_blog-quote', true )); ?>
					<cite><?php echo esc_html(get_post_meta( get_the_ID(), 'gymx_post_blog-quotesource', true )); ?></cite>
				</blockquote>
			</a>
	    <?php } else { esc_html_e('Please insert quote.','gymx'); } ?>
	</div>	
</div>
