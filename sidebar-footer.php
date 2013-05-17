<?php
/* The footer widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
if ( ! is_active_sidebar( 'sidebar-footer-1' )
	&& ! is_active_sidebar( 'sidebar-footer-2' )
	&& ! is_active_sidebar( 'sidebar-footer-3' )
	&& ! is_active_sidebar( 'sidebar-footer-4' )
)
	return;
// If we get this far, we have widgets. Let do this.
?>

<div id="supplementary" <?php if( function_exists( 'shopfront_footer_sidebar_class' ) ) shopfront_footer_sidebar_class(); ?>>


<?php 
	$count = 0;
	$count++; 
?>

	<?php // first widget area
	if ( is_active_sidebar( 'sidebar-footer-1' ) ) : ?>

		<div id="first" class="widget-area " role="complementary">
			<?php dynamic_sidebar( 'sidebar-footer-1' ); ?>
		</div>

	<?php endif; ?>

	<?php // second widget area
	if ( is_active_sidebar( 'sidebar-footer-2' ) ) : ?>

		<div id="second" class="widget-area" role="complementary">

			<?php dynamic_sidebar( 'sidebar-footer-2' ); ?>
		</div>

	<?php endif; ?>


	<?php 

	 if( $count %2 == 1) echo '<div class="clear-2"></div>'; 

	?>

	<?php // third widget area
	if ( is_active_sidebar( 'sidebar-footer-3' ) ) : ?>

		<div id="third" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-footer-3' ); ?>
		</div>

	<?php endif; ?>


	<?php // fourth widget area
	if ( is_active_sidebar( 'sidebar-footer-4' ) ) : ?>

		<div id="fourth" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-footer-4' ); ?>
		</div>

	<?php endif; ?>

</div>