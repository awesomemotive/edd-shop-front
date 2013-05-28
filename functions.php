<?php
/**		
 * Constants
 * @since 1.0 
*/

define( 'INCLUDES_DIR', trailingslashit( get_template_directory() ) . 'includes' ); /* Sets the path to the theme's includes directory. */

/**		
 * Includes
 * @since 1.0 
*/

require_once( trailingslashit( INCLUDES_DIR ) . 'edd-functions.php' );
require_once( trailingslashit( INCLUDES_DIR ) . 'edd-shortcodes.php' );
require_once( trailingslashit( INCLUDES_DIR ) . 'theme-functions.php' );    // theme functions
require_once( trailingslashit( INCLUDES_DIR ) . 'gallery.php' ); 			  // gallery
require_once( trailingslashit( INCLUDES_DIR ) . 'header.php' ); 			  // Header
require_once( trailingslashit( INCLUDES_DIR ) . 'theme-options.php' );      // Options related to the theme options
require_once( trailingslashit( INCLUDES_DIR ) . 'navigation.php' ); 	      // Navigation
require_once( trailingslashit( INCLUDES_DIR ) . 'scripts.php' ); 			  // Theme Scripts
require_once( trailingslashit( INCLUDES_DIR ) . 'sidebars.php' ); 	      // sidebars
require_once( trailingslashit( INCLUDES_DIR ) . 'comments.php' ); 	      // comments
require_once( trailingslashit( INCLUDES_DIR ) . 'ie.php' ); 			      // ie
require_once( trailingslashit( INCLUDES_DIR ) . 'wp-customize.php' );       // WP Customizer
require_once( trailingslashit( INCLUDES_DIR ) . 'updater.php' );       // EDD theme updater


/**
 * General theme setup
 * @since 1.0
 * To override this function in a child theme, copy the entire function below and paste it into the child theme's functions.php
 */

if ( ! function_exists( 'shopfront_setup' ) ):
	function shopfront_setup() {

		/**
		 * Set max width for media in content area. Used to assign a maximum width for images and embedded videos when inserting them into the content area
		 */
		global $content_width;

		if ( !isset( $content_width ) )
			$content_width = 632;

		// Make this theme available for translation. Translations can be added to the /languages/ directory.
		load_theme_textdomain( 'shop-front', get_template_directory() . '/languages' );

		// This theme styles the visual editor with editor-style.css to match the theme style. Will also look for the file in the child theme folder
		add_editor_style( 'css/editor-style.css' );

		// featured images on the homepage
		add_image_size( 'home-featured', '1083', '9999' );

		// featured image size for blog posts etc
		add_image_size( 'featured-image', '632', '9999' );

		// download images that appear in either 3 or 4 column layouts
		add_image_size( 'download', '321', '201', true ); 

		// download images that appear in either 1 or 2 column layouts
		add_image_size( 'download-medium', '494', '309', true ); 

		// large download image
		add_image_size( 'download-large', '664', '9999' ); // main product image

		// full width image
		add_image_size( 'download-full-width', '1019', '9999' ); // main product image

		// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
		add_theme_support( 'post-thumbnails' );

		// Add default posts and comments RSS feed links to <head>.
		add_theme_support( 'automatic-feed-links' );

		// Add support to pages for specific features
		add_post_type_support( 'page', 'excerpt' );

	}
endif; // shopfront_setup
add_action( 'after_setup_theme', 'shopfront_setup' );


/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 * @since 1.0
 * @param string  $title Default title text for current view.
 * @param string  $sep   Optional separator.
 * @return string Filtered title.
 */
function shopfront_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'shop-front' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'shopfront_wp_title', 10, 2 );


/**
 * Add custom image sizes to media chooser
 * @since 1.0
 */
function shopfront_image_size_names_choose( $sizes ) {

	$sizes['download-large'] = 'Large Download';

	// return the array of sizes.
	return $sizes;
}
add_filter( 'image_size_names_choose', 'shopfront_image_size_names_choose', 10 );