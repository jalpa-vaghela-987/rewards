<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BizBell
 */
/**
* Hook - bizbell_action_doctype.
*
* @hooked bizbell_doctype -  10
*/
do_action( 'bizbell_action_doctype' );
?>
<head>
<?php
/**
* Hook - bizbell_action_head.
*
* @hooked bizbell_head -  10
*/
do_action( 'bizbell_action_head' );
?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<?php

/**
* Hook - bizbell_action_before.
*
* @hooked bizbell_page_start - 10
*/
do_action( 'bizbell_action_before' );

/**
*
* @hooked bizbell_header_start - 10
*/
do_action( 'bizbell_action_before_header' );

/**
*
*@hooked bizbell_site_branding - 10
*@hooked bizbell_header_end - 15 
*/
do_action('bizbell_action_header');

/**
*
* @hooked bizbell_content_start - 10
*/
do_action( 'bizbell_action_before_content' );

/**
 * Banner start
 * 
 * @hooked bizbell_banner_header - 10
*/
do_action( 'bizbell_banner_header' );  
