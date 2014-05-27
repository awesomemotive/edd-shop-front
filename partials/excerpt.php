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
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo the_title_attribute( 'echo=0' ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			
			
	</header>

	<?php shopfront_the_post_thumbnail(); ?>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>
	
	<?php do_action( 'shopfront_page_article_end' ); ?>

</article>