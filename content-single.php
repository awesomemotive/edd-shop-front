<?php
/**
 * The template for displaying content in the single.php template
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			 <?php	
			 	shopfront_posted_on();
			 ?>
		</div>
		<?php endif; ?>

		<?php do_action( 'shopfront_the_title' ); ?>

	</header><!-- .entry-header -->
	<?php 
			// Retrieves the post's featured image
			shopfront_the_post_thumbnail();
		?>
	<?php if( get_the_content() ) : /* show the content */ ?>
				 	
		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'shop-front' ) . '</span>', 'after' => '</div>' ) ); ?>
		</div>
				
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'shopfront_single_article_after' ); ?>
