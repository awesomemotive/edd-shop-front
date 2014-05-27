<?php
/**
 * Enqueue scripts and styles
 */

if ( !function_exists( 'shopfront_enqueue_scripts' ) ) :
	function shopfront_enqueue_scripts() {
		global $post;

		/**
		 * main stylesheet
		 * wp_enqueue_style( $handle, $src, $deps, $ver, $media );
		 * the stylesheet selection in theme options relies on get_stylesheet_uri
		 */
		wp_enqueue_style( 'style', get_stylesheet_uri() );

		/**
		 * Custom css file. Only added to theme if it exists at /css/custom.css and is loaded after the main theme stylesheet
		 */

		$custom_css = get_stylesheet_directory() . '/css/custom.css';

		if ( file_exists( $custom_css ) )
			wp_enqueue_style( 'custom', get_stylesheet_directory_uri() . '/css/custom.css', '', SHOPFRONT_THEME_VERSION, 'screen' );

		/**
		 * Custom js file. Only added to theme if it exists at /js/custom.js
		 */

		$custom_js = get_stylesheet_directory() . '/js/custom.js';

		if ( file_exists( $custom_js ) )
			wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/custom.js',  array( 'jquery' ), SHOPFRONT_THEME_VERSION, true );

		/**
		 * Modernizr (includes html5 shim)
		 * This can be overrided on a child theme basis by including the same file in the child theme's /js folder
		 * Needs to be loaded in the header or IE 8 will freak out
		 */
		wp_register_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.min.js', array( 'jquery' ), SHOPFRONT_THEME_VERSION, false );
		wp_enqueue_script( 'modernizr' );

		/**
		 * Respond.js
		 * This makes media queries work in IE 8
		 */
		wp_register_script( 'respondjs', get_template_directory_uri() . '/js/respond.min.js', array( 'jquery' ), SHOPFRONT_THEME_VERSION, false );
		wp_enqueue_script( 'respondjs' );


		/**
		 * jQuery validation
		 */
		wp_register_script( 'validate', get_template_directory_uri() . '/js/jquery.validate.min.js ', array( 'jquery' ), SHOPFRONT_THEME_VERSION, true );

		// load validate script for comment pages
		if ( is_singular() && comments_open() )
			wp_enqueue_script( 'validate' );

		/**
		 * Common JS
		 */
		wp_register_script( 'common-js', get_template_directory_uri() . '/js/common.js', array( 'jquery' ), SHOPFRONT_THEME_VERSION, true );
		wp_enqueue_script( 'common-js' );

		/**
		 * Comments
		 */

		wp_register_script( 'comment-reply', '', '', '',  true );

		// We don't need the script on pages where there is no comment form and not on the homepage if it's a page. Neither do we need the script if comments are closed or not allowed. In other words, we only need it if "Enable threaded comments" is activated and a comment form is displayed.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

	}
endif; // end shopfront_enqueue_scripts
add_action( 'wp_enqueue_scripts', 'shopfront_enqueue_scripts');