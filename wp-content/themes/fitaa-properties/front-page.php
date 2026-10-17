<?php
/**
 * Homepage: Fitaa House Southampton — arrival at the building, then a scroll-through of the flat.
 *
 * @package fitaa
 */
get_header();
?>
<main id="main" class="site-main home">

	<!-- 1. ARRIVAL ------------------------------------------------------ -->
	<section class="hero" data-hero aria-label="<?php esc_attr_e( 'Fitaa House Southampton', 'fitaa' ); ?>">
		<div class="hero__media" data-hero-media>
			<?php fitaa_photo( 'exterior-ibex-house-entrance', 'The entrance to Ibex House, Southampton: a black panelled door under a white portico in red and black brick', array( 'class' => 'hero__img', 'loading' => 'eager', 'width' => 1200, 'height' => 1600 ) ); ?>
		</div>
		<div class="hero__veil" aria-hidden="true"></div>
		<div class="hero__content container">
			<p class="eyebrow" data-hero-in>Fitaa Homes &middot; Southampton</p>
			<h1 class="hero__title">
				<span class="line"><span class="line__i" data-hero-line>Fitaa House</span></span>
				<span class="line"><span class="line__i" data-hero-line><em>Southampton</em></span></span>
			</h1>
			<p class="hero__lede" data-hero-in>A self-contained one-bedroom flat in Ibex House. Step through the door and take the tour.</p>
			<div class="hero__actions" data-hero-in>
				<a class="btn btn--solid" href="<?php echo esc_url( fitaa_booking_url( 'fitaa-house-southampton' ) ); ?>">Book your stay</a>
				<a class="btn btn--ghost" href="#tour">Take the tour</a>
			</div>
		</div>
		<a class="scroll-cue" href="#tour" aria-label="<?php esc_attr_e( 'Scroll to the tour', 'fitaa' ); ?>"><span></span></a>
	</section>

	<!-- 2. WELCOME ------------------------------------------------------ -->
	<section class="welcome section" id="welcome">
		<div class="container welcome__grid">
			<div>
				<p class="eyebrow" data-reveal>Flat 1, Ibex House</p>
				<h2 class="display" data-split><?php echo fitaa_split_words( 'Everything you need, already waiting behind the black door.' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			</div>
			<div class="welcome__copy">
				<p data-reveal>Flat 1 at 7 The Carronades is a calm, dark-toned one-bedroom flat with a full kitchen, a bath with rainfall shower and a living room that doubles up with a sofa bed. It is styled, stocked and ready on arrival.</p>
				<ul class="chips" data-reveal-group>
					<li>Zip-and-link bed</li>
					<li>Sofa bed</li>
					<li>Full kitchen</li>
					<li>Rainfall shower</li>
					<li>Breakfast bar for two</li>
					<li>Washing machine</li>
					<li>No smoking</li>
				</ul>
			</div>
		</div>
	</section>

	<!-- 3. SCROLL-THROUGH OF THE ROOMS --------------------------------- -->
	<?php get_template_part( 'template-parts/property-tour', null, array( 'property' => 'fitaa-house-southampton' ) ); ?>

	<!-- 4. ONE BED, TWO WAYS ------------------------------------------- -->
	<section class="bed section" id="bed" data-bed>
		<div class="container bed__grid">
			<div class="bed__copy">
				<p class="eyebrow" data-reveal>The bedroom</p>
				<h2 class="display" data-split><?php echo fitaa_split_words( 'One bed, two ways.' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
				<p data-reveal>The bed zips and links. Travelling as a couple? It joins into one large double. Sharing as friends or colleagues? It splits into two singles. Ask us about the set-up when you enquire.</p>
				<div class="toggle" role="group" aria-label="<?php esc_attr_e( 'Bed set-up', 'fitaa' ); ?>" data-bed-toggle>
					<button type="button" class="toggle__btn is-active" data-mode="double" aria-pressed="true">Double</button>
					<button type="button" class="toggle__btn" data-mode="twin" aria-pressed="false">Twin</button>
				</div>
			</div>
			<div class="bed__stage" data-bed-stage>
				<?php fitaa_photo( 'bedroom-as-twin', 'The bedroom set up with two single beds', array( 'class' => 'bed__img bed__img--twin' ) ); ?>
				<?php fitaa_photo( 'bedroom-as-double-lamps', 'The bedroom set up with one large double bed and bedside lamps', array( 'class' => 'bed__img bed__img--double' ) ); ?>
			</div>
		</div>
	</section>

	<!-- 5. DETAILS ------------------------------------------------------ -->
	<?php get_template_part( 'template-parts/property-details', null, array( 'property' => 'fitaa-house-southampton' ) ); ?>

	<!-- 6. BOOK --------------------------------------------------------- -->
	<?php
	get_template_part( 'template-parts/booking-widget', null, array(
		'property' => 'fitaa-house-southampton',
		'heading'  => 'Choose your dates.',
	) );
	?>

	<!-- 6b. OUR OTHER HOME --------------------------------------------- -->
	<section class="other section">
		<div class="container other__inner">
			<div class="other__media" data-parallax><?php fitaa_prop_photo( 'sa-endeavours', 'living-room-wide', 'The living room at SA Endeavours' ); ?></div>
			<div>
				<p class="eyebrow" data-reveal>Also from Fitaa</p>
				<h2 class="display display--sm" data-split><?php echo fitaa_split_words( 'Looking for more space? Meet SA Endeavours.' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
				<p data-reveal>Two bedrooms, a full kitchen, a dining table and a marble-tiled bathroom.</p>
				<a class="btn btn--ghost" data-reveal href="<?php echo esc_url( fitaa_sa_url() ); ?>">See SA Endeavours</a>
			</div>
		</div>
	</section>

	<!-- 7. LANDLORD TEASER --------------------------------------------- -->
	<section class="landlord-band">
		<div class="container landlord-band__inner">
			<div>
				<p class="eyebrow" data-reveal>Own a property?</p>
				<h2 class="display display--sm" data-split><?php echo fitaa_split_words( 'Guaranteed rent. Zero chasing.' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			</div>
			<div>
				<p data-reveal>We are growing the Fitaa portfolio and want more homes to look after. Hand us the keys and we handle the rest.</p>
				<a class="btn btn--solid" data-reveal href="<?php echo esc_url( fitaa_landlords_url() ); ?>">See landlord benefits</a>
			</div>
		</div>
	</section>
</main>
<?php get_footer();
