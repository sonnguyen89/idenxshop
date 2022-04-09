<?php 
    $post_format = get_post_format();
	if ( false === $post_format ) {
		$post_format = '';
	} ?>
	
<div class="content-img">
    <?php
    if ( has_post_thumbnail() ) { ?>
        <div class="col-xs-12 col-sm-4">
            <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'gymx'), the_title_attribute('echo=0') ); ?>" rel="bookmark">
                <?php the_post_thumbnail('gymx-img-size-blog'); ?>
            </a>    
        </div>
        <div class="col-xs-12 col-sm-8">
   <?php } else { ?>
        <div class="col-xs-12">
    <?php } ?>
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
</div>
