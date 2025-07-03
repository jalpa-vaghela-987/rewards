<?php
/**
 * Default theme options.
 *
 * @package BizBell
 */

if ( ! function_exists( 'bizbell_get_default_theme_options' ) ) :

	/**
	 * Get default theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
function bizbell_get_default_theme_options() {

	$theme_data = wp_get_theme();
	$defaults = array();
	$defaults['disable_homepage_content_section']	= true;

	// Featured Slider Section
	$defaults['disable_featured-slider_section']	= false;
	$defaults['slider_speed']						= 800;
	

	// Information Section
	$defaults['disable_information_section']	= false;
	$defaults['information_subtitle']	   	 	= esc_html__( 'A cultural icon is a person or artifact that is recognized by members of a culture or sub-culture as representing.', 'bizbell' );


	// Our Service Section
	$defaults['disable_services_section']	= false;
	$defaults['service_title']	   	 		= esc_html__( 'Our Services', 'bizbell' );


	// Testimonial Section
	$defaults['disable_testimonial_section']	= false;
	$defaults['testimonial_title']	   	 		= esc_html__( 'Happy Customer', 'bizbell' );

	// Team Section
	$defaults['disable_team_section']	= false;
	$defaults['team_title']	   	 		= esc_html__( 'Our Team', 'bizbell' );



	//Cta Section	
	$defaults['disable_cta_section']	   	= false;
	$defaults['background_cta_section']		= get_template_directory_uri() .'/assets/images/default-header.jpg';
	$defaults['cta_button_label']	   	 	= esc_html__( 'Purchase Now', 'bizbell' );
	$defaults['cta_button_url']	   	 		= '#';
	$defaults['cta_alt_button_label']	   	= esc_html__( 'Contact Us', 'bizbell' );
	$defaults['cta_alt_button_url']	   	 	= '#';



	// Blog Section
	$defaults['disable_blog_section']		= false;
	$defaults['blog_title']	   	 			= esc_html__( 'Latest Post', 'bizbell' ); 


	//General Section
	$defaults['blog_readmore_text']				= esc_html__('Read More','bizbell');
	$defaults['excerpt_length']				= 40;
	$defaults['layout_options_blog']			= 'no-sidebar';
	$defaults['layout_options_archive']			= 'right-sidebar';
	$defaults['layout_options_page']			= 'right-sidebar';	
	$defaults['layout_options_single']			= 'right-sidebar';

	$defaults['post_category_enable']			= true;	
	$defaults['post_comment_enable']			= true;	
	$defaults['post_image_enable']				= true;	
	$defaults['post_header_image_enable']		= true;	
	$defaults['post_meta_enable']				= true;		
	$defaults['post_pagination_enable']			= true;	

	$defaults['page_image_enable']				= true;	
	$defaults['page_header_image_enable']		= true;


	//Footer section 		
	$defaults['copyright_text']				= esc_html__( 'Copyright &copy; All rights reserved.', 'bizbell' );
	$defaults['powered_by_text']			= esc_html__( 'BizBell by Sensational Theme', 'bizbell' );

	// Pass through filter.
	$defaults = apply_filters( 'bizbell_filter_default_theme_options', $defaults );
	return $defaults;
}

endif;

/**
*  Get theme options
*/
if ( ! function_exists( 'bizbell_get_option' ) ) :

	/**
	 * Get theme option
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function bizbell_get_option( $key ) {

		$default_options = bizbell_get_default_theme_options();
		if ( empty( $key ) ) {
			return;
		}

		$theme_options = (array)get_theme_mod( 'theme_options' );
		$theme_options = wp_parse_args( $theme_options, $default_options );

		$value = null;

		if ( isset( $theme_options[ $key ] ) ) {
			$value = $theme_options[ $key ];
		}

		return $value;

	}

endif;