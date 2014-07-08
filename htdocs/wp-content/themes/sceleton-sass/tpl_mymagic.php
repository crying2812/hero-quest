<?php //Template name: My spells ?>
<?php acf_form_head(); ?>
<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<article <?php post_class('article'); ?> id="post-<?php the_ID(); ?>">
			<header>
				<h1 class="page-title"><?php the_title(); ?></h1>
			</header>
			<div class="entry">
				<?php the_content(); ?>
			</div>
			<div class="my-magic">
				<?php 
				global $current_user;
				get_currentuserinfo();
				acf_form(array(
					'post_id' => 'user_'.$current_user->ID,
					'submit_value' => 'Save spells',
					'updated_message' => 'Congratulations. Now put those spells to good use!'
				)); 
				?>
			</div>
		</article>
	<?php endwhile; endif; ?>

<?php get_footer(); ?>
