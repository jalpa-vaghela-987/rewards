<?php  
    $testimonial_title = bizbell_get_option( 'testimonial_title' );

    for( $i=1; $i<=3; $i++ ) :
        $testimonial_page_posts[] = absint(bizbell_get_option( 'testimonial_page_'.$i ) );
    endfor; 
?>       
        
    <?php if ( ! empty( $testimonial_title ) ) : ?>
       <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($testimonial_title); ?></h2>                                  
            <div class="separator"></div>
        </div><!-- .section-header -->
    <?php endif; ?>  
    <div class="section-content">
        <div class="testimonial-slider" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": true, "speed": 1000, "dots": true, "arrows":true, "autoplay": true, "fade": false, "draggable": true }'>      
            <?php $args = array (
                'post_type'     => 'page',
                'post_per_page' => count( $testimonial_page_posts ),
                'post__in'      => $testimonial_page_posts,
                'orderby'       =>'post__in', 
            ); 
                $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
                $i=0;  
                while ($loop->have_posts()) : $loop->the_post(); $i++;?>
                    <article  class="testi-cloud-disable">
                        <div class="slick-item">
                            <div class="quote">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/quote.png' ); ?>">
                            </div><!-- .quote -->
                            <div class="client-wrapper">
                                <div class="featured-image">
                                    <img src="<?php the_post_thumbnail_url('full');  ?>">
                                </div><!-- .featured-image -->
                                <header class="entry-header">
                                    <h2 class="entry-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                </header>
                                <div class="entry-content">
                                    <?php 
                                        $excerpt = bizbell_the_excerpt( 60 );
                                        echo wp_kses_post( wpautop( $excerpt ) );
                                    ?>
                                </div><!-- .entry-content -->     
                            </div><!-- .client-wrapper -->
                        </div><!-- .slick-item -->
                    </article>
               
                <?php endwhile;?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .testimonial-slider -->
    </div><!-- .section-content -->
