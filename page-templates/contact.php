<?php 
/*
Template Name: Contact
*/

// load validate script
function shopfront_contact_scripts() {
	wp_enqueue_script( 'validate' );
}
add_action( 'wp_enqueue_scripts', 'shopfront_contact_scripts' );

// load script
function shopfront_contact_js() { ?>
	
	<script>
		jQuery(document).ready(function(){

			jQuery('.shopfront-form').validate({
				errorClass: "alert error",
				highlight: function(element, errorClass) {
			        jQuery(element).removeClass(errorClass);
			    }
			});

		});
	</script>

<?php }
add_action( 'wp_footer', 'shopfront_contact_js' );

// success message
$success_message = get_theme_mod( 'contact_form_message', __('Thanks for getting in touch!', 'shop-front' ) );

/*
* Error Messages
*/
$nameError = __( 'Please enter your name.', 'shop-front' );
$emailError = __( 'Please enter your email address.', 'shop-front' );
$emailInvalidError = __( 'You entered an invalid email address.', 'shop-front' );
$messageError = __( 'Please enter a message.', 'shop-front' );

$errorMessages = array();
if(isset($_POST['submitted'])) {
		if(trim($_POST['contactName']) === '') {
			$errorMessages['nameError'] = $nameError;
			$hasError = true;
		} else {
			$name = trim($_POST['contactName']);
		}
		
		if(trim($_POST['email']) === '')  {
			$errorMessages['emailError'] = $emailError;
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
			$errorMessages['emailInvalidError'] = $emailInvalidError;
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}
			
		if(trim($_POST['message']) === '') {
			$errorMessages['messageError'] = $messageError;
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$message = stripslashes(trim($_POST['message']));
			} else {
				$message = trim($_POST['message']);
			}
		}
			
		if(!isset($hasError)) {

			$emailTo = get_theme_mod( 'contact_form_email', get_option('admin_email') );

			if (!isset($emailTo) || ($emailTo == '') ){
				$emailTo = get_option('admin_email');
			}			
			$subject = 'Message From '.$name;
			$body = "Name: $name \n\nEmail: $email \n\nMessage: $message";
			$headers = 'From: '.$name.' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $email;
			
			mail($emailTo, $subject, $body, $headers);
			$emailSent = true;
		}
	
} ?>

<?php get_header(); ?>
			

			<div id="primary" class="hfeed">
				<div class="wrapper">
					
					<?php do_action( 'shopfront_primary_wrapper_start' ); ?>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                
					<?php get_template_part( 'content', 'page' ); ?>

				<?php if(isset($emailSent) && $emailSent == true) { ?>

					<p class="alert success">
						<?php echo $success_message; ?>
					</p>

				<?php } else { ?>

		
					<?php if(isset($hasError) || isset($captchaError)) { ?>
						<p class="error"><?php _e('Oops, there seems to be a problem.', 'shop-front') ?></p>
					<?php } ?>
					
					

					<form action="<?php the_permalink(); ?>" id="form" method="post" class="shopfront-form">
						
							<p>
								<label for="contactName"><?php _e('Name', 'shop-front') ?></label>
								<span class="required">*</span>
								<input class="text required" data-msg-required="<?php _e('Please enter your name', 'shop-front'); ?>" type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" />
								
								<?php if(isset($errorMessages['nameError'])) { ?>
									<span class="error"><?php echo $errorMessages['nameError']; ?></span> 
								<?php } ?>

							</p>
				
							<p>
								<label for="email"><?php _e('Email', 'shop-front') ?></label>
								<span class="required">*</span>
								<input class="text required" data-msg-email="<?php _e('Please enter a valid email address', 'shop-front'); ?>" data-msg-required="<?php _e('Please enter your email address', 'shop-front'); ?>" type="email" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" />
								
								<?php if(isset($errorMessages['emailError'])) { ?>
									<span class="error"><?php echo $errorMessages['emailError']; ?></span> 
								<?php } ?>
								<?php if(isset($errorMessages['emailInvalidError'])) { ?>
									<span class="error"><?php echo $errorMessages['emailInvalidError']; ?></span> 
								<?php } ?>
							</p>
				
							<p class="textarea">
								<label for="message"><?php _e('Message', 'shop-front') ?></label>
								
								<textarea class="required" data-msg-required="<?php _e('Please enter a message', 'shop-front'); ?>" name="message" id="message"><?php if(isset($_POST['message'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['message']); } else { echo $_POST['message']; } } ?></textarea>
								<?php if(isset($errorMessages['messageError'])) { ?>
									<span class="error"><?php echo $errorMessages['messageError']; ?></span> 
								<?php } ?>
							</p>
				
							<p>
								<input type="hidden" name="submitted" id="submitted" value="true" />
								
								<button class="button large primary">
									<span class="text"><?php _e('Send', 'shop-front') ?></span>
								</button>
							</p>
						
					</form>
					

				<?php } // endif ?>
				
				<?php endwhile; endif; ?>
					
				</div>
			</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>