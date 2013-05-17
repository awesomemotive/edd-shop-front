<?php
/**
 * The Sidebar shown on single download pages
 */
?>

<?php do_action( 'shopfront_secondary_before' ); ?>

<div id="secondary" class="widget-area">

	<?php do_action( 'shopfront_secondary_start' ); ?>

	<aside id="single-download">
		<?php
			// price
			edd_get_template_part( 'shortcode', 'content-price' );

			// download button
			shopfront_download_button(); 

			// download meta
			shopfront_download_meta();

		?>	
	</aside>

	<?php if ( ! dynamic_sidebar( 'single-download' ) ) :  ?>

	<?php endif; // end sidebar widget area ?>

	<?php do_action( 'shopfront_secondary_end' ); ?>

</div>

<?php do_action( 'shopfront_secondary_after' ); ?>