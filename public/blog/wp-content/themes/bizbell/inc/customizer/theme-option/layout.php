<?php 

/**
 * Theme Options.
 *
 * @package BizBell
 */

$default = bizbell_get_default_theme_options();
//For Sidebar Layout Option
$wp_customize->add_section('section_sidebar_layout', array(    
'title'       => __('Sidebar Layout Setting', 'bizbell'),
'panel'       => 'theme_option_panel'    
));

//Layout Options for Blog
$wp_customize->add_setting('theme_options[layout_options_blog]', 
	array(
	'default' 			=> $default['layout_options_blog'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'bizbell_sanitize_select'
	)
);

$wp_customize->add_control(new BizBell_Image_Radio_Control($wp_customize, 'theme_options[layout_options_blog]', 
	array(		
	'label' 	=> __('Layout Option For Blog', 'bizbell'),
	'section' 	=> 'section_sidebar_layout',
	'settings'  => 'theme_options[layout_options_blog]',
	'type' 		=> 'radio-image',
	'choices' 	=> array(								
								
			'right-sidebar' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
			'no-sidebar' 	=> get_template_directory_uri() . '/assets/images/no-sidebar.png',						
		),	
	))
);

//Layout Options for Archive
$wp_customize->add_setting('theme_options[layout_options_archive]', 
	array(
	'default' 			=> $default['layout_options_archive'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'bizbell_sanitize_select'
	)
);

$wp_customize->add_control(new BizBell_Image_Radio_Control($wp_customize, 'theme_options[layout_options_archive]', 
	array(		
	'label' 	=> __('Layout Option For Archive', 'bizbell'),
	'section' 	=> 'section_sidebar_layout',
	'settings'  => 'theme_options[layout_options_archive]',
	'type' 		=> 'radio-image',
	'choices' 	=> array(								
								
			'right-sidebar' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
			'no-sidebar' 	=> get_template_directory_uri() . '/assets/images/no-sidebar.png',
		),	
	))
);


//Layout Options for Pages
$wp_customize->add_setting('theme_options[layout_options_page]', 
	array(
	'default' 			=> $default['layout_options_page'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'bizbell_sanitize_select'
	)
);

$wp_customize->add_control(new BizBell_Image_Radio_Control($wp_customize, 'theme_options[layout_options_page]', 
	array(		
	'label' 	=> __('Layout Option For Pages', 'bizbell'),
	'section' 	=> 'section_sidebar_layout',
	'settings'  => 'theme_options[layout_options_page]',
	'type' 		=> 'radio-image',
	'choices' 	=> array(							
								
			'right-sidebar' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
			'no-sidebar' 	=> get_template_directory_uri() . '/assets/images/no-sidebar.png',
		),	
	))
);

//Layout Options for Single Post
$wp_customize->add_setting('theme_options[layout_options_single]', 
	array(
	'default' 			=> $default['layout_options_single'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'bizbell_sanitize_select'
	)
);

$wp_customize->add_control(new BizBell_Image_Radio_Control($wp_customize, 'theme_options[layout_options_single]', 
	array(		
	'label' 	=> __('Layout Option For Single Posts', 'bizbell'),
	'section' 	=> 'section_sidebar_layout',
	'settings'  => 'theme_options[layout_options_single]',
	'type' 		=> 'radio-image',
	'choices' 	=> array(								
								
			'right-sidebar' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
			'no-sidebar' 	=> get_template_directory_uri() . '/assets/images/no-sidebar.png',
		),	
	))
);