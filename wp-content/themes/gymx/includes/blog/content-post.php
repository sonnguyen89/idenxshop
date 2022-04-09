<div class="content-wrap">
	<header class="entry-header">
    	<div class="clearfix">
    		<div class="date-wrapper">
	         <?php 
    		//Post Date
    		if ( 'post' == get_post_type() ) : ?>
			    <?php echo sprintf(wp_kses(__( '<span class="entry-posted-on">%1$s</span>', 'gymx'), array( 'span' => array( 'class' => array() ) ) ),esc_html( get_the_date('d. M') ) ); ?>
			<?php endif; ?>
		    </div>
		    <div class="meta col-sm-10">
            	<div class="author">
                	<i class="icon-user"></i>
                	<?php the_author_posts_link(); ?>
                </div>
                <?php
                $categories_list = get_the_category_list( esc_html_x( ', ', 'Used between list items, there is a space after the comma.', 'gymx' ) );
        		if ( $categories_list ) {
        			printf( '<div class="categories"><i class="icon-folder"></i>%1$s</div>',
        				$categories_list
        			);
        		} ?>
    		</div>
		</div>
		<?php //Post Title
		if ( get_theme_mod('gymx_post_title','no') == 'yes' ) {
			the_title('<h3 class="entry-title">','</h3>' );
		}
		?>
	</header><!-- .entry-header -->
	
    <div class="single-content">
        <?php
    		the_content();
    		wp_link_pages();
    	?>
    </div>
    <?php if (get_theme_mod('gymx_show_tags','yes') != 'no' || get_theme_mod('gymx_show_social_share', 'yes') != 'no') { ?>
	    <hr class="divider" />
	    <div class="row">
	    	<div class="col-md-12">
	    		<?php if (get_theme_mod('gymx_show_tags','yes') != 'no' && get_the_tags()) { ?>
	    			<div class="tagcloud pull-left">
		    			<label><?php esc_html_e('Tags','gymx'); ?></label>
		    			<?php the_tags('','',''); ?>
		    		</div>
	    		<?php } ?>
	  			<?php if (get_theme_mod('gymx_show_social_share', 'yes') != 'no') {
	  				get_template_part('includes/socialshare');
	  			} ?>
	    	</div>
	    </div>	
    <?php } ?>
    
    <?php 
    	$author_desc = get_the_author_meta( 'description' );
    	if ( get_theme_mod('gymx_show_author_details','yes') != 'no' && $author_desc != '' ) { ?>
	 	<hr class="divider" />
	 	<div id="author-info" class="row pd15">
		    <div class="author-image col-sm-2">
		    	<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta( 'ID' ))); ?>"><?php echo get_avatar( esc_attr(get_the_author_meta('user_email')), '160', '' ); ?></a>
		    </div>   
		    <div class="author-bio col-sm-10">
		       <label class="pdb15"><?php echo the_author_meta( 'display_name', get_the_author_meta( 'ID' ) ); ?></label>
		        <p><?php the_author_meta('description'); ?></p>
		    </div>
		</div>
	<?php } ?>
	<?php if (get_theme_mod('gymx_show_post_navigation','yes') != 'no') { ?>
	    <?php gymx_post_nav(); ?>
    <?php } ?>
    <?php if( comments_open() ) { ?>
    	<hr class="divider" />
		<?php comments_template(); 
	}?>
</div>