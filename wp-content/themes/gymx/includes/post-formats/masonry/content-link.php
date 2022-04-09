<div class="content-link">
        <a href="<?php echo esc_url(get_post_meta( get_the_ID(), 'gymx_post_blog-link', true )) ?>" title="<?php printf( esc_attr__('Link to %s', 'gymx'), the_title_attribute('echo=0') ); ?>" target="_blank"><?php the_title(); ?><span><?php echo esc_html(get_post_meta( get_the_ID(), 'gymx_post_blog-link', true )) ?></span></a>
</div>