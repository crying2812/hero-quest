<?php get_header(); ?>

	<?php if (have_posts()) : ?>
	
		<h1 class="page-title">
		<?php 
		$post = $posts[0]; 
		/* If this is a category archive */ if (is_category()) { 
			single_cat_title();	
		/* If this is a tag archive */ } elseif( is_tag() ) { 
			single_tag_title();
		/* If this is a daily archive */ } elseif (is_day()) {
			the_time('d F, Y');
		/* If this is a monthly archive */ } elseif (is_month()) {
			the_time('F, Y');
		/* If this is a yearly archive */ } elseif (is_year()) {
			the_time('Y');
		/* If this is an author archive */ } elseif (is_author()) {
			_e('Author archive', 'sceleton');
		/* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
			_e('Blog archive', 'sceleton');
		} 
		?>
		</h1>
	
		<?php while (have_posts()) : the_post(); ?>
		
			<article id="post-<?php the_ID(); ?>" <?php post_class() ?>>
				<header>
					<h2 class="post-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php include (TEMPLATEPATH . '/includes/components/meta.php' ); ?>
				</header>
				<div class="entry">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	
		<?php include (TEMPLATEPATH . '/includes/components/nav.php' ); ?>
		
	<?php else : ?>
	
		<h1><?php _e('Nothing found…', 'sceleton'); ?></h1>
	
	<?php endif; ?>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
