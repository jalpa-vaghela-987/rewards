<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package BizBell
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
    <?php $blog_image_buttom    = bizbell_get_option( 'image_buttom' );
    if ( true == $blog_image_buttom ) {
        $classes = 'image-buttom';
    } else {
        $classes = 'image-top';
    }?>
	<div class="blog-item-wrapper <?php echo esc_attr( $classes ); ?>">
      	<?php if(has_post_thumbnail()):?>
	        <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
	        	<a href="<?php the_permalink();?>"></a>  
	        </div>
    	<?php endif;?>

    	<div class="entry-container">
			
			<header class="entry-header">
				<?php
				if ( is_single() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif; ?>
			</header><!-- .entry-header -->

			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php bizbell_posted_on(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>

			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->
			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php
					bizbell_entry_meta(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</div><!-- .entry-container -->
    </div><!-- .post-item -->
</article>

