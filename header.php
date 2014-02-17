<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="ie6 legacy-ie"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7 legacy-ie"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8 legacy-ie"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?> class="no-js">
<!--<![endif]-->
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
<title><?php wp_title( '|', true, 'right' ); ?></title>

<?php
/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
if ( is_singular() && get_option( 'thread_comments' ) )
	wp_enqueue_script( 'comment-reply' );

wp_head(); 

?>

</head>

<body <?php body_class(); ?>>
	
<?php do_action( 'shopfront_body_start' ); ?>

<?php do_action( 'shopfront_site_before' ); ?>

<div id="site" class="hfeed">

<?php do_action( 'shopfront_site_start' ); ?>

<?php do_action( 'shopfront_header' ); ?>

<?php do_action( 'shopfront_container_before' ); ?>

	<div id="container">
		<?php do_action( 'shopfront_container_start' ); ?>

		<div class="wrapper">
			<?php do_action( 'shopfront_container_wrapper_start' ); ?>

	<?php do_action( 'shopfront_content_before' ); ?>

	<div id="content">

	<?php do_action( 'shopfront_content_start', isset( $post->ID ) ? $post->ID : null ); ?>