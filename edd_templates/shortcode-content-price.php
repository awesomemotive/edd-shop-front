<?php 
	
/**		
 * Coming soon downloads
*/

$coming_soon = isset( $post->ID ) ? get_post_meta( $post->ID, 'edd_coming_soon', true ) : '';
$coming_soon_text = isset( $post->ID ) ? get_post_meta( $post->ID, 'edd_coming_soon_text', true ) : '';

if ( $coming_soon ) : ?>
	
	<?php if ( $coming_soon_text ) : ?>

	<div itemprop="price" class="edd_price">
		<?php echo $coming_soon_text; ?>
	</div>

	<?php else : ?>

		<div itemprop="price" class="edd_price">
			<?php _e( 'Coming soon', 'shop-front' ); ?>
		</div>

	<?php endif; ?>

<?php
/**		
 * Free downloads
*/
elseif ( '0' == edd_get_download_price( get_the_ID() ) && ! edd_has_variable_prices( get_the_ID() ) ) : ?>
	<div itemprop="price" class="edd_price">
		<?php _e( 'Free', 'shop-front' ); ?>
	</div>


<?php 
/**		
 * Variable priced downloads
*/
elseif ( edd_has_variable_prices( get_the_ID() ) ) : ?>

	<div itemprop="price" class="edd_price">
		<?php _e( 'From', 'shop-front' ); ?> <?php edd_price( get_the_ID() ); ?>
	</div>

<?php 
/**		
 * Else show the normal price
*/
else : ?>

	<div itemprop="price" class="edd_price">
		<?php edd_price( get_the_ID() ); ?>
	</div>

<?php endif; ?>