<?php
/**
 * Template Name: SA Endeavours
 *
 * Property page: photo hero, spiral room tour, details, date-picker booking.
 *
 * @package fitaa
 */
get_header();
$slug = 'sa-endeavours';
?>
<main id="main" class="site-main home sa">

	<section class="hero" data-hero aria-label="<?php esc_attr_e( 'SA Endeavours', 'fitaa' ); ?>">
		<div class="hero__media" data-hero-media>
			<?php fitaa_prop_photo( 'sa-endeavours', 'living-room-wide', 'Living room at SA Endeavours with sofas, a diamond-pattern rug and a wall-mounted TV', 'hero__img', 'eager' ); ?>
		</div>
		<div class="hero__veil" aria-hidden="true"></div>
		<div class="hero__content container">
			<p class="eyebrow" data-hero-in>Fitaa Homes</p>
			<h1 class="hero__title">
				<span class="line"><span class="line__i" data-hero-line>SA</span></span>
				<span class="line"><span class="line__i" data-hero-line><em>Endeavours</em></span></span>
			</h1>
			<p class="hero__lede" data-hero-in>Two bedrooms, a full kitchen and room to spread out. Take the tour, then pick your dates.</p>
			<div class="hero__actions" data-hero-in>
				<a class="btn btn--solid" href="#book">Check dates</a>
				<a class="btn btn--ghost" href="#tour">Take the tour</a>
			</div>
		</div>
		<a class="scroll-cue" href="#tour" aria-label="<?php esc_attr_e( 'Scroll to the tour', 'fitaa' ); ?>"><span></span></a>
	</section>

	<section class="welcome section">
		<div class="container welcome__grid">
			<div>
				<p class="eyebrow" data-reveal>The home</p>
				<h2 class="display" data-split><?php echo fitaa_split_words( 'Space for everyone, set up and ready.' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			</div>
			<div class="welcome__copy">
				<p data-reveal>A two-bedroom home with a living room and dining area, a stocked kitchen and a marble-tiled bathroom with a walk-in shower. Fresh towels are laid out on the beds.</p>
				<ul class="chips" data-reveal-group>
					<li>Two bedrooms</li>
					<li>Living room</li>
					<li>Dining table</li>
					<li>Full kitchen</li>
					<li>Washing machine</li>
					<li>Walk-in shower</li>
				</ul>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/property-tour', null, array( 'property' => $slug ) ); ?>
	<?php get_template_part( 'template-parts/property-details', null, array( 'property' => $slug ) ); ?>
	<?php get_template_part( 'template-parts/booking-widget', null, array( 'property' => $slug, 'heading' => 'Choose your dates.' ) ); ?>

	<section class="other section">
		<div class="container other__inner">
			<div class="other__media" data-parallax><?php fitaa_prop_photo( 'southampton', 'exterior-ibex-house-entrance', 'The entrance to Ibex House' ); ?></div>
			<div>
				<p class="eyebrow" data-reveal>Also from Fitaa</p>
				<h2 class="display display--sm" data-split><?php echo fitaa_split_words( 'Prefer a one-bedroom? See Fitaa House Southampton.' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
				<p data-reveal>A self-contained flat in Ibex House with a zip-and-link bed and a sofa bed.</p>
				<a class="btn btn--ghost" data-reveal href="<?php echo esc_url( home_url( '/' ) ); ?>">See Fitaa House</a>
			</div>
		</div>
	</section>

	<section class="landlord-band">
		<div class="container landlord-band__inner">
			<div>
				<p class="eyebrow" data-reveal>Own a property?</p>
				<h2 class="display display--sm" data-split><?php echo fitaa_split_words( 'Guaranteed rent. Zero chasing.' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			</div>
			<div>
				<p data-reveal>We are growing the Fitaa portfolio and want more homes to look after.</p>
				<a class="btn btn--solid" data-reveal href="<?php echo esc_url( fitaa_landlords_url() ); ?>">See landlord benefits</a>
			</div>
		</div>
	</section>
</main>
<?php get_footer();
