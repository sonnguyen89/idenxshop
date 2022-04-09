<?php 
	$post_format = get_post_format();
	if ( false === $post_format ) {
		$post_format = '';
	}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(array('col-sm-12','blog-item', 'clearfix')); ?>>
	<div class="row">
		<div class="col-sm-12">
			<div class="row">
				<?php get_template_part('includes/post-formats/medium/content', $post_format); ?>
			</div>
			<hr class="blog-medium-divider" />
		</div>
    </div>
</article>