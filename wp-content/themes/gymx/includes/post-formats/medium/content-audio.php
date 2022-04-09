<?php 
    $post_format = get_post_format();
	if ( false === $post_format ) {
		$post_format = '';
	} ?>
<?php if (get_post_meta( get_the_ID(), 'gymx_post_blog-audioembed', true ) != '' ) {  ?>
    <div class="col-sm-12 col-md-4">
        <div class="content-audio">
           <?php   
                echo wp_kses(get_post_meta( get_the_ID(), 'gymx_post_blog-audioembed', true ), gymx_allowed_tags());
            ?>
        </div>    
    </div>
<?php } ?>
    <div class="col-sm-12 col-md-8">
        <div class="content-wrap">
            <header class="entry-header">
            	<?php //Post Title
    			the_title( sprintf( '<h5 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' ); ?>
            	<div class="clearfix">
            		<div class="date-wrapper">
    		         <?php 
            		//Post Date
            		if ( 'post' == get_post_type() ) : ?>
    					<a href="<?php esc_url(the_permalink()) ?>">
    					<?php echo sprintf(wp_kses(__( '<span class="entry-posted-on">%1$s</span>', 'gymx'), array( 'span' => array( 'class' => array() ) ) ),esc_html( get_the_date(get_option( 'date_format' )) ) ); ?>
    					</a>
    				<?php endif; ?>
    			    </div>
            	</div>
    		</header><!-- .entry-header -->
            <?php 
	        	if(!( 'page' == get_post_type() ) || '' == $post_format) { ?>
	        	<p>
	        		<?php echo wp_kses_post(gymx_custom_excerpt(20)); ?>
	        	</p>
	        		
	        	<?php } ?>
        </div>
    </div>