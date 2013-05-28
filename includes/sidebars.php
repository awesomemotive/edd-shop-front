<?php
/**
 * Sidebars
 * @since 1.0
 * You can unregister sidebars from the child theme, or create a new shopfront_widgets_init function which the child theme will use instead of this one
 * <?php unregister_sidebar( $id ); ?>
 * http://codex.wordpress.org/Function_Reference/unregister_sidebar
 */


if ( ! function_exists( 'shopfront_register_sidebars' ) ):
	function shopfront_register_sidebars() {

		register_sidebar( array(
				'name' => __( 'Primary', 'shop-front' ),
				'description' =>  __( 'The main (primary) widget area.', 'shop-front' ),
				'id' => 'primary',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => "</aside>",
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );

		register_sidebar( array(
				'name' => __( 'Single Download', 'shop-front' ),
				'description' =>  __( 'Shown on each single download page', 'shop-front' ),
				'id' => 'single-download',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => "</aside>",
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );

		register_sidebar( array(
				'name' => __( 'Footer 1', 'shop-front' ),
				'description' =>  __( 'The first footer widget area.', 'shop-front' ),
				'id' => 'sidebar-footer-1',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => "</aside>",
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );

		register_sidebar( array(
				'name' => __( 'Footer 2', 'shop-front' ),
				'description' =>  __( 'The second footer widget area.', 'shop-front' ),
				'id' => 'sidebar-footer-2',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => "</aside>",
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );

		register_sidebar( array(
				'name' => __( 'Footer 3', 'shop-front' ),
				'description' =>  __( 'The third footer widget area.', 'shop-front' ),
				'id' => 'sidebar-footer-3',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => "</aside>",
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );

		register_sidebar( array(
				'name' => __( 'Footer 4', 'shop-front' ),
				'description' =>  __( 'The fourth footer widget area.', 'shop-front' ),
				'id' => 'sidebar-footer-4',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => "</aside>",
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
	}
endif;
add_action( 'widgets_init', 'shopfront_register_sidebars' );


/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function shopfront_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-footer-1' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-footer-2' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-footer-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-footer-4' ) )
		$count++;

	$class = '';

	switch ( $count ) {
	case '1':
		$class = 'one';
		break;
	case '2':
		$class = 'two';
		break;
	case '3':
		$class = 'three';
		break;
	case '4':
		$class = 'four';
		break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}

/**
 * Count the number of widgets in each sidebar area and add a class if there is more than 1
 * @since 1.0 
 */
function shopfront_sidebar_params( $params ) {

	$sidebar_id = $params[0]['id'];

	if ( 
		$sidebar_id == 'sidebar-footer-1' ||
		$sidebar_id == 'sidebar-footer-2' ||
		$sidebar_id == 'sidebar-footer-3' ||
		$sidebar_id == 'sidebar-footer-4' 
	) {

		$total_widgets = wp_get_sidebars_widgets();
		$sidebar_widgets = count( $total_widgets[$sidebar_id] );

		// if there's more than 1 widget set a class
		if( $sidebar_widgets > 1 )
			$class = 'multiple';
		else
			$class = '';

		$params[0]['before_widget'] = str_replace( 'class="', 'class="' . $class . ' ', $params[0]['before_widget'] );
	}

	return $params;
}
add_filter( 'dynamic_sidebar_params', 'shopfront_sidebar_params' );
