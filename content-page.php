<?php
/**
 * The template used for displaying page content in page.php
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php do_action( 'shopfront_the_title' ); ?>

	<?php do_action( 'shopfront_page_header_after' ); ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'shop-front' ) . '</span>', 'after' => '</div>' ) ); ?>
	
	<?php do_action( 'shopfront_page_article_end' ); ?>
	
</article>