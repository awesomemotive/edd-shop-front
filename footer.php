
	<?php do_action( 'shopfront_content_end' ); ?>
	</div><!-- #content -->

	<?php do_action( 'shopfront_content_after' ); ?>

	</div> <!-- / .wrapper -->

</div>

<?php do_action( 'shopfront_footer_before' ); ?>

<footer id="footer" role="contentinfo">
	
	<?php do_action( 'shopfront_footer_start' ); ?>

	<div class="wrapper">
		
		<?php do_action( 'shopfront_footer_wrapper_start' ); ?>

		<?php
			/**		
			 * Footer sidebars
			*/
			if ( ! is_404() )
				get_sidebar( 'footer' );

		?>

		<?php do_action( 'shopfront_footer_wrapper_end' ); ?>

		<?php
			/**		
			 * Copyright notice
			*/
			do_action( 'shopfront_footer_copyright' ); 
		?>
	</div><!-- .wrapper -->	

	<?php do_action( 'shopfront_footer_end' ); ?>

</footer><!-- #footer -->

<?php do_action( 'shopfront_footer_after' ); ?>

</div> <!-- #site -->	

<?php wp_footer(); ?>
</body>
</html>