<?php if ( comments_open() ) : ?>

    <!-- Add comment -->

            <h5><?php esc_html_e( 'Write Comment.', 'gymx' ); ?> <small class="text-danger"><?php esc_html_e( '*Mandatory', 'gymx' ); ?></small></h5>

            <input type="hidden" name="redirect_to" value="<?php echo home_url(add_query_arg(array(), $wp->request)); ?>" />

            <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" role="form">

                <hr/>
                <div class="form-group">
                    <label for="author"><?php esc_html_e( 'Name', 'gymx' ); ?> <small class="text-danger">*</small></label>
                    <input class="form-control" type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22"/>
                </div>

                <hr/>
                <div class="form-group">
                    <label for="email"><?php esc_html_e( 'E-Mail', 'gymx' ); ?> <small>( <?php esc_html_e( 'Not public.', 'gymx' ); ?> )</small><small class="text-danger">*</small></label>
                    <input class="form-control" type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2"/>
                </div>
                <hr/>
                <div class="form-group">
                    <label for="url"><?php esc_html_e( 'Website', 'gymx' ); ?></label>
                    <input class="form-control" type="url" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
                </div>
                <hr/>
                <div class="form-group">
                    <label><?php esc_html_e( 'Your Comment', 'gymx' ); ?> <small class="text-danger">*</small></label>
                    <textarea class="form-control" placeholder="<?php esc_html_e( 'Your Comment', 'gymx' ); ?>" name="comment" id="comment" style="width: 100%;" rows="10" tabindex="4"></textarea>
                </div>



                <div class="form-group text-center">
                    <input class="form-control btn btn-primary" name="submit" type="submit" id="submit" tabindex="5" value="<?php esc_html_e( 'Send comment.', 'gymx' ); ?>" />
                    <input class="form-control" type="hidden" name="comment_post_ID" value="<?php echo esc_attr($id); ?>" />
                </div>

                <?php do_action('comment_form', $post->ID); ?>

            </form>

<?php endif ?>