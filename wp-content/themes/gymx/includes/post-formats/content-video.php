<?php if (get_post_meta( get_the_ID(), 'gymx_post_blog-videourl', true ) != '' || get_post_meta( get_the_ID(), 'gymx_post_blog-videoembed', true ) != '' ) {  ?>
    <div class="content-video embed-responsive embed-responsive-16by9">
       <?php   
            if (get_post_meta( get_the_ID(), 'gymx_post_blog-videosource', true ) == 'videourl') {
                echo wp_oembed_get(esc_url(get_post_meta( get_the_ID(), 'gymx_post_blog-videourl', true )), array('class' => 'embed-responsive-item'));
            }  
            else {  
                echo wp_kses(get_post_meta( get_the_ID(), 'gymx_post_blog-videoembed', true ), gymx_allowed_tags());
            }  
        ?>
    </div>
    <?php } ?>