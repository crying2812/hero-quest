<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<article <?php post_class('article'); ?> id="post-<?php the_ID(); ?>">
			<header>
				<h1 class="page-title"><?php the_title(); ?></h1>
			</header>
			<div class="entry">
				<?php the_content(); ?>
			</div>
			<?php $schools = get_terms('school'); ?>
			<?php if($schools): ?>
				<div class="schools">
					<?php foreach($schools as $school): ?>
						<div class="school">
							<h2><?php echo $school->name; ?></h2>
							<?php 
							$args = array(
								'post_type' => 'magic',
								'tax_query' => array(
									array(
										'taxonomy' => 'school',
										'terms' => $school->term_id,
									)
								)
							);
							$magic_query = new WP_Query($args);
							?>
							<?php if($magic_query->have_posts()): ?>
								<div class="columns cards">
									<?php while($magic_query->have_posts()): $magic_query->the_post(); ?>
										<div class="three-col card">
											<?php $card = get_field('magic_card'); ?>
											<?php if($card): ?>
												<img src="<?php echo $card['url']; ?>" alt="<?php echo get_the_title(); ?>" width="<?php echo $card['url']; ?>" height="<?php echo $card['url']; ?>" />
											<?php endif; ?>
										</div>
									<?php endwhile; ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>	
			<?php endif; ?>
		</article>
	<?php endwhile; endif; ?>

<?php get_footer(); ?>
