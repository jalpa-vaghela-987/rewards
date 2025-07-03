<?php
/**
 * Comments related functions
 *
 * @package esotera
 */

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own esotera_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 */
if ( ! function_exists( 'esotera_comment' ) ) :
function esotera_comment( $comment, $args, $depth ) {
	switch ( $comment->comment_type ) :
		case 'pingback'  :
		case 'trackback' :
		?>
			<li class="post pingback">
			<p><?php _e( 'Pingback: ', 'esotera' ); ?><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'esotera' ), ' ' ); ?></p>
		<?php
		break;
		case '' :
		default :
		?>
			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>"<?php cryout_schema_microdata( 'comment' ); ?>>

				<article>
					<div class="comment-avatar">
							<?php echo get_avatar( $comment, 50, '', '', array( 'extra_attr' => cryout_schema_microdata('image', 0) )  ); ?>
							<div class="comment-author" <?php cryout_schema_microdata( 'comment-author' ); ?>>
								<?php printf(  '%s ', sprintf( '<span class="author-name fn"' . cryout_schema_microdata( 'author-name', 0) . '>%s</span>', get_comment_author_link() ) ); ?>
							</div> <!-- .comment-author -->
					</div>
					<div class="comment-body" <?php cryout_schema_microdata( 'text' ); ?>>

						<header class="comment-header vcard">


							<div class="comment-meta">
								<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
								<time datetime="<?php comment_time( 'c' );?>" <?php cryout_schema_microdata( 'time' );?>>

									<span class="comment-date">
										<?php /* translators: 1: date, 2: time */
										printf(  '%1$s ' . __( 'at', 'esotera' ) . ' %2$s', get_comment_date(),  get_comment_time() ); ?>
									</span>
									<span class="comment-timediff">
										<?php printf( _x( '%1$s ago', '%s = human-readable time difference', 'esotera' ), esc_html( human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ) ); ?>
									</span>

								</time>
								</a>
								<?php edit_comment_link( __( '(Edit)', 'esotera' ), ' ' ); ?>
							</div><!-- .comment-meta -->

							<div class="reply">
								<?php comment_reply_link( array_merge( $args, array(
										'reply_text' 	=> '<i class="icon-reply-comments"></i> ' . __( 'Reply', 'esotera' ),
										'depth'			=> $depth,
										'max_depth'		=> $args['max_depth'] ) ) );
								?>
							</div><!-- .reply -->

						</header><!-- .comment-header .vcard -->

						<?php if ( $comment->comment_approved == '0' ) : ?>
							<span class="comment-await"><em><?php _e( 'Your comment is awaiting moderation.', 'esotera' ); ?></em></span>
						<?php endif; ?>
						<?php comment_text(); ?>
					</div><!-- .comment-body -->
				</article>
		<?php
		break;
	endswitch;

	// </li><!-- #comment-##  -->  closed by wp_comments_list()
} // esotera_comment()
endif;

/** Number of comments on loop post if comments are enabled. */
if ( ! function_exists( 'esotera_comments_on' ) ) :
function esotera_comments_on() {
	$meta_blog_comment = cryout_get_option( 'theme_meta_blog_comment' );
    // Only show comments if they're open, or are closed but with comments already posted, if the theme's meta comments are enabled and if it's not a single post
//    if ( ( comments_open() || get_comments_number() ) && ! post_password_required() && $meta_blog_comment && ! is_single() ) :
//			echo '<span class="comments-link" title="' . sprintf( esc_attr__('Comments on "%s"', 'esotera'), esc_attr( get_the_title() ) ) . '"><i class="icon-comments icon-metas" title="' . esc_attr__('Comments', 'esotera') . '"></i>';
//			comments_popup_link(
//				 0,
//				 1,
//				number_format_i18n( get_comments_number() ),
//				'',
//				''
//			);
//			echo '</span>';
//		endif;
} // esotera_comments_on()
endif;

/** Number of comments on single post if comments are enabled. */
if ( ! function_exists( 'esotera_comments_on_single' ) ) :
function esotera_comments_on_single() {
	$meta_single_comment = cryout_get_option( 'theme_meta_single_comment' );
    // Only show comments if they're open, or are closed but with comments already posted, if the theme's meta comments are enabled and if it's not a single post
    if ( ( comments_open() || get_comments_number() ) && $meta_single_comment && is_single() ) :
			echo '<span class="comments-link" title="' . esc_attr__('Jump to comments', 'esotera') . '">
					<i class="icon-comments icon-metas" title="' . esc_attr__('Comments', 'esotera') . '"></i>';
					comments_popup_link(
						 __( 'Leave a comment', 'esotera' ),
						 __( 'One Comment', 'esotera' ),
						sprintf( _n( '%1$s Comment', '%1$s Comments', get_comments_number(), 'esotera' ), number_format_i18n( get_comments_number() ) ),
						'',
						''
					);
			echo '</span>';
		endif;
} // esotera_comments_on_single()
endif;

/** Adds microdata tags to comment link */
if ( ! function_exists( 'esotera_comments_microdata' ) ) :
function esotera_comments_microdata() {

	cryout_schema_microdata('comment-meta');

} // esotera_comments_microdata()
endif;
add_filter( 'comments_popup_link_attributes', 'esotera_comments_microdata' );


/* Edit comments form inputs: removed labels and replaced them with placeholders */
function esotera_comments_form( $arg ) {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$arg =  array(

		'author' =>	'<p class="comment-form-author"><label for="author">' . __( 'Name', 'esotera' ) .  ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
					'<em><input id="author" placeholder="'. esc_attr__( 'Name', 'esotera' ) .'*" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size="30" maxlength="245"' . $aria_req . ' /></em></p>',

		'email' =>	'<p class="comment-form-email"><label for="email">' . __( 'Email', 'esotera' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
					'<em><input id="email" placeholder="'. esc_attr__( 'Email', 'esotera' ) . '*" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) .
					'" size="30"  maxlength="100" aria-describedby="email-notes"' . $aria_req . ' /></em></p>',

		'url' =>	'<p class="comment-form-url"><label for="url">' . __( 'Website', 'esotera' ) . '</label>' .
					'<em><input id="url" placeholder="'. esc_attr__( 'Website', 'esotera' ) .'" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) .
					'" size="30"  maxlength="200" /></em></p>',
		'cookies' => '<p class="comment-form-cookies-consent"><label for="wp-comment-cookies-consent">' .
   	                  '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" />' .
 	                   __( 'Save my name, email, and site URL in my browser for next time I post a comment.', 'esotera' ) . '</label></p>',

	);

	return $arg;
} // esotera_comments_form()

/* Edit comments form textarea: removed label and replaced it with a placeholder */
function esotera_comments_form_textarea( $arg ) {
//	$arg = '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'esotera' ) .
//			'</label><em><textarea placeholder="'. esc_attr_x( 'Comment', 'noun', 'esotera' ) .'" id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
//			'</textarea></em></p>';
//
//	return $arg;
} // esotera_comments_form_textarea()

/* Hooks are located in cryout_master_hook() in core.php */

/* FIN */
