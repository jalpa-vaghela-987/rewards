<?php
/**
 * The template for displaying home page.
 * @package BizBell
 */

if ( 'posts' != get_option( 'show_on_front' ) ){ 
    get_header(); ?>
    <?php $enabled_sections = bizbell_get_sections();
    if( is_array( $enabled_sections ) ) {
        foreach( $enabled_sections as $section ) {
            $cloud_enable = bizbell_get_option('disable_homepage_cloud_section');
            if( ( $section['id'] == 'featured-slider' ) ){ ?>
                <?php $disable_featured_slider = bizbell_get_option( 'disable_featured-slider_section' );
                if( true == $disable_featured_slider): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>">

                        <?php get_template_part( 'inc/sections/section', esc_attr( $section['id'] ) ); ?>
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/curve.png' ) ?>" class="cloud-bg">
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'services' ) { ?>
                <?php $disable_services_section = bizbell_get_option( 'disable_services_section' );
                if( true ==$disable_services_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section relative">
                        <div class="services-wrapper">
                        <div class="wrapper">
                            <?php get_template_part( 'inc/sections/section', esc_attr( $section['id'] ) ); ?>
                            
                        </div>
                        </div>
                        
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'information' ) { ?>
                <?php $disable_information_section = bizbell_get_option( 'disable_information_section' );
                if( true ==$disable_information_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section relative">

                        <div class="wrapper">
                            <?php get_template_part( 'inc/sections/section', esc_attr( $section['id'] ) ); ?>
                            
                        </div>

                    </section>
            <?php endif; ?>

        <?php } elseif( $section['id'] == 'cta' ) { ?>
                <?php $disable_cta_section = bizbell_get_option( 'disable_cta_section' );
                $background_cta_section = bizbell_get_option( 'background_cta_section' );
                if( true ==$disable_cta_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" style="background-image: url('<?php echo esc_url( $background_cta_section );?>');">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/curve-down.png' ) ?>" class="cloud-shape">
                        <div class="wrapper">
                            <?php get_template_part( 'inc/sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/curve.png' ) ?>" class="cloud-bg">
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'team' ) { ?>
            <?php $disable_team_section = bizbell_get_option( 'disable_team_section' );
            if( true ==$disable_team_section): ?>
                <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section clear">
                    <?php get_template_part( 'inc/sections/section', esc_attr( $section['id'] ) ); ?>
                </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'testimonial' ) { ?>
            <?php $disable_testimonial_section = bizbell_get_option( 'disable_testimonial_section' );
            $testimonial_image = bizbell_get_option( 'testimonial_image' );
            if( true ==$disable_testimonial_section): ?>
                <section id="<?php echo esc_attr( $section['id'] ); ?>" style="background-image: url('<?php echo esc_url( $testimonial_image );?>');">
                    <div class="wrapper">
                        <?php get_template_part( 'inc/sections/section', esc_attr( $section['id'] ) ); ?>
                    </div>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/curve.png' ) ?>" class="cloud-bg">
                </section>            
            <?php endif; ?>

           <?php } elseif ( $section['id'] == 'blog' ) { ?>
                <?php $disable_blog_section = bizbell_get_option( 'disable_blog_section' );
                if( true === $disable_blog_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="relative page-section">
                        <div class="wrapper">
                            <?php get_template_part( 'inc/sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
                <?php endif; 

                
            }
        }
    }
    $disable_homepage_content_section = bizbell_get_option( 'disable_homepage_content_section' );
    if('posts' == get_option( 'show_on_front' )){ ?>
        <div class="wrapper">
       <?php include( get_home_template() ); ?>
        </div>
    <?php } elseif(($disable_homepage_content_section == true ) && ('posts' != get_option( 'show_on_front' ))) { ?>
        <div class="wrapper">
           <?php include( get_page_template() ); ?>
        <div class="wrapper">
     <?php  }
    get_footer();
} 
// elseif('posts' == get_option( 'show_on_front' ) ) {
//     include( get_home_template() );
// } 
// else{
//     include( get_page_template() );
// }