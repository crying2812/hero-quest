<?php get_header(); ?>

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>

			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<header>
					<h1 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
					<?php include (TEMPLATEPATH . '/includes/components/meta.php' ); ?>
				</header>
				<div class="entry">
					<?php the_content(); ?>
				</div>
			</article>
	
		<?php endwhile; ?>

		<?php include (TEMPLATEPATH . '/includes/components/nav.php' ); ?>

	<?php else : ?>

		<h1><?php _e('Oops! Nothing found…','sceleton'); ?></h1>

	<?php endif; ?>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
