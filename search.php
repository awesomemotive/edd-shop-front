<?php
/**
 * The template for displaying Search Results pages.
 */

get_header(); ?>

		<section id="primary">
			<div class="wrapper">

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( '/partials/excerpt' , $post->post_type ); ?>

				<?php endwhile; ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">

					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'shop-front' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'shop-front' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->

				</article><!-- #post-0 -->

			<?php endif; ?>

			</div>
		</section><!-- #primary -->


<?php get_footer(); ?>