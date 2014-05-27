<?php 
/**     
 * Downloads archive page.
 * This is used by default unless EDD_DISABLE_ARCHIVE is set to true
*/

    get_header();

    $plural = function_exists( 'edd_get_label_plural' ) ? edd_get_label_plural() : '';
    $singular = function_exists( 'edd_get_label_singular' ) ? edd_get_label_singular() : '';
   ?>

    <?php do_action( 'shopfront_the_title' ); ?>

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
            <h2><?php printf( __( 'No %s to display', 'shop-front' ), $plural ); ?></h2>
        </header>

        <div class="entry-content">
            <p><?php printf( __( 'Ready to add your first %s? <a href="%s">Get started here</a>.', 'shop-front' ), $singular, admin_url( 'post-new.php?post_type=download' ) ); ?></p>
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