<?php get_header(); ?>
<main id="main" class="site-main page-plain">
	<div class="container container--narrow">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article <?php post_class( 'entry' ); ?>>
				<h1 class="entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<div class="entry__content"><?php the_excerpt(); ?></div>
			</article>
		<?php endwhile; the_posts_pagination(); else : ?>
			<p><?php esc_html_e( 'Nothing here yet.', 'fitaa' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php get_footer();
