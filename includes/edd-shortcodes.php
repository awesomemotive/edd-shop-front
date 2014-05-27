<?php
/**		
 * Filter [download] shortcode HTML
 * @since 1.0
*/

function shopfront_modify_edd_download_shortcode( $display, $atts, $buy_button, $columns, $column_width, $downloads, $excerpt, $full_content, $price, $thumbnails, $query ) { ?>

<?php 

switch( intval( $columns ) ) :
		case 1:
			$column_number = 'col-1'; break;
		case 2:
			$column_number = 'col-2'; break;
		case 3:
			$column_number = 'col-3'; break;
		case 4:
			$column_number = 'col-4'; break;
	endswitch;

	ob_start(); $count = 0; ?>

	
	<div class="downloads <?php echo $column_number; ?>">
		
			<?php while ( $downloads->have_posts() ) : $downloads->the_post(); $count++; 

				$in_cart = ( edd_item_in_cart( get_the_ID() ) && !edd_has_variable_prices( get_the_ID() ) ) ? 'in-cart' : ''; 
				$variable_priced = ( edd_has_variable_prices( get_the_ID() ) ) ? 'variable-priced' : '';
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( array( $in_cart, $variable_priced ) ); ?>>
       				<div class="edd_download_inner">
					 	<?php 
					 	/**		
					 	 * Show thumbnails
					 	*/
					 	if( 'false' != $thumbnails ) : ?>
				        <div class="download-image">
				        	 <a title="<?php _e( 'View ', 'shop-front' ) . the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
				             
				             <?php if ( has_post_thumbnail() ) : ?>
				            
				             	 <?php 

				                    if( 'col-1' == $column_number || 'col-2' == $column_number ) {
				                        the_post_thumbnail( 'download-medium' ); 
				                    }
				                    else {
				                        the_post_thumbnail( 'download' ); 
				                    }
				                ?>
				            
				            <?php else: ?>

				            	<img src="<?php echo get_template_directory_uri(); ?>/images/blank.png" alt="" />
				            	 <?php echo apply_filters( 'shopfront_download_icon', '<i class="icon icon-product"></i>'); ?>
				             <?php endif; ?>
				        </a>

				       <?php if ( $buy_button != 'yes' ) : ?> 	
		               <div class="overlay">
      	
			                <a title="<?php _e('View ','shop-front') . the_title_attribute(); ?>" class="icon-action button <?php if( edd_has_variable_prices( get_the_ID() ) ) echo 'single'; ?>" href="<?php the_permalink(); ?>">
			                    <i class="icon-view"></i>
			                </a>

			                <?php 
			                if( !edd_has_variable_prices( get_the_ID() ) )
			                	echo shopfront_get_purchase_link( array( 'id' => get_the_ID() ) ); 
			                ?>

			            </div>
			            <?php endif; ?>

				        </div>
				        <?php endif; ?>


				        <div class="download-info">

				         	<?php 
				         		edd_get_template_part( 'shortcode', 'content-title' );

				         		if ( $price == 'yes' ) {
				         			edd_get_template_part( 'shortcode', 'content-price' );
				         		}
				         		
				         	?>

				         	 <?php
					        /**		
					         * Excerpt and Content
					        */

							$excerpt_length = apply_filters('excerpt_length', 20);
					        if ( $excerpt != 'no' && $full_content != 'yes' && has_excerpt() ) {
					      
					        	echo '<p>' . wp_trim_words( get_the_excerpt(), $excerpt_length ) . '</p>';
					        }
					        elseif( $full_content == 'yes' ) {
					        	the_content();
					        }
					     
							?>

							<?php
					        /**		
					         * Buy button
					        */
					        if ( $buy_button == 'yes' ) : ?>
					    	<div class="edd_download_buy_button">
								<?php echo edd_get_purchase_link( array( 'id' => get_the_ID() ) );  ?>
							</div>

						<?php endif; ?>
				        </div>
				    </div>
				</article>
			
			<?php if ( $count %2 == 0 ) echo '<div class="clear-2"></div>'; ?>
	        <?php if ( $count %3 == 0 ) echo '<div class="clear-3"></div>'; ?>
	        <?php if ( $count %4 == 0 ) echo '<div class="clear-4"></div>'; ?>

	       

			<?php endwhile; ?>

			<?php wp_reset_postdata(); ?>

			
			
		</div>
		<nav id="downloads-shortcode" class="download-navigation">
			<?php
			$big = 999999;
			echo paginate_links( array(
				'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'  => '?paged=%#%',
				'current' => max( 1, $query['paged'] ),
				'total'   => $downloads->max_num_pages,
				'prev_next' => false,
				'show_all' => true,
			) );
			?>
		</nav>

<?php 

$display = ob_get_clean();
return $display; }

add_filter( 'downloads_shortcode', 'shopfront_modify_edd_download_shortcode', 10, 11);