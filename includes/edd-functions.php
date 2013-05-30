<?php
/**
 * Easy Digital Downloads specific settings / functions
 */

/**
 * Test if EDD plugin is active
 *
 * @since       1.0
*/

function shopfront_edd_is_active() {
	if ( defined( 'EDD_VERSION' ) )
		return true;
}


/**		
 * Prevent button colour dropdown from showing when there are no colours in the array
 * @since 1.0.1
*/

function shopfront_edd_get_button_colors( $colors ) {
	$colors = array();
	return $colors;
}
add_filter( 'edd_button_colors', 'shopfront_edd_get_button_colors' );


/**
 * Featured downloads on the homepage. Only loaded if EDD featured plugin is installed
 *
 * @since  1.0.3
*/
function shopfront_home_featured_downloads() {

	if( function_exists('edd_fd_show_featured_downloads') )
			edd_fd_show_featured_downloads();

}
add_action( 'shopfront_index', 'shopfront_home_featured_downloads' );

/**		
 * Latest downloads on homepage
 * @since 1.0
*/

function shopfront_home_latest() { ?> 

<?php

	$home_latest_downloads = get_theme_mod( 'home_latest_downloads', '3' );
	$post_type_obj = get_post_type_object( 'download' );

if( $home_latest_downloads ) : ?>

	<?php if ( have_posts() ) : $count = 0; ?>

		<h1><?php printf(  __( 'Latest %s', 'shop-front' ), $post_type_obj->labels->name ); ?></h1>

		<div class="downloads<?php shopfront_get_download_columns(); ?>">

			<?php while ( have_posts() ) : the_post(); $count++; ?>
				
			<?php get_template_part( '/partials/download', 'grid' ); ?>

			<?php if ( $count %2 == 0 ) echo '<div class="clear-2"></div>'; ?>
			<?php if ( $count %3 == 0 ) echo '<div class="clear-3"></div>'; ?>
			<?php if ( $count %4 == 0 ) echo '<div class="clear-4"></div>'; ?>

			<?php endwhile; ?>
		</div>

	<?php else : ?>

		<?php if( post_type_exists( 'download' ) ) : ?>

		<section class="home">
			<article id="post-0" class="post no-results not-found">

			<?php if ( current_user_can( 'edit_posts' ) ) : ?>
				
				<header class="entry-header">
		            <h2><?php printf( __( 'No %s to display', 'shop-front' ), $post_type_obj->labels->name ); ?></h2>
		        </header>

		        <div class="entry-content">
		            <p><?php printf( __( 'Ready to add your first %s? <a href="%s">Get started here</a>.', 'shop-front' ), $post_type_obj->labels->singular_name, admin_url( 'post-new.php?post_type=download' ) ); ?></p>
		        </div>

			<?php endif; // end current_user_can() check ?>

			</article>
		</section>

		<?php endif; ?>

	<?php endif; // end have_posts() check ?>

<?php endif; ?>

<?php }
add_action( 'shopfront_index', 'shopfront_home_latest' );


/**		
 * Filter download html from EDD featured downloads plugin
 * @since 1.0 
*/

if ( ! function_exists( 'shopfront_edd_fd_featured_downloads_html' ) ) :
function shopfront_edd_fd_featured_downloads_html( $html, $featured_downloads ) {
	ob_start();
	
	if( post_type_exists('download') )
		$post_type_obj = get_post_type_object( 'download' );

	if ( $featured_downloads->have_posts() ) : $count = 0; ?>

		<h1><?php if( post_type_exists('download') ) printf(  __( 'Featured %s', 'shop-front' ), $post_type_obj->labels->name ); ?></h1>

		<div class="downloads<?php shopfront_get_download_columns(); ?>">

			<?php while ( $featured_downloads->have_posts() ) : $featured_downloads->the_post(); $count++; ?>

				<?php get_template_part( '/partials/download', 'grid' ); ?>
				
				<?php if ( $count %2 == 0 ) echo '<div class="clear-2"></div>'; ?>
				<?php if ( $count %3 == 0 ) echo '<div class="clear-3"></div>'; ?>
				<?php if ( $count %4 == 0 ) echo '<div class="clear-4"></div>'; ?>

		  	<?php endwhile; ?>
		</div>
		<?php endif; wp_reset_postdata(); ?>
<?php
	$html = ob_get_clean(); 
	echo $html;
}
endif;
add_filter( 'edd_fd_featured_downloads_html', 'shopfront_edd_fd_featured_downloads_html', 10, 2 );


/**		
 * Filter the 'EDD Featured Downloads' plugin's wp_query args and pass in the number of downloads from the theme customizer
 * @since 1.0 
*/

function shopfront_edd_fd_featured_downloads_args( $args ) {

	$args['posts_per_page'] = get_theme_mod( 'home_featured_downloads', '3' );

	return $args;

}
add_filter( 'edd_fd_featured_downloads_args', 'shopfront_edd_fd_featured_downloads_args' );


/**		
 * Homepage button
 * Displays the button on the homepage
 * @since 1.0
*/

function shopfront_home_button() { ?>

	<?php 
		$post_type_obj = get_post_type_object( 'download' );
		$home_button_text = get_theme_mod( 'home_button_text', sprintf( __( 'View Our %s', 'shop-front' ), $post_type_obj->labels->name ) );

		if ( post_type_exists('download') && $home_button_text ) : // show button only if 'download' post type exists ?>

		<section class="home">
			<a id="home-shop-button" href="<?php echo $post_type_obj->rewrite['slug']; ?>" class="button large primary" title="<?php echo $home_button_text; ?>">
				<?php echo $home_button_text; ?>
			</a>
		</section>
	<?php endif; ?>


<?php }
add_action( 'shopfront_index', 'shopfront_home_button' );

/**
 * Get the icon from theme mods
 *
 * @since       1.0.3
*/
function shopfront_get_cart_icon() {
	$icon = get_theme_mod( 'cart_icon', 'cart' );

	return $icon;
}


/**
 * Show the amount of downloads in the cart with an icon
 *
 * @since 1.0
 */
function shopfront_show_cart_quantity_icon() {
	global $edd_options;

	$show_icon = get_theme_mod( 'cart_show_icon', '1' );
	$icon_alignment = get_theme_mod( 'cart_icon_alignment', 'left' );
	$text = 'cart' == shopfront_get_cart_icon() ? __( 'Cart', 'shop-front' ) : __( 'Basket', 'shop-front' );

?>
	<?php if ( shopfront_edd_is_active() ) : ?>
	
	<a id="cart" class="<?php echo 'align-'.$icon_alignment; ?> <?php if( $show_icon ) echo 'has-icon'; ?>" href="<?php echo get_permalink( $edd_options['purchase_page'] ); ?>">
		 
		<?php if( $show_icon ) : // there's an icon ?>

			<?php if( 'left' == $icon_alignment ) : ?>

				<i class="icon icon-<?php echo shopfront_get_cart_icon(); ?>"></i><span class="edd-cart-quantity"><?php echo edd_get_cart_quantity(); ?></span>

			<?php elseif( 'right' == $icon_alignment ): ?>

				<span class="edd-cart-quantity"><?php echo edd_get_cart_quantity(); ?></span><i class="icon icon-<?php echo shopfront_get_cart_icon(); ?>"></i>

			<?php endif; ?>

		<?php else: // no icon ?>
			<?php echo $text; ?> (<span class="edd-cart-quantity"><?php echo edd_get_cart_quantity(); ?></span>)
		<?php endif; ?>

	</a>
	<?php endif; ?>
<?php }


/**
 * Filter discount HTML
 *
 * @since 1.0
 */
function shopfront_modify_edd_get_cart_discounts_html( $html, $discounts, $rate, $remove_url ) {

	foreach( $discounts as $discount ) {
		$html = '<span class="edd_discount_rate">' . $discount .'&nbsp;&ndash;&nbsp;' . $rate . '</span>';
		$html .= '<a title="Remove Discount" href="'. $remove_url .'" data-code="' . $discount . '" class="edd_discount_remove">remove</a>';
	}

	return $html;
}
add_filter( 'edd_get_cart_discounts_html', 'shopfront_modify_edd_get_cart_discounts_html', 10, 4 );


/**
 * Remove and deactivate all styling included with EDD. Theme uses unique styling
 *
 * @since 1.0
 */
remove_action( 'wp_enqueue_scripts', 'edd_register_styles' );


/**
 * Removes the automatic purchase link after the main content on each single download
 *
 * @since 1.0
 */
remove_action( 'edd_after_download_content', 'edd_append_purchase_link' );



/**
 * Filter message text. Shows when ajax is disabled
 *
 * @since 1.0
 */
function shopfront_modify_edd_show_added_to_cart_messages() {

	global $download_id;

	$alert = '
			<p class="alert success">'
		. sprintf( __( 'You have successfully added %1$s to your %2$s', 'shop-front' ), '<strong>' . get_the_title( $download_id ) . '</strong>', shopfront_get_cart_icon() )
		. ' <a href="' . edd_get_checkout_uri() . '" class="edd_alert_checkout_link alignright">' . __( 'Checkout', 'shop-front' ) . '</a>'
		. '</p>';

	return $alert;
}
add_filter( 'edd_show_added_to_cart_messages', 'shopfront_modify_edd_show_added_to_cart_messages' );


/**
 * Move edd_show_added_to_cart_messages() 
 *
 * @since 1.0
 */
remove_action( 'edd_after_download_content', 'edd_show_added_to_cart_messages' );

// move add to cart message to the start of the content div. This message appears when ajax is disabled
add_action( 'shopfront_content_start', 'edd_show_added_to_cart_messages' );


/**
 * Filter edd_show_has_purchased_item_message()
 *
 * @since 1.0
 */

function shopfront_modify_edd_show_has_purchased_item_message() {

	$alert = '<p class="alert notice">' . __( 'You have already purchased this item, but you may purchase it again.', 'shop-front' ) . '</p>';
	return $alert;

}
add_filter( 'edd_show_has_purchased_item_message', 'shopfront_modify_edd_show_has_purchased_item_message' );


/**
 * Message that appears when a download has already been purchased
 *
 * @since       1.0
*/

// remove from default location
remove_action( 'edd_after_download_content', 'edd_show_has_purchased_item_message' );
// add it to the start of the content <div>
add_action( 'shopfront_content_start', 'edd_show_has_purchased_item_message' );



/**
 * Add various body classes
 *
 * @since 1.0
 */

function shopfront_download_body_classes( $classes ) {

	global $post;

	if( is_post_type_archive( 'download' ) )
		$classes[] = 'shop';

	return $classes;
}
add_filter( 'body_class', 'shopfront_download_body_classes' );


/**
 * Get Purchase Link
 *
 * Builds a Purchase link for a specified download based on arguments passed.
 * This function is used all over EDD to generate the Purchase or Add to Cart
 * buttons. If no arguments are passed, the function uses the defaults that have
 * been set by the plugin. The Purchase link is built for simple and variable
 * pricing and filters are available throughout the function to override
 * certain elements of the function.
 *
 * $download_id = null, $link_text = null, $style = null, $color = null, $class = null
 *
 * @since 1.0
 * @param array $args Arguments for display
 * @return string $purchase_form
 */
function shopfront_get_purchase_link( $args = array() ) {
	global $edd_options, $post;

	if ( ! isset( $edd_options['purchase_page'] ) || $edd_options['purchase_page'] == 0 ) {
		edd_set_error( 'set_checkout', sprintf( __( 'No checkout page has been configured. Visit <a href="%s">Settings</a> to set one.', 'shop-front' ), admin_url( 'edit.php?post_type=download&page=edd-settings' ) ) );
		edd_print_errors();
		return false;
	}

	$defaults = apply_filters( 'edd_purchase_link_defaults', array(
		'download_id' => $post->ID,
		'price'       => (bool) true,
		'text'        => ! empty( $edd_options[ 'add_to_cart_text' ] ) ? $edd_options[ 'add_to_cart_text' ] : __( 'Purchase', 'shop-front' ),
		'style'       => isset( $edd_options[ 'button_style' ] ) 	   ? $edd_options[ 'button_style' ]     : 'button',
		'color'       => isset( $edd_options[ 'checkout_color' ] ) 	   ? $edd_options[ 'checkout_color' ] 	: 'blue',
		'class'       => ''
	) );

	$args = wp_parse_args( $args, $defaults );

	$variable_pricing = edd_has_variable_prices( $args['download_id'] );
	$data_variable    = $variable_pricing ? ' data-variable-price=yes' : 'data-variable-price=no';
	$type             = edd_single_price_option_mode( $args['download_id'] ) ? 'data-price-mode=multi' : 'data-price-mode=single';
	if ( $args['price'] && $args['price'] != 'no' && ! $variable_pricing ) {
		$price = edd_get_download_price( $args['download_id'] );
		$args['text'] = edd_currency_filter( edd_format_amount( $price ) ) . '&nbsp;&ndash;&nbsp;' . $args['text'];
	}

	if ( edd_item_in_cart( $args['download_id'] ) && ! $variable_pricing ) {
		$button_display   = 'style="display:none;"';
		$checkout_display = '';
	} else {
		$button_display   = '';
		$checkout_display = 'style="display:none;"';
	}

	ob_start();
?>
	<!--dynamic-cached-content-->
	<form id="edd_purchase_<?php echo $args['download_id']; ?>" class="icon-action edd_download_purchase_form" method="post">
		
			<?php

			printf(
				'<button type="submit" class="button edd-add-to-cart %1$s" name="edd_purchase_download" data-action="edd_add_to_cart" data-download-id="%3$s" %4$s %5$s %6$s>
					<i class="icon-%7$s-add"></i><span class="visuallyhidden">%2$s</span>
				</button>',
				'',
				esc_attr( $args['text'] ),
				esc_attr( $args['download_id'] ),
				esc_attr( $data_variable ),
				esc_attr( $type ),
				$button_display,
				shopfront_get_cart_icon()
			);


				printf(
					'<a title="' . __( 'Go to Checkout', 'shop-front' ) . '" href="%1$s" class="%2$s %3$s" %4$s><i class="icon-%5$s"></i><span class="visuallyhidden">' . __( 'Checkout', 'shop-front' ) . '</span></a>',
					esc_url( edd_get_checkout_uri() ),
					esc_attr( 'edd_go_to_checkout' ),
					implode( ' ', array( $args['style'], $args['color'], trim( $args['class'] ) ) ),
					$checkout_display,
					shopfront_get_cart_icon()
				);
			?>

		<input type="hidden" name="download_id" value="<?php echo esc_attr( $args['download_id'] ); ?>">
		<input type="hidden" name="edd_action" value="add_to_cart">

		<?php do_action( 'edd_purchase_link_end', $args['download_id'] ); ?>

	</form><!--end #edd_purchase_<?php echo esc_attr( $args['download_id'] ); ?>-->
	<!--/dynamic-cached-content-->
<?php
	$purchase_form = ob_get_clean();

	return apply_filters( 'edd_purchase_download_form', $purchase_form, $args );
}





/**
 * Empty Cart Message. Filters edd_empty_cart_message()
 *
 * @since 1.0
 */
function shopfront_edd_empty_cart_message() {
	return sprintf( __( '<p class="alert notice">Your %1$s is empty</p>', 'shop-front' ), shopfront_get_cart_icon() );
}
add_action( 'edd_empty_cart_message', 'shopfront_edd_empty_cart_message' );


/**
 * Filters edd_print_errors() function and adds our own css classes
 *
 * @since 1.0
 */
function shopfront_edd_error_class() {

	$classes = array(
		'edd_errors',
		'error',
		'alert'
	);

	return $classes;
}
add_filter( 'edd_error_class', 'shopfront_edd_error_class' );

/**
 * Output price onto single download page using edd_get_template_part
 *
 * @since       1.0
*/
function shopfront_single_download_price() {
	edd_get_template_part( 'shortcode', 'content-price' );	
}
add_action( 'shopfront_single_download_aside', 'shopfront_single_download_price' );


/**
 * Download button
 *
 * @since 1.0
 * Shows either 'buy', 'download' or the standard button text defined in settings
 * used on single-download.php
 */
if ( ! function_exists( 'shopfront_download_button' ) ):
	function shopfront_download_button() { ?>

	<?php
		global $post;

		$download_information = get_post_meta( $post->ID, 'edd_extra_download_options', true );

		$download_url = isset( $download_information['download_url'] ) ? $download_information['download_url'] : '';

		$download_url_target = isset( $download_information['download_url_target'] ) ? 'target="_blank"' : '';

		// overrides any variable/ multi priced options
		if( $download_url )
			echo '<a title="Download" href="' . $download_url . '" class="button large primary" '. $download_url_target .'>' . __( 'Download', 'shop-front' ) . '</a>';

		// it's a free download ($0.00) so we don't want the button to say 'buy' or 'purchase'
		elseif( '0' == edd_get_download_price( get_the_ID() ) && !edd_has_variable_prices( get_the_ID() ) ) {
			echo edd_get_purchase_link( array( 'class' => 'large primary', 'price' => false, 'text' => 'Add to ' . shopfront_get_cart_icon() ) );
		}
		// variable priced downloads
		elseif( edd_has_variable_prices( get_the_ID() ) ) {
			echo edd_get_purchase_link( array( 'class' => 'large primary' ) );
		}
		// normal downloads, don't show price on button
		else {
			echo edd_get_purchase_link( array( 'class' => 'large primary', 'price' => false ) );
		}

?>

		<?php }
endif;
add_action( 'shopfront_single_download_aside', 'shopfront_download_button' );


/**		
 * Output download categories and tags
 * @since 1.0
*/
if ( ! function_exists( 'shopfront_download_meta' ) ) :
function shopfront_download_meta() { ?>

    <?php
    	global $post;

        
        $category_list = get_the_term_list( $post->ID, 'download_category', '', ', ');
        $tag_list = get_the_term_list( $post->ID, 'download_tag', '', ', ');

        $text = '';

        if( $category_list || $tag_list ) {
        	$text .= '<div id="download-meta">';

        	if( $category_list )
	        	$text .= '<span class="categories">' . __( 'Categories: %1$s', 'shop-front' ). '</span>';

	        if ( $tag_list )
	            $text .= '<span class="tags">' . __( 'Tags: %2$s', 'shop-front' ) . '</span>';

        	$text .= '</div>';
        }
        
        printf( $text, $category_list, $tag_list );
    ?>
          
<?php }
endif;
add_action( 'shopfront_single_download_aside', 'shopfront_download_meta' );