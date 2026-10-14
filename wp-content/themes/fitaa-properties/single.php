<?php get_header(); ?>
<main id="main" class="site-main page-plain">
	<div class="container container--narrow">
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class( 'entry' ); ?>>
				<h1 class="entry__title"><?php the_title(); ?></h1>
				<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large', array( 'class' => 'entry__thumb' ) ); } ?>
				<div class="entry__content"><?php the_content(); ?></div>
			</article>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer();
