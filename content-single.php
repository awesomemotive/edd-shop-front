<?php
/**
 * The template for displaying content in the single.php template
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
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

	<footer class="entry-meta">
			<?php shopfront_entry_meta(); ?>
			<?php edit_post_link( __( 'Edit', 'shop-front' ), '<span class="edit-link">', '</span>' ); ?>
			<?php if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
				<div class="author-info">
					<div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'shopfront_author_bio_avatar_size', 68 ) ); ?>
					</div><!-- .author-avatar -->
					<div class="author-description">
						<h2><?php printf( __( 'About %s', 'shop-front' ), get_the_author() ); ?></h2>
						<p><?php the_author_meta( 'description' ); ?></p>
						<div class="author-link">
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'shop-front' ), get_the_author() ); ?>
							</a>
						</div><!-- .author-link	-->
					</div><!-- .author-description -->
				</div><!-- .author-info -->
			<?php endif; ?>
		</footer><!-- .entry-meta -->

</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'shopfront_single_article_after' ); ?>
