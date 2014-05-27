<?php 
/*
Template Name: Archives
*/

get_header(); ?>

		<section id="primary">
			<div class="wrapper">
				<?php do_action( 'shopfront_primary_wrapper_start' ); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>
					
				<?php endwhile; // end of the loop. ?>

					<div class="entry-content">
						<?php get_search_form(); ?>
						
						<h2><?php _e( 'Last 10 Posts:', 'shop-front' ); ?></h2>

						<?php 

						    $args = array(
						      'post_type' => 'post',
						      'posts_per_page' => '10',
						      'orderby' => 'date',
						      'order' => 'DESC'
						    );

          					$last_x_posts = new WP_query($args); ?>

				          <?php if ($last_x_posts->have_posts()) : ?>

						<ul>
							<?php while ($last_x_posts->have_posts()) : $last_x_posts->the_post(); ?>
							<li>
							   <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'shop-front' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
							        <?php the_title(); ?>
							   </a>
							</li>
							<?php endwhile; ?>
						</ul>

				        <?php else : ?>
        
        					<p><?php _e('No posts found', 'shop-front'); ?></p>

       					<?php endif; wp_reset_postdata(); ?>

						<h2><?php _e( 'Archives by Month:', 'shop-front' ); ?></h2>
						<ul>
							<?php wp_get_archives('type=monthly'); ?>
						</ul>
						
						<h2><?php _e( 'Archives by Subject:', 'shop-front' ); ?></h2>
						<ul>
							 <?php wp_list_categories(); ?>
						</ul>

					</div>
				<?php do_action( 'shopfront_primary_wrapper_end' ); ?>

			</div>
		</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>