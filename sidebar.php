<?php
/**
 * The Sidebar containing the main widget area.
 */
?>

<?php do_action( 'shopfront_secondary_before' ); ?>

<div id="secondary" class="widget-area">

	<?php do_action( 'shopfront_secondary_start' ); ?>

	<?php 
	// widgets
	if ( ! dynamic_sidebar( 'primary' ) ) :  ?>

	<?php endif; ?>

	<?php do_action( 'shopfront_secondary_end' ); ?>

</div>

<?php do_action( 'shopfront_secondary_after' ); ?>