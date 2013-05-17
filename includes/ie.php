<?php

/**
 * Load styling for IE 8
 * @since 1.0
 */

if ( ! function_exists( 'shopfront_ie_8' ) ):
	function shopfront_ie_8() { ?>

	<!--[if lte IE 8]>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ie.css"> 
	<![endif]-->

	<?php }
endif;
add_action( 'wp_head', 'shopfront_ie_8' );
