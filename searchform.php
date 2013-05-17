<?php
/**
 * The template for displaying search forms
 */
?>

<form method="get" id="search-form" class="" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">

	<label for="s" class="assistive-text">
		<?php _e( 'Search', 'shop-front' ); ?>
	</label>

	<div class="search-wrapper">
		<input class="text" type="text" name="s" id="search-input" placeholder="<?php esc_attr_e( 'Search', 'shop-front' ); ?>" />

		<button class="submit">
			<i class="icon-search"></i>
		</button>

	</div>
	
</form>