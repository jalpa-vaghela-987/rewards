<?php 
/**
 * Template part for displaying Services Section
 *
 *@package BizBell
 */

    $service_title       = bizbell_get_option( 'service_title' );
    for( $i=1; $i<=6; $i++ ) :
        $services_page_posts[] = absint(bizbell_get_option( 'services_page_'.$i ) );
        $services_icon   = bizbell_get_option( 'services_icon_'.$i );
    endfor;
    ?>
    

    <?php if( !empty($service_title) ):?>
        <div class="section-header">
        <?php if( !empty($service_title)):?>
            <h2 class="section-title"><?php echo esc_html($service_title);?></h2>
        <?php endif;?>
        </div>
    <?php endif; ?>
    <div class="section-content col-3">

        <?php $args = array (
            'post_type'     => 'page',
            'post_per_page' => count( $services_page_posts ),
            'post__in'      => $services_page_posts,
            'orderby'       =>'post__in',
            
        ); 
        $loop = new WP_Query($args);                        
        if ( $loop->have_posts() ) :
            $i=1;  
            while ($loop->have_posts()) : $loop->the_post(); ?>
                <article>
                    <div class="service-item-wrapper">
                    <?php 
                    $services_icon = bizbell_get_option( 'service_icon_'.$i );
                    if ( !empty($services_icon) ) { ?>
                        <div class="icon-container">
                            <a href="<?php the_permalink();?>">
                            <i class="fa <?php echo esc_attr( $services_icon)?>"></i>
                        </a>
                        </div>
                    <?php  } ?>
                    <div class="service-content">
                        <header class="entry-header">
                            <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                        </header>
                        <div class="entry-content">
                            <?php
                                $excerpt = bizbell_the_excerpt( 20 );
                                echo wp_kses_post( wpautop( $excerpt ) );
                            ?>
                        </div><!-- .entry-content -->
                    </div>
                  </div>
                </article>
            <?php $i++; endwhile;?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div> 