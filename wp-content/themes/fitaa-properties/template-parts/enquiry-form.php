<?php
/**
 * Shared enquiry form. Args: type (landlord|stay|general), heading, intro, show_property (bool).
 */
$args  = wp_parse_args( $args ?? array(), array(
	'type'          => 'general',
	'heading'       => __( 'Get in touch', 'fitaa' ),
	'intro'         => '',
	'show_property' => false,
	'button'        => __( 'Send enquiry', 'fitaa' ),
) );
$state = isset( $_GET['enquiry'] ) ? sanitize_key( wp_unslash( $_GET['enquiry'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
?>
<section class="enquire section" id="enquire">
	<div class="container enquire__grid">
		<div>
			<p class="eyebrow" data-reveal><?php esc_html_e( 'Enquire', 'fitaa' ); ?></p>
			<h2 class="display display--sm" data-split><?php echo fitaa_split_words( $args['heading'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<?php if ( $args['intro'] ) : ?><p data-reveal><?php echo esc_html( $args['intro'] ); ?></p><?php endif; ?>
			<?php fitaa_social_icons( 'social--contact' ); ?>
			<ul class="contact-list" data-reveal>
				<?php foreach ( fitaa_contact_links() as $link ) : ?>
					<li><a href="<?php echo esc_url( $link[1] ); ?>"><?php echo esc_html( $link[0] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<form class="form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-reveal>
			<?php if ( 'sent' === $state ) : ?>
				<p class="form__notice form__notice--ok" role="status"><?php esc_html_e( 'Thank you — your enquiry is with us and we will be in touch shortly.', 'fitaa' ); ?></p>
			<?php elseif ( 'invalid' === $state ) : ?>
				<p class="form__notice form__notice--err" role="alert"><?php esc_html_e( 'Please add your name and a valid email address.', 'fitaa' ); ?></p>
			<?php elseif ( 'error' === $state ) : ?>
				<p class="form__notice form__notice--err" role="alert"><?php esc_html_e( 'Something went wrong sending that. Please try again.', 'fitaa' ); ?></p>
			<?php endif; ?>
			<input type="hidden" name="action" value="fitaa_enquiry">
			<input type="hidden" name="enquiry_type" value="<?php echo esc_attr( $args['type'] ); ?>">
			<?php wp_nonce_field( 'fitaa_enquiry', 'fitaa_enquiry_nonce' ); ?>
			<div class="form__hp" aria-hidden="true"><label>Website<input type="text" name="fitaa_website" tabindex="-1" autocomplete="off"></label></div>

			<div class="form__row">
				<label class="field"><span>Name</span><input type="text" name="name" required autocomplete="name"></label>
				<label class="field"><span>Email</span><input type="email" name="email" required autocomplete="email"></label>
			</div>
			<div class="form__row">
				<label class="field"><span>Phone <i>(optional)</i></span><input type="tel" name="phone" autocomplete="tel"></label>
				<?php if ( $args['show_property'] ) : ?>
					<label class="field"><span>Property postcode</span><input type="text" name="postcode" autocomplete="postal-code"></label>
				<?php else : ?>
					<label class="field"><span>Preferred dates <i>(optional)</i></span><input type="text" name="postcode" placeholder="e.g. 3–10 March"></label>
				<?php endif; ?>
			</div>
			<?php if ( $args['show_property'] ) : ?>
				<label class="field"><span>Bedrooms</span>
					<select name="bedrooms">
						<option value="">Select</option>
						<option>Studio / 1</option><option>2</option><option>3</option><option>4</option><option>5+</option>
					</select>
				</label>
			<?php endif; ?>
			<label class="field"><span>Message</span><textarea name="message" rows="4"></textarea></label>
			<button class="btn btn--solid" type="submit"><?php echo esc_html( $args['button'] ); ?></button>
		</form>
	</div>
</section>
