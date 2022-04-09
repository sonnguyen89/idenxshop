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