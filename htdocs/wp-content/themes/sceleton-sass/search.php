<?php get_header(); ?>

	<?php if (have_posts()) : ?>

		<h1><?php _e('Search results', 'sceleton'); ?></h1>
		<?php while (have_posts()) : the_post(); ?>

			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<header>
					<h2 class="post-title"><?php the_title(); ?></h2>
					<?php include (TEMPLATEPATH . '/includes/components/meta.php' ); ?>
				</header>
				<div class="entry">
					<?php the_excerpt(); ?>
				</div>
			</article>

		<?php endwhile; ?>

		<?php include (TEMPLATEPATH . '/includes/components/nav.php' ); ?>

	<?php else : ?>

		<h1><?php _e('No searchresults found…', 'sceleton'); ?></h1>

	<?php endif; ?>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
