<?php 
    $post_format = get_post_format();
	if ( false === $post_format ) {
		$post_format = '';
	} ?>
<?php if (get_post_meta( get_the_ID(), 'gymx_post_blog-videourl', true ) != '' || get_post_meta( get_the_ID(), 'gymx_post_blog-videoembed', true ) != '' ) {  ?>
    <div class="content-video embed-responsive embed-responsive-16by9">
       <?php   
            if (get_post_meta( get_the_ID(), 'gymx_post_blog-videosource', true ) == 'videourl') {
                echo wp_oembed_get(esc_url(get_post_meta( get_the_ID(), 'gymx_post_blog-videourl', true )), array('class' => 'embed-responsive-item'));
            }  
            else {  
                $video = wp_kses(get_post_meta( get_the_ID(), 'gymx_post_blog-videoembed', true ), gymx_allowed_tags());
                echo do_shortcode( '[video src="'. $video . '"]' ); 
            }  
        ?>
    </div>
<?php } ?>
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