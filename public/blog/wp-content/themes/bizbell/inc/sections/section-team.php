<?php 
/**
 * Template part for displaying Services Section
 *
 *@package BizBell
 */

    $team_title       = bizbell_get_option( 'team_title' );
    for( $i=1; $i<=4; $i++ ) :
        $team_page_posts[] = absint(bizbell_get_option( 'team_page_'.$i ) );
        $team_position     = bizbell_get_option( 'team_custom_position_'. $i );
    endfor;
    ?>
    <div class=" team-section relative">
       	<div class="wrapper">
            <?php if (!empty($team_title) ) : ?>
                <div class="section-header">
                    <h2 class="section-title"><?php echo esc_html($team_title); ?></h2>                                  
                    <div class="separator"></div>
                </div><!-- .section-header -->
            <?php endif; ?>
                            
            <div class="section-content col-4">
                <?php $args = array (
                    'post_type'     => 'page',
                    'post_per_page' => count( $team_page_posts ),
                    'post__in'      => $team_page_posts,
                    'orderby'       =>'post__in', 
                ); 
                $loop = new WP_Query($args);                         
                if ( $loop->have_posts() ) :
                    $i=0;  
                    while ($loop->have_posts()) : $loop->the_post(); $i++;?>
                        <article class="hentry ">
                            <div class="post-wrapper">
                                 <div class="featured-image">
                                    <a href="<?php the_permalink(); ?>"  ><img src="<?php the_post_thumbnail_url('bizbell-team'); ?>"></a>
                                </div><!-- .team-image -->
                                                
                                <div class="entry-container">
                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    </header>
                                    <div class="entry-content">
                                        <?php
                                            $excerpt = bizbell_the_excerpt( 15 );
                                            echo wp_kses_post( wpautop( $excerpt ) );
                                        ?>
                                    </div><!-- .entry-content -->
                                    <?php 
                                    $team_position     = bizbell_get_option( 'team_custom_position_'. $i );
                                     if ( ! empty($team_position)) : ?>
                                        <h6 class="position"><?php echo esc_html( $team_position ); ?></h6>
                                    <?php endif; ?>
                                </div><!-- .entry-container -->
                                <div class="separator"></div>
                            </div><!-- .post-wrapper -->
                        </article>
                    <?php endwhile;?>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </div><!-- .section-content -->
        </div><!-- .wrapper -->
    </div><!-- #team-posts -->
