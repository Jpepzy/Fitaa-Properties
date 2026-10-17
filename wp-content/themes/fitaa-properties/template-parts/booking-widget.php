<?php
/**
 * Date-picker booking request form.
 * Args: property (slug, default selection), selectable (bool: show a property switcher), heading, intro.
 */
$args       = wp_parse_args( $args ?? array(), array(
	'property'   => 'fitaa-house-southampton',
	'selectable' => false,
	'heading'    => 'Check dates and book.',
	'intro'      => 'Pick your check-in and check-out days. Dates already taken are crossed out. Send a request and we will confirm by email. Nothing is charged online.',
) );
$properties = fitaa_properties();
$state      = isset( $_GET['booking'] ) ? sanitize_key( wp_unslash( $_GET['booking'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
$ref        = isset( $_GET['ref'] ) ? sanitize_text_field( wp_unslash( $_GET['ref'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification

wp_enqueue_script( 'fitaa-booking' );
wp_localize_script( 'fitaa-booking', 'FITAA_BOOKING', fitaa_booking_config() );
?>
<section class="book section" id="book" data-booking data-property="<?php echo esc_attr( $args['property'] ); ?>">
	<div class="container book__grid">
		<div class="book__intro">
			<p class="eyebrow" data-reveal><?php esc_html_e( 'Book', 'fitaa' ); ?></p>
			<h2 class="display display--sm" data-split><?php echo fitaa_split_words( $args['heading'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<p data-reveal><?php echo esc_html( $args['intro'] ); ?></p>
			<ul class="legend" data-reveal>
				<li><i class="legend__sw legend__sw--sel"></i><?php esc_html_e( 'Your dates', 'fitaa' ); ?></li>
				<li><i class="legend__sw legend__sw--range"></i><?php esc_html_e( 'Nights in your stay', 'fitaa' ); ?></li>
				<li><i class="legend__sw legend__sw--taken"></i><?php esc_html_e( 'Taken', 'fitaa' ); ?></li>
			</ul>
		</div>

		<form class="booking" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-booking-form data-reveal>
			<?php if ( 'sent' === $state ) : ?>
				<p class="form__notice form__notice--ok" role="status"><?php echo esc_html( sprintf( 'Thank you. Your request%s is with us and we will confirm by email. No payment has been taken.', $ref ? ' (' . $ref . ')' : '' ) ); ?></p>
			<?php elseif ( 'unavailable' === $state ) : ?>
				<p class="form__notice form__notice--err" role="alert"><?php esc_html_e( 'Sorry, some of those nights were just taken. Please choose different dates.', 'fitaa' ); ?></p>
			<?php elseif ( 'dates' === $state ) : ?>
				<p class="form__notice form__notice--err" role="alert"><?php esc_html_e( 'Please choose a check-in in the future and check-out after it. For very long stays, send an enquiry instead.', 'fitaa' ); ?></p>
			<?php elseif ( 'invalid' === $state || 'error' === $state ) : ?>
				<p class="form__notice form__notice--err" role="alert"><?php esc_html_e( 'We could not send that. Check your dates, name and email, then try again.', 'fitaa' ); ?></p>
			<?php endif; ?>

			<input type="hidden" name="action" value="fitaa_booking">
			<?php wp_nonce_field( 'fitaa_booking', 'fitaa_booking_nonce' ); ?>
			<div class="form__hp" aria-hidden="true"><label>Website<input type="text" name="fitaa_website" tabindex="-1" autocomplete="off"></label></div>
			<input type="hidden" name="check_in" id="bk-in" data-in>
			<input type="hidden" name="check_out" id="bk-out" data-out>

			<?php if ( $args['selectable'] ) : ?>
				<label class="field"><span><?php esc_html_e( 'Property', 'fitaa' ); ?></span>
					<select name="property" id="bk-property" data-property-select>
						<?php foreach ( $properties as $slug => $p ) : ?>
							<option value="<?php echo esc_attr( $slug ); ?>"<?php selected( $args['property'], $slug ); ?>><?php echo esc_html( $p['name'] ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
			<?php else : ?>
				<input type="hidden" name="property" value="<?php echo esc_attr( $args['property'] ); ?>">
				<p class="booking__prop"><?php echo esc_html( $properties[ $args['property'] ]['name'] ); ?></p>
			<?php endif; ?>

			<div class="cal" data-cal aria-label="<?php esc_attr_e( 'Choose your dates', 'fitaa' ); ?>"></div>
			<noscript>
				<div class="form__row">
					<label class="field"><span>Check-in</span><input type="date" name="check_in_ns" required></label>
					<label class="field"><span>Check-out</span><input type="date" name="check_out_ns" required></label>
				</div>
			</noscript>

			<p class="booking__summary" data-summary role="status" aria-live="polite"><?php esc_html_e( 'Select your check-in day, then your check-out day.', 'fitaa' ); ?></p>

			<div class="form__row">
				<label class="field"><span><?php esc_html_e( 'Guests', 'fitaa' ); ?></span><input type="number" name="guests" id="bk-guests" min="1" max="20" value="2" required></label>
				<label class="field"><span><?php esc_html_e( 'Name', 'fitaa' ); ?></span><input type="text" name="name" id="bk-name" required autocomplete="name"></label>
			</div>
			<div class="form__row">
				<label class="field"><span><?php esc_html_e( 'Email', 'fitaa' ); ?></span><input type="email" name="email" id="bk-email" required autocomplete="email"></label>
				<label class="field"><span><?php esc_html_e( 'Phone', 'fitaa' ); ?> <i>(optional)</i></span><input type="tel" name="phone" id="bk-phone" autocomplete="tel"></label>
			</div>
			<label class="field"><span><?php esc_html_e( 'Anything we should know?', 'fitaa' ); ?> <i>(optional)</i></span><textarea name="message" id="bk-message" rows="3"></textarea></label>
			<button class="btn btn--solid" type="submit" data-submit disabled><?php esc_html_e( 'Request to book', 'fitaa' ); ?></button>
		</form>
	</div>
</section>
