<?php 
/**
 * List of posts for post choices.
 * @return Array Array of post ids and name.
 */
function bizbell_post_choices() {
    $posts = get_posts( array( 'numberposts' => -1 ) );
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'bizbell' );
    foreach ( $posts as $post ) {
        $choices[ $post->ID ] = $post->post_title;
    }
    return  $choices;
}

if ( ! function_exists( 'bizbell_switch_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function bizbell_switch_options() {
        $arr = array(
            'on'        => esc_html__( 'On', 'bizbell' ),
            'off'       => esc_html__( 'Off', 'bizbell' )
        );
        return apply_filters( 'bizbell_switch_options', $arr );
    }
endif;


 /**
 * Get an array of google fonts.
 * 
 */
function bizbell_font_choices() {
    $font_family_arr = array();
    $font_family_arr[''] = esc_html__( '--Default--', 'bizbell' );

    // Make the request
    $request = wp_remote_get( get_theme_file_uri( 'assets/fonts/webfonts.json' ) );

    if( is_wp_error( $request ) ) {
        return false; // Bail early
    }
    // Retrieve the data
    $body = wp_remote_retrieve_body( $request );
    $data = json_decode( $body );
    if ( ! empty( $data ) ) {
        foreach ( $data->items as $items => $fonts ) {
            $family_str_arr = explode( ' ', $fonts->family );
            $family_value = implode( '-', array_map( 'strtolower', $family_str_arr ) );
            $font_family_arr[ $family_value ] = $fonts->family;
        }
    }

    return apply_filters( 'bizbell_font_choices', $font_family_arr );
}

if ( ! function_exists( 'bizbell_typography_options' ) ) :
    /**
     * Returns list of typography
     * @return array font styles
     */
    function bizbell_typography_options(){
        $choices = array(
            'default'         => esc_html__( 'Default', 'bizbell' ),
            'header-font-1'     => esc_html__( 'Raleway', 'bizbell' ),
            'header-font-2'     => esc_html__( 'Poppins', 'bizbell' ),
            'header-font-3'     => esc_html__( 'Roboto', 'bizbell' ),
            'header-font-4'     => esc_html__( 'Open Sans', 'bizbell' ),
            'header-font-5'     => esc_html__( 'Lato', 'bizbell' ),
            'header-font-6'   => esc_html__( 'Shadows Into Light', 'bizbell' ),
            'header-font-7'   => esc_html__( 'Playfair Display', 'bizbell' ),
            'header-font-8'   => esc_html__( 'Lora', 'bizbell' ),
            'header-font-9'   => esc_html__( 'Titillium Web', 'bizbell' ),
            'header-font-10'   => esc_html__( 'Muli', 'bizbell' ),
            'header-font-11'   => esc_html__( 'Oxygen', 'bizbell' ),
            'header-font-12'   => esc_html__( 'Nunito Sans', 'bizbell' ),
            'header-font-13'   => esc_html__( 'Maven Pro', 'bizbell' ),
            'header-font-14'   => esc_html__( 'Cairo', 'bizbell' ),
            'header-font-15'   => esc_html__( 'Philosopher', 'bizbell' ),
            'header-font-16'   => esc_html__( 'IBM Plex Sans', 'bizbell' ),
            'header-font-17'   => esc_html__( 'Tangerine', 'bizbell' ),
            'header-font-18'   => esc_html__( 'Montserrat', 'bizbell' ),
        );

        $output = apply_filters( 'bizbell_typography_options', $choices );
        if ( ! empty( $output ) ) {
            ksort( $output );
        }

        return $output;
    }
endif;


if ( ! function_exists( 'bizbell_body_typography_options' ) ) :
    /**
     * Returns list of typography
     * @return array font styles
     */
    function bizbell_body_typography_options(){
        $choices = array(
            'default'         => esc_html__( 'Default', 'bizbell' ),
            'body-font-1'     => esc_html__( 'Raleway', 'bizbell' ),
            'body-font-2'     => esc_html__( 'Poppins', 'bizbell' ),
            'body-font-3'     => esc_html__( 'Roboto', 'bizbell' ),
            'body-font-4'     => esc_html__( 'Open Sans', 'bizbell' ),
            'body-font-5'     => esc_html__( 'Lato', 'bizbell' ),
            'body-font-6'   => esc_html__( 'Shadows Into Light', 'bizbell' ),
            'body-font-7'   => esc_html__( 'Playfair Display', 'bizbell' ),
            'body-font-8'   => esc_html__( 'Lora', 'bizbell' ),
            'body-font-9'   => esc_html__( 'Titillium Web', 'bizbell' ),
            'body-font-10'   => esc_html__( 'Muli', 'bizbell' ),
            'body-font-11'   => esc_html__( 'Oxygen', 'bizbell' ),
            'body-font-12'   => esc_html__( 'Nunito Sans', 'bizbell' ),
            'body-font-13'   => esc_html__( 'Maven Pro', 'bizbell' ),
            'body-font-14'   => esc_html__( 'Cairo', 'bizbell' ),
            'body-font-15'   => esc_html__( 'Philosopher', 'bizbell' ),
            'body-font-16'   => esc_html__( 'IBM Plex Sans', 'bizbell' ),
            'body-font-18'   => esc_html__( 'Montserrat', 'bizbell' ),
        );

        $output = apply_filters( 'bizbell_body_typography_options', $choices );
        if ( ! empty( $output ) ) {
            ksort( $output );
        }

        return $output;
    }
endif;

if ( ! function_exists( 'bizbell_subtitle_typography_options' ) ) :
    /**
     * Returns list of typography
     * @return array font styles
     */
    function bizbell_subtitle_typography_options(){
        $choices = array(
            'default'         => esc_html__( 'Default', 'bizbell' ),
            'subtitle-font-1'     => esc_html__( 'Raleway', 'bizbell' ),
            'subtitle-font-2'     => esc_html__( 'Poppins', 'bizbell' ),
            'subtitle-font-3'     => esc_html__( 'Roboto', 'bizbell' ),
            'subtitle-font-4'     => esc_html__( 'Open Sans', 'bizbell' ),
            'subtitle-font-5'     => esc_html__( 'Lato', 'bizbell' ),
            'subtitle-font-6'   => esc_html__( 'Shadows Into Light', 'bizbell' ),
            'subtitle-font-7'   => esc_html__( 'Playfair Display', 'bizbell' ),
            'subtitle-font-8'   => esc_html__( 'Lora', 'bizbell' ),
            'subtitle-font-9'   => esc_html__( 'Titillium Web', 'bizbell' ),
            'subtitle-font-10'   => esc_html__( 'Muli', 'bizbell' ),
            'subtitle-font-11'   => esc_html__( 'Oxygen', 'bizbell' ),
            'subtitle-font-12'   => esc_html__( 'Nunito Sans', 'bizbell' ),
            'subtitle-font-13'   => esc_html__( 'Maven Pro', 'bizbell' ),
            'subtitle-font-14'   => esc_html__( 'Cairo', 'bizbell' ),
            'subtitle-font-15'   => esc_html__( 'Philosopher', 'bizbell' ),
            'subtitle-font-16'   => esc_html__( 'IBM Plex Sans', 'bizbell' ),
            'subtitle-font-17'   => esc_html__( 'Tangerine', 'bizbell' ),
            'subtitle-font-18'   => esc_html__( 'Montserrat', 'bizbell' ),
        );
        $output = apply_filters( 'bizbell_subtitle_typography_options', $choices );
        if ( ! empty( $output ) ) {
            ksort( $output );
        }

        return $output;
    }
endif;

 ?>