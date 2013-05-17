<?php
/*
Template Name: Blog
*/

get_header(); 

$wp_posts_per_page = get_option('posts_per_page');
$blog_posts_per_page = get_theme_mod( 'blog_posts_per_page', $wp_posts_per_page );

if( $blog_posts_per_page )
	$posts_per_page = $blog_posts_per_page;
else
	$posts_per_page = $wp_posts_per_page;

?>

<section id="primary">
	<div class="wrapper">
		<?php do_action( 'shopfront_primary_wrapper_start' ); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>

		<?php endwhile;  wp_reset_postdata(); // end of the loop. ?>
		

<?php

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	$args = array(
		'orderby' => 'date',
		'order' => 'DESC',
		'paged' => $paged,
		'posts_per_page' => $posts_per_page,
	);

	 $temp = $wp_query; // assign orginal query to temp variable for later use  
	 $wp_query = null;
	 $wp_query = new WP_Query($args); 
?>
<?php if( have_posts() ) : ?>

	<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

		<?php
			global $more;
			$more = 0;
		?>
		
		<?php get_template_part( 'content', get_post_format() ); ?>

	<?php endwhile; ?>

		<nav id="nav-below" class="post-navigation">

        <h3 class="assistive-text">
          <?php _e( 'Post navigation', 'shop-front' ); ?>
        </h3>

        <?php
          $previous = apply_filters( 'shopfront_content_nav_previous', __( '<i class="icon icon-arrow-right"></i><span class="text">Newer</span>', 'shop-front' ) );
          $next = apply_filters( 'shopfront_content_nav_next', __( '<i class="icon icon-arrow-left"></i> <span class="text">Older</span>', 'shop-front' ) );
      ?>

      <span class="nav-next">
        <?php previous_posts_link( $previous ); ?>
      </span>

      <span class="nav-previous">
        <?php next_posts_link( $next ); ?>
      </span>

      </nav>


	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php get_search_form(); ?>

<?php endif; $wp_query = $temp; //reset back to original query ?>

	 	<?php do_action( 'shopfront_primary_wrapper_end' ); ?>
	 </div>
</section><!-- #primary -->


<?php get_sidebar(); ?>
<?php get_footer(); ?>