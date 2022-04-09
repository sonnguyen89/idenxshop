<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package ttbase
 */

get_header();

$terms = get_the_terms( get_the_ID(), 'team_category' );
$top_padding = rwmb_meta('gymx_post_top_padding',get_the_ID());
$bottom_padding = rwmb_meta('gymx_post_bottom_padding',get_the_ID());
?>
<section class="wrapper <?php echo esc_attr($top_padding) . ' ' . esc_attr($bottom_padding); ?>" id="single-wrapper">
    <?php 
    if ( have_posts() ) : while ( have_posts() ) : the_post();
        $position   = rwmb_meta( 'gymx_post_team-position' );
        $twitter    = rwmb_meta( 'gymx_post_team-twitter' );
        $facebook   = rwmb_meta( 'gymx_post_team-facebook' );
        $googleplus = rwmb_meta( 'gymx_post_team-googleplus' );
        $instagram  = rwmb_meta( 'gymx_post_team-instagram' );
        $linkedin   = rwmb_meta( 'gymx_post_team-linkedin' );
        $dribbble   = rwmb_meta( 'gymx_post_team-dribbble' );
        $skype      = rwmb_meta( 'gymx_post_team-skype' );
        $phone      = rwmb_meta( 'gymx_post_team-phone' );
        $mail       = rwmb_meta( 'gymx_post_team-mail' );
        $terms = get_the_terms( get_the_ID(), 'team_category' ); ?>
        
        <div class="container">
            <div class="row">
            	<div class="col-md-4">
            	    <?php if ( has_post_thumbnail() ) { ?>
            	    <div class="team-member-image">
            	        <?php the_post_thumbnail('full'); ?>
            	    </div>
                    <?php } ?>
            	    <h3 class="team-member-title"><?php the_title(); ?></h3>
            	    <?php if ($position) { ?>
            	        <h3 class="team-member-position"><?php echo esc_attr($position); ?></h3>
            	   <?php } ?>
            	   <?php if ( ! empty ($terms)) { ?>
            	   	<ul class="tagcloud">
                    <?php
                    foreach ($terms as $term) {
                        echo '<a href="' . esc_url( get_term_link($term) ) . '">' . $term->name . '</a>';
                    }
                    ?>
                    </ul>
            	   <?php } 
            	   // Phone & Mail
            	   if ($phone) { ?>
            	   	<div class="team-member-contact">
			           <?php if ($phone) { ?>
			               <div><i class="fa fa-phone"></i><?php echo esc_attr($phone); ?></div>
			           <?php } ?>
			           <?php if ($mail) { ?>
			               <div><i class="fa fa-envelope"></i><?php echo esc_attr($mail); ?></div>
			           <?php } ?>
			       </div>
            	   <?php } ?>
            	   
                   <?php 
                   // Social Profiles
				    if ( $twitter || $facebook || $googleplus || $instagram || $linkedin || $dribbble || $skype ) { ?>
				        <ul class="team-member-social">
				            <?php if ($twitter) { ?>
				                <li>
				                    <a href="<?php echo esc_url($twitter);?>" title="<?php esc_html_e('Twitter','ttbase-framework'); ?>"><i class="sl sl-twitter"></i></a>
				                </li>
				            <?php } ?>
				            <?php if ($facebook) { ?>
				                <li>
				                    <a href="<?php echo esc_url($facebook);?>" title="<?php esc_html_e('Facebook','ttbase-framework'); ?>"><i class="sl sl-facebook"></i></a>
				                </li>
				            <?php } ?>
				            <?php if ($googleplus) { ?>
				                <li>
				                    <a href="<?php echo esc_url($googleplus);?>" title="<?php esc_html_e('Google+','ttbase-framework'); ?>"><i class="sl sl-google-plus"></i></a>
				                </li>
				            <?php } ?>
				            <?php if ($instagram) { ?>
				                <li>
				                    <a href="<?php echo esc_url($instagram);?>" title="<?php esc_html_e('Instagram','ttbase-framework'); ?>"><i class="sl sl-instagram"></i></a>
				                </li>
				            <?php } ?>
				            <?php if ($dribbble) { ?>
				                <li>
				                    <a href="<?php echo esc_url($dribbble);?>" title="<?php esc_html_e('Dribbble','ttbase-framework'); ?>"><i class="sl sl-dribbble"></i></a>
				                </li>
				            <?php } ?>
				            <?php if ($linkedin) { ?>
				                <li>
				                    <a href="<?php echo esc_url($linkedin);?>" title="<?php esc_html_e('LinkedIn','ttbase-framework'); ?>"><i class="sl sl-linkedin"></i></a>
				                </li>
				            <?php } ?>
				            <?php if ($skype) { ?>
				                <li>
				                    <a href="<?php echo esc_url($skype);?>" title="<?php esc_html_e('Skype','ttbase-framework'); ?>"><i class="sl sl-skype"></i></a>
				                </li>
				            <?php } ?>
				        </ul>
				    <?php } ?>
				    <div class="team-member-excerpt">
				    	<?php the_excerpt(); ?>
				    </div>
				    <?php
				    //Team Sidebar
				    if ( is_active_sidebar('sidebar-team') && rwmb_meta( 'gymx_post_content_sidebar',$post->ID ) != 'hide' ) { ?>
				        <div class="team-member-sidebar">
                    		<?php dynamic_sidebar( 'sidebar-team' ); ?>
                    	</div>
				    <?php } ?>
            	</div>
            	<div class="col-md-8">
            	    <div class="row">
                		<article id="post-<?php the_ID(); ?>" <?php post_class(array('col-sm-12','team-member-content', 'clearfix')); ?>>
    		                <?php the_content(); ?>
        			    </article>
                	</div>
            	</div>
            </div>
        </div>
    <?php
	endwhile;
	endif;
    ?>
</section>

<?php get_footer(); ?>
