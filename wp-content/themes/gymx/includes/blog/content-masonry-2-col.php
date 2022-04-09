<?php 
	$post_format = get_post_format();
	if ( false === $post_format ) {
		$post_format = '';
	}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(array('col-sm-6','masonry-item', 'clearfix')); ?>>
    <?php get_template_part('includes/post-formats/masonry/content', $post_format); ?>
</article>