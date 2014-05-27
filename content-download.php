<?php
/**
 * The template for displaying content in the single-download.php template
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content" itemscope itemtype="http://schema.org/Product">
		<?php the_content(); ?>
	</div>

	<?php do_action( 'shopfront_single_content_end' ); ?>

</article>