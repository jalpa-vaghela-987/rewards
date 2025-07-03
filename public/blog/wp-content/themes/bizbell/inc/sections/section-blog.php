<?php 
/**
 * Template part for displaying Blog Section
 *
 *@package BizBell
 */
?>
<?php 
    $blog_post_title    = bizbell_get_option( 'blog_title' );
    $blog_category = bizbell_get_option( 'blog_category' );

?> 

    <?php if( !empty($blog_post_title) ):?>
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($blog_post_title);?></h2>
        </div>
    <?php endif;?>
  <div class="section-content clear col-3">

    <?php
        $args = array (

            'posts_per_page' =>3,              
            'post_type' => 'post',
            'post_status' => 'publish',
            'paged' => 1,
            );
            if ( absint( $blog_category ) > 0 ) {
                $args['cat'] = absint( $blog_category );
            }

            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
                $i=0;  
                while ($loop->have_posts()) : $loop->the_post(); $i++;?>
				    <article>

				    	<div class="blog-item-wrapper">
					      	<?php if(has_post_thumbnail()):?>
						        <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
						        	<a href="<?php the_permalink();?>"></a>  
						        </div>
					    	<?php endif;?>

					    	<div class="entry-container">

                                    <div class="entry-meta">                 
                                        <?php bizbell_entry_meta();?>
                                    </div><!-- .entry-meta -->
                               
						        <header class="entry-header">
									<h2 class="entry-title">
										<a href="<?php the_permalink();?>"><?php the_title();?></a>
									</h2>
						        </header>
						      
                                    <div class="entry-content">
                                        <?php
                                            $excerpt = bizbell_the_excerpt( 20 );
                                            echo wp_kses_post( wpautop( $excerpt ) );
                                        ?>
                                    </div><!-- .entry-content -->
                                
					        </div><!-- .entry-container -->
					    </div><!-- .post-item -->
				    </article>
	    <?php endwhile;?>  
    <?php endif;?>
    <?php wp_reset_postdata(); ?>
  </div>