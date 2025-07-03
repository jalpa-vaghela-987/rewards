<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BizBell
 */

/**
 *
 * @hooked bizbell_footer_start
 */
do_action( 'bizbell_action_before_footer' );

/**
 * Hooked - bizbell_footer_top_section -10
 * Hooked - bizbell_footer_section -20
 */
do_action( 'bizbell_action_footer' );

/**
 * Hooked - bizbell_footer_end. 
 */
do_action( 'bizbell_action_after_footer' );

wp_footer(); ?>

</body>  
</html>