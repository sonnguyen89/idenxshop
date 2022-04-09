<?php 
    $post_format = get_post_format();
	if ( false === $post_format ) {
		$post_format = '';
	} ?>
<div class="content-gallery">

    <div class="flexslider">
        <ul class="slides">
            <?php $images = rwmb_meta( 'gymx_post_blog-gallery', 'type=image_advanced&size=gymx-img-size-blog' );
                if (empty($images)) {
                    // Make sure the post has a gallery in it
                 	if( ! has_shortcode( $post->post_content, 'gallery' ) )
                 		return $post->post_content;
                
                 	// Retrieve the first gallery in the post
                 	$gallery = get_post_gallery_images( $post );
                 	// Loop through each image in each gallery
                	foreach( $gallery as $image_url ) {
                        echo "<li><img src='".esc_url($image_url)."'/></li>";
                
                	}
                } else {
                    foreach ( $images as $image ) {
                        echo "<li><img src='".esc_url($image['url'])."' width='".esc_attr($image['width'])."' height='".esc_attr($image['height'])."' alt='".esc_attr($image['alt'])."' /></li>";
                    }    
                }
            ?>
        </ul>
    </div>

</div>
<div class="content-wrap">
    <header class="entry-header">
		<?php if ( 'post' == get_post_type() ) : ?>
			<a href="<?php esc_url(the_permalink()) ?>">
			<?php echo sprintf(wp_kses(__( '<span class="entry-posted-on">%1$s</span>', 'gymx'), array( 'span' => array( 'class' => array() ) ) ),esc_html( get_the_date(get_option( 'date_format' )) ) ); ?>
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