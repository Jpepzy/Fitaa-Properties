<?php
/**
 * Request-to-book system.
 *
 * - Custom post type "fitaa_booking" (admin: Bookings) stores every request.
 * - A booking with status "confirmed" blocks its nights on the date picker.
 *   To block dates for other reasons (an Airbnb stay, owner use), add a booking with status Confirmed.
 * - No payment is taken online; the team confirms by email.
 */
defined( 'ABSPATH' ) || exit;

const FITAA_BOOKING_STATUSES = array(
	'pending'   => 'Pending',
	'confirmed' => 'Confirmed',
	'declined'  => 'Declined',
);

add_action( 'init', function () {
	register_post_type( 'fitaa_booking', array(
		'labels'              => array(
			'name'          => __( 'Bookings', 'fitaa' ),
			'singular_name' => __( 'Booking', 'fitaa' ),
			'add_new_item'  => __( 'Add booking or block dates', 'fitaa' ),
			'edit_item'     => __( 'Edit booking', 'fitaa' ),
		),
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-calendar-alt',
		'menu_position'       => 25,
		'supports'            => array( 'title' ),
		'capability_type'     => 'post',
		'exclude_from_search' => true,
	) );
} );

/** Give hand-made admin bookings a readable title. */
add_filter( 'wp_insert_post_data', function ( $data ) {
	if ( 'fitaa_booking' === $data['post_type'] && '' === trim( (string) $data['post_title'] ) ) {
		$data['post_title'] = 'Booking ' . gmdate( 'Y-m-d H:i' );
	}
	return $data;
} );

/* ---------- Helpers ---------- */

function fitaa_valid_date( $date ) {
	$d = DateTime::createFromFormat( '!Y-m-d', (string) $date );
	return $d && $d->format( 'Y-m-d' ) === $date ? $d : false;
}

/** Confirmed [check_in, check_out) ranges for one property, future only. */
function fitaa_blocked_ranges( $property ) {
	$posts = get_posts( array(
		'post_type'      => 'fitaa_booking',
		'post_status'    => array( 'publish', 'private', 'draft', 'pending' ),
		'posts_per_page' => 500,
		'fields'         => 'ids',
		'meta_query'     => array(
			'relation' => 'AND',
			array( 'key' => '_fb_property', 'value' => $property ),
			array( 'key' => '_fb_status', 'value' => 'confirmed' ),
			array( 'key' => '_fb_out', 'value' => gmdate( 'Y-m-d' ), 'compare' => '>=', 'type' => 'CHAR' ),
		),
	) );
	$ranges = array();
	foreach ( $posts as $id ) {
		$ranges[] = array( get_post_meta( $id, '_fb_in', true ), get_post_meta( $id, '_fb_out', true ) );
	}
	return $ranges;
}

function fitaa_range_is_free( $property, $in, $out ) {
	foreach ( fitaa_blocked_ranges( $property ) as $r ) {
		if ( $in < $r[1] && $out > $r[0] ) {
			return false;
		}
	}
	return true;
}

/** Data handed to assets/js/booking.js. */
function fitaa_booking_config() {
	$props = array();
	foreach ( fitaa_properties() as $slug => $p ) {
		$props[ $slug ] = array( 'name' => $p['name'], 'blocked' => fitaa_blocked_ranges( $slug ) );
	}
	return array(
		'properties' => $props,
		'today'      => gmdate( 'Y-m-d' ),
		'maxNights'  => (int) apply_filters( 'fitaa_booking_max_nights', 90 ),
	);
}

/* ---------- Front-end submission ---------- */

function fitaa_handle_booking() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( array( 'booking', 'ref' ), $back );
	$fail = function ( $code ) use ( $back ) {
		wp_safe_redirect( add_query_arg( 'booking', $code, $back ) . '#book' );
		exit;
	};

	if ( ! isset( $_POST['fitaa_booking_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['fitaa_booking_nonce'] ) ), 'fitaa_booking' ) ) {
		$fail( 'error' );
	}
	if ( ! empty( $_POST['fitaa_website'] ) ) { // honeypot
		$fail( 'sent' );
	}

	$property = isset( $_POST['property'] ) ? sanitize_key( wp_unslash( $_POST['property'] ) ) : '';
	$in       = ! empty( $_POST['check_in'] ) ? sanitize_text_field( wp_unslash( $_POST['check_in'] ) ) : ( isset( $_POST['check_in_ns'] ) ? sanitize_text_field( wp_unslash( $_POST['check_in_ns'] ) ) : '' );
	$out      = ! empty( $_POST['check_out'] ) ? sanitize_text_field( wp_unslash( $_POST['check_out'] ) ) : ( isset( $_POST['check_out_ns'] ) ? sanitize_text_field( wp_unslash( $_POST['check_out_ns'] ) ) : '' );
	$guests   = isset( $_POST['guests'] ) ? max( 1, min( 20, (int) $_POST['guests'] ) ) : 1;
	$name     = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email    = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone    = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$message  = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	$d_in  = fitaa_valid_date( $in );
	$d_out = fitaa_valid_date( $out );
	if ( ! fitaa_property( $property ) || '' === $name || ! is_email( $email ) || ! $d_in || ! $d_out ) {
		$fail( 'invalid' );
	}
	$nights = (int) $d_in->diff( $d_out )->format( '%r%a' );
	if ( $in < gmdate( 'Y-m-d' ) || $nights < 1 || $nights > (int) apply_filters( 'fitaa_booking_max_nights', 90 ) ) {
		$fail( 'dates' );
	}
	if ( ! fitaa_range_is_free( $property, $in, $out ) ) {
		$fail( 'unavailable' );
	}

	$prop = fitaa_property( $property );
	$id   = wp_insert_post( array(
		'post_type'   => 'fitaa_booking',
		'post_status' => 'publish',
		'post_title'  => sprintf( '%s — %s (%s to %s)', $prop['name'], $name, $in, $out ),
	) );
	if ( ! $id || is_wp_error( $id ) ) {
		$fail( 'error' );
	}
	$meta = array(
		'_fb_property' => $property, '_fb_in' => $in, '_fb_out' => $out, '_fb_guests' => $guests,
		'_fb_status' => 'pending', '_fb_name' => $name, '_fb_email' => $email, '_fb_phone' => $phone, '_fb_message' => $message,
	);
	foreach ( $meta as $k => $v ) {
		update_post_meta( $id, $k, $v );
	}

	$ref   = 'FB' . str_pad( (string) $id, 5, '0', STR_PAD_LEFT );
	$site  = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
	$admin = get_theme_mod( 'fitaa_lead_to', '' );
	$admin = is_email( $admin ) ? $admin : get_option( 'admin_email' );

	wp_mail(
		$admin,
		sprintf( '[%s] Booking request %s: %s, %s to %s', $site, $ref, $prop['name'], $in, $out ),
		"Reference: {$ref}\nProperty: {$prop['name']}\nDates: {$in} to {$out} ({$nights} nights)\nGuests: {$guests}\nName: {$name}\nEmail: {$email}\nPhone: {$phone}\n\n{$message}\n\nReview and confirm: " . admin_url( 'post.php?post=' . $id . '&action=edit' ),
		array( 'Reply-To: ' . $name . ' <' . $email . '>' )
	);
	wp_mail(
		$email,
		sprintf( 'We have your booking request (%s)', $ref ),
		"Hi {$name},\n\nThanks for your request for {$prop['name']}, {$in} to {$out} ({$nights} nights, {$guests} guests).\nNo payment has been taken. We will check availability and reply to confirm.\n\nReference: {$ref}\n\n{$site}\n"
	);

	wp_safe_redirect( add_query_arg( array( 'booking' => 'sent', 'ref' => $ref ), $back ) . '#book' );
	exit;
}
add_action( 'admin_post_nopriv_fitaa_booking', 'fitaa_handle_booking' );
add_action( 'admin_post_fitaa_booking', 'fitaa_handle_booking' );

/* ---------- Admin UI ---------- */

add_action( 'add_meta_boxes', function () {
	add_meta_box( 'fitaa_booking_details', __( 'Booking details', 'fitaa' ), 'fitaa_booking_metabox', 'fitaa_booking', 'normal', 'high' );
} );

function fitaa_booking_metabox( $post ) {
	wp_nonce_field( 'fitaa_booking_save', 'fitaa_booking_save_nonce' );
	$g = function ( $k, $d = '' ) use ( $post ) {
		$v = get_post_meta( $post->ID, $k, true );
		return '' === $v ? $d : $v;
	};
	echo '<p><em>' . esc_html__( 'Only bookings with status Confirmed block dates on the website. Use this screen to add stays from other platforms or owner use.', 'fitaa' ) . '</em></p>';
	echo '<table class="form-table"><tbody>';
	echo '<tr><th>' . esc_html__( 'Property', 'fitaa' ) . '</th><td><select name="fb_property">';
	foreach ( fitaa_properties() as $slug => $p ) {
		printf( '<option value="%s"%s>%s</option>', esc_attr( $slug ), selected( $g( '_fb_property' ), $slug, false ), esc_html( $p['name'] ) );
	}
	echo '</select></td></tr>';
	printf( '<tr><th>%s</th><td><input type="date" name="fb_in" value="%s"> &rarr; <input type="date" name="fb_out" value="%s"> <span class="description">%s</span></td></tr>', esc_html__( 'Check-in / check-out', 'fitaa' ), esc_attr( $g( '_fb_in' ) ), esc_attr( $g( '_fb_out' ) ), esc_html__( 'The check-out day itself stays bookable.', 'fitaa' ) );
	echo '<tr><th>' . esc_html__( 'Status', 'fitaa' ) . '</th><td><select name="fb_status">';
	foreach ( FITAA_BOOKING_STATUSES as $k => $label ) {
		printf( '<option value="%s"%s>%s</option>', esc_attr( $k ), selected( $g( '_fb_status', 'confirmed' ), $k, false ), esc_html( $label ) );
	}
	echo '</select></td></tr>';
	printf( '<tr><th>%s</th><td><input type="number" min="1" name="fb_guests" value="%d"></td></tr>', esc_html__( 'Guests', 'fitaa' ), (int) $g( '_fb_guests', 1 ) );
	foreach ( array( 'name' => 'Guest name', 'email' => 'Email', 'phone' => 'Phone' ) as $k => $label ) {
		printf( '<tr><th>%s</th><td><input type="text" class="regular-text" name="fb_%s" value="%s"></td></tr>', esc_html( $label ), esc_attr( $k ), esc_attr( $g( '_fb_' . $k ) ) );
	}
	printf( '<tr><th>%s</th><td><textarea name="fb_message" rows="4" class="large-text">%s</textarea></td></tr>', esc_html__( 'Notes', 'fitaa' ), esc_textarea( $g( '_fb_message' ) ) );
	echo '</tbody></table>';
}

add_action( 'save_post_fitaa_booking', function ( $post_id ) {
	if ( ! isset( $_POST['fitaa_booking_save_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['fitaa_booking_save_nonce'] ) ), 'fitaa_booking_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$old_status = get_post_meta( $post_id, '_fb_status', true );
	$property   = isset( $_POST['fb_property'] ) ? sanitize_key( wp_unslash( $_POST['fb_property'] ) ) : '';
	$in         = isset( $_POST['fb_in'] ) ? sanitize_text_field( wp_unslash( $_POST['fb_in'] ) ) : '';
	$out        = isset( $_POST['fb_out'] ) ? sanitize_text_field( wp_unslash( $_POST['fb_out'] ) ) : '';
	$status     = isset( $_POST['fb_status'] ) ? sanitize_key( wp_unslash( $_POST['fb_status'] ) ) : 'pending';
	if ( ! isset( FITAA_BOOKING_STATUSES[ $status ] ) ) {
		$status = 'pending';
	}
	if ( fitaa_property( $property ) ) {
		update_post_meta( $post_id, '_fb_property', $property );
	}
	if ( fitaa_valid_date( $in ) ) {
		update_post_meta( $post_id, '_fb_in', $in );
	}
	if ( fitaa_valid_date( $out ) ) {
		update_post_meta( $post_id, '_fb_out', $out );
	}
	update_post_meta( $post_id, '_fb_status', $status );
	update_post_meta( $post_id, '_fb_guests', isset( $_POST['fb_guests'] ) ? max( 1, (int) $_POST['fb_guests'] ) : 1 );
	update_post_meta( $post_id, '_fb_name', isset( $_POST['fb_name'] ) ? sanitize_text_field( wp_unslash( $_POST['fb_name'] ) ) : '' );
	update_post_meta( $post_id, '_fb_email', isset( $_POST['fb_email'] ) ? sanitize_email( wp_unslash( $_POST['fb_email'] ) ) : '' );
	update_post_meta( $post_id, '_fb_phone', isset( $_POST['fb_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['fb_phone'] ) ) : '' );
	update_post_meta( $post_id, '_fb_message', isset( $_POST['fb_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['fb_message'] ) ) : '' );

	// Tell the guest when a pending request is confirmed or declined.
	$email = get_post_meta( $post_id, '_fb_email', true );
	if ( 'pending' === $old_status && in_array( $status, array( 'confirmed', 'declined' ), true ) && is_email( $email ) ) {
		$prop = fitaa_property( get_post_meta( $post_id, '_fb_property', true ) );
		$site = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
		$line = 'confirmed' === $status ? 'Good news: your stay is confirmed.' : 'Sorry, we are unable to offer those dates.';
		wp_mail( $email, sprintf( 'Your booking request: %s', $status ), sprintf( "%s\n\n%s, %s to %s\n\n%s\n", $line, $prop ? $prop['name'] : '', get_post_meta( $post_id, '_fb_in', true ), get_post_meta( $post_id, '_fb_out', true ), $site ) );
	}
} );

add_filter( 'manage_fitaa_booking_posts_columns', function () {
	return array( 'cb' => '<input type="checkbox">', 'title' => __( 'Booking', 'fitaa' ), 'fb_status' => __( 'Status', 'fitaa' ), 'fb_dates' => __( 'Dates', 'fitaa' ), 'fb_guest' => __( 'Guest', 'fitaa' ), 'date' => __( 'Received', 'fitaa' ) );
} );
add_action( 'manage_fitaa_booking_posts_custom_column', function ( $col, $id ) {
	if ( 'fb_status' === $col ) {
		$s = get_post_meta( $id, '_fb_status', true );
		echo esc_html( FITAA_BOOKING_STATUSES[ $s ] ?? $s );
	} elseif ( 'fb_dates' === $col ) {
		echo esc_html( get_post_meta( $id, '_fb_in', true ) . ' → ' . get_post_meta( $id, '_fb_out', true ) );
	} elseif ( 'fb_guest' === $col ) {
		echo esc_html( get_post_meta( $id, '_fb_name', true ) . ' · ' . get_post_meta( $id, '_fb_email', true ) );
	}
}, 10, 2 );
