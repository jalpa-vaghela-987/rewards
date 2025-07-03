<?php
/**
 * About options.
 *
 * @package BizBell
 */

$default = bizbell_get_default_theme_options();

// About Section
$wp_customize->add_section( 'section_home_information',
	array(
		'title'      => __( 'About Section', 'bizbell' ),
		'priority'   => 15,
		'capability' => 'edit_theme_options',
		'panel'      => 'home_page_panel',
		)
);

$wp_customize->add_setting( 'theme_options[disable_information_section]',
	array(
		'default'           => $default['disable_information_section'],
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'bizbell_sanitize_switch_control',
	)
);
$wp_customize->add_control( new BizBell_Switch_Control( $wp_customize, 'theme_options[disable_information_section]',
    array(
		'label' 			=> __('Enable/Disable About Section', 'bizbell'),
		'section'    		=> 'section_home_information',
		 'settings'  		=> 'theme_options[disable_information_section]',
		'on_off_label' 		=> bizbell_switch_options(),
    )
) );
//Services Section title
$wp_customize->add_setting('theme_options[information_subtitle]', 
	array(
	'default'           => $default['information_subtitle'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[information_subtitle]', 
	array(
	'label'       => __('Section Sub Title', 'bizbell'),
	'section'     => 'section_home_information',   
	'settings'    => 'theme_options[information_subtitle]',
	'active_callback' => 'bizbell_information_active',		
	'type'        => 'text'
	)
);


// Additional Information First Page
$wp_customize->add_setting('theme_options[information_page]', 
	array(
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'bizbell_dropdown_pages'
	)
);

$wp_customize->add_control('theme_options[information_page]', 
	array(
	'label'       => __('Select Page', 'bizbell'),
	'section'     => 'section_home_information',   
	'settings'    => 'theme_options[information_page]',		
	'type'        => 'dropdown-pages',
	'active_callback' => 'bizbell_information_active',
	)
);
