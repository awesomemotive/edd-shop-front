<?php
/**
 * The template for displaying search forms
 */
?>

<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">

	<label for="s" class="visuallyhidden">
		<?php _e( 'Search', 'shop-front' ); ?>
	</label>

	<div class="search-wrapper">
		<input class="text search-input" type="text" id="s" name="s" placeholder="<?php esc_attr_e( 'Search', 'shop-front' ); ?>" />

		<button class="submit">
			<i class="icon-search"></i>
		</button>

	</div>
	
</form>