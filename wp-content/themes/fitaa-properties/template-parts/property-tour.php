<?php
/**
 * Pinned tour of a property's rooms (spiral column on desktop, vertical stack on mobile).
 * Args: property (slug).
 */
$slug = $args['property'] ?? 'fitaa-house-southampton';
$prop = fitaa_property( $slug );
if ( ! $prop ) {
	return;
}
$rooms = $prop['rooms'];
$total = str_pad( (string) count( $rooms ), 2, '0', STR_PAD_LEFT );
?>
<section class="tour" id="tour" data-tour aria-label="<?php esc_attr_e( 'A tour of the property', 'fitaa' ); ?>">
	<div class="tour__sticky" data-tour-sticky>
		<div class="tour__head container">
			<p class="eyebrow"><?php esc_html_e( 'The tour', 'fitaa' ); ?></p>
			<p class="tour__count"><span data-tour-current>01</span><span class="tour__sep">/</span><span><?php echo esc_html( $total ); ?></span></p>
		</div>
		<div class="tour__axis" aria-hidden="true"></div>
		<div class="tour__track" data-tour-track>
			<?php foreach ( $rooms as $i => $room ) : ?>
				<article class="room" data-room>
					<div class="room__media">
						<?php fitaa_prop_photo( $prop['folder'], $room['img'], $room['alt'], 'room__img room__img--main' ); ?>
						<?php fitaa_prop_photo( $prop['folder'], $room['img2'], $room['alt2'], 'room__img room__img--inset' ); ?>
					</div>
					<div class="room__copy">
						<span class="room__num"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
						<h3 class="room__title"><?php echo esc_html( $room['title'] ); ?></h3>
						<p><?php echo esc_html( $room['text'] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
		<div class="tour__bar" aria-hidden="true"><span data-tour-bar></span></div>
	</div>
</section>
