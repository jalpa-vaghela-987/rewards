<?php
/**
 * Functions used in the main loop
 *
 * @package Esotera
 */

/**
 * Sets the post excerpt length to the number of words set in the theme settings
 */
function esotera_excerpt_length_words( $length ) {
	if ( is_admin() ) {
		return $length;
	}

	return absint( cryout_get_option( 'theme_excerptlength' ) );
}
add_filter( 'excerpt_length', 'esotera_excerpt_length_words' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 */
function esotera_custom_excerpt_more() {
	if ( ! is_attachment() ) {
		 echo wp_kses_post( esotera_continue_reading_link() );
	}
}
add_action( 'cryout_post_excerpt_hook', 'esotera_custom_excerpt_more', 10 );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function esotera_continue_reading_link() {
	$theme_excerptcont = cryout_get_option( 'theme_excerptcont' );
	return '<a class="continue-reading-link" href="'. esc_url( get_permalink() ) . '"><span>' . wp_kses_post( $theme_excerptcont ). '</span><i class="icon-continue-reading"></i><i class="icon-continue-reading"></i><em class="screen-reader-text">"' . get_the_title() . '"</em></a>';
}
add_filter( 'the_content_more_link', 'esotera_continue_reading_link' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and esotera_continue_reading_link().
 */
function esotera_auto_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}

	return wp_kses_post( cryout_get_option( 'theme_excerptdots' ) );
}
add_filter( 'excerpt_more', 'esotera_auto_excerpt_more' );

/**
 * Adds a "Continue Reading" link to post excerpts created using the <!--more--> tag.
 */
function esotera_more_link( $more_link, $more_link_text ) {
	$theme_excerptcont = cryout_get_option( 'theme_excerptcont' );
	$new_link_text = $theme_excerptcont;
	if ( preg_match( "/custom=(.*)/", $more_link_text, $m ) ) {
		$new_link_text = $m[1];
	}
	$more_link = str_replace( $more_link_text, $new_link_text, $more_link );
	$more_link = str_replace( 'more-link', 'continue-reading-link', $more_link );
	return $more_link;
}
add_filter( 'the_content_more_link', 'esotera_more_link', 10, 2 );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 * Galleries are styled by the theme in style.css.
 */
function esotera_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'esotera_remove_gallery_css' );

/**
 * Posted in category
 */
if ( ! function_exists( 'esotera_posted_category' ) ) :
function esotera_posted_category() {
	if ( 'post' !== get_post_type() ) return;
	$theme_meta_category = cryout_get_option( 'theme_meta_blog_category' );

	if ( is_single() ) {
		$theme_meta_category = cryout_get_option( 'theme_meta_single_category' );
	}

//	if ( $theme_meta_category && get_the_category_list() ) {
//		echo '<span class="bl_categ"' . cryout_schema_microdata( 'category', 0 ) . '>' .
//					'<i class="icon-category icon-metas" title="' . esc_attr__( "Categories", "esotera" ) . '"></i>' .
//					'<span class="category-metas"> '
//					 . get_the_category_list( ' <span class="sep">/</span> ' ) .
//				'</span></span>';
//	}
} // esotera_posted_category()
endif;

/**
 * Posted by author
 */
if ( ! function_exists( 'esotera_posted_author' )) :
function esotera_posted_author() {
	if ( 'post' !== get_post_type() ) return;
	$theme_meta_blog_author = cryout_get_option( 'theme_meta_blog_author' );

	if ( $theme_meta_blog_author ) {
		echo sprintf(
			'<span class="author vcard"' . cryout_schema_microdata( 'author', 0 ) . '>
				<i class="icon-author icon-metas" title="' . esc_attr__( "Author", "esotera" ) . '"></i>
				<a class="url fn n" rel="author" href="%1$s" title="%2$s"' . cryout_schema_microdata( 'author-url', 0 ) . '>
					<em' .  cryout_schema_microdata( 'author-name', 0 ) . '>%3$s</em></a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'esotera' ), get_the_author() ),
			get_the_author()
		);
	}
} // esotera_posted_author
endif;

/**
 * Posted by author for single posts
 */
if ( ! function_exists( 'esotera_posted_author_single' )) :
function esotera_posted_author_single() {
	$theme_meta_single_author = cryout_get_option( 'theme_meta_single_author' );
	global $post;
	$author_id = $post->post_author;

	if ( $theme_meta_single_author ) {
		echo sprintf(
			'<span class="author-avatar" >' . get_avatar( $author_id ) . '</span>' .
			'<span class="author vcard"' . cryout_schema_microdata( 'author', 0 ) . '>' .
				'<a class="url fn n" rel="author" href="%1$s" title="%2$s"' . cryout_schema_microdata( 'author-url', 0 ) . '>
					<em' .  cryout_schema_microdata( 'author-name', 0 ) . '>%3$s</em></a>' .
			'</span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID', 	$author_id ) ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'esotera' ), wp_kses( get_the_author_meta( 'display_name', $author_id), array() ) ),
			wp_kses( get_the_author_meta( 'display_name', $author_id), array() )
		);
	}
} // esotera_posted_author_single
endif;

/**
 * Posted date/time, tags
 */
if ( ! function_exists( 'esotera_posted_date' ) ) :
function esotera_posted_date() {
	if ( 'post' !== get_post_type() ) return;
	$theme_meta_date = cryout_get_option( 'theme_meta_blog_date' );
	$theme_meta_time = cryout_get_option( 'theme_meta_blog_time' );

	if ( is_single() ) {
		$theme_meta_date = cryout_get_option( 'theme_meta_single_date' );
		$theme_meta_time = cryout_get_option( 'theme_meta_single_time' );
	}

	// Post date/time
	if ( $theme_meta_date || $theme_meta_time ) {
		$date = ''; $time = '';
		if ( $theme_meta_date ) { $date = esc_html( get_the_date() ); }
		if ( $theme_meta_time ) { $time = esc_html( get_the_time() ); }
		?>

		<span class="onDate date" >
				<i class="icon-date icon-metas" title="<?php esc_attr_e( "Date", "esotera" ) ?>"></i>
				<time class="published" datetime="<?php echo esc_attr( get_the_time( 'c' ) ) ?>" <?php cryout_schema_microdata( 'time' ) ?>>
					<?php echo $date . ( ( $theme_meta_date && $theme_meta_time ) ? ', ' : '' ) . $time ?>
				</time>
				<time class="updated" datetime="<?php echo esc_attr( get_the_modified_time( 'c' ) ) ?>" <?php cryout_schema_microdata( 'time-modified' ) ?>><?php echo esc_html( get_the_modified_date() );?></time>
		</span>
		<?php
	}

}; // esotera_posted_date()
endif;

/**
 * Posted tags
 */
if ( ! function_exists( 'esotera_posted_tags' ) ) :
function esotera_posted_tags() {
	if ( 'post' !== get_post_type() ) return;
	$theme_meta_tag  = cryout_get_option( 'theme_meta_blog_tag' );

	if ( is_single() ) {
		$theme_meta_tag = cryout_get_option( 'theme_meta_single_tag' );
	}

	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '<span class="sep">#</span>', ' <span class="sep">#</span>' );
	if ( $theme_meta_tag && $tag_list ) { ?>
		<span class="tags" <?php cryout_schema_microdata( 'tags' ) ?>>
				<i class="icon-tag icon-metas" title="<?php esc_attr_e( 'Tagged', 'esotera' ) ?>"></i>&nbsp;<?php echo $tag_list ?>
		</span>
		<?php
	}
}//esotera_posted_tags()
endif;

/**
 * Post edit link for editors
 */
if ( ! function_exists( 'esotera_posted_edit' ) ) :
function esotera_posted_edit() {
	edit_post_link( sprintf( __( 'Edit %s', 'esotera' ), '<em class="screen-reader-text">"' . get_the_title() . '"</em>' ), '<span class="edit-link"><i class="icon-edit icon-metas"></i> ', '</span>' );
}; // esotera_posted_edit()
endif;

/**
 * Post format meta
 */
if ( ! function_exists( 'esotera_meta_format' ) ) :
function esotera_meta_format() {
	if ( 'post' !== get_post_type() ) return;
	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format"><a href="%1$s"><i class="icon-%2$s" title="%3$s"></i> %2$s</a></span>',
			esc_url( get_post_format_link( $format ) ),
			esc_attr( $format ),
			esc_attr( get_post_format_string( $format ) )
		);
	}
} //esotera_meta_format()
endif;

/**
 * Post format meta
 */
if ( ! function_exists( 'esotera_meta_sticky' ) ) :
function esotera_meta_sticky() {
	if ( is_sticky() ) echo '<span class="entry-sticky">' . __('Featured', 'esotera') . '</span>';
} //esotera_meta_sticky()
endif;

/**
 * Post format info
 */
function esotera_meta_infos() {

	//add_action( 'cryout_featured_hook', 'esotera_posted_edit', 50 ); // Edit button

	if ( is_single() ) { // If single, metas are shown after the title

		add_action( 'cryout_post_meta_hook',	'esotera_posted_author_single', 10 );
		add_action( 'cryout_post_meta_hook',	'esotera_posted_date', 30 );
		add_action( 'cryout_post_meta_hook', 	'esotera_comments_on_single', 50 ); // Comments
		add_action( 'cryout_post_title_hook',	'esotera_posted_category', 20 );
		add_action( 'cryout_post_title_hook',	'esotera_posted_edit', 60 ); // Edit button
		add_action( 'cryout_post_utility_hook',	'esotera_posted_tags', 40 );


	} else { // if blog page, metas are shown at the top of the article

		add_action( 'cryout_post_meta_hook', 'esotera_posted_author', 15 );
		add_action( 'cryout_post_thumbnail_hook', 'esotera_comments_on', 50 ); // Comments
		add_action( 'cryout_post_thumbnail_hook', 'esotera_posted_category', 20 );
		add_action( 'cryout_post_utility_hook',	'esotera_posted_tags', 30 );
		add_action( 'cryout_post_meta_hook', 'esotera_posted_date', 40 );

	}

	add_action( 'cryout_meta_format_hook', 'esotera_meta_format', 10 ); // Post format
	add_action( 'cryout_post_title_hook', 'esotera_meta_sticky', 9 ); // Sticky posts
} //esotera_meta_infos()
add_action( 'wp_head', 'esotera_meta_infos' );


/* Remove category from rel in category tags */
function esotera_remove_category_tag( $text ) {
	$text = str_replace( 'rel="category tag"', 'rel="tag"', $text );
	return $text;
} //esotera_remove_category_tag()

/**
 * Backup navigation
 */
if ( ! function_exists( 'esotera_content_nav' ) ) :
function esotera_content_nav( $nav_id ) {
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) : ?>

		<nav id="<?php echo esc_attr( $nav_id ); ?>" class="navigation">

			<span class="nav-previous">
				 <?php next_posts_link( '<i class="icon-angle-left"></i>' . __( 'Older posts', 'esotera' ) ); ?>
			</span>

			<span class="nav-next">
				<?php previous_posts_link( __( 'Newer posts', 'esotera' ) . '<i class="icon-angle-right"></i>' ); ?>
			</span>

		</nav><!-- #<?php echo $nav_id; ?> -->

	<?php endif;
}; // esotera_content_nav()
endif;

/**
 * Adds a post thumbnail and if one doesn't exist the first post image is returned
 * @uses cryout_get_first_image( $postID )
 */
if ( ! function_exists( 'esotera_set_featured_srcset_picture' ) ) :
function esotera_set_featured_srcset_picture() {

	global $post;
	$options = cryout_get_option( array( 'theme_fpost', 'theme_fauto', 'theme_falign', 'theme_magazinelayout', 'theme_landingpage' ) );

	switch ( apply_filters( 'esotera_lppostslayout_filter', $options['theme_magazinelayout'] ) ) {
		case 3: $featured = 'esotera-featured-third'; break;
		case 2: $featured = 'esotera-featured-half'; break;
		case 1: default: $featured = 'esotera-featured'; break;
	}

	// filter to disable srcset if so desired
	$use_srcset = apply_filters( 'esotera_featured_srcset', true );

	if ( function_exists('has_post_thumbnail') && has_post_thumbnail() && $options['theme_fpost']) {
		// has featured image
		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'esotera-featured' );
		$fimage_id = get_post_thumbnail_id( $post->ID );
	} elseif ( $options['theme_fpost'] && $options['theme_fauto'] && empty($featured_image) ) {
		// get the first image from post
		$featured_image = cryout_post_first_image( $post->ID, 'esotera-featured' );
		$fimage_id = $featured_image['id'];
	} else {
		// featured image not enabled or not obtainable
		$featured_image[0] = apply_filters('esotera_preview_img_src', '');
		$featured_image[1] = apply_filters('esotera_preview_img_w', '');
		$featured_image[2] = apply_filters('esotera_preview_img_h', '');
		$fimage_id = FALSE;
	};

	if ( ! empty( $featured_image[0] ) ) {

		$featured_width = esotera_featured_width();
		?>
		<div class="post-thumbnail-container" <?php cryout_schema_microdata( 'image' ); ?>>
			<div class="entry-meta">
				<?php do_action('cryout_post_thumbnail_hook'); ?>
			</div>
			<a class="post-featured-image" href="<?php echo esc_url( get_permalink( $post->ID ) ) ?>" title="<?php echo esc_attr( get_post_field( 'post_title', $post->ID ) ) ?>" <?php cryout_echo_bgimage( $featured_image[0] ) ?> tabindex="-1">
			</a>
			<picture class="responsive-featured-image">
				<source media="(max-width: 1152px)" sizes="<?php echo esc_attr( cryout_gen_featured_sizes( $featured_width, $options['theme_magazinelayout'], $options['theme_landingpage'] ) ) ?>" srcset="<?php echo esc_url( cryout_get_picture_src( $fimage_id, 'esotera-featured-third' ) ); ?> 512w">
				<source media="(max-width: 800px)" sizes="<?php echo esc_attr( cryout_gen_featured_sizes( $featured_width, $options['theme_magazinelayout'], $options['theme_landingpage'] ) ) ?>" srcset="<?php echo esc_url( cryout_get_picture_src( $fimage_id, 'esotera-featured-half' ) ); ?> 800w">
				<?php if ( cryout_on_landingpage() ) { ?><source sizes="<?php echo esc_attr( cryout_gen_featured_sizes( $featured_width, $options['theme_magazinelayout'], $options['theme_landingpage'] ) ) ?>" srcset="<?php echo esc_url( cryout_get_picture_src( $fimage_id, 'esotera-featured-lp' ) ); ?> <?php printf( '%sw', absint( $featured_width ) ) ?>">
				<?php } ?>
				<img alt="<?php the_title_attribute();?>" <?php cryout_schema_microdata( 'url' ); ?> src="<?php echo esc_url( cryout_get_picture_src( $fimage_id, 'esotera-featured' ) ); ?>">
			</picture>
			<meta itemprop="width" content="<?php echo absint( $featured_image[1] ); // width ?>">
			<meta itemprop="height" content="<?php echo absint( $featured_image[2] ); // height ?>">
			<div class="featured-image-overlay">
				<a class="featured-image-link" href="<?php echo esc_url( get_permalink( $post->ID ) ) ?>" title="<?php echo esc_attr( get_post_field( 'post_title', $post->ID ) ) ?>" tabindex="-1"></a>
			</div>
		</div>
	<?php } else { ?>
		<div class="entry-meta">
			<?php do_action('cryout_post_thumbnail_hook'); ?>
		</div>
		<?php // return false;
	}
} // esotera_set_featured_srcset_picture()
endif;
if ( cryout_get_option( 'theme_fpost' ) ) add_action( 'cryout_featured_hook', 'esotera_set_featured_srcset_picture' );

/* FIN */
