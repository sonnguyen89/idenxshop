<?php 
    $post_format = get_post_format();
	if ( false === $post_format ) {
		$post_format = '';
	} ?>
<?php if(!is_single()) { ?>
    <a href="<?php the_permalink(); ?>"> 
<?php } ?>
    <div class="content-img">
        <?php
        if ( has_post_thumbnail() ) {
            the_post_thumbnail('gymx-img-size-blog'); 
        } else {
            // No post thumbnail, try attachments instead.
            $images = get_posts(
                array(
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'post_parent'    => get_the_ID(),
                    'posts_per_page' => 1, /* Save memory, only need one */
                )
            );
    
            if ( $images ) {
                echo wp_get_attachment_image( $images[0]->ID, 'gymx-img-size-blog' );
            }
        } ?>
    </div>
<?php if(!is_single()) { ?>
</a>
<?php } ?>
<div class="content-wrap">
	    	
	        <header class="entry-header">
        		
        		<?php if ( 'post' == get_post_type() ) : ?>
					<a href="<?php esc_url(the_permalink()) ?>">
					<?php echo sprintf(wp_kses(__( '<span class="entry-posted-on">%1$s</span>', 'gymx'), array( 'span' => array( 'class' => array() ) ) ),esc_html(get_the_date(get_option( 'date_format' )) ) ); ?>
					</a>
				<?php endif; 
				
				the_title( sprintf( '<h5 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' ); ?>
		        
			</header><!-- .entry-header -->
	        
	       <?php 
	        	if(!( 'page' == get_post_type() ) || '' == $post_format) { ?>
	        	<p>
	        		<?php echo wp_kses_post(gymx_custom_excerpt(20)); ?>
	        	</p>
	        		
	        <?php } ?>
	    </div>