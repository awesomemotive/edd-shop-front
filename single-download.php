<?php
/**
 * Single download pages
 */
	
get_header(); ?>

<?php do_action( 'shopfront_page_start', $post->ID ); ?>

<?php
/**		
 * Primary Column
*/
?>
<div id="primary">

<?php do_action( 'shopfront_primary_start', $post->ID ); ?>

<?php do_action( 'shopfront_the_title' ); ?>

<?php 
	if ( has_post_thumbnail() ) { 
		echo '<div class="download-image">';
		the_post_thumbnail( 'download-large' ); 
		echo '</div>';
	}
?>

	<?php while ( have_posts() ) : the_post(); ?>
	
		<?php get_template_part( 'content', 'download' ); ?>

		<?php do_action( 'shopfront_single_after_content', $post->ID ); ?>

		<?php comments_template( '', true );  ?>

	<?php endwhile; // end of the loop. ?>


</div>

<?php // #primary end ?>

<?php
/**		
 * Secondary Sidebar
*/
if ( !is_page_template( 'page-templates/fullwidth.php' ) )
	get_sidebar( 'download' );
?>


<?php get_footer(); ?>
