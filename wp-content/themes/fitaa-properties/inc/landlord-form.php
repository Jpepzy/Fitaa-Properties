<?php
defined( 'ABSPATH' ) || exit;

/**
 * Landlord / general enquiry handler. Posts to admin-post.php, verifies a nonce,
 * emails the site owner and redirects back with a status flag.
 */
function fitaa_handle_enquiry() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$redirect = remove_query_arg( 'enquiry', $redirect );

	if ( ! isset( $_POST['fitaa_enquiry_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['fitaa_enquiry_nonce'] ) ), 'fitaa_enquiry' ) ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'error', $redirect ) . '#enquire' );
		exit;
	}

	// Honeypot: real visitors leave this empty.
	if ( ! empty( $_POST['fitaa_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'sent', $redirect ) . '#enquire' );
		exit;
	}

	$type    = isset( $_POST['enquiry_type'] ) ? sanitize_text_field( wp_unslash( $_POST['enquiry_type'] ) ) : 'general';
	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$postcode = isset( $_POST['postcode'] ) ? sanitize_text_field( wp_unslash( $_POST['postcode'] ) ) : '';
	$beds    = isset( $_POST['bedrooms'] ) ? sanitize_text_field( wp_unslash( $_POST['bedrooms'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $name || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'invalid', $redirect ) . '#enquire' );
		exit;
	}

	$to = get_theme_mod( 'fitaa_lead_to', '' );
	if ( ! is_email( $to ) ) {
		$to = get_option( 'admin_email' );
	}

	$subject = sprintf( '[%s] New %s enquiry from %s', wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ), $type, $name );
	$body    = "Type: {$type}\nName: {$name}\nEmail: {$email}\nPhone: {$phone}\nPostcode: {$postcode}\nBedrooms: {$beds}\n\n{$message}\n";
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'enquiry', $sent ? 'sent' : 'error', $redirect ) . '#enquire' );
	exit;
}
add_action( 'admin_post_nopriv_fitaa_enquiry', 'fitaa_handle_enquiry' );
add_action( 'admin_post_fitaa_enquiry', 'fitaa_handle_enquiry' );
