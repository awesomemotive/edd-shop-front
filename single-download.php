<?php
/**
 * Single download pages
 */
	
get_header(); ?>

<?php do_action( 'shopfront_single_download_start' ); ?>

<section id="primary">

	<?php do_action( 'shopfront_single_download_primary_start' ); ?>

	<?php do_action( 'shopfront_the_title' ); // The shopfront_render_the_title() function is loaded on this hook ?>

	<?php do_action( 'shopfront_single_download_image' ); // The single download image is loaded on this hook ?>

	<?php do_action( 'shopfront_single_download_content_before' ); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', 'download' ); ?>

		<?php do_action( 'shopfront_single_download_content_after' ); ?>

		<?php comments_template( '', true );  ?>

	<?php endwhile; // end of the loop. ?>

	<?php do_action( 'shopfront_single_download_primary_end' ); ?>

</section>

<?php do_action( 'shopfront_single_download_end' ); ?>

<?php
/**		
 * Secondary Sidebar
*/
if ( !is_page_template( 'page-templates/fullwidth.php' ) )
	get_sidebar( 'download' );
?>

<?php get_footer(); ?>