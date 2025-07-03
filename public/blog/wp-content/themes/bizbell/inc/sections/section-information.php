<?php 
/**
 * Template part for displaying About Section
 *
 *@package BizBell
 */
    $information_subtitle       = bizbell_get_option( 'information_subtitle' );
?>
    
    <?php 
    $information_id = bizbell_get_option( 'information_page' );
        $args = array (
        'post_type'     => 'page',
        'posts_per_page' => 1,
        'p' => $information_id,
        
    ); 
        $the_query = new WP_Query( $args );

        // The Loop
        while ( $the_query->have_posts() ) : $the_query->the_post();
        ?>
        <article class="<?php echo  has_post_thumbnail() ? 'has' : 'no'; ?>-post-thumbnail">  
            <div class="entry-container">
                <div class="section-header">
                    <h2 class="section-title"><?php the_title(); ?></h2>
                    <?php if ( ! empty($information_subtitle ) ) : ?>
                        <p class="section-subtitle"><?php echo esc_html( $information_subtitle ); ?></p>
                    <?php endif; ?><!-- .section-header -->
                    <p class="section-details"> 
                        <?php $excerpt = bizbell_the_excerpt( 50 );
                        echo wp_kses_post( wpautop( $excerpt ) ); ?>    
                    </p>
                </div> 
            </div>
            <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');"></div><!-- .featured-image -->
        </article>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>