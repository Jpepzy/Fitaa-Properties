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

/** Where "Book" buttons point: the on-page booking section, or a property's page. */
function fitaa_booking_url( $property = '' ) {
	return $property ? fitaa_property_url( $property ) . '#book' : fitaa_stays_url() . '#book';
}

/** Email and phone as text links (social profiles are icons, see fitaa_social_icons). */
function fitaa_contact_links() {
	$links = array();
	$email = get_theme_mod( 'fitaa_email', '' );
	$phone = get_theme_mod( 'fitaa_phone', '' );
	if ( $email ) {
		$links[] = array( $email, 'mailto:' . antispambot( $email ) );
	}
	if ( $phone ) {
		$links[] = array( $phone, 'tel:' . preg_replace( '/[^\d+]/', '', $phone ) );
	}
	return $links;
}

/** Social profiles set in the Customizer: key => [label, url]. Only networks with a link are returned. */
function fitaa_social_links() {
	$map = array(
		'instagram' => array( 'Instagram', get_theme_mod( 'fitaa_instagram', '' ) ),
		'facebook'  => array( 'Facebook', get_theme_mod( 'fitaa_facebook', '' ) ),
		'tiktok'    => array( 'TikTok', get_theme_mod( 'fitaa_tiktok', '' ) ),
		'x'         => array( 'X', get_theme_mod( 'fitaa_x', '' ) ),
		'youtube'   => array( 'YouTube', get_theme_mod( 'fitaa_youtube', '' ) ),
		'linkedin'  => array( 'LinkedIn', get_theme_mod( 'fitaa_linkedin', '' ) ),
	);
	$wa = preg_replace( '/\D+/', '', (string) get_theme_mod( 'fitaa_whatsapp', '' ) );
	if ( $wa ) {
		$map['whatsapp'] = array( 'WhatsApp', 'https://wa.me/' . $wa );
	}
	return array_filter( $map, function ( $n ) {
		return ! empty( $n[1] );
	} );
}

/** Inline SVG glyphs (24x24, stroke style). */
function fitaa_social_svg( $key ) {
	$paths = array(
		'instagram' => '<rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r=".6" fill="currentColor"/>',
		'facebook'  => '<path d="M14.5 21v-8h2.8l.5-3.3h-3.3V7.600c0-1 .4-1.700 1.800-1.700h1.600V3.100C17.600 3 16.700 3 15.700 3c-2.600 0-4.300 1.500-4.300 4.300v2.400H8.500V13h2.900v8z"/>',
		'tiktok'    => '<path d="M14 3.500v10.200a3.700 3.700 0 1 1-3.700-3.700"/><path d="M14 3.500c.3 2.500 1.900 4.100 4.700 4.400"/>',
		'x'         => '<path d="M4 4h4.200l11.800 16h-4.200z"/><path d="M4.500 20l6.800-7.700M12.800 11.300L19.500 4"/>',
		'youtube'   => '<rect x="2.500" y="5.500" width="19" height="13" rx="4"/><path d="M10 9.200v5.600l5-2.800z"/>',
		'linkedin'  => '<rect x="3.500" y="9" width="3.600" height="11.500"/><circle cx="5.300" cy="5.200" r="1.900"/><path d="M10 9h3.500v1.700c.8-1.300 2-2 3.600-2 3 0 3.900 1.900 3.900 4.800v6H17.400v-5.300c0-1.300-.4-2.200-1.700-2.200-1.300 0-2 .9-2 2.300v5.200H10z"/>',
		'whatsapp'  => '<path d="M3.500 20.500l1.300-4.300A8.300 8.300 0 1 1 8 19.300z"/><path d="M9 8.500c-.3 2.600 2.800 6.200 6.200 6.500l1.200-1.300-2.100-1.100-1 .8c-1.100-.5-2-1.400-2.600-2.600l.8-1-1-2.100z"/>',
	);
	if ( ! isset( $paths[ $key ] ) ) {
		return '';
	}
	return '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths[ $key ] . '</svg>';
}

/** Echo a row of round social icon links. Prints nothing until at least one profile is set. */
function fitaa_social_icons( $class = '' ) {
	$links = fitaa_social_links();
	if ( ! $links ) {
		return;
	}
	echo '<ul class="social ' . esc_attr( $class ) . '">';
	foreach ( $links as $key => $n ) {
		printf(
			'<li><a class="social__link social__link--%1$s" href="%2$s" target="_blank" rel="noopener" aria-label="%3$s">%4$s</a></li>',
			esc_attr( $key ),
			esc_url( $n[1] ),
			esc_attr( $n[0] ),
			fitaa_social_svg( $key ) // phpcs:ignore WordPress.Security.EscapeOutput
		);
	}
	echo '</ul>';
}

/** Wrap each word of a string in spans for GSAP text reveals. */
function fitaa_split_words( $text ) {
	$out = '';
	foreach ( preg_split( '/\s+/', trim( $text ) ) as $word ) {
		$out .= '<span class="w"><span class="w__i">' . esc_html( $word ) . '</span></span> ';
	}
	return $out;
}
