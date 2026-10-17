<?php
/**
 * Template Name: Stays & Rentals
 *
 * Fitaa Homes short stays and long-term rentals.
 *
 * @package fitaa
 */
get_header();

/** Print products from a WooCommerce category slug, if WooCommerce is active. Returns true if any printed. */
if ( ! function_exists( 'fitaa_stays_products' ) ) {
function fitaa_stays_products( $cat_slug ) {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return false;
	}
	$q = new WP_Query( array(
		'post_type'      => 'product',
		'posts_per_page' => 6,
		'post_status'    => 'publish',
		'tax_query'      => array( array( 'taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => $cat_slug ) ), // phpcs:ignore WordPress.DB.SlowDBQuery
	) );
	if ( ! $q->have_posts() ) {
		return false;
	}
	echo '<div class="listing-grid" data-reveal-group>';
	while ( $q->have_posts() ) {
		$q->the_post();
		$product = wc_get_product( get_the_ID() );
		echo '<a class="listing" href="' . esc_url( get_permalink() ) . '">';
		echo '<span class="listing__media">' . ( has_post_thumbnail() ? get_the_post_thumbnail( get_the_ID(), 'woocommerce_thumbnail' ) : '' ) . '</span>';
		echo '<span class="listing__body"><span class="listing__title">' . esc_html( get_the_title() ) . '</span>';
		if ( $product ) {
			echo '<span class="listing__price">' . wp_kses_post( $product->get_price_html() ) . '</span>';
		}
		echo '</span></a>';
	}
	echo '</div>';
	wp_reset_postdata();
	return true;
}
}
?>
<main id="main" class="site-main stays">

	<section class="page-hero page-hero--stays" data-page-hero>
		<div class="page-hero__orb" aria-hidden="true" data-orb></div>
		<div class="container page-hero__inner">
			<p class="eyebrow" data-hero-in>Fitaa Homes</p>
			<h1 class="display display--xl">
				<span class="line"><span class="line__i" data-hero-line>A night, a month,</span></span>
				<span class="line"><span class="line__i" data-hero-line><em>or longer.</em></span></span>
			</h1>
			<p class="page-hero__lede" data-hero-in>Thoughtfully styled short stays and settled long-term rentals, in homes we look after ourselves.</p>
			<div class="hero__actions" data-hero-in>
				<a class="btn btn--solid" href="#short">Short stays</a>
				<a class="btn btn--ghost" href="#long">Long-term rentals</a>
			</div>
		</div>
	</section>

	<section class="split section" id="short">
		<div class="container split__grid">
			<div class="split__media" data-parallax>
				<?php fitaa_photo( 'bedroom-as-double', 'Fitaa House bedroom with navy linen', array( 'class' => 'split__img' ) ); ?>
			</div>
			<div class="split__copy">
				<p class="eyebrow" data-reveal>Short stays &middot; Fitaa Homes</p>
				<h2 class="display display--sm" data-split><?php echo fitaa_split_words( 'Arrive, unpack, feel at home.' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
				<p data-reveal>Self-contained apartments with everything provided: fresh linen and towels, toiletries, a fully equipped kitchen, and a welcome basket of snacks and hot drinks. Ideal for business trips, relocations, family visits and city breaks.</p>
				<ul class="ticks" data-reveal-group>
					<li>Fully furnished and styled</li>
					<li>Linen, towels and toiletries included</li>
					<li>Full kitchen with washing machine</li>
					<li>Flexible bed set-ups</li>
				</ul>
				<a class="btn btn--solid" href="#book" data-reveal>Check dates and book</a>
			</div>
		</div>
		<div class="container">
			<h3 class="listing-head">Available stays</h3>
			<?php if ( ! fitaa_stays_products( 'short-stays' ) ) : ?>
				<div class="listing-grid" data-reveal-group>
					<?php foreach ( fitaa_properties() as $slug => $p ) : ?>
						<a class="listing" href="<?php echo esc_url( fitaa_property_url( $slug ) ); ?>">
							<span class="listing__media"><?php fitaa_prop_photo( $p['folder'], $p['rooms'][1]['img'], $p['name'] ); ?></span>
							<span class="listing__body"><span class="listing__title"><?php echo esc_html( $p['name'] ); ?></span><span class="listing__price"><?php echo 'sa-endeavours' === $slug ? 'Two bedrooms' : 'One bedroom &middot; Ibex House'; ?></span></span>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="split split--flip section" id="long">
		<div class="container split__grid">
			<div class="split__media" data-parallax>
				<?php fitaa_photo( 'living-room-velvet-sofa', 'Furnished living room with a blue velvet sofa', array( 'class' => 'split__img' ) ); ?>
			</div>
			<div class="split__copy">
				<p class="eyebrow" data-reveal>Long-term rentals</p>
				<h2 class="display display--sm" data-split><?php echo fitaa_split_words( 'A proper place to settle.' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
				<p data-reveal>Longer tenancies in well-kept homes, with a landlord that answers the phone. Furnished and unfurnished options, clear terms, and a team that fixes things promptly.</p>
				<ul class="ticks" data-reveal-group>
					<li>Clear, fair tenancy terms</li>
					<li>Responsive maintenance</li>
					<li>Well-presented, well-maintained homes</li>
					<li>One point of contact</li>
				</ul>
				<a class="btn btn--solid" href="#enquire" data-reveal>Enquire about a rental</a>
			</div>
		</div>
		<div class="container">
			<h3 class="listing-head">Available rentals</h3>
			<?php if ( ! fitaa_stays_products( 'long-term-rentals' ) ) : ?>
				<p class="muted" data-reveal>New long-term homes are added regularly &mdash; send an enquiry and we will tell you what is coming up.</p>
			<?php endif; ?>
		</div>
	</section>

	<?php
	get_template_part( 'template-parts/booking-widget', null, array(
		'property'   => 'fitaa-house-southampton',
		'selectable' => true,
		'heading'    => 'Pick a home and your dates.',
	) );
	?>

	<section class="landlord-band">
		<div class="container landlord-band__inner">
			<div>
				<p class="eyebrow" data-reveal>Landlords</p>
				<h2 class="display display--sm" data-split><?php echo fitaa_split_words( 'Got a home we could look after?' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			</div>
			<div>
				<p data-reveal>Guaranteed rent, full management and no void periods.</p>
				<a class="btn btn--solid" data-reveal href="<?php echo esc_url( fitaa_landlords_url() ); ?>">Landlord benefits</a>
			</div>
		</div>
	</section>

	<?php
	get_template_part( 'template-parts/enquiry-form', null, array(
		'type'    => 'stay',
		'heading' => 'Tell us what you need.',
		'intro'   => 'Dates, group size, and whether it is a stay or a longer let. We will reply with options.',
	) );
	?>
</main>
<?php get_footer();
