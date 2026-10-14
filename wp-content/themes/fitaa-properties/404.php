<?php get_header(); ?>
<main id="main" class="site-main page-plain">
	<div class="container container--narrow">
		<h1 class="entry__title"><?php esc_html_e( 'This door is locked.', 'fitaa' ); ?></h1>
		<p><?php esc_html_e( 'We could not find that page.', 'fitaa' ); ?></p>
		<a class="btn btn--solid" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Fitaa House', 'fitaa' ); ?></a>
	</div>
</main>
<?php get_footer();
