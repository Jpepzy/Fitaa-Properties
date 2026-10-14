<?php
defined( 'ABSPATH' ) || exit;

/** URL of a bundled Fitaa House Southampton photo (slug without extension). */
function fitaa_img( $slug ) {
	return esc_url( FITAA_URI . '/assets/img/southampton/' . $slug . '.webp' );
}

/** Echo an <img> for a bundled photo with sensible loading attributes. */
function fitaa_photo( $slug, $alt, $args = array() ) {
	$args = wp_parse_args( $args, array(
		'class'   => '',
		'loading' => 'lazy',
		'width'   => '',
		'height'  => '',
	) );
	printf(
		'<img src="%s" alt="%s" class="%s" loading="%s" decoding="async"%s%s>',
		fitaa_img( $slug ),
		esc_attr( $alt ),
		esc_attr( $args['class'] ),
		esc_attr( $args['loading'] ),
		$args['width'] ? ' width="' . (int) $args['width'] . '"' : '',
		$args['height'] ? ' height="' . (int) $args['height'] . '"' : ''
	);
}

/** Permalink for a page that uses a given page template, falling back to a slug. */
function fitaa_page_url( $template, $fallback_slug ) {
	$pages = get_pages( array(
		'meta_key'   => '_wp_page_template',
		'meta_value' => $template,
		'number'     => 1,
	) );
	if ( $pages ) {
		return get_permalink( $pages[0] );
	}
	return home_url( '/' . $fallback_slug . '/' );
}

function fitaa_landlords_url() {
	return fitaa_page_url( 'page-landlords.php', 'landlords' );
}

function fitaa_stays_url() {
	return fitaa_page_url( 'page-stays.php', 'stays' );
}

/** Where "Book" buttons for Fitaa House Southampton point. */
function fitaa_booking_url() {
	$url = get_theme_mod( 'fitaa_booking', '' );
	return $url ? $url : fitaa_stays_url() . '#enquire';
}

/** Direct contact links from Customizer values. Returns array of [label, href]. */
function fitaa_contact_links() {
	$links = array();
	$email = get_theme_mod( 'fitaa_email', '' );
	$phone = get_theme_mod( 'fitaa_phone', '' );
	$wa    = preg_replace( '/\D+/', '', (string) get_theme_mod( 'fitaa_whatsapp', '' ) );
	$ig    = get_theme_mod( 'fitaa_instagram', '' );
	if ( $email ) {
		$links[] = array( $email, 'mailto:' . antispambot( $email ) );
	}
	if ( $phone ) {
		$links[] = array( $phone, 'tel:' . preg_replace( '/[^\d+]/', '', $phone ) );
	}
	if ( $wa ) {
		$links[] = array( 'WhatsApp', 'https://wa.me/' . $wa );
	}
	if ( $ig ) {
		$links[] = array( 'Instagram', $ig );
	}
	return $links;
}

/** Wrap each word of a string in spans for GSAP text reveals. */
function fitaa_split_words( $text ) {
	$out = '';
	foreach ( preg_split( '/\s+/', trim( $text ) ) as $word ) {
		$out .= '<span class="w"><span class="w__i">' . esc_html( $word ) . '</span></span> ';
	}
	return $out;
}
