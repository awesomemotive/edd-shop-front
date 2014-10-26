<?php

/**
 * Entry Meta
 *
 * @since       1.0
*/
if ( ! function_exists( 'shopfront_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own shopfront_entry_meta() to override in a child theme.
 *
 * @since 1.0
 */
function shopfront_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'shop-front' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'shop-front' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'shop-front' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'shop-front' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'shop-front' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'shop-front' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;


/**		
 * Render the_title
 * Uses hooks so title can be removed/repositioned
 * @since 1.0
*/
function shopfront_render_the_title() { ?>
	
	<?php if( !is_front_page() && is_page() ) : ?>

		<header class="entry-header">
			<h1 class="page-title"><?php the_title(); ?></h1>
		</header>

	<?php elseif( is_post_type_archive( 'download' ) ) : 
		 $post_type_archive_title = get_theme_mod( 'post_type_archive_title', edd_get_label_plural() );
	?>
		
		<?php if( $post_type_archive_title ) : ?>
		<h1 class="page-title">
	        <?php echo $post_type_archive_title; // echos the name of the post type for use as the heading ?>
	    </h1>
		<?php endif; ?>

	<?php elseif( is_singular('download') ) : ?>
	
		<h1 class="download-title"><?php the_title(); ?></h1>

	<?php elseif( is_tax( 'download_category' ) || is_tax( 'download_tag' ) ) : ?>
	
		 <h1 class="page-title">
            <?php printf( __( '%s', 'shop-front' ), single_term_title( '', false ) ); ?>
        </h1>

	<?php else : ?>

		<h1 class="entry-title"><?php the_title(); ?></h1>

	<?php endif; ?>

<?php }	
add_action( 'shopfront_the_title', 'shopfront_render_the_title' );


/**
 * Inserts required code for Featured Images, including caption div if required
 *
 * @since 1.0
 */

function shopfront_the_post_thumbnail() { ?>

	<?php
	global $post;

	if ( has_post_thumbnail( $post->ID ) ) : /* this is the featured image */ ?>

			<div class="entry-post-thumbnail">

				<?php the_post_thumbnail( 'featured-image' ); ?>

			</div>
		<?php endif; ?>

<?php }



/**
 * Test for subpages
 *
 * @since 1.0
 * @link http://codex.wordpress.org/Conditional_Tags#Testing_for_sub-Pages
 */
function shopfront_is_subpage() {
	global $post;                              // load details about this page

	if ( is_page() && $post->post_parent ) {   // test to see if the page has a parent
		return $post->post_parent;             // return the ID of the parent post

	} else {                                   // there is no parent so ...
		return false;                          // ... the answer to the question is false
	}
}

/**
 * Check the current post for the existence of a short code
 *
 * @since 1.0
 */

function shopfront_has_shortcode( $shortcode = '' ) {
	global $post;
	// false because we have to search through the post content first
	$found = false;

	// if no short code was provided, return false
	if ( !$shortcode ) {
		return $found;
	}

	if (  is_object( $post ) && stripos( $post->post_content, '[' . $shortcode ) !== false ) {
		// we have found the short code
		$found = true;
	}

	// return our final results
	return $found;
}


/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0
 */
function shopfront_body_classes( $classes ) {

	global $post;

	// Adds a class of 'has-featured-image' if the current post has a featured image
	if ( isset( $post->ID ) && get_the_post_thumbnail( $post->ID ) )
		$classes[] = 'has-featured-image';

	// Adds a 'has-gallery' class if a gallery shortcode is detected on the page
	if ( isset( $post->ID ) && strpos( $post->post_content, '[gallery' ) )
		$classes[] = 'has-gallery';

	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() )
		$classes[] = 'group-blog';

	// Adds a class of 'blog' if the blog template is being used. The homepage when used as a blog also has this class already
	if ( is_page_template( 'page-templates/blog.php' ) )
		$classes[] = 'blog';

	if ( is_page_template( 'page-templates/full-width.php' ) )
		$classes[] = 'full-width';
	
	return $classes;
}
add_filter( 'body_class', 'shopfront_body_classes' );


/**
 * Custom post classes
 *
 * @since 1.0
 */
function shopfront_post_classes( $classes ) {

	global $post;

	// Adds a 'is-post-format' class to the post classes
	if ( is_object( $post ) && get_post_format( $post->ID ) )
		$classes[] = 'is-post-format';

	// Adds a 'has-featured-image' to the post class
	if ( current_theme_supports( 'post-thumbnails' ) )
		if ( is_object( $post ) && has_post_thumbnail() )
			$classes[] = 'has-featured-image';

		return $classes;
}
add_filter( 'post_class', 'shopfront_post_classes' );


/**		
 * Removes the default [...] from end of excerpt
 * @since 1.0 
*/
function shopfront_excerpt_more( $more ) {
	return false;
}
add_filter( 'excerpt_more', 'shopfront_excerpt_more' );


/**		
 * Custom read more function
 * @since 1.0
*/
function shopfront_read_more() {
	global $post;

	echo '<a title="' . __( 'Read more', 'shop-front' ) . '" class="more-link" href="'. get_permalink( $post->ID ) . '">' . __( 'Read more', 'shop-front' ) . '</a>';
}


/**		
 * Prevent Page Scroll When Clicking the More Link
 * @link http://codex.wordpress.org/Customizing_the_Read_More
 * @since 1.0 
*/
function shopfront_remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'shopfront_remove_more_link_scroll' );

/**
 * Add additional classes to widgets
 * @since 1.0
 * @link http://wordpress.org/support/topic/how-to-first-and-last-css-classes-for-sidebar-widgets
 */
function shopfront_widget_first_last_classes( $params ) {
	global $my_widget_num;

	$this_id = $params[0]['id'];
	$arr_registered_widgets = wp_get_sidebars_widgets();

	if ( !$my_widget_num )
		$my_widget_num = array();

	if ( !isset( $arr_registered_widgets[$this_id] ) || !is_array( $arr_registered_widgets[$this_id] ) )
		return $params;

	if ( isset( $my_widget_num[$this_id] ) ) 
		$my_widget_num[$this_id] ++;
	else
		$my_widget_num[$this_id] = 1;

	$class = 'class="widget-' . $my_widget_num[$this_id] . ' ';

	if ( $my_widget_num[$this_id] == 1 )
		$class .= 'widget-first ';
	elseif ( $my_widget_num[$this_id] == count( $arr_registered_widgets[$this_id] ) )
		$class .= 'widget-last ';
	

	$params[0]['before_widget'] = preg_replace( '/class=\"/', "$class", $params[0]['before_widget'], 1 );

	return $params;

}
add_filter( 'dynamic_sidebar_params', 'shopfront_widget_first_last_classes' );




/**
 * Fix for empty search queries redirecting to home page
 * @since 1.0
 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330
 */

if ( ! function_exists( 'shopfront_fix_empty_search_redirection' ) ):
	function shopfront_fix_empty_search_redirection( $query_vars ) {
		if (isset($_GET['s']) && empty($_GET['s']))
			$query_vars['s'] = ' ';

		return $query_vars;
	}
endif;
add_filter('request', 'shopfront_fix_empty_search_redirection');



/**
 * Removes default inline gallery styling. We want to add this to our own stylesheet rather than having it inline within the source
 * @since 1.0
 */
add_filter( 'use_default_gallery_style', '__return_false' );






/**
 * Strip type attribute from our stylesheets
 * @since 1.0
 */

function shopfront_remove_type( $src ) {
    return str_replace( "type='text/css'", '', $src );
}
add_filter( 'style_loader_tag', 'shopfront_remove_type' );


/**
 * Remove inline comments style from <head>
 * @since 1.0
 */

function shopfront_remove_recent_comments_style() {
  global $wp_widget_factory;
  remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'shopfront_remove_recent_comments_style' );



/**
 * Posted On
 * @since 1.0 
 */
if ( ! function_exists( 'shopfront_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date
	 * Create your own shopfront_posted_on to override in a child theme
	 */
	function shopfront_posted_on() {
		global $date_format;

		if ( $date_format ) {

			printf( __( '
			<time class="entry-date" datetime="%1$s">%2$s %3$s %4$s</time>', 'shop-front' ),
				esc_attr( get_the_date( 'c' ) ), // datetime (ISO 8601 ) 2004-02-12T15:19:21+00:00
				esc_html( get_the_date( 'j' ) ),
				esc_html( get_the_date( 'M' ) ),
				esc_html( get_the_date( 'Y' ) )
			);

		} else {
			printf( __( '
			<time class="entry-date" datetime="%1$s"><span class="full-date">%2$s</span></time>', 'shop-front' ),
				esc_attr( get_the_date( 'c' ) ), // datetime (ISO 8601 ) 2004-02-12T15:19:21+00:00
				esc_html( get_the_date( 'F j, Y' ) )


			);
		}
	}
endif;