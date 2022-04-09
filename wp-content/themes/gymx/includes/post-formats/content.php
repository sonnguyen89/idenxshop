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