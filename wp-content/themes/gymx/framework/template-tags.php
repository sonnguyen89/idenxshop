<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 */

if ( ! function_exists( 'gymx_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function gymx_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	
	// Previous/next page navigation.
	the_posts_pagination( array(
		'mid_size' => 2,
		'prev_text' => '<i class="icon-prev"></i>',
		'next_text' => '<i class="icon-next"></i>',
	) );
}
endif;

if ( ! function_exists( 'gymx_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function gymx_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<hr class="divider" />
	<nav class="post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'gymx' ); ?></h1>
		<div class="nav-links row pdt5">
		<?php
			previous_post_link( wp_kses(__('<div class="nav-previous col-md-6"><label>Previous Post</label>%link</div>','gymx'), array( 'div' => array( 'class' => array() ),'label' => array() )), wp_kses( _x( '<i class="icon-prev"></i>&nbsp;%title', 'Previous post link', 'gymx' ), array(  'i' => array( 'class' => array() ) ) ) );
			next_post_link( wp_kses(__('<div class="nav-next text-right col-md-6 pull-right"><label>Next Post</label>%link</div>','gymx'), array(  'div' => array( 'class' => array() ), 'label' => array() )), wp_kses( _x( '%title&nbsp;<i class="icon-next"></i>', 'Next post link', 'gymx' ), array( 'i' => array( 'class' => array() ) ) ) );
		?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'gymx_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function gymx_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( date_i18n(get_option( 'date_format' )) ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'gymx' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'gymx' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';

}
endif;

if ( ! function_exists( 'gymx_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function gymx_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'gymx' ) );
		if ( $categories_list ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'gymx' ) . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'gymx' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'gymx' ) . '</span>', $tags_list );
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'gymx' ), esc_html__( '1 Comment', 'gymx' ), esc_html__( '% Comments', 'gymx' ) );
		echo '</span>';
	}

	edit_post_link( esc_html__( 'Edit', 'gymx' ), '<span class="edit-link">', '</span>' );
}
endif;

if ( ! function_exists( 'gymx_the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function gymx_the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( esc_html__( 'Category: %s', 'gymx' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( esc_html__( 'Tag: %s', 'gymx' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( esc_html__( 'Author: %s', 'gymx' ), get_the_author() );
	} elseif ( is_year() ) {
		$title = sprintf( esc_html__( 'Year: %s', 'gymx' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'gymx' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( esc_html__( 'Month: %s', 'gymx' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'gymx' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( esc_html__( 'Day: %s', 'gymx' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'gymx' ) ) );
	} elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {
		$title = esc_html_x( 'Asides', 'post format archive title', 'gymx' );
	} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
		$title = esc_html_x( 'Galleries', 'post format archive title', 'gymx' );
	} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
		$title = esc_html_x( 'Images', 'post format archive title', 'gymx' );
	} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
		$title = esc_html_x( 'Videos', 'post format archive title', 'gymx' );
	} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
		$title = esc_html_x( 'Quotes', 'post format archive title', 'gymx' );
	} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
		$title = esc_html_x( 'Links', 'post format archive title', 'gymx' );
	} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
		$title = esc_html_x( 'Statuses', 'post format archive title', 'gymx' );
	} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
		$title = esc_html_x( 'Audio', 'post format archive title', 'gymx' );
	} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
		$title = esc_html_x( 'Chats', 'post format archive title', 'gymx' );
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( esc_html__( 'Archives: %s', 'gymx' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( esc_html__( '%1$s: %2$s', 'gymx' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = esc_html__( 'Archives', 'gymx' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		return $before . $title . $after;
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function gymx_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'gymx_scripts_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'gymx_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so gymx_scripts_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so gymx_scripts_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in gymx_scripts_categorized_blog.
 */
function gymx_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'gymx_categories' );
}
add_action( 'edit_category', 'gymx_category_transient_flusher' );
add_action( 'save_post',     'gymx_category_transient_flusher' );
