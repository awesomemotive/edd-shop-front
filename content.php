<?php
/**
 * The default template for displaying content
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
					
		<header class="entry-header">
				<div class="entry-meta">
					 <?php	
					 	shopfront_posted_on();
					 ?>
				</div>
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php echo the_title_attribute( 'echo=0' ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>

		</header><!-- .entry-header -->


		<?php if ( is_search() ) : ?>
		
			   <div class="entry-summary">
                    <?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'shop-front' ) ); ?>
                </div><!-- .entry-summary -->
		
		<?php else : ?>
				
				<?php if ( 'content' == get_theme_mod( 'blog_excerpt_or_content' ) ) : ?>
					
					<?php if( has_excerpt() ) : ?>

						<div class="entry-summary">
					    	<?php the_excerpt(); ?>
					    	<?php shopfront_read_more(); ?>
					 	</div>

					<?php else : ?>

					<div class="entry-summary">
						<?php the_content( '', true ); ?>
						
						<?php shopfront_read_more(); ?>

						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'shop-front' ), 'after' => '</div>' ) ); ?>
					</div>

					<?php endif; ?>

				<?php elseif( 'excerpt' == get_theme_mod( 'blog_excerpt_or_content' ) ) : ?>

					<div class="entry-summary">
				    	<?php the_excerpt(); ?>
				    	<?php shopfront_read_more(); ?>
				 	</div>

				<?php endif; ?>

		<?php endif; ?>


		<?php 
			/**
			 * Footer meta
			 */
			do_action( 'shopfront_page_article_end' );
		?>
	

	</article><!-- #post-<?php the_ID(); ?> -->
