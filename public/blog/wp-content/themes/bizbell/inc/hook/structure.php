<?php
/**
 * Theme functions related to structure.
 *
 * This file contains structural hook functions.
 *
 * @package BizBell
 */

if ( ! function_exists( 'bizbell_doctype' ) ) :
	/**
	 * Doctype Declaration.
	 *
	 * @since 1.0.0
	 */
function bizbell_doctype() {
	?><!DOCTYPE html> <html <?php language_attributes(); ?>><?php
}
endif;

add_action( 'bizbell_action_doctype', 'bizbell_doctype', 10 );


if ( ! function_exists( 'bizbell_head' ) ) :
	/**
	 * Header Codes.
	 *
	 * @since 1.0.0
	 */
function bizbell_head() {
	?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php endif; ?>
	<?php
}
endif;
add_action( 'bizbell_action_head', 'bizbell_head', 10 );

if ( ! function_exists( 'bizbell_page_start' ) ) :
	/**
	 * Add Skip to content.
	 *
	 * @since 1.0.0
	 */
	function bizbell_page_start() {
	?><div id="page" class="site"><a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'bizbell' ); ?></a><?php
	}
endif;

add_action( 'bizbell_action_before', 'bizbell_page_start', 10 );

if ( ! function_exists( 'bizbell_header_start' ) ) :
	/**
	 * Header Start.
	 *
	 * @since 1.0.0
	 */
	function bizbell_header_start() { ?>
		<header id="masthead" class="site-header" role="banner"><?php
	}
endif;
add_action( 'bizbell_action_before_header', 'bizbell_header_start' );

if ( ! function_exists( 'bizbell_header_end' ) ) :
	/**
	 * Header Start.
	 *
	 * @since 1.0.0
	 */
	function bizbell_header_end() {

		?>

		</header> <!-- header ends here --><?php
	}
endif;
add_action( 'bizbell_action_header', 'bizbell_header_end', 15 );

if ( ! function_exists( 'bizbell_content_start' ) ) :
	/**
	 * Header End.
	 *
	 * @since 1.0.0
	 */
	function bizbell_content_start() {
	?>
	<div id="content" class="site-content">
	<?php

	}
endif;

add_action( 'bizbell_action_before_content', 'bizbell_content_start', 10 );

if ( ! function_exists( 'bizbell_footer_start' ) ) :
	/**
	 * Footer Start.
	 *
	 * @since 1.0.0
	 */
	function bizbell_footer_start() {
		if( !(is_home() || is_front_page()) ){
			echo '</div>';
		} ?>
		</div>
		<footer id="colophon" class="site-footer" role="contentinfo"><?php
	}
endif;
add_action( 'bizbell_action_before_footer', 'bizbell_footer_start' );

if ( ! function_exists( 'bizbell_footer_end' ) ) :
	/**
	 * Footer End.
	 *
	 * @since 1.0.0
	 */
	function bizbell_footer_end() {?>
		</footer><div class="backtotop"><i class="fas fa-caret-up"></i></div><?php
	}
endif;
add_action( 'bizbell_action_after_footer', 'bizbell_footer_end' );
