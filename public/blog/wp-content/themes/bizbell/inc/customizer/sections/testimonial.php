<?php
/**
 * Testimonial options.
 *
 * @package BizBell
 */

$default = bizbell_get_default_theme_options();

// Testimonial Section
$wp_customize->add_section( 'section_home_testimonial',
	array(
		'title'      => __( 'Testimonial Section', 'bizbell' ),
		'priority'   => 60,
		'capability' => 'edit_theme_options',
		'panel'      => 'home_page_panel',
		)
);

$wp_customize->add_setting( 'theme_options[disable_testimonial_section]',
	array(
		'default'           => $default['disable_testimonial_section'],
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'bizbell_sanitize_switch_control',
	)
);
$wp_customize->add_control( new BizBell_Switch_Control( $wp_customize, 'theme_options[disable_testimonial_section]',
    array(
		'label' 			=> __('Enable/Disable Testimonial Section', 'bizbell'),
		'section'    		=> 'section_home_testimonial',
		'settings'  		=> 'theme_options[disable_testimonial_section]',
		'on_off_label' 		=> bizbell_switch_options(),
    )
) );

//Testimonial Section title
$wp_customize->add_setting('theme_options[testimonial_title]', 
	array(
	'default'           => $default['testimonial_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[testimonial_title]', 
	array(
	'label'       => __('Section Title', 'bizbell'),
	'section'     => 'section_home_testimonial',   
	'settings'    => 'theme_options[testimonial_title]',
	'active_callback' => 'bizbell_testimonial_active',		
	'type'        => 'text'
	)
);


// Testimonial background image control and setting
$wp_customize->add_setting( 'theme_options[testimonial_image]', array(
	'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'theme_options[testimonial_image]', array(
	'label'             => esc_html__( 'Background Image', 'bizbell' ),
	'section'           => 'section_home_testimonial',
	'active_callback'   => 'bizbell_testimonial_active',
) ) );

for( $i=1; $i<=3; $i++ ){

	// Additional Information First Page
	$wp_customize->add_setting('theme_options[testimonial_page_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'bizbell_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[testimonial_page_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Page #%1$s', 'bizbell'), $i),
		'section'     => 'section_home_testimonial',   
		'settings'    => 'theme_options[testimonial_page_'.$i.']',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'bizbell_testimonial_active',
		)
	);

	// testimonial hr setting and control
	$wp_customize->add_setting( 'theme_options[testimonial_hr_'. $i .']', array(
		'sanitize_callback' => 'sanitize_text_field'
	) );

	$wp_customize->add_control( new BizBell_Customize_Horizontal_Line( $wp_customize, 'theme_options[testimonial_hr_'. $i .']',
		array(
			'section'         => 'section_home_testimonial',
			'active_callback' => 'bizbell_testimonial_active',
			'type'			  => 'hr',
	) ) );
}


