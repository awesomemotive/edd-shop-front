<?php

/**
 * Outputs the site's title and description. Replaces site title with a logo image if set in the WP Customizer
 *
 * @since 1.0
 */

if ( ! function_exists( 'shopfront_do_header_site_title' ) ):
	function shopfront_do_header_site_title() { ?>
	
	<?php do_action( 'shopfront_header_before' ); ?>

	<header id="masthead" role="banner">

		<?php do_action( 'shopfront_header_start' ); ?>

		<div class="wrapper">
		
			<?php do_action( 'shopfront_header_wrapper_start' ); ?>

	<?php 
	$tagline = get_bloginfo( 'description' );

	if ( !empty( $tagline ) ) : /* if there's a tagline we use an hgroup element */ ?>
		
			<?php 
				$output = '
				<hgroup>
					<h1 id="site-title">
						<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) .'" rel="home">'. get_bloginfo( 'name' ) . '</a>
					</h1>
					<h2 id="site-description">' . get_bloginfo( 'description' ) .'</h2>
				</hgroup>
				';

				// make $output filterable
				echo apply_filters('shopfront_header_output', $output);
			?>

		<?php do_action( 'shopfront_header_site_title_end' ); ?>

	<?php else : /* just display the title */ ?>

		<?php 
			$output = '
			<h1 id="site-title">
				<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) .'" rel="home">'. get_bloginfo( 'name' ) . '</a>
				</h1>
			';

			// make $header_output filterable
			echo apply_filters('shopfront_header_output', $output);
		?>

		<?php do_action( 'shopfront_header_site_title_end' ); ?>

	<?php endif; ?>

	<?php do_action( 'shopfront_header_wrapper_end' ); ?>

		</div>

		<?php do_action( 'shopfront_header_end' ); ?>
	</header>

	<?php do_action( 'shopfront_header_after' ); ?>

	<?php }
endif;
add_action( 'shopfront_header', 'shopfront_do_header_site_title' );