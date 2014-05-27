<?php
/**
 * Navigation
 */

/**
 * To keep your custom post type menu item highlighted while viewing a single post type or taxonomy pages (download_category or download_tag)
 * Add a Link Relationship (XFN) value of 'download download_category download_tag' (separated by a space) to the custom menu item
 *
 * @since 1.0
 */
function shopfront_add_current_menu_item_class( $classes, $item ) {

  $post_type = get_query_var( 'post_type' );
  $taxonomy = get_query_var( 'taxonomy' );

  if ( $item->xfn && !is_home() ) {

    $link_rel = $item->xfn;
    $link_rel_array = explode( ' ', $link_rel );
    $title_posttype = $link_rel_array[0];
    $category = $link_rel_array[1];
    $tag = $link_rel_array[2];

    // add CSS class to any 'download' post type page, 'download_category' or 'download_tag' page
    if ( $title_posttype == $post_type || $category == $taxonomy || $tag == $taxonomy ) {
      array_push( $classes, 'current-menu-item' );
    }

  }

  return $classes;
}
//add_filter( 'nav_menu_css_class', 'shopfront_add_current_menu_item_class', 10, 2 );


/**
 * Wrap site title with extra div
 *
 * @since 1.0
 */
function shopfront_add_wrap_open() {
  echo '<div id="site-title-wrap">';
}
add_action( 'shopfront_header_wrapper_start', 'shopfront_add_wrap_open' );

function shopfront_add_wrap_close() {
  echo '</div>';
}
add_action( 'shopfront_header_wrapper_end', 'shopfront_add_wrap_close', 11 );



/**
 * Display the WP3 menu if available
 *
 * @since 1.0
 */

if ( ! function_exists( 'shopfront_do_nav' ) ) :
  function shopfront_do_nav() {

    wp_nav_menu(
      array(
        'menu' => 'main_nav',
        'menu_class' => 'menu',
        'theme_location' => 'primary',
        'container' => 'nav',
        'container_id' => 'main',
        'fallback_cb' => 'shopfront_primary_menu_fallback',
        'depth' => '3',
      )
    );
    
  }
endif;
add_action( 'shopfront_header_end', 'shopfront_do_nav', 9 );


/**
 * Filter menu and add 'has-sub-menu' class to parent
 *
 * @since       1.0.4
*/

function shopfront_add_has_sub_menu_parent_class( $items ) {
  
  $parents = array();
  foreach ( $items as $item ) {
    if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
      $parents[] = $item->menu_item_parent;
    }
  }
  
  foreach ( $items as $item ) {
    if ( in_array( $item->ID, $parents ) ) {
      $item->classes[] = 'has-sub-menu'; 
    }
  }
  
  return $items;    
}
add_filter( 'wp_nav_menu_objects', 'shopfront_add_has_sub_menu_parent_class' );



/**
 * Menu Fallback
 * @since 1.0
 */

function shopfront_primary_menu_fallback() {
  echo '<nav class="menu-primary-container" id="main"><ul id="menu-primary-menu" class="menu">';
  wp_list_pages( 'title_li=&depth=3' );
  echo '</ul></nav>';

}


/**
 * Register nav menus
 * @since 1.0
 */
register_nav_menu( 'primary', __( 'Primary Menu', 'shop-front' ) );
register_nav_menu( 'secondary', __( 'Secondary Menu', 'shop-front' ) ); 


/**
 * Nav toggle
 * @since 1.0
 */

if ( ! function_exists( 'shopfront_do_nav_toggle' ) ) :
  function shopfront_do_nav_toggle() {
    $nav = '<h3 class="button" id="nav-toggle">'
    . '<span class="text">' . __( 'Menu', 'shop-front' ) . '</span>'
    . '<i class="icon icon-menu"></i>
  </h3>';

    echo apply_filters('shopfront_do_nav_toggle', $nav);
  }

add_action( 'shopfront_header_wrapper_end', 'shopfront_do_nav_toggle', 19 );
endif;


/**
 * Secondary Navigation
 *
 * @since 1.0
 */
function shopfront_do_secondary_nav() {

  $menuParameters = array(
    'menu_class' => false,
    'theme_location' => 'secondary',
    'container' => false,
    'items_wrap' => '%3$s',
    'depth'           => 0,
    'fallback_cb' => false,
    'echo'            => false,
  );

  echo '<nav id="secondary-menu">';

  echo strip_tags( wp_nav_menu( $menuParameters ), '<a>' );

  do_action( 'shop_front_secondary_navigation' );

  echo '</nav>';

}
add_action( 'shopfront_header_wrapper_end', 'shopfront_do_secondary_nav' );



/**
 * Download navigation
 * Shows next page/previous page
 */
if ( ! function_exists( 'shopfront_download_nav' ) ) :

  function shopfront_download_nav( $nav_id ) {
    global $wp_query;

    if ( $wp_query->max_num_pages > 1 ) : ?>
      <nav id="<?php echo $nav_id; ?>" class="download-navigation">

      <h3 class="assistive-text">
        <?php _e( 'Download navigation', 'shop-front' ); ?>
      </h3>

      <?php
    $previous = apply_filters( 'shopfront_download_nav_previous', __( '<i class="icon icon-arrow-left"></i>', 'shop-front' ) );
    $next = apply_filters( 'shopfront_download_nav_next', __( '<i class="icon icon-arrow-right"></i>', 'shop-front' ) );
?>

      <span class="nav-previous">
      <?php previous_posts_link( $previous ); ?>
     </span>

     <span class="nav-next">

      <?php next_posts_link( $next ); ?>
    </span>

      </nav>
    <?php endif;
  }
endif;


/**
 * Display navigation to next/previous pages when applicable
 *
 * @since 1.0
 */
if ( ! function_exists( 'shopfront_content_nav' ) ) :

  function shopfront_content_nav( $nav_id ) {
    global $wp_query;

    $page = (get_query_var('paged')) ? get_query_var('paged') : 1; query_posts('paged=$page');

    if ( $wp_query->max_num_pages > 1 ) : ?>
      <nav id="<?php echo $nav_id; ?>" class="navigation">

        <h3 class="assistive-text">
          <?php _e( 'Post navigation', 'shop-front' ); ?>
        </h3>

        <?php
          $previous = apply_filters( 'shopfront_content_nav_previous', __( '<i class="icon icon-arrow-right"></i><span class="text">Newer</span>', 'shop-front' ) );
          $next = apply_filters( 'shopfront_content_nav_next', __( '<i class="icon icon-arrow-left"></i> <span class="text">Older</span>', 'shop-front' ) );
      ?>

      <span class="nav-next">
        <?php previous_posts_link( $previous ); ?>
      </span>

      <span class="nav-previous">
        <?php next_posts_link( $next ); ?>
      </span>

      </nav>
    <?php endif;
  }
endif;
