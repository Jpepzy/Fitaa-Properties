<?php defined( 'ABSPATH' ) || exit; ?>
<footer class="site-footer">
	<div class="container site-footer__grid">
		<div>
			<p class="site-footer__logo"><img src="<?php echo esc_url( FITAA_URI . '/assets/img/brand/fitaa-homes-logo.webp' ); ?>" width="591" height="503" alt="<?php esc_attr_e( 'Fitaa Homes', 'fitaa' ); ?>" loading="lazy" decoding="async"></p>
			<p class="site-footer__brand">Fitaa <em>Properties</em></p>
			<p class="site-footer__tag"><?php esc_html_e( 'Considered homes for short stays, long-term lets and landlords who want their property looked after.', 'fitaa' ); ?></p>
			<?php fitaa_social_icons( 'social--footer' ); ?>
		</div>
		<div>
			<h3 class="site-footer__h"><?php esc_html_e( 'Explore', 'fitaa' ); ?></h3>
			<ul class="site-footer__list">
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Fitaa House Southampton', 'fitaa' ); ?></a></li>
				<li><a href="<?php echo esc_url( fitaa_sa_url() ); ?>"><?php esc_html_e( 'SA Endeavours', 'fitaa' ); ?></a></li>
				<li><a href="<?php echo esc_url( fitaa_stays_url() ); ?>"><?php esc_html_e( 'Stays & Rentals', 'fitaa' ); ?></a></li>
				<li><a href="<?php echo esc_url( fitaa_landlords_url() ); ?>"><?php esc_html_e( 'For landlords', 'fitaa' ); ?></a></li>
			</ul>
		</div>
		<div>
			<h3 class="site-footer__h"><?php esc_html_e( 'Get in touch', 'fitaa' ); ?></h3>
			<ul class="site-footer__list">
				<?php foreach ( fitaa_contact_links() as $link ) : ?>
					<li><a href="<?php echo esc_url( $link[1] ); ?>"><?php echo esc_html( $link[0] ); ?></a></li>
				<?php endforeach; ?>
				<li><a href="<?php echo esc_url( fitaa_stays_url() . '#enquire' ); ?>"><?php esc_html_e( 'Send an enquiry', 'fitaa' ); ?></a></li>
			</ul>
		</div>
	</div>
	<div class="container site-footer__base">
		<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Fitaa Properties</span>
		<?php if ( has_nav_menu( 'footer' ) ) { wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'depth' => 1, 'menu_class' => 'site-footer__menu' ) ); } ?>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
