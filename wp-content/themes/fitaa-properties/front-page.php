<?php
/**
 * Homepage: Fitaa House Southampton — arrival at the building, then a scroll-through of the flat.
 *
 * @package fitaa
 */
get_header();

$rooms = array(
	array(
		'num'   => '01',
		'title' => 'Your front door',
		'text'  => 'A private entrance off a quiet communal hallway. Self-contained, and yours for the length of your stay.',
		'img'   => 'flat-front-door',
		'alt'   => 'The front door of Flat 1',
		'img2'  => 'communal-hallway-flat-door',
		'alt2'  => 'The communal hallway leading to the flat door',
	),
	array(
		'num'   => '02',
		'title' => 'Living room',
		'text'  => 'Deep blue velvet, a wall-mounted TV and warm lamp light. The sofa opens into an extra bed when you need one.',
		'img'   => 'living-room-velvet-sofa',
		'alt'   => 'Living room with a blue velvet sofa, rug and wall-mounted TV',
		'img2'  => 'living-room-sofa-bed',
		'alt2'  => 'The velvet sofa opened out as a sofa bed',
	),
	array(
		'num'   => '03',
		'title' => 'Full kitchen',
		'text'  => 'Oven, hob, extractor, microwave, air fryer, fridge-freezer and washing machine. Cook properly, not just reheat.',
		'img'   => 'kitchen-full-view',
		'alt'   => 'Fully equipped white kitchen with black handles and slate floor',
		'img2'  => 'breakfast-bar-windows',
		'alt2'  => 'Breakfast bar for two by the front windows',
	),
	array(
		'num'   => '04',
		'title' => 'Bedroom',
		'text'  => 'Navy linen, bedside lamps and a dressing table. The bed is zip-and-link: two singles, or one large double.',
		'img'   => 'bedroom-as-double',
		'alt'   => 'Bedroom with a navy double bed, towels and pendant light',
		'img2'  => 'bedroom-dressing-table',
		'alt2'  => 'Dressing table with round mirror in the bedroom',
	),
	array(
		'num'   => '05',
		'title' => 'Bathroom',
		'text'  => 'A bath with rainfall shower and screen, heated towel rail, and shampoo, conditioner, body wash and hand soap provided.',
		'img'   => 'bathroom-rainfall-shower',
		'alt'   => 'Bathroom with a rainfall shower over the bath',
		'img2'  => 'bathroom-sink-mirror',
		'alt2'  => 'Bathroom sink and mirror',
	),
	array(
		'num'   => '06',
		'title' => 'The little extras',
		'text'  => 'A welcome snack and hot-drinks basket on arrival, plus a utility cupboard with iron, ironing board, airer and hangers.',
		'img'   => 'welcome-snack-basket',
		'alt'   => 'Welcome snack and hot drinks basket',
		'img2'  => 'utility-cupboard-iron-board',
		'alt2'  => 'Utility cupboard with iron, ironing board and airer',
	),
);

$details = array(
	array( 'kitchen-fridge-freezer', 'Fridge-freezer and kitchen shelving' ),
	array( 'living-room-artwork-lamp', 'Living room artwork and lamp' ),
	array( 'breakfast-bar-kettle', 'Kettle at the breakfast bar' ),
	array( 'bathroom-toilet-towel-rail', 'Heated towel rail' ),
	array( 'bedroom-towels-detail', 'Fresh towels folded on the bed' ),
	array( 'kitchen-cupboard-crockery-pans', 'Crockery and pans in the kitchen cupboard' ),
	array( 'entrance-intercom-thermostat', 'Entrance intercom and thermostat' ),
	array( 'bathroom-wall-sign', 'Bathroom wall sign' ),
);
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
				<a class="btn btn--solid" href="<?php echo esc_url( fitaa_booking_url() ); ?>">Book your stay</a>
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
	<section class="tour" id="tour" data-tour aria-label="<?php esc_attr_e( 'A tour of the flat', 'fitaa' ); ?>">
		<div class="tour__sticky" data-tour-sticky>
			<div class="tour__head container">
				<p class="eyebrow">The tour</p>
				<p class="tour__count"><span data-tour-current>01</span><span class="tour__sep">/</span><span>06</span></p>
			</div>
			<div class="tour__axis" aria-hidden="true"></div>
			<div class="tour__track" data-tour-track>
				<?php foreach ( $rooms as $room ) : ?>
					<article class="room" data-room>
						<div class="room__media">
							<?php fitaa_photo( $room['img'], $room['alt'], array( 'class' => 'room__img room__img--main' ) ); ?>
							<?php fitaa_photo( $room['img2'], $room['alt2'], array( 'class' => 'room__img room__img--inset' ) ); ?>
						</div>
						<div class="room__copy">
							<span class="room__num"><?php echo esc_html( $room['num'] ); ?></span>
							<h3 class="room__title"><?php echo esc_html( $room['title'] ); ?></h3>
							<p><?php echo esc_html( $room['text'] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			<div class="tour__bar" aria-hidden="true"><span data-tour-bar></span></div>
		</div>
	</section>

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
	<section class="details section" aria-label="<?php esc_attr_e( 'Details', 'fitaa' ); ?>">
		<div class="container">
			<p class="eyebrow" data-reveal>In the details</p>
			<h2 class="display display--sm" data-split><?php echo fitaa_split_words( 'Small things, thought through.' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
		</div>
		<div class="details__grid container">
			<?php foreach ( $details as $i => $d ) : ?>
				<figure class="detail detail--<?php echo (int) $i; ?>" data-detail>
					<?php fitaa_photo( $d[0], $d[1], array( 'class' => 'detail__img' ) ); ?>
					<figcaption><?php echo esc_html( $d[1] ); ?></figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</section>

	<!-- 6. BOOK --------------------------------------------------------- -->
	<section class="cta section">
		<div class="container cta__inner">
			<p class="eyebrow" data-reveal>Stay with Fitaa Homes</p>
			<h2 class="display" data-split><?php echo fitaa_split_words( 'Ready when you are.' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<p data-reveal>A night, a month or longer. Tell us your dates and we will come back to you.</p>
			<div class="cta__actions" data-reveal>
				<a class="btn btn--solid" href="<?php echo esc_url( fitaa_booking_url() ); ?>">Book Fitaa House</a>
				<a class="btn btn--ghost" href="<?php echo esc_url( fitaa_stays_url() ); ?>">Stays &amp; long-term rentals</a>
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
