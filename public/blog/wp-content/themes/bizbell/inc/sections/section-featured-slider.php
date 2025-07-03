<?php 
/**
 * Template part for displaying Featured Slider Section
 *
 *@package BizBell
 */
    $slider_speed   = bizbell_get_option( 'slider_speed' );

    for( $i=1; $i<=3; $i++ ) :
        $featured_slider_page_posts[] = bizbell_get_option( 'slider_page_'.$i );
    endfor;
    ?>
    
        <div class="featured-slider-wrapper" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite":true, "speed": <?php echo esc_attr( $slider_speed) ?>, "dots": true, "arrows":true, "autoplay": true, "fade": false }'>

            <?php
                $args = array (

                'post_type'     => 'page',
                'post_per_page' => count( $featured_slider_page_posts ),
                'post__in'      => $featured_slider_page_posts,
                'orderby'       =>'post__in',
            );

            $loop = new WP_Query($args);                        
                if ( $loop->have_posts() ) :
                $i=0;  
                    while ($loop->have_posts()) : $loop->the_post(); $i++;?>
                        <article class="slick-item" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                            <div class="overlay"></div>
                            <div class="wrapper">
                                <div class="featured-content-wrapper">
                                    <header class="entry-header">
                                        <h2 class="entry-title"><?php the_title();?></h2>
                                    </header>

                                    <div class="entry-content">
                                        <?php
                                            $excerpt = bizbell_the_excerpt( 40 );
                                            echo wp_kses_post( wpautop( $excerpt ) );
                                        ?>
                                    </div><!-- .entry-content -->

                                    <?php
                                    $readmore_text   = bizbell_get_option( 'slider_custom_btn_text_' . $i );
                                    $alt_readmore_text   = bizbell_get_option( 'slider_alt_custom_btn_text');
                                    $alt_readmore_url   = bizbell_get_option( 'slider_alt_custom_btn_url');  
                                    if ( ! empty( $readmore_text )|| ! empty( $alt_readmore_text ) ) { ?>
                                        <div class="read-more">
                                        <?php if ( ! empty( $readmore_text ) ) : ?>
                                                <a href="<?php the_permalink();?>" class="btn btn-primary"><?php echo esc_html($readmore_text);?></a>
                                            <?php endif; ?>
                                            <?php if ( ! empty( $alt_readmore_text ) && ! empty( $alt_readmore_url ) ) : ?>
                                                <a href="<?php echo esc_url( $alt_readmore_url ); ?>" class="btn btn-transparent"><?php echo esc_html( $alt_readmore_text); ?></a>
                                            <?php endif; ?>
                                        </div><!-- .read-more -->
                                    <?php } ?>
                                </div><!-- .featured-content-wrapper -->
                            </div><!-- .wrapper -->
                        </article><!-- .slick-item -->
                    <?php endwhile;?> 
               <?php endif;?>
               <?php wp_reset_postdata(); ?>
        </div><!-- .featured-slider-wrapper -->
    