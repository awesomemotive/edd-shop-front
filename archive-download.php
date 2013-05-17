<?php 
/**     
 * Downloads archive page.
 * This is used by default unless EDD_DISABLE_ARCHIVE is set to true
*/

    get_header();

    // get post type object
    $obj = get_post_type_object('download');

    // Shows an alert with what download was added to the cart. Only shows when ajax is turned off
    $download_id = isset( $_POST["download_id"] ) ? $_POST["download_id"] : '';

    if( function_exists('edd_show_added_to_cart_messages') ) edd_show_added_to_cart_messages( $download_id );

    $post_type_archive_title = get_theme_mod( 'post_type_archive_title', $obj->labels->menu_name );

    if( $post_type_archive_title ) : ?>

    <h1 class="page-title">
        <?php echo $post_type_archive_title; // echos the name of the post type for use as the heading ?>
    </h1>
    <?php endif; ?>

    <?php do_action( 'shopfront_primary_wrapper_before' ); ?>
        
        <section id="primary" class="full-width">
            <div class="wrapper">
      
           <?php if ( have_posts() ) : $count = 0; ?>

    <div class="downloads<?php shopfront_get_download_columns(); ?>">

        <?php while ( have_posts() ) : the_post(); $count++; ?>

        <?php
            get_template_part( '/partials/download', 'grid' );
        ?>

        <?php if ( $count %2 == 0 ) echo '<div class="clear-2"></div>'; ?>
        <?php if ( $count %3 == 0 ) echo '<div class="clear-3"></div>'; ?>
        <?php if ( $count %4 == 0 ) echo '<div class="clear-4"></div>'; ?>

        <?php endwhile; ?>
    </div>


     <?php
        /**
         * Pagination
         * Comment out to remove from page
         */
        shopfront_download_nav( 'downloads' );
    ?>

<?php else : ?>

    <article id="post-0" class="post no-results not-found">

    <?php if ( current_user_can( 'edit_posts' ) ) : // Show a different message to a logged-in user who can add posts ?>
        
        <header class="entry-header">
            <h2><?php printf( __( 'No %s to display', 'shop-front' ), $obj->labels->name ); ?></h2>
        </header>

        <div class="entry-content">
            <p><?php printf( __( 'Ready to add your first %s? <a href="%s">Get started here</a>.', 'shop-front' ), $obj->labels->singular_name, admin_url( 'post-new.php?post_type=download' ) ); ?></p>
        </div>

    <?php else : // Show the default message to everyone else ?>

        <header class="entry-header">
            <h1 class="entry-title"><?php _e( 'Nothing Found', 'shop-front' ); ?></h1>
        </header>

        <div class="entry-content">
            <p><?php _e( 'Sorry, there\'s nothing here just yet.', 'shop-front' ); ?></p>
            <?php get_search_form(); ?>
        </div>

    <?php endif; // end current_user_can() check ?>

    </article>

<?php endif; // end have_posts() check ?>

            
    </div>
</section>

<?php get_footer(); ?>