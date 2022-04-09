<?php
/**
 * The sidebar containing the main widget area.
 *
 */

if ( ! is_active_sidebar( 'sidebar-blog' ) ) {
	return;
}
?>

<div class="col-md-4">
	<aside class="sidebar">
		<?php dynamic_sidebar( 'sidebar-blog' ); ?>
	</aside>
</div><!-- #secondary -->
