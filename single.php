<?php
/**
 * The Template for displaying all single posts.
 */

get_header();

?>
<section id="primary">
	<div class="wrapper">
	<?php do_action( 'shopfront_primary_wrapper_start' ); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php comments_template( '', true );  ?>

		<?php endwhile; // end of the loop. ?>

		<?php do_action( 'shopfront_single_article_end' ); ?>

		<nav id="nav-single" class="navigation">

		<?php
			$prev_post = get_adjacent_post( false, '', true );

			if ( !empty( $prev_post ) ) {
				echo '<span class="nav-previous"><a href="' . get_permalink( $prev_post->ID ) . '" title="' . $prev_post->post_title . '"><i class="icon icon-arrow-left"></i><span class="text">' . $prev_post->post_title . '</span></a></span>';
			}

			$next_post = get_adjacent_post( false, '', false );

			if ( !empty( $next_post ) ) {
				echo '<span class="nav-next"><a href="' . get_permalink( $next_post->ID ) . '" title="' . $next_post->post_title . '"><i class="icon icon-arrow-right"></i><span class="text">' . $next_post->post_title . '</span></a></span>';
			}
		?>

		</nav>

	<?php do_action( 'shopfront_primary_wrapper_end' ); ?>

	</div>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>