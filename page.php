<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 */

get_header(); ?>
		<div id="primary">
			<div class="wrapper">
				<?php do_action( 'shopfront_primary_wrapper_start' ); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

						<?php comments_template( '', true );  ?>
					
				<?php endwhile; // end of the loop. ?>

				<?php do_action( 'shopfront_primary_wrapper_end' ); ?>

			</div>
		</div>

<?php 
	get_sidebar();
	get_footer(); 
?>