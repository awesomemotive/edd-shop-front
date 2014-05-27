<?php
/**
 * 404 Page
 */

get_header(); ?>

	<section id="primary">
		<div class="wrapper">

			<article id="post-0" class="post error404 not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'shop-front' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'shop-front' ); ?></p>

					<?php get_search_form(); ?>

				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		</div>
	</section><!-- #primary -->

<?php get_footer(); ?>