<?php
/**
 * Partial: Download Grid
*/

$in_cart = ( edd_item_in_cart( get_the_ID() ) && !edd_has_variable_prices( get_the_ID() ) ) ? 'in-cart' : ''; 
$variable_priced = ( edd_has_variable_prices( get_the_ID() ) ) ? 'variable-priced' : '';

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array( $in_cart, $variable_priced ) ); ?>>

        <div class="download-image">

             <a title="<?php _e('View ','shop-front') . the_title(); ?>" href="<?php the_permalink(); ?>">
             <?php 
                if ( has_post_thumbnail() ) : ?>
                
                <?php 
                   if( is_home() )
                        $download_columns = get_theme_mod( 'home_download_columns' );
                    else 
                        $download_columns = get_theme_mod( 'download_columns' );

                    if( '1' == $download_columns || '2' == $download_columns ) {
                        the_post_thumbnail( 'download-medium' ); 
                    }
                    else {
                        the_post_thumbnail( 'download' ); 
                    }
                ?>

            <?php else: ?>
                <img src="<?php echo get_template_directory_uri(); ?>/images/blank.png" alt="" />
                <i class="icon icon-product"></i>
             <?php endif; ?>
            </a>
            
            <div class="overlay">
              
                <a title="<?php _e('View ','shop-front') . the_title(); ?>" class="icon-action button <?php if( edd_has_variable_prices( get_the_ID() ) ) echo 'single'; ?>" href="<?php the_permalink(); ?>">
                    <i class="icon-view"></i>
                </a>

                <?php 
                if( !edd_has_variable_prices( get_the_ID() ) )
                    echo shopfront_get_purchase_link( array( 'id' => get_the_ID() ) ); 
                ?>

            </div>

        </div>

       
        <a title="<?php _e('View ','shop-front') . the_title(); ?>" href="<?php the_permalink(); ?>">
            
        <h2>
            <?php the_title(); ?>
        </h2>

            <?php edd_get_template_part( 'shortcode', 'content-price' ); ?>
        
            <?php 
                $excerpt_length = apply_filters( 'excerpt_length', 15 );

                if ( has_excerpt() ) : ?>
                <?php 
                    echo '<p>' . wp_trim_words( get_the_excerpt(), $excerpt_length ) . '</p>'; 

                ?>
            <?php endif; ?>
        
        </a>


</article>