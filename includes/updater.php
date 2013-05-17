<?php

/**
 * Licensing admin page
 */

if ( !class_exists( 'EDD_SL_Theme_Updater' ) ) {
	// load our custom theme updater
	include trailingslashit( INCLUDES_DIR ) . 'EDD_SL_Theme_Updater.php';
}

$theme_license = trim( get_option( 'shop_front_theme_license_key' ) );

$edd_updater = new EDD_SL_Theme_Updater( array(
		'remote_api_url'  => SUMOBI_STORE_URL,
		'version'    => SUMOBI_THEME_VERSION,
		'license'    => $theme_license,
		'item_name'   => SUMOBI_THEME_NAME,
		'author'   => 'Sumobi'
	)
);


/**
 * Add licensing menu
 */
function shopfront_license_menu() {
	add_theme_page( 'Theme License', 'Theme License', 'manage_options', 'theme-license', 'shopfront_license_page' );
}
add_action( 'admin_menu', 'shopfront_license_menu' );


/**
 * License Page
 */
function shopfront_license_page() {
	$license  = get_option( 'shopfront_license_key' );
	$status  = get_option( 'shopfront_license_key_status' );
?>
	<div class="wrap">
		<h2><?php _e( 'Theme License Options', 'shop-front' ); ?></h2>
		<p><?php _e( 'Enter your license key to receive Automatic Theme Updates.', 'shop-front' ); ?></p>
		<form method="post" action="options.php">

			<?php settings_fields( 'shopfront_license' ); ?>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e( 'License Key', 'shop-front' ); ?>
						</th>
						<td>
							<input id="shopfront_license_key" name="shopfront_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="shopfront_license_key"><?php _e( 'Enter Your License Key', 'shop-front' ); ?></label>
						</td>
					</tr>
					<?php if ( false !== $license ) { ?>
						<tr valign="top">
							<th scope="row" valign="top">
								<?php _e( 'Activate License', 'shop-front' ); ?>
							</th>
							<td>

								<?php if ( $status !== false && $status == 'valid' ) { ?>

									<span style="color:green;"><?php _e( 'Active', 'shop-front' ); ?></span>
									<?php wp_nonce_field( 'shopfront_nonce', 'shopfront_nonce' ); ?>
									<input type="submit" class="button-secondary" name="shopfront_license_deactivate" value="<?php _e( 'Deactivate License', 'shop-front' ); ?>"/>

								<?php } else {
									wp_nonce_field( 'shopfront_nonce', 'shopfront_nonce' ); 
								?>
									<input type="submit" class="button-secondary" name="shopfront_license_activate" value="<?php _e( 'Activate License', 'shop-front' ); ?>"/>

								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>



			<?php submit_button(); ?>

		</form>


		<?php shopfront_check_license(); ?>


	<?php
}

/**
 * Register setting
 */
function shopfront_register_option() {
	// creates our settings in the options table
	register_setting( 'shopfront_license', 'shopfront_license_key', 'shopfront_sanitize_license' );
}
add_action( 'admin_init', 'shopfront_register_option' );


/**
 * Sanitize license
 */
function shopfront_sanitize_license( $new ) {
	$old = get_option( 'shopfront_license_key' );
	if ( $old && $old != $new ) {
		delete_option( 'shopfront_license_key_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}


/**
 * Activate License
 */
function shopfront_activate_license() {

	if ( isset( $_POST['shopfront_license_activate'] ) ) {
		if ( ! check_admin_referer( 'shopfront_nonce', 'shopfront_nonce' ) )
			return; // get out if we didn't click the Activate button

		global $wp_version;

		$license = trim( get_option( 'shopfront_license_key' ) );

		$api_params = array(
			'edd_action' => 'activate_license',
			'license' => $license,
			'item_name' => urlencode( SUMOBI_THEME_NAME )
		);

		$response = wp_remote_get( add_query_arg( $api_params, SUMOBI_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		if ( is_wp_error( $response ) )
			return false;

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "active" or "inactive"

		update_option( 'shopfront_license_key_status', $license_data->license );

	}
}
add_action( 'admin_init', 'shopfront_activate_license' );


/**
 * Check license is valid
 */
function shopfront_check_license() {

	global $wp_version;

	$license = trim( get_option( 'shopfront_license_key' ) );

	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_name' => urlencode( SUMOBI_THEME_NAME )
	);

	$response = wp_remote_get( add_query_arg( $api_params, SUMOBI_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );


	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if ( $license_data->license == 'valid' ) {
		echo 'valid'; exit;
		// this license is still valid
	} else {
		echo 'invalid'; exit;
		// this license is no longer valid
	}
}

/**
 * Deactivate license
 * Decreases site count
 */

function shopfront_theme_deactivate_license() {

	// listen for our activate button to be clicked
	if ( isset( $_POST['shopfront_license_deactivate'] ) ) {

		// run a quick security check
		if ( ! check_admin_referer( 'shopfront_nonce', 'shopfront_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'shopfront_license_key' ) );

		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'deactivate_license',
			'license'  => $license,
			'item_name' => urlencode( SUMOBI_THEME_NAME ) // the name of our product in EDD
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, SUMOBI_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if ( $license_data->license == 'deactivated' )
			delete_option( 'shopfront_license_key' );

	}
}
add_action( 'admin_init', 'shopfront_theme_deactivate_license' );
