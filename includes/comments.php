<?php
/**
 * Modify the entire output of the comment form
 * This is because we would like to style it beyond the limitation of action hooks and filters
 */
function shopfront_comment_form( $args = array(), $post_id = null ) {
	global $id;

		if ( null === $post_id )
			$post_id = $id;
		else
			$id = $post_id;

		$commenter = wp_get_current_commenter();
		$user = wp_get_current_user();
		$user_identity = ! empty( $user->ID ) ? $user->display_name : '';

		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$fields =  array(
			'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'shop-front' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
			            '<input class="text required" data-msg-required="' . __('Please enter your Name', 'shop-front') . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
			'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'shop-front' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
			            '<input class="text required" data-msg-required="' . __('Please enter your Email', 'shop-front') . '" id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
			'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'shop-front' ) . '</label>' .
			            '<input class="text" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
		);
		
		$defaults = array(
			'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
			'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . __( 'Comment', 'shop-front' ) . '</label><textarea id="comment" name="comment" aria-required="true"></textarea></p>',
			'must_log_in'          => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
			'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
			'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will <strong>not</strong> be published.', 'shop-front' ) . '</p>',
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'title_reply'          => __( 'Leave a Reply', 'shop-front' ),
			'title_reply_to'       => __( 'Leave a Reply to %s', 'shop-front' ),
			'cancel_reply_link'    => __( 'Cancel', 'shop-front' ),
			'label_submit'         => __( 'Post Comment', 'shop-front' ),
		);

		$args = wp_parse_args( $args, apply_filters( 'shopfront_comment_form', $defaults ) );

	?>
		<?php if ( comments_open( $post_id ) ) : ?>
			<?php do_action( 'comment_form_before' ); ?>
			<div id="respond">
				
				<h3 id="reply-title">
					<?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?>
					<?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?>
				</h3>
				
				<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
					<?php echo $args['must_log_in']; ?>
					<?php do_action( 'comment_form_must_log_in_after' ); ?>
				<?php else : ?>
					<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
						<?php do_action( 'comment_form_top' ); ?>
						<?php if ( is_user_logged_in() ) : ?>
							<?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
							<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
						<?php else : ?>
							<?php echo $args['comment_notes_before']; ?>
							<?php
							do_action( 'comment_form_before_fields' );
							foreach ( (array) $args['fields'] as $name => $field ) {
								echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
							}
							do_action( 'comment_form_after_fields' );
							?>
						<?php endif; ?>
						<?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
						
						<p class="form-submit">

							<button class="button">
								
								<span class="text">
									<?php echo esc_attr( $args['label_submit'] ); ?>
								</span>
							</button>

							<?php comment_id_fields( $post_id ); ?>
						</p>
						<?php do_action( 'comment_form', $post_id ); ?>
					</form>
				<?php endif; ?>
				
			</div><!-- #respond -->
			<?php do_action( 'comment_form_after' ); ?>
		<?php else : ?>
			<?php do_action( 'comment_form_comments_closed' ); ?>
		<?php endif; ?>
	<?php
}

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own shopfront_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */



if ( ! function_exists( 'shopfront_comment' ) ) :

function shopfront_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'shop-front' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'shop-front' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			
			<div class="comment-author vcard">
					<?php
						$avatar_size = 72;
						
						if ( '0' != $comment->comment_parent ) {
							$avatar_size = 48;
						}	

						if( get_option('show_avatars') ) {
							echo '<span class="avatar-wrap">' . get_avatar( $comment, $avatar_size ) . '</span>';
						}

						/* comment author, */
						printf( __( '%1$s', 'shop-front' ),	sprintf( '<span class="fn">%s</span>', get_comment_author_link() ) );

						/* date and time */
						printf( __( '%1$s', 'shop-front' ),
							

							sprintf( '<time pubdate datetime="%1$s">%2$s</time>',
								get_comment_time( 'c' ),
								
								sprintf( __( '%1$s at %2$s', 'shop-front' ), get_comment_date(), get_comment_time() )
							)
						);

					?>

					<?php //edit_comment_link( __( 'Edit', 'shop-front' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->
				
			<div class="comment-content">
				<?php comment_text(); ?>

				<div class="reply">

					<?php 
						comment_reply_link( array_merge( $args, 
						array( 
							'reply_text' => __( 'Reply', 'shop-front' ), 
							'depth' => $depth, 
							'max_depth' => $args['max_depth']
						) ) ); 
					?>
				</div><!-- .reply -->
			</div>

		
		</article><!-- #comment-## -->

		
				

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="comment-awaiting-moderation">
						<?php _e( 'Your comment is awaiting moderation.', 'shop-front' ); ?>
					</p>
					
				<?php endif; ?>

			
			
	<?php
			break;
	endswitch;
}
endif; // ends check for shopfront_comment()


/**		
 * Add JS to comment form
*/


/**
 * Load validation JS into footer on comment pages so we can validate the form
 */
function shopfront_comment_js() {
	if ( is_singular() && comments_open() ) { ?>
			<script>
				jQuery(document).ready(function() {
				
					jQuery('#commentform').validate({
						errorClass: "alert error",
						highlight: function(element, errorClass) {
					        jQuery(element).removeClass(errorClass);
					    }
					});
				});
			</script>
	<?php }

}
add_action( 'wp_footer', 'shopfront_comment_js', 20 );
