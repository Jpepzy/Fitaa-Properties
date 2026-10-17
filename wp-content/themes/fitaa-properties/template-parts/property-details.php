<?php
/** Detail-shot gallery. Args: property (slug). */
$slug = $args['property'] ?? 'fitaa-house-southampton';
$prop = fitaa_property( $slug );
if ( ! $prop ) {
	return;
}
?>
<section class="details section" aria-label="<?php esc_attr_e( 'Details', 'fitaa' ); ?>">
	<div class="container">
		<p class="eyebrow" data-reveal><?php esc_html_e( 'In the details', 'fitaa' ); ?></p>
		<h2 class="display display--sm" data-split><?php echo fitaa_split_words( 'Small things, thought through.' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
	</div>
	<div class="details__grid container">
		<?php foreach ( $prop['details'] as $i => $d ) : ?>
			<figure class="detail detail--<?php echo (int) $i; ?>" data-detail>
				<?php fitaa_prop_photo( $prop['folder'], $d[0], $d[1], 'detail__img' ); ?>
				<figcaption><?php echo esc_html( $d[1] ); ?></figcaption>
			</figure>
		<?php endforeach; ?>
	</div>
</section>
