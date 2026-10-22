<?php
/**
 * Template Name: Landlords
 *
 * Guaranteed-rent and incentives offer for landlords, to grow the Fitaa portfolio.
 *
 * @package fitaa
 */
get_header();

$benefits = array(
	array( 'Guaranteed rent', 'A fixed, agreed monthly payment to you, paid whether or not the property is occupied.', 'M4 12h16M12 4v16' ),
	array( 'No void periods', 'We carry the empty weeks. Your income does not dip between guests or tenants.', 'M5 12l5 5 9-10' ),
	array( 'Full management', 'Guest and tenant communication, check-ins, keys, cleaning and linen are all looked after by us.', 'M4 7h16M4 12h16M4 17h10' ),
	array( 'Maintenance handled', 'Repairs and upkeep arranged and managed so you are not the first call at midnight.', 'M14 6l4 4-8 8H6v-4z' ),
	array( 'Styled & furnished', 'We dress the property to the Fitaa standard so it presents beautifully and lets well.', 'M5 18V9l7-5 7 5v9z' ),
	array( 'Compliance on our side', 'We keep on top of the paperwork and safety checks that come with letting.', 'M12 3l7 3v6c0 4-3 7-7 9-4-2-7-5-7-9V6z' ),
	array( 'Care for your home', 'Regular inspections and prompt reporting, so the property is treated like ours.', 'M12 5c4 0 7 3 7 7s-3 7-7 7-7-3-7-7 3-7 7-7z' ),
	array( 'Flexible use', 'Short stays through Fitaa Homes, long-term lets, or a mix, whichever suits the property best.', 'M4 8h10M10 16h10' ),
);

$steps = array(
	array( 'Tell us about the property', 'Share the address, size and condition. A quick enquiry is all it takes.' ),
	array( 'We assess and make an offer', 'We view the property and put a clear guaranteed-rent offer in writing.' ),
	array( 'Agree the terms', 'You review the agreement at your pace, with the rent, term and responsibilities spelled out.' ),
	array( 'We prepare the home', 'Styling, furnishing and set-up to Fitaa standard, ready to welcome guests or tenants.' ),
	array( 'You get paid, we run it', 'Your guaranteed rent lands on schedule while we handle everything day to day.' ),
);

$compare = array(
	array( 'Rent when empty', 'You absorb the gap', 'Guaranteed, paid regardless' ),
	array( 'Finding guests / tenants', 'Your job (or agent fees)', 'Ours' ),
	array( 'Cleaning, linen, keys', 'Your job', 'Ours' ),
	array( 'Repairs and upkeep', 'You arrange and chase', 'We arrange and manage' ),
	array( 'Time you spend', 'Ongoing', 'Close to none' ),
);
?>
<main id="main" class="site-main landlords">

	<section class="page-hero page-hero--landlords" data-page-hero>
		<div class="page-hero__orb" aria-hidden="true" data-orb></div>
		<div class="container page-hero__inner">
			<p class="eyebrow" data-hero-in>For landlords</p>
			<h1 class="display display--xl">
				<span class="line"><span class="line__i" data-hero-line>Your property.</span></span>
				<span class="line"><span class="line__i" data-hero-line><em>Guaranteed rent.</em></span></span>
			</h1>
			<p class="page-hero__lede" data-hero-in>We are building the Fitaa Homes portfolio and want more homes to look after. Partner with us for dependable income and a genuinely hands-off experience.</p>
			<div class="hero__actions" data-hero-in>
				<a class="btn btn--solid" href="#enquire">Get your offer</a>
				<a class="btn btn--ghost" href="#benefits">See what you get</a>
			</div>
		</div>
		<div class="page-hero__figure" aria-hidden="true" data-hero-in>
			<?php fitaa_photo( 'exterior-ibex-house-entrance', '', array( 'class' => 'page-hero__img', 'loading' => 'eager' ) ); ?>
			<span class="page-hero__badge">Fitaa House Southampton<br><em>one of our homes</em></span>
		</div>
	</section>

	<section class="section" id="benefits">
		<div class="container">
			<p class="eyebrow" data-reveal>Why partner with us</p>
			<h2 class="display" data-split><?php echo fitaa_split_words( 'Everything a landlord wants, nothing they have to chase.' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<div class="benefits" data-reveal-group>
				<?php foreach ( $benefits as $b ) : ?>
					<article class="benefit">
						<svg class="benefit__icon" viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="<?php echo esc_attr( $b[2] ); ?>"/></svg>
						<h3><?php echo esc_html( $b[0] ); ?></h3>
						<p><?php echo esc_html( $b[1] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="steps section" data-steps>
		<div class="container steps__grid">
			<div class="steps__intro">
				<p class="eyebrow">How it works</p>
				<h2 class="display display--sm" data-split><?php echo fitaa_split_words( 'From first call to first payment.' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			</div>
			<ol class="steps__list">
				<?php foreach ( $steps as $i => $s ) : ?>
					<li class="step" data-step>
						<span class="step__num"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
						<div><h3><?php echo esc_html( $s[0] ); ?></h3><p><?php echo esc_html( $s[1] ); ?></p></div>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<section class="section compare">
		<div class="container container--narrow">
			<p class="eyebrow" data-reveal>Side by side</p>
			<h2 class="display display--sm" data-split><?php echo fitaa_split_words( 'Letting it yourself vs. letting it to Fitaa.' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<div class="table-wrap" data-reveal>
				<table class="compare__table">
					<thead><tr><th></th><th>Going it alone</th><th class="is-fitaa">With Fitaa</th></tr></thead>
					<tbody>
						<?php foreach ( $compare as $row ) : ?>
							<tr><th scope="row"><?php echo esc_html( $row[0] ); ?></th><td><?php echo esc_html( $row[1] ); ?></td><td class="is-fitaa"><?php echo esc_html( $row[2] ); ?></td></tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<p class="fine" data-reveal>Terms, rent levels and guarantee length are agreed individually per property and set out in writing before you commit.</p>
		</div>
	</section>

	<section class="section faq">
		<div class="container container--narrow">
			<p class="eyebrow" data-reveal>Questions</p>
			<h2 class="display display--sm" data-split><?php echo fitaa_split_words( 'Before you ask.' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<div data-reveal-group>
				<details><summary>What does guaranteed rent mean?</summary><p>You receive an agreed amount on an agreed schedule for the term of the agreement, independent of how often the property is occupied.</p></details>
				<details><summary>What kind of properties are you looking for?</summary><p>Tell us about yours. We will let you know whether it suits short stays, long-term lets or both.</p></details>
				<details><summary>Who pays for upkeep and repairs?</summary><p>We manage upkeep and arrange repairs. How costs are shared is set out clearly in your agreement before you sign.</p></details>
				<details><summary>How quickly can you get started?</summary><p>After an enquiry we arrange a viewing and put an offer in writing. Set-up timing depends on the property&rsquo;s condition.</p></details>
			</div>
		</div>
	</section>

	<?php
	get_template_part( 'template-parts/enquiry-form', null, array(
		'type'          => 'landlord',
		'heading'       => 'Get your guaranteed-rent offer.',
		'intro'         => 'Tell us a little about your property and we will come back to you with next steps.',
		'show_property' => true,
		'button'        => 'Request my offer',
	) );
	?>
</main>
<?php get_footer();
