<?php

/**		
 * Download columns
 * @since 1.0 
*/
function shopfront_get_download_columns() {
	
	if( is_home() )
		$download_columns = get_theme_mod( 'home_download_columns', '3' );
	else
		$download_columns = get_theme_mod( 'download_columns', '3' );

	echo ' col-' . $download_columns;
}

/**
 * Alter the main loop
 * @since 1.0
 */

if ( ! function_exists( 'shopfront_modify_main_loops' ) ):
	function shopfront_modify_main_loops( $query ) {

		$home_latest_downloads = get_theme_mod( 'home_latest_downloads', '3' );
		$post_type_archive_downloads_per_page = get_theme_mod( 'post_type_archive_downloads_per_page' );

		// bail if in the admin or we're not working with the main WP query
		if ( is_admin() || ! $query->is_main_query() )
			return;


		// set the number of downloads on the homepage and also set the post type to downloads if 'download' post type exists
		// this means that if EDD is not installed it will still output posts onto the homepage
		if ( is_home() && post_type_exists( 'download' ) ) {
			$query->set( 'posts_per_page', $home_latest_downloads ); 
			$query->set( 'post_type', 'download' ); // set post type to download
			return;
		}


		// set the number of downloads to show on the archive-download page
		if( is_post_type_archive( 'download' ) ) {
			$query->set( 'posts_per_page', $post_type_archive_downloads_per_page ); 
		}

	}
endif;
add_action( 'pre_get_posts', 'shopfront_modify_main_loops', 1 );


/**		
 * Logo is shown from the images folder if it's place there and called logo.png
 * @since 1.0 
*/
function shopfront_header_folder_logo() {

	$tagline = get_bloginfo( 'description' );

	// if there's a description, add <hgroup> and <h2>
	if ( $tagline ) {
		$output = '
		<hgroup>
			<h1 id="site-title" class="logo">
				<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) .'" rel="home">
					<img src="'. get_stylesheet_directory_uri() . '/images/logo.png" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" /> 
				</a>
			</h1>
			<h2 id="site-description">' . get_bloginfo( 'description' ) .'</h2>
		</hgroup>
		';
	}
	// just usual <h1>
	else {
		$output = '
		<h1 id="site-title" class="logo">
			<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) .'" rel="home">
				<img src="'. get_stylesheet_directory_uri() . '/images/logo.png" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" /> 
			</a>
			</h1>
		';
	}

	return $output;	
}

/**
 * Modified markup for logo
 * @since 1.0
 */
function shopfront_header_logo() {

	$logo = get_theme_mod( 'logo' );

	$tagline = get_bloginfo( 'description' );


	// if there's a description, add <hgroup> and <h2>
	if ( $tagline ) {
		$output = '
		<hgroup>
			<h1 id="site-title" class="logo">
				<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) .'" rel="home">
					<img src="' . $logo . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" />
				</a>
			</h1>
			<h2 id="site-description">' . get_bloginfo( 'description' ) .'</h2>
		</hgroup>
		';
	}
	// just usual <h1>
	else {
		$output = '
		<h1 id="site-title" class="logo">
			<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) .'" rel="home">
				<img src="' . $logo . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" />
			</a>
			</h1>
		';
	}

	return $output;

}



/**
 * Default Copyright text
 * @since 1.0 
 */

function shopfront_do_copyright() {
	
	$copyright = get_theme_mod( 'copyright' );
	$copyright = str_replace( '%year%', date( 'Y' ), $copyright );
	$copyright = str_replace( '%sitetitle%', get_bloginfo( 'name' ), $copyright );

	if( $copyright ) {
		echo '<p class="copyright">' . esc_attr( $copyright )  . '</p>';
	}
	elseif( '' == $copyright ) {
		echo '<p class="copyright">' . __('Copyright &copy;', 'shop-front') . date(' Y ') . get_bloginfo('name') . '</p>';
	}

}
add_action( 'shopfront_footer_copyright', 'shopfront_do_copyright' );


/**
 * Load the typography stylesheet
 * @since 1.0 
 */
function shopfront_load_typography_style() {
	
	$style = get_theme_mod( 'typography', 'default.css' );

	if ( isset( $style ) ) {

		// check for existance of stylesheet in child theme's directory and load if found
		if ( file_exists( get_stylesheet_directory() . '/typography/' . $style ) )
			wp_enqueue_style( 'typography', get_stylesheet_directory_uri() . '/typography/' . $style, '', SUMOBI_THEME_VERSION, 'screen' );
		
		// check for existance of stylesheet in parent theme's directory and load if found
		if ( file_exists( get_template_directory() . '/typography/' . $style ) )
			wp_enqueue_style( 'typography', get_template_directory_uri() . '/typography/' . $style, '', SUMOBI_THEME_VERSION, 'screen' );
	
	}
}
add_action( 'wp_enqueue_scripts', 'shopfront_load_typography_style', 20 );



/**
 * Only load filter above if logo is set
 * @since 1.0 
 */

function shopfront_load_logo() {

	$logo = get_theme_mod( 'logo' );
	
	// logo has been placed in images folder so we'll use that one
	if( file_exists( get_stylesheet_directory() . '/images/logo.png' ) )
		add_filter( 'shopfront_header_output', 'shopfront_header_folder_logo' );
	// if logo is set in theme options, add the filter to modify the header markup
	elseif ( $logo )
		add_filter( 'shopfront_header_output', 'shopfront_header_logo' );
}
add_action( 'template_redirect', 'shopfront_load_logo' );




/**
 * Stylesheet chooser
 * @since 1.0 
 */
function shopfront_stylesheet_uri( $stylesheet_uri, $stylesheet_dir_uri ) {

	$style = get_theme_mod( 'theme_style', 'style.css' );

	// if stylesheet cannot be found then load the default style.css
	if( !file_exists( get_stylesheet_directory() . '/styles/' . $style ) ) {
		$style = 'style.css';

		return trailingslashit( $stylesheet_dir_uri ) . $style;
	}
	
	else {
		// change $stylesheet_dir_uri depending on whether 'styles' folder exists in child theme or not
		if( file_exists( get_stylesheet_directory() . '/styles/' ) ) {
			$stylesheet_dir_uri = get_stylesheet_directory_uri() . '/styles/';
		}
		elseif( file_exists( get_template_directory() . '/styles/' ) ) {
			$stylesheet_dir_uri = get_template_directory_uri() . '/styles/';
		}

		return $stylesheet_dir_uri . $style;
	}	

}


/**
 * Load the stylesheet
 * @since 1.0 
 */
function shopfront_load_style() {

	$style = get_theme_mod( 'theme_style', 'style.css' );

	if ( isset( $style ) && $style != 'style.css' )
		add_filter( 'stylesheet_uri', 'shopfront_stylesheet_uri', 10, 2 );
}
add_action( 'template_redirect', 'shopfront_load_style' );



/**        
 * Create array of styles for theme customizer
 * @since 1.0 
*/

function shopfront_theme_options_theme_styles() {


	if( file_exists( get_stylesheet_directory() . '/styles/' ) ) {
		$stylesheet_dir = get_stylesheet_directory() . '/styles/';
	}
	elseif( file_exists( get_template_directory() . '/styles/' ) ) {
		$stylesheet_dir = get_template_directory() . '/styles/';
	}
	else {
		$stylesheet_dir = '';
	}

    // return if no folder exists
    if( !$stylesheet_dir )
    	return;

    $styles = array(
        'style.css' => 'clean/blue (default style.css)' // default
    );

    $stylesheet_files = array();

    $it = new RecursiveDirectoryIterator( $stylesheet_dir );

	$allowed = array('css');

	foreach(new RecursiveIteratorIterator($it) as $file) {

	    if(in_array(substr($file, strrpos($file, '.') + 1),$allowed)) {
	       
	       $file = str_replace( $stylesheet_dir, "", $file);
	       $file_label = str_replace( array('.css'), '', $file);
	       $styles[ $file ] = $file_label;
	    }

	}

	return apply_filters( 'shopfront_style_array', $styles );

}


