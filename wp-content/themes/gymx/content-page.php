<?php
/**
 * The template used for displaying page content in page.php
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php gymx_paging_nav(); ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
